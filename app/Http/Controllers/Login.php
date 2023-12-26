<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{

    //
    public function __construct(protected Request $request)
    {
    }

    function show()
    {
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
}
