@props(['label' => null, 'id' => null, 'value', 'name', 'type' => 'text'])
@php
    if(!$id) {
        $id = 'input-' . $name;
    }
@endphp
<div class="mb-3">
    @if($label)
        <label for="{{$id}}" class="form-label">{{$label}}</label>
    @endif
    <input type="{{$type}}" class="form-control @error($name) is-invalid @enderror" id="{{$id}}" name="{{$name}}"
           @if($value)value="{{$value}}"@endif>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
