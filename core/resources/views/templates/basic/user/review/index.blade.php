@extends($activeTemplate . 'layouts.master')
@section('content')
<form action="" class="d-flex flex-wrap justify-content-end ms-auto table--form mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}" placeholder="@lang('Search here')">
        <button class="input-group-text bg--base text-white border-0 px-4"><i class="las la-search"></i></button>
    </div>
</form>
<table class="table--responsive--lg table">
    <thead>
        <tr>
            <th>@lang('Order | Hire Number')</th>
            <th>@lang('Influencer')</th>
            <th>@lang('Rating')</th>
            <th>@lang('Action')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
        <tr>
            <td data-label="@lang('Order | Hire Number')">
                @if ($review->order_id == 0)
                <a href="{{ route('user.hiring.detail', @$review->hiring_id) }}" class="text--base">{{ @$review->hiring->hiring_no }}</a>
                @else
                <a href="{{ route('user.order.detail', @$review->order_id) }}" class="text--base">{{ @$review->order->order_no }}</a>
                @endif
            </td>
            <td data-label="@lang('Influencer')">
                <span class="fw-bold"><a href="{{ route('influencer.profile', [slug($review->influencer->username), $review->influencer_id]) }}" class="text--base">{{ __(@$review->influencer->username) }}</a></span>
            </td>

            <td data-label="@lang('Rating')">
                <p class="text--warning">
                    @php
                    echo showRatings($review->star);
                    @endphp
                </p>
            </td>

            <td data-label="@lang('Action')">
                <div class="d-flex flex-wrap gap-1 justify-content-end">
                    @if ($review->order_id == 0)
                    <a href="{{ route('user.review.influencer', $review->hiring_id) }}" class="btn btn--sm btn--outline-base">
                        <i class="las la-edit"></i> @lang('Edit')
                    </a>
                    <button class="btn btn--sm btn--outline-danger confirmationBtn" data-action="{{ route('user.review.remove.influencer',$review->id) }}" data-question="@lang('Are you sure to remove this review?')" data-btn_class="btn btn--base btn--md">
                        <i class="las la-sms"></i> @lang('Delete')
                    </button>
                    @else
                    <a href="{{ route('user.review.service', $review->order_id) }}" class="btn btn--sm btn--outline-base">
                        <i class="las la-edit"></i> @lang('Edit')
                    </a>
                    <button class="btn btn--sm btn--outline-danger confirmationBtn" data-action="{{ route('user.review.remove.service',$review->id) }}" data-question="@lang('Are you sure to remove this review?')" data-btn_class="btn btn--base btn--md">
                        <i class="las la-sms"></i> @lang('Delete')
                    </button>
                    @endif
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
{{ $reviews->links() }}

<x-confirmation-modal></x-confirmation-modal>
@endsection