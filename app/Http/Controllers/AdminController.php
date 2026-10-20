<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Response;
use App\Models\ResponseAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $categories = Category::with('questions.answers')->orderBy('order')->get();
        $previewCategories = $this->buildPreviewCategories($categories);

        return view('admin.index', compact('categories', 'previewCategories'));
    }

    private function buildPreviewCategories($categories)
    {
        $categories = collect($categories)->map(function ($category) {
            $category = clone $category;
            $category->setRelation('questions', collect($category->questions)->values());
            return $category;
        });

        $personalInfoCategory = $categories->firstWhere('order', 2);
        if (!$personalInfoCategory) {
            return $categories;
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

        return $categories;
    }

    public function analytics()
    {
        $questionTexts = [
            'worked_past_week' => 'Did you work or have a business/job during the past week?',
            'has_job_on_leave' => 'Although you did not work, do you have a job/business?',
            'looked_for_work' => 'Did you look for work or try to establish a business during the past week?',
            'employment_type' => 'Type of employment',
            'grad_studies' => 'Have you pursued graduate studies (Masters/Doctorate)?',
            'education_required' => 'Was your education required for this job?',
            'program' => 'What baccalaureate program/degree did you complete?',
            'income_current' => 'Monthly income (PHP)',
            'income_first' => 'Monthly income at first job (PHP)',
        ];

        $questionIds = Question::whereIn('text', array_values($questionTexts))
            ->get()
            ->pluck('id', 'text');

        $idToKey = [];
        foreach ($questionTexts as $key => $text) {
            if ($questionIds->has($text)) {
                $idToKey[$questionIds[$text]] = $key;
            }
        }

        $byResponse = [];
        if (!empty($idToKey)) {
            ResponseAnswer::whereIn('question_id', array_keys($idToKey))
                ->get(['response_id', 'question_id', 'value'])
                ->each(function ($ra) use (&$byResponse, $idToKey) {
                    $byResponse[$ra->response_id][$idToKey[$ra->question_id]] = $ra->value;
                });
        }

        // ── Employment Status Overview ──
        $employmentStatus = [
            'Employed' => 0,
            'Self-employed/Entrepreneur' => 0,
            'Unemployed' => 0,
            'Pursuing Further Studies' => 0,
            'Not Seeking Employment' => 0,
        ];

        $employedResponseIds = [];

        foreach ($byResponse as $responseId => $data) {
            if (!array_key_exists('worked_past_week', $data)) {
                continue;
            }

            $hasJob = ($data['worked_past_week'] === 'Yes') || (($data['has_job_on_leave'] ?? null) === 'Yes');

            if ($hasJob) {
                $employedResponseIds[$responseId] = true;
                if (($data['employment_type'] ?? null) === 'Self-employed') {
                    $employmentStatus['Self-employed/Entrepreneur']++;
                } else {
                    $employmentStatus['Employed']++;
                }
            } elseif (($data['looked_for_work'] ?? null) === 'Yes') {
                $employmentStatus['Unemployed']++;
            } elseif (($data['grad_studies'] ?? null) === 'Yes') {
                $employmentStatus['Pursuing Further Studies']++;
            } else {
                $employmentStatus['Not Seeking Employment']++;
            }
        }

        // ── Job–Degree Alignment by Program (employed respondents only) ──
        $alignmentLabels = ['Aligned', 'Partially Aligned', 'Not Aligned'];
        $alignmentCounts = [];

        foreach (array_keys($employedResponseIds) as $responseId) {
            $data = $byResponse[$responseId];
            $label = match ($data['education_required'] ?? null) {
                'Yes' => 'Aligned',
                'Not required but preferred' => 'Partially Aligned',
                'No' => 'Not Aligned',
                default => null,
            };
            if ($label === null) {
                continue;
            }

            $program = trim($data['program'] ?? '') ?: 'Unspecified';
            $alignmentCounts[$program][$label] = ($alignmentCounts[$program][$label] ?? 0) + 1;
        }

        $alignmentByProgram = $this->capByRespondentCount($alignmentCounts, $alignmentLabels, 8);
        foreach ($alignmentByProgram as $program => $counts) {
            $total = array_sum($counts);
            $percentages = [];
            foreach ($alignmentLabels as $label) {
                $percentages[$label] = $total > 0 ? round((($counts[$label] ?? 0) / $total) * 100, 1) : 0;
            }
            $percentages['total'] = $total;
            $alignmentByProgram[$program] = $percentages;
        }

        // ── Monthly Income Distribution (initial vs current, by program) ──
        $brackets = ['<10k', '10k–19k', '20k–29k', '30k–49k', '50k+'];
        $bracketFor = function ($amount) {
            if ($amount === null || $amount === '') {
                return null;
            }
            $amount = (float) $amount;
            return match (true) {
                $amount < 10000 => '<10k',
                $amount < 20000 => '10k–19k',
                $amount < 30000 => '20k–29k',
                $amount < 50000 => '30k–49k',
                default => '50k+',
            };
        };

        $incomeCounts = [];
        foreach ($byResponse as $data) {
            $program = trim($data['program'] ?? '') ?: 'Unspecified';

            $currentBracket = $bracketFor($data['income_current'] ?? null);
            if ($currentBracket) {
                $incomeCounts[$program]['current'][$currentBracket] = ($incomeCounts[$program]['current'][$currentBracket] ?? 0) + 1;
                $incomeCounts['All Programs']['current'][$currentBracket] = ($incomeCounts['All Programs']['current'][$currentBracket] ?? 0) + 1;
            }

            $firstBracket = $bracketFor($data['income_first'] ?? null);
            if ($firstBracket) {
                $incomeCounts[$program]['first'][$firstBracket] = ($incomeCounts[$program]['first'][$firstBracket] ?? 0) + 1;
                $incomeCounts['All Programs']['first'][$firstBracket] = ($incomeCounts['All Programs']['first'][$firstBracket] ?? 0) + 1;
            }
        }

        $incomeByProgram = ['All Programs' => [
            'current' => array_map(fn ($b) => $incomeCounts['All Programs']['current'][$b] ?? 0, $brackets),
            'first' => array_map(fn ($b) => $incomeCounts['All Programs']['first'][$b] ?? 0, $brackets),
        ]];

        $programTotals = [];
        foreach ($incomeCounts as $program => $data) {
            if ($program === 'All Programs') {
                continue;
            }
            $programTotals[$program] = array_sum($data['current'] ?? []) + array_sum($data['first'] ?? []);
        }
        arsort($programTotals);

        foreach (array_slice(array_keys($programTotals), 0, 8) as $program) {
            $data = $incomeCounts[$program];
            $incomeByProgram[$program] = [
                'current' => array_map(fn ($b) => $data['current'][$b] ?? 0, $brackets),
                'first' => array_map(fn ($b) => $data['first'][$b] ?? 0, $brackets),
            ];
        }

        return view('admin.analytics', [
            'employmentStatus' => $employmentStatus,
            'alignmentByProgram' => $alignmentByProgram,
            'incomeByProgram' => $incomeByProgram,
            'incomeBrackets' => $brackets,
        ]);
    }

    /**
     * Keep the top N programs by respondent count and fold the rest into "Other",
     * so a long tail of free-text program names doesn't blow up the chart.
     */
    private function capByRespondentCount(array $counts, array $labels, int $limit): array
    {
        $totals = [];
        foreach ($counts as $program => $byLabel) {
            $totals[$program] = array_sum($byLabel);
        }
        arsort($totals);

        $kept = array_slice(array_keys($totals), 0, $limit);
        $result = [];
        foreach ($kept as $program) {
            $result[$program] = $counts[$program];
        }

        $rest = array_diff(array_keys($counts), $kept);
        if (!empty($rest)) {
            $other = array_fill_keys($labels, 0);
            foreach ($rest as $program) {
                foreach ($labels as $label) {
                    $other[$label] += $counts[$program][$label] ?? 0;
                }
            }
            if (array_sum($other) > 0) {
                $result['Other'] = $other;
            }
        }

        return $result;
    }

    public function responses()
    {
        $responses = Response::orderBy('submitted_at', 'desc')->get();
        $categories = Category::with('questions')->orderBy('order')->get();

        // Build question lookup
        $questionLookup = [];
        foreach ($categories as $cat) {
            foreach ($cat->questions as $q) {
                $questionLookup[$q->id] = [
                    'text' => $q->text,
                    'category_title' => $cat->title,
                    'category_order' => $cat->order,
                    'question_order' => $q->order,
                ];
            }
        }

        return view('admin.responses', compact('responses', 'questionLookup'));
    }

    public function responseDetails(string $responseId)
    {
        $answers = ResponseAnswer::where('response_id', $responseId)->get();
        $categories = Category::with('questions')->orderBy('order')->get();

        $questionLookup = [];
        foreach ($categories as $cat) {
            foreach ($cat->questions as $q) {
                $questionLookup[$q->id] = [
                    'text' => $q->text,
                    'category_title' => $cat->title,
                    'category_order' => $cat->order,
                    'question_order' => $q->order,
                ];
            }
        }

        $enriched = $answers->map(function ($ra) use ($questionLookup) {
            $q = $questionLookup[$ra->question_id] ?? null;
            return [
                'id' => $ra->id,
                'question_id' => $ra->question_id,
                'value' => $ra->value,
                'values' => $ra->values,
                'question_text' => $q ? $q['text'] : $ra->question_id,
                'category_title' => $q ? $q['category_title'] : 'Unknown',
                'category_order' => $q ? $q['category_order'] : 999,
                'question_order' => $q ? $q['question_order'] : 999,
            ];
        })->sortBy(['category_order', 'question_order'])->values();

        return response()->json($enriched);
    }

    public function exportCsv()
    {
        $responses = Response::orderBy('submitted_at', 'desc')->get();
        $allAnswers = ResponseAnswer::all();
        $categories = Category::with('questions')->orderBy('order')->get();

        $questionLookup = [];
        $qIds = [];
        foreach ($categories as $cat) {
            foreach ($cat->questions()->orderBy('order')->get() as $q) {
                $questionLookup[$q->id] = $q->text;
                $qIds[] = $q->id;
            }
        }

        // Group answers by response
        $byResponse = [];
        foreach ($allAnswers as $ra) {
            if (!isset($byResponse[$ra->response_id])) {
                $byResponse[$ra->response_id] = [];
            }
            $byResponse[$ra->response_id][$ra->question_id] =
                ($ra->values && count($ra->values) > 0) ? implode('; ', $ra->values) : ($ra->value ?? '');
        }

        $headers = array_merge(['Response ID', 'Submitted At'], array_map(fn($id) => $questionLookup[$id] ?? $id, $qIds));

        $callback = function () use ($responses, $qIds, $byResponse, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($responses as $r) {
                $ans = $byResponse[$r->id] ?? [];
                $row = [
                    $r->id,
                    $r->submitted_at?->format('M d, Y g:i A'),
                ];
                foreach ($qIds as $qId) {
                    $row[] = $ans[$qId] ?? '';
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };

        $filename = 'tracer-study-responses-' . now()->format('Y-m-d') . '.csv';

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    // Category CRUD
    public function storeCategory(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $order = Category::count() + 1;

        $category = Category::create([
            'title' => $request->title,
            'description' => $request->description ?? '',
            'order' => $order,
        ]);

        return response()->json($category->load('questions.answers'));
    }

    public function updateCategory(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'title' => $request->title,
            'description' => $request->description ?? '',
        ]);

        return response()->json($category);
    }

    public function deleteCategory(string $id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // Question CRUD
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'category_id' => 'required|uuid|exists:categories,id',
            'text' => 'required|string',
            'type' => 'required|string',
        ]);

        $question = Question::create([
            'category_id' => $request->category_id,
            'text' => $request->text,
            'type' => $request->type,
            'required' => $request->boolean('required'),
            'placeholder' => $request->placeholder ?? '',
            'help_text' => $request->help_text ?? '',
            'order' => $request->order ?? 0,
            'condition_question_id' => $request->condition_question_id,
            'condition_operator' => $request->condition_operator,
            'condition_value' => $request->condition_value,
            'repeat_count_question_id' => $request->repeat_count_question_id,
        ]);

        // Save answers
        if ($request->has('answers')) {
            foreach ($request->answers as $a) {
                Answer::create([
                    'question_id' => $question->id,
                    'text' => $a['text'],
                    'order' => $a['order'] ?? 0,
                ]);
            }
        }

        return response()->json($question->load('answers'));
    }

    public function updateQuestion(Request $request, string $id)
    {
        $request->validate([
            'text' => 'required|string',
            'type' => 'required|string',
        ]);

        $question = Question::findOrFail($id);
        $question->update([
            'text' => $request->text,
            'type' => $request->type,
            'required' => $request->boolean('required'),
            'placeholder' => $request->placeholder ?? '',
            'help_text' => $request->help_text ?? '',
            'order' => $request->order ?? $question->order,
            'condition_question_id' => $request->condition_question_id,
            'condition_operator' => $request->condition_operator,
            'condition_value' => $request->condition_value,
            'repeat_count_question_id' => $request->repeat_count_question_id,
        ]);

        // Sync answers
        if ($request->has('answers')) {
            $question->answers()->delete();
            foreach ($request->answers as $a) {
                Answer::create([
                    'question_id' => $question->id,
                    'text' => $a['text'],
                    'order' => $a['order'] ?? 0,
                ]);
            }
        }

        return response()->json($question->load('answers'));
    }

    public function deleteQuestion(string $id)
    {
        Question::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function reorderQuestions(Request $request)
    {
        $request->validate([
            'category_id' => 'required|uuid|exists:categories,id',
            'question_orders' => 'required|array|min:1',
            'question_orders.*.id' => 'required|uuid|exists:questions,id',
            'question_orders.*.order' => 'required|integer|min:1',
        ]);

        $categoryId = $request->category_id;
        $questionOrders = collect($request->question_orders);
        $questionIds = $questionOrders->pluck('id')->all();

        $matchedCount = Question::where('category_id', $categoryId)
            ->whereIn('id', $questionIds)
            ->count();

        if ($matchedCount !== count($questionIds)) {
            return response()->json(['message' => 'One or more questions do not belong to this category.'], 422);
        }

        DB::transaction(function () use ($questionOrders, $categoryId) {
            foreach ($questionOrders as $item) {
                Question::where('id', $item['id'])
                    ->where('category_id', $categoryId)
                    ->update(['order' => $item['order']]);
            }
        });

        $questions = Question::with('answers')
            ->where('category_id', $categoryId)
            ->orderBy('order')
            ->get();

        return response()->json($questions);
    }

    // API: get all categories with questions for the admin JS
    public function categoriesJson()
    {
        $categories = Category::with('questions.answers')->orderBy('order')->get();
        return response()->json($categories);
    }
}
