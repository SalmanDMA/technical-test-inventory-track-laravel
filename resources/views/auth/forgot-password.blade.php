<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Forgot Password" />
<x-auth.layout title="Forgot Password">
    <form class="flex flex-col gap-4 p-6 sm:p-8" method="POST" action="{{ route('forgot-password.post') }}">
        @csrf
        <h3 class="text-2xl sm:text-3xl font-bold font-poppins text-slate-950">Forgot your password?</h3>
        <p class="text-sm font-medium text-slate-500">Enter your new password.</p>

        <x-input-field name="password" labelName="Password" placeholder="Enter your new password here..."
            type="password" />

        <x-button text="Reset" />
    </form>

</x-auth.layout>

</html>
