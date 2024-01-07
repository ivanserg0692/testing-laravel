<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class Login extends Controller
{

    const LOGGING_ACTION = self::class . '::logging:';
    const MAX_LOGGING_ATTEMPTS = 4;

    //
    public function __construct(protected Request $request, protected RateLimiter $rateLimiter)
    {
    }

    protected function clearAttempts()
    {
        $this->rateLimiter->clear(static::LOGGING_ACTION . $this->request->ip());
        if($user = $this->request->user()) {
            $this->rateLimiter->clear(static::LOGGING_ACTION . $user->name);
        }
    }

    protected function attempt(): bool
    {
        //There are two limiters, one which checks ip and other one checks a user's name
        //if one of them is false, you need a captcha
        $ipResult = ($this->rateLimiter->attempt(static::LOGGING_ACTION . $this->request->ip(),
                static::MAX_LOGGING_ATTEMPTS, fn() => true, 60 * 60) !== false);
        $userResult = true;
        if ($this->request->name) {
            $userResult = ($this->rateLimiter->attempt(static::LOGGING_ACTION . $this->request->name,
                    static::MAX_LOGGING_ATTEMPTS, fn() => true, 60 * 60) !== false);
        }
        return $ipResult && $userResult;
    }

    protected function tooManyAttempts(): bool
    {
        //There are two limiters, one which checks ip and other one checks a user's name
        //if one of them is true, you need a captcha
        $ipResult = $this->rateLimiter->tooManyAttempts(static::LOGGING_ACTION . $this->request->ip(),
                static::MAX_LOGGING_ATTEMPTS);
        $userResult = false;
        if ($this->request->name) {
            $userResult = $this->rateLimiter->tooManyAttempts(static::LOGGING_ACTION . $this->request->name,
                    static::MAX_LOGGING_ATTEMPTS);
        }
        return $ipResult || $userResult;
    }

    function show()
    {
        if ($this->request->user()) {
            return redirect('/')->withErrors(['authorization' => ['TEXT' => 'You are already authenticated']]);
        }
        return view('login', ['captcha' => $this->tooManyAttempts()]);
    }

    function logout(): RedirectResponse
    {
        if($this->request->user()) {
            Auth::logout();
        }
        return redirect()->back();
    }

    function login(): RedirectResponse
    {
        $credentials = $this->request->validate([
            'name' => ['required', 'min:3', 'max:30'],
            'password' => ['required', 'min:3', 'max:30'],
        ]);
        if ($this->attempt() === false) {
            $this->request->validate(['captcha' => 'required|captcha']);
        }

        $credentials = array_intersect_key($credentials, array_flip(['name', 'password']));
        if (Auth::attempt($credentials)) {
            $this->clearAttempts();
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
    function showResetPasswordRequest()
    {
        if ($this->request->user()) {
            return abort(403, 'You\'ve been authenticated already');
        }
        if($status = $this->request->session()->get('status')) {
            return view('message', ['text' => $status]);
        }
        return view('forgot-password');
    }

    function resetPasswordRequest(): RedirectResponse
    {
        if ($this->request->user()) {
            return abort(403, 'You\'ve been authenticated already');
        }
        $this->request->validate(['email' => 'required|email']);

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

    function showResetPassword(string $token = '', string $email = '')
    {
        if ($this->request->user()) {
            return abort(403, 'You\'ve been authenticated already');
        }
        if($status = $this->request->session()->get('status')) {
            return view('message', ['text' => $status]);
        }
        return view('reset-password', ['token' => $token, 'email' => $email]);
    }

    function resetPassword(): RedirectResponse
    {
        $data = $this->request->validate([
            'token' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3', 'max:30', 'confirmed'],
            'password_confirmation' => ['required', 'min:3', 'max:30']
        ]);
        if ($this->request->user()) {
            return abort(403, 'You\'ve been authenticated already');
        }

        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        if($status !== Password::PASSWORD_RESET) {
            $this->request->flash();
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['errors' => [__($status)]]);
    }
}
