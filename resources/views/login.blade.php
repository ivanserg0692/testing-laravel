@extends('templates.simple')
@php
/**
 * @var \Illuminate\Support\ViewErrorBag $errors
*/
@endphp
@section('body')
    <form method="post" name="login">
        @csrf
        @if($errors->get('authorization'))
            <div class="alert alert-danger">{{ $errors->get('authorization')['TEXT'] }}</div><br>
        @endif

        <div class="input">
            <label for="login">Your login</label>

            <input id="login"
                   type="text"
                   name="name"
                   value="{{old('name')}}"
                   class="@error('name') is-invalid @enderror">

            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="input">
            <label for="password">Your password</label>

            <input id="password"
                   type="password"
                   name="password"
                   value="{{old('password')}}"
                   class="@error('password') is-invalid @enderror">

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" name="submit" value="login">Login</button>
    </form>
@endsection
