<div class="single-message admin-message">
    <div class="single-message__content">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-1">
            <span class="text--primary">@lang('Admin')</span>
            <p class="fs--14px">{{ showDateTime($conversation->created_at) }}</p>
        </div>
        <p class="single-message__details fs--15px">{{ __($conversation->message) }}</p>
    </div>
</div>