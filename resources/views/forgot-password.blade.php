@extends('templates.simple')

@section('body')
    <x-centred-page title="Please, enter your email, that was entered within your registration">
        <form method="post" name="login">
            @csrf
            @if($errors->get('authorization'))
                <div class="alert alert-danger">{{ $errors->get('authorization')['TEXT'] }}</div><br>
            @endif

            <x-input-group name="email" label="Your email" :value="old('email')"></x-input-group>
            <button type="submit" name="submit" value="forgot-password">Submit</button>
            |
            <button type="submit" name="submit" value="to-login">Authorize</button>
        </form>
    </x-centred-page>
@endsection
