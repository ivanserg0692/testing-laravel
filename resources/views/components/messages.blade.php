@props([
'messages' => []
])
@if($messages)
<div class="messages">
    @foreach($messages as $message)
        <div class="messages__message">{{is_array($message)? $message['TEXT']: $message}}</div>
    @endforeach
</div>
@endif
