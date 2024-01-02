@extends('templates.simple')

@section('body')
    <h2>Please, enter your email, that was entered within your registration</h2>
    <br>
    <form method="post" name="login">
        @csrf
        @if($errors->get('authorization'))
            <div class="alert alert-danger">{{ $errors->get('authorization')['TEXT'] }}</div><br>
        @endif

        <div class="input">
            <label for="login">Your email</label>

            <input id="login"
                   type="email"
                   name="email"
                   value="{{old('email')}}"
                   class="@error('email') is-invalid @enderror">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" name="submit" value="forgot-password">Submit</button>
    </form>
@endsection
