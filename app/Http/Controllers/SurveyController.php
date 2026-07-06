<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Draft;
use App\Models\Response;
use App\Models\ResponseAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class SurveyController extends Controller
{
    public function welcome()
    {
        // Always show welcome page when explicitly accessed; clear any stale session flag
        session()->forget('survey_started');

        // Prevent cached welcome page from being shown when user navigates back
        return response(view('survey.welcome'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function index()
    {
        try {
            // Mark that the user has started the survey so they cannot return to welcome
            session(['survey_started' => true]);

            $categories = Category::with('questions.answers')->orderBy('order')->get();
            $this->normalizePersonalInfoBirthQuestions($categories);
            return response(view('survey.index', compact('categories'))->render());
        } catch (Throwable $e) {
            error_log('SURVEY_INDEX_EXCEPTION '.get_class($e).': '.$e->getMessage());
            throw $e;
        }
    }

    public function countries()
    {
        $countries = require base_path('vendor/umpirsky/country-list/data/en/country.php');

        $names = collect($countries)
            ->sortBy(fn ($name) => iconv('UTF-8', 'ASCII//TRANSLIT', $name))
            ->values()
            ->all();

        return response()->json(['countries' => $names]);
    }

    public function psgcRegions()
    {
        return response()->json($this->psgcDataset('regions'));
    }

    public function psgcProvinces(string $regionCode)
    {
        $provinces = collect($this->psgcDataset('provinces'))
            ->where('regionCode', $regionCode)
            ->values()
            ->all();

        return response()->json($provinces);
    }

    public function psgcMunicipalities(string $provinceCode)
    {
        $municipalities = collect($this->psgcDataset('cities-municipalities'))
            ->where('provinceCode', $provinceCode)
            ->values()
            ->all();

        return response()->json($municipalities);
    }

    public function psgcBarangays(string $municipalityCode)
    {
        $barangays = Cache::remember('psgc.barangays.'.$municipalityCode, now()->addMonth(), function () use ($municipalityCode) {
            return collect($this->psgcDataset('barangays'))
                ->filter(fn ($barangay) => ($barangay['cityCode'] ?? null) === $municipalityCode
                    || ($barangay['municipalityCode'] ?? null) === $municipalityCode)
                ->values()
                ->all();
        });

        return response()->json($barangays);
    }

    /**
     * PSGC reference data (regions/provinces/cities-municipalities/barangays) served as
     * static JSON files from psgc.gitlab.io. Cached for a month since PSGC codes rarely change.
     */
    private function psgcDataset(string $file): array
    {
        return Cache::remember('psgc.dataset.'.$file, now()->addMonth(), function () use ($file) {
            return Http::get('https://psgc.gitlab.io/api/'.$file.'.json')->throw()->json();
        });
    }

    private function normalizePersonalInfoBirthQuestions($categories): void
    {
        $personalInfoCategory = $categories->firstWhere('order', 2);
        if (!$personalInfoCategory) {
            return;
        }

        $questions = $personalInfoCategory->questions->sortBy('order')->values();
        $birthdayQuestion = $questions->firstWhere('text', 'Birthday');

        if (!$birthdayQuestion) {
            $monthQuestion = $questions->firstWhere('text', 'Month of birth');
            $yearQuestion = $questions->firstWhere('text', 'Year of birth');

            if ($monthQuestion && $yearQuestion) {
                $monthQuestion->text = 'Birthday';
                $monthQuestion->type = 'date';
                $monthQuestion->placeholder = '';
                $monthQuestion->setRelation('answers', collect());

                $questions = $questions->reject(fn ($q) => $q->id === $yearQuestion->id)->values();
                $questions->each(function ($q, $idx) {
                    $q->order = $idx + 1;
                });
            }
        }

        $ageQuestion = $questions->firstWhere('text', 'Age on last birthday');
        if ($ageQuestion) {
            $ageQuestion->placeholder = 'Auto-calculated from birthday';
        }

        $personalInfoCategory->setRelation('questions', $questions);
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($request->email));
        $existing = Response::where('respondent_email', $email)->first();

        $formData = [];
        $responseId = null;
        $isEditMode = false;

        if ($existing) {
            $answers = ResponseAnswer::where('response_id', $existing->id)->get();
            foreach ($answers as $a) {
                $formData[$a->question_id] = ($a->values && count($a->values) > 0) ? $a->values : ($a->value ?? '');
            }
            $responseId = $existing->id;
            $isEditMode = true;
        }

        return response()->json([
            'formData' => $formData,
            'responseId' => $responseId,
            'isEditMode' => $isEditMode,
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'formData' => 'required|array',
        ]);

        $email = $request->filled('email') ? strtolower(trim($request->email)) : null;
        $formData = $request->formData;
        $existingResponseId = $request->existingResponseId;

        $responseId = $existingResponseId;

        if (!$responseId) {
            $response = Response::create([
                'respondent_email' => $email,
                'submitted_at' => now(),
            ]);
            $responseId = $response->id;

            // Delete draft if resume code provided
            if ($request->resumeCode) {
                Draft::where('resume_code', $request->resumeCode)->delete();
            }
        } else {
            Response::where('id', $responseId)->update(['submitted_at' => now()]);
            // Clear old answers
            ResponseAnswer::where('response_id', $responseId)->delete();
        }

        $answerRows = [];
        foreach ($formData as $questionId => $value) {
            if ($value === '' || $value === null) continue;

            $answerRows[] = [
                'id' => Str::uuid(),
                'response_id' => $responseId,
                'question_id' => $questionId,
                'value' => is_array($value) ? null : (string) $value,
                'values' => is_array($value) ? json_encode($value) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($answerRows)) {
            ResponseAnswer::insert($answerRows);
        }

        return response()->json(['success' => true]);
    }

    public function saveDraft(Request $request)
    {
        $request->validate([
            'formData' => 'required|array',
            'currentSection' => 'required|integer',
        ]);

        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        Draft::create([
            'resume_code' => $code,
            'form_data' => $request->formData,
            'current_section' => $request->currentSection,
        ]);

        return response()->json(['code' => $code]);
    }

    public function resume(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $code = strtoupper(trim($request->code));
        $draft = Draft::where('resume_code', $code)->first();

        if (!$draft) {
            return response()->json(['error' => 'Invalid resume code. Please try again.'], 404);
        }

        // Check if expired (10 days)
        if ($draft->updated_at->diffInDays(now()) > 10) {
            $draft->delete();
            return response()->json(['error' => 'Your saved progress has expired. Please start over.'], 410);
        }

        return response()->json([
            'formData' => $draft->form_data,
            'currentSection' => $draft->current_section,
        ]);
    }
}
