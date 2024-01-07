@props(['title' => null])
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @if($title)
                    <h5 class="card-title">{{$title}}</h5>
                    @endif
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</div>
