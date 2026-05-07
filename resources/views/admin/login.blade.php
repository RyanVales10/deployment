@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md p-6 bg-white rounded-xl shadow">
        <h2 class="text-2xl font-bold text-[#003087] mb-4">Admin Login</h2>
        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="admin_email" name="email" type="email" required autofocus class="w-full rounded-xl border border-gray-200 px-4 py-3" value="{{ old('email') }}">
            </div>
            <div>
                <label for="admin_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="admin_password" name="password" type="password" required class="w-full rounded-xl border border-gray-200 px-4 py-3">
            </div>
            <div class="flex items-center justify-between">
                <a href="/" class="text-sm text-gray-500">Back to survey</a>
                <button type="submit" class="bg-[#003087] text-white px-4 py-2 rounded-lg font-semibold">Sign in</button>
            </div>
        </form>
    </div>
</div>
@endsection
