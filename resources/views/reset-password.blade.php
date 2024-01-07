@extends('templates.simple')
@php
    /**
     * @var \Illuminate\Support\ViewErrorBag $errors
    */
$commonErrors = $errors->get('errors');
@endphp
@section('body')
    <x-centred-page>
        <form method="post" name="login">
            @csrf
            @if($commonErrors)
                <div class="alert alert-danger">{{ end($commonErrors) }}</div><br>
            @endif

            <x-input-group name="token" label="Your resetToken" :value="old('token') ?: $token"></x-input-group>
            <x-input-group name="email" label="Your email" :value="old('email') ?: $email"></x-input-group>
            <x-input-group type="password" name="password" label="Your new password"
                           :value="old('password')"></x-input-group>
            <x-input-group type="password" name="password_confirmation" label="Your new password confirmation"
                           :value="old('password_confirmation')"></x-input-group>

            <button type="submit" name="submit" value="reset-password">Submit</button>
        </form>
    </x-centred-page>
@endsection
