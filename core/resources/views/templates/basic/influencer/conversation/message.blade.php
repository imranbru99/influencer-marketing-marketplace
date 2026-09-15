@foreach ($conversationMessage->reverse() as $conversation)
@php
if($conversation->order_id){
    $type = 'order';
}elseif($conversation->hiring_id){
    $type = 'hiring';
}else{
    $type = 'conversation';
}
@endphp
    @if ($conversation->sender == 'influencer')
        <li class="outgoing__msg">
            <div class="msg__item">
                <div class="post__creator">
                    <div class="post__creator-content">
                        @if ($conversation->message)
                            <p>{{ __($conversation->message) }}</p>
                            <span class="comment-date text--secondary">{{ diffForHumans($conversation->created_at) }}</span>
                        @endif
                        @if ($conversation->attachments)
                            <div>

                                @foreach (json_decode($conversation->attachments) as $key => $attachment)
                                    <p class="m-1">
                                        <a href="{{ route('attachment.download', [$attachment, $conversation->id, $type]) }}" class="me-2 text-white">
                                            <i class="fa fa-file text--base"></i>
                                            @lang('Attachment') {{ ++$key }}
                                        </a>
                                    </p>
                                @endforeach
                                <span class="comment-date text--secondary">{{ diffForHumans($conversation->created_at) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </li>
    @else
        <li class="incoming__msg">
            <div class="msg__item">
                <div class="post__creator">
                    <div class="post__creator-content">
                        @if ($conversation->message)
                            @if ($conversation->sender == 'admin')
                                <p class="admin_message">{{ __($conversation->message) }}</p>
                                <span class="comment-date text--danger"> @lang('Admin') </span>
                            @else
                                <p>{{ __($conversation->message) }}</p>
                            @endif
                            <span class="comment-date text--secondary">{{ diffForHumans($conversation->created_at) }}</span>
                        @endif
                        @if ($conversation->attachments)
                            <div>
                                @foreach (json_decode($conversation->attachments) as $key => $attachment)
                                    <p class="m-1">
                                        <a href="{{ route('attachment.download', [$attachment, $conversation->id, $type]) }}" class="me-2 text--base">
                                            <i class="fa fa-file text--base"></i>
                                            @lang('Attachment') {{ ++$key }}
                                        </a>
                                    </p>
                                @endforeach
                                <span class="comment-date text--secondary">{{ diffForHumans($conversation->created_at) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </li>
    @endif
@endforeach
