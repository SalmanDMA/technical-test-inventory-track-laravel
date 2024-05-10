<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Register" />

<x-auth.layout title="Register">
    <form class="flex flex-col gap-4 p-6 sm:p-8" method="POST" action="{{ route('register.post') }}">
        @csrf
        <h3 class="text-2xl sm:text-3xl font-bold font-poppins text-slate-950">Create an account</h3>

        <x-input-field name="name" labelName="Name" placeholder="Enter your name here..." type="text" />
        <x-input-field name="email" labelName="Email" placeholder="Enter your email here..." type="text" />
        <x-input-field name="password" labelName="Password" placeholder="Enter your password here..." type="password" />

        <x-button text="Sign Up" />

        <x-auth.prompt text="Already have an account?" textLink="Sign in" action="{{ route('login') }}" />

    </form>
</x-auth.layout>
</body>

</html>
