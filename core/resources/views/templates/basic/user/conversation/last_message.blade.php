@php
if($message->order_id){
    $type = 'order';
}elseif($message->hiring_id){
    $type = 'hiring';
}else{
    $type = 'conversation';
}
@endphp
<li class="outgoing__msg">
    <div class="msg__item">
        <div class="post__creator">
            <div class="post__creator-content">
                @if ($message->message)
                <p>{{ __($message->message) }}</p>
                <span class="comment-date text--secondary">{{ diffForHumans($message->created_at)
                    }}</span>
                @endif
                @if ($message->attachments)
                <div>
                    @foreach (json_decode($message->attachments) as $key => $attachment)
                    <p class="m-1">
                        <a href="{{ route('attachment.download', [$attachment, $message->id, $type]) }}" class="me-2 text-white"><i
                                class="fa fa-file text--base"></i>
                            @lang('Attachment') {{ ++$key }}
                        </a>
                    </p>
                    @endforeach
                    <span class="comment-date text--secondary">{{ diffForHumans($message->created_at) }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</li>
