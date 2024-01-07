@extends('templates.simple')
@php
/**
 * @var \Illuminate\Support\ViewErrorBag $errors
*/
@endphp


@section('body')
    <x-centred-page title="You need to authorize">
        @if(session('status'))
            <x-messages :messages="[session('status')]"></x-messages>
        @endif
        <form method="post" name="login">
            @csrf
            @if($errors->get('authorization'))
                <div class="alert alert-danger">{{ $errors->get('authorization')['TEXT'] }}</div><br>
            @endif


            <x-input-group name="name" label="Your login" :value="old('name')"></x-input-group>
            <x-input-group type="password" name="password" label="Your password" :value="old('password')"></x-input-group>
            @if($captcha)
                <div class="input">
                    <label for="captcha-input">Enter a captcha code <br>
                        {!!captcha_img()!!}
                    </label>

                    <input id="captcha-input"
                           type="input"
                           name="captcha"
                           class="@error('captcha') is-invalid @enderror">

                    @error('captcha')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
                <button type="submit" name="submit" value="to-forgot-password" class="btn btn-link">I forgot my password</button>
            </div>
        </form>
    </x-centred-page>
@endsection
