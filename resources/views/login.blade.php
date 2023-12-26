@extends('templates.simple')

@section('body')
    <form method="post" name="login">
        @csrf

        <div class="input">
            <label for="login">Your login</label>

            <input id="login"
                   type="text"
                   class="@error('login') is-invalid @enderror">

            @error('login')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="input">
            <label for="password">Your password</label>

            <input id="password"
                   type="password"
                   class="@error('password') is-invalid @enderror">

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" name="submit" value="login">Login</button>
    </form>
@endsection
