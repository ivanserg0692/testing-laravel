@extends('templates.simple')

@section('body')
    <x-centred-page>
        <div class="message">
            {{$text}}
        </div>
    </x-centred-page>
@endsection
