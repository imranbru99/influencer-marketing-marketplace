@extends($activeTemplate . 'layouts.master')
@section('content')
<form action="" class="d-flex flex-wrap justify-content-end ms-auto table--form mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}" placeholder="@lang('Order No / Influencer')">
        <button class="input-group-text bg--base text-white border-0 px-4"><i class="las la-search"></i></button>
    </div>
</form>
<table class="table--responsive--lg table">
    <thead>
        <tr>
            <th>@lang('Order Number')</th>
            <th>@lang('Influencer')</th>
            <th class="text-center">@lang('Amount | Delivery')</th>
            <th>@lang('Status')</th>
            <th>@lang('Action')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td data-label="@lang('Order Number')">
                <span>{{ $order->order_no }}</span>
            </td>
            <td data-label="@lang('Influencer')">
                <span class="fw-bold"><a href="{{ route('influencer.profile', [slug($order->influencer->username), $order->influencer_id]) }}" class="text--base">{{ __(@$order->influencer->username) }}</span>
            </td>
            <td data-label="@lang('Amount | Delivery')" class="text-center">
                <div>
                    <span class="fw-bold">{{ __($general->cur_sym) }}{{ showAmount($order->amount) }}</span> <br>
                    {{ $order->delivery_date }}
                </div>
            </td>
            <td data-label="@lang('Status')">
                @php echo $order->statusBadge @endphp
            </td>

            <td data-label="@lang('Action')">
                <div class="d-flex flex-wrap gap-1 justify-content-end">
                    @if ($order->status == 1)
                        @if ($order->review)
                            <a href="{{ route('user.review.service',$order->id) }}" class="btn btn--sm btn--outline-warning">
                                <i class="las la-star"></i> @lang('Review')
                            </a>
                        @else
                            <a href="{{ route('service.details', [slug(@$order->service->title), $order->service_id, $order->id]) }}" class="btn btn--sm btn--outline-warning">
                                <i class="las la-star"></i> @lang('Review')
                            </a>
                        @endif
                    @else
                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-placement="top" title="@lang('You can review it after the order is completed.')">
                        <button type="button" class="btn btn--sm btn--outline-warning disabled"><i class="las la-star"></i> @lang('Review')</button>
                    </span>
                    @endif
                    <a href="{{ route('user.order.detail',$order->id) }}" class="btn btn--sm btn--outline-base">
                        <i class="la la-desktop"></i> @lang('Detail')
                    </a>
                    <a href="{{ route('user.order.conversation.view',$order->id) }}" class="btn btn--sm btn--outline-info">
                        <i class="las la-sms"></i> @lang('Chat')
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td class="justify-content-center text-center" colspan="100%">
                <i class="la la-4x la-frown"></i>
                <br>
                {{ __($emptyMessage) }}
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $orders->links() }}
@endsection
