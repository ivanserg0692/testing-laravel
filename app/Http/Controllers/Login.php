<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class Login extends Controller
{

    //
    public function __construct(protected Request $request)
    {
    }

    function show()
    {
        if ($this->request->user()) {
            return redirect('/')->withErrors(['authorization' => ['TEXT' => 'You are already authenticated']]);
        }
        return view('login');
    }

    function login(): RedirectResponse
    {
        $credentials = $this->request->validate([
            'name' => ['required', 'min:3', 'max:30'],
            'password' => ['required', 'min:3', 'max:30']
        ]);
        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }
        $this->request->flash();
        return back()->withErrors(['authorization' => ['TEXT' => 'An authorization attempt isn`t successful']]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|never
     */
    function showConfirmingPassword()
    {
        if (!$this->request->user()) {
            return abort(403, 'You haven\'t been authenticated still');
        }
        return view('confirm-password');
    }

    function confirmPassword(): RedirectResponse
    {
        if (!$this->request->user()) {
            return abort(403, 'You haven\'t been authenticated still');
        }
        $data = $this->request->validate(['password' => ['required', 'min:3', 'max:30']]);
        if (!Hash::check($data['password'], $this->request->user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        $this->request->session()->passwordConfirmed();

        return redirect()->intended();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|never
     */
    function showResetPassword()
    {
        if ($this->request->user()) {
            return abort(403, 'You\'ve been authenticated already');
        }
        return view('forgot-password');
    }

    function resetPassword(): RedirectResponse
    {
        if ($this->request->user()) {
            return abort(403, 'You\'ve been authenticated already');
        }
        $this->request->validate(['email' => 'required|email']);

        xdebug_break();
        $status = Password::sendResetLink(
            $this->request->only('email')
        );
        if($status !== Password::RESET_LINK_SENT) {
            $this->request->flash();
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

    }
}
