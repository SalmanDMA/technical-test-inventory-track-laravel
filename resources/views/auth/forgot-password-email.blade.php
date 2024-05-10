<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Forgot Password" />
<x-auth.layout title="Forgot Password">
    <form class="flex flex-col gap-4 p-6 sm:p-8" method="POST" action="{{ route('forgot-password-email.post') }}">
        @csrf

        <a href="{{ route('login') }}" class="flex items-center gap-2">
            <i class="fa-solid fa-backward text-lg text-primary"></i>
            <span class="text-sm font-medium text-primary hover:underline font-gelasio">Back</span>
        </a>

        <h3 class="text-2xl sm:text-3xl font-bold font-poppins text-slate-950">Forgot your password?</h3>
        <p class="text-sm font-medium text-slate-500">Enter your email address to reset your password.</p>

        <x-input-field name="email" labelName="Email" placeholder="Enter your email here..." type="text" />

        <x-button text="Continue" />
    </form>

</x-auth.layout>

</html>
