<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Login" />
<x-auth.layout title="Login">
    <form class="flex flex-col gap-4 p-6 sm:p-8" method="POST" action="{{ route('login.post') }}">
        @csrf

        <h3 class="text-2xl sm:text-3xl font-bold font-poppins text-slate-950">Sign in to your account</h3>

        <x-input-field name="email" labelName="Email" placeholder="Enter your email here..." type="text" />
        <x-input-field name="password" labelName="Password" placeholder="Enter your password here..." type="password" />

        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center gap-2">
                <input type="checkbox" id="remember" name="remember"
                    class="size-4 border-primary bg-transparent outline-none disabled:cursor-not-allowed">
                <span class="text-sm font-medium text-slate-950">Remember me</span>
            </label>
            <a href="{{ route('forgot-password-email') }}"
                class="text-sm font-medium text-primary hover:underline">Forgot
                Password? </a>
        </div>

        <x-button text="Sign In" />


        <x-auth.prompt text="Don't have an account?" textLink="Sign up" action="{{ route('register') }}" />
    </form>

    <script>
        $(document).ready(function() {
            function rememberMe() {
                const email = $('#email').val();
                if ($('#remember').is(':checked')) {
                    localStorage.setItem('rememberMe', email);
                } else {
                    localStorage.removeItem('rememberMe');
                }
            }

            $('#remember').on('change', function() {
                if (!$('#email').val()) {
                    toastr.warning('Please enter your email first');
                    $('#remember').prop('checked', false);
                } else {
                    rememberMe();
                }
            });

            const rememberedEmail = localStorage.getItem('rememberMe');

            if (rememberedEmail) {
                $('#email').val(rememberedEmail);
                $('#remember').prop('checked', true);
            }

            $('#email').on('input', function() {
                $('#remember').prop('disabled', !$('#email').val());
            });
        });
    </script>

</x-auth.layout>

</html>
