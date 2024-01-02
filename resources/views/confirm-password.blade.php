@extends('templates.simple')

@section('body')
    <h2>Please, confirm your password, it's necessary for your security</h2>
    <br>
    <form method="post" name="login">
        @csrf
        @if($errors->get('authorization'))
            <div class="alert alert-danger">{{ $errors->get('authorization')['TEXT'] }}</div><br>
        @endif

        <div class="input">
            <label for="password-input">Your password's confirmation</label>

            <input id="password-input"
                   type="password"
                   name="password"
                   value="{{old('password')}}"
                   class="@error('password') is-invalid @enderror">

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" name="submit" value="password-confirmation">Submit</button>
    </form>
@endsection
