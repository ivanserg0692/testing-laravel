@props([
'messages' => []
])
@if($messages)
<div class="messages">
    @foreach($messages as $message)
        <div class="messages__message">{{$message['TEXT']}}</div>
    @endforeach
</div>
@endif
