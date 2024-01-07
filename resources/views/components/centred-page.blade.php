@props(['title' => null])
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @section('messages')@endsection
                    @if($title)
                        <h5 class="card-title">{{$title}}</h5>
                    @endif
                    <x-messages :messages="session('header.messages')"></x-messages>
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</div>
