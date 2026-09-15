@forelse ($conversations->reverse() as $conversation)
@if ($conversation->sender == 'admin')
<div class="single-message admin-message">
    <div class="single-message__content">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-1">
            <span class="text--primary">@lang('Admin')</span>
            <p class="fs--14px">{{ showDateTime($conversation->created_at) }}</p>
        </div>
        <p class="single-message__details fs--15px">{{ __($conversation->message) }}</p>
    </div>
</div>
@else
<div class="single-message">
    <div class="single-message__content">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-1">
            <span class="text--primary">{{ __($conversation->sender) }}</span>
            <p class="fs--14px">{{ showDateTime($conversation->created_at) }}</p>
        </div>
        <p class="single-message__details fs--15px">{{ __($conversation->message) }}</p>

        @if ($conversation->attachments)
        @foreach (json_decode($conversation->attachments) as $key => $attachment)
        <p class="m-1">
            <a href="{{ route('admin.hiring.attachment.download', $attachment) }}" class="me-2 text--base"><i class="fa fa-file text--base"></i>
                @lang('Attachment') {{ ++$key }}
            </a>
        </p>
        @endforeach
        @endif
    </div>
</div>
@endif
@empty
<div class="no-message text-center">
    <h4 class="title fw-normal text--muted">@lang('No message to display yet')</h4>
    <i class="far fa-comment-dots text--muted mt-2"></i>
</div>
@endforelse
