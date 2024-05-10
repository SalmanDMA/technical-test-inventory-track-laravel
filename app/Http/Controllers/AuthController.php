<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:255',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 255 characters',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $notification = array(
                'message' => 'Login successfully',
                'alert-type' => 'success'
            );

            $request->session()->regenerate();

            return redirect()->route('dashboard.index')->with($notification);
        }

        $notification = array(
            'message' => 'Email or password is incorrect, please try again',
            'alert-type' => 'error'
        );

        return redirect()->route('login')->with($notification);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255',
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name must not exceed 255 characters',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'email.email' => 'Email is not valid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 255 characters',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $notification = array(
            'message' => 'Registered successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('login')->with($notification);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $notification = array(
            'message' => 'Logout successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('login')->with($notification);
    }

    public function forgotPasswordEmail()
    {
        return view('auth.forgot-password-email');
    }

    public function forgotPasswordEmailPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $notification = array(
                'message' => 'User not found',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        $email = $request->email;
        Session::put('email', $email);

        return redirect()->route('forgot-password');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordPost(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|max:255',
        ], [
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 255 characters',
        ]);

        $email = Session::get('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $notification = array(
                'message' => 'User not found',
                'alert-type' => 'error'
            );
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        Session::forget('email');

        $notification = array(
            'message' => 'Password changed successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('login')->with($notification);
    }
}
