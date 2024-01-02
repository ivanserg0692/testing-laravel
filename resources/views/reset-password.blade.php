@extends('templates.simple')
@php
    /**
     * @var \Illuminate\Support\ViewErrorBag $errors
    */
xdebug_break();
echo '<pre>';
var_export(old('password'));
echo '</pre>';
@endphp
@section('body')
    <form method="post" name="login">
        @csrf
        @if($errors->get('authorization'))
            <div class="alert alert-danger">{{ $errors->get('authorization')['TEXT'] }}</div><br>
        @endif

        <div class="input">
            <label for="login-input">Your resetToken</label>

            <input id="login-input"
                   type="text"
                   name="token"
                   value="{{old('token') ?: $token}}"
                   class="@error('token') is-invalid @enderror">

            @error('token')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="input">
            <label for="email-input">Your email</label>

            <input id="email-input"
                   type="email"
                   name="email"
                   value="{{old('email')}}"
                   class="@error('email') is-invalid @enderror">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="input">
            <label for="password-input">Your new password</label>

            <input id="password-input"
                   type="password"
                   name="password"
                   value="{{old('password')}}"
                   class="@error('password') is-invalid @enderror">

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="input">
            <label for="confirming-password-input">Your new password confirmation</label>

            <input id="confirming-password-input"
                   type="password"
                   name="password_confirmation"
                   value="{{old('password_confirmation')}}"
                   class="@error('password_confirmation') is-invalid @enderror">

            @error('password_confirmation')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" name="submit" value="reset-password">Submit</button>
    </form>
@endsection
