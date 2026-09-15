@extends($activeTemplate . 'layouts.master')
@section('content')
<form action="" class="d-flex flex-wrap justify-content-end ms-auto table--form mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}" placeholder="@lang('Search by Influencer')">
        <button class="input-group-text bg--base text-white border-0 px-4"><i class="las la-search"></i></button>
    </div>
</form>
<table class="table table--responsive--lg">
    <thead>
        <tr>
            <th>@lang('Influencer')</th>
            <th>@lang('Rating')</th>
            <th class="text-center">@lang('Completed Order')</th>
            <th>@lang('Joined At')</th>
            <th>@lang('Action')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($favorites as $favorite)
        <tr>
            <td data-label="@lang('Influencer')">
                <span class="fw-bold">
                    <a href="{{ route('influencer.profile', [slug($favorite->influencer->username), $favorite->influencer_id]) }}">{{ __(@$favorite->influencer->username) }}
                    </a>
                </span>
            </td>

            <td data-label="@lang('Rating')">
                <p class="text--warning">
                    @php
                    echo showRatings($favorite->influencer->rating);
                    @endphp
                    ({{ getAmount(@$favorite->influencer->reviews_count) }})
                </p>
            </td>

            <td data-label="@lang('Completed Order')" class="text-center">
                <span>{{ getAmount(@$favorite->influencer->completed_order )}}</span>
            </td>

            <td data-label="@lang('Joined')">
                <span>{{ showDateTime(@$favorite->influencer->created_at) }}</span>
            </td>

            <td data-label="@lang('Action')">
                <div>
                    <a href="{{ route('influencer.profile', [slug($favorite->influencer->username), $favorite->influencer_id]) }}" class="btn btn--sm btn--outline-base">
                        <i class="las la-external-link-alt"></i> @lang('Profile')
                    </a>

                    <button type="button" class="btn btn--sm btn--outline-danger confirmationBtn" data-action="{{ route('user.favorite.remove', $favorite->id) }}" data-question="Are you sure to remove this influencer?" data-btn_class="btn btn--base btn--md">
                        <i class="la la-times"></i> @lang('Remove')
                    </button>

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
{{ $favorites->links() }}

<x-confirmation-modal></x-confirmation-modal>
@endsection
