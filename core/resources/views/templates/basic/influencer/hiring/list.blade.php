@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="d-flex justify-content-between align-items-center position-relative mb-4 flex-wrap gap-4">
    <span class="filter-toggle btn btn--base btn--sm h-100 d-none"> <i class="i las la-bars"></i></span>

    <div class="d-flex justify-content-between flex-wrap gap-3">

        <div class="d-flex align-items-start flex-wrap gap-2">
            <a class="btn btn--outline-custom {{ menuActive('influencer.hiring.index') }}" aria-current="page" href="{{ route('influencer.hiring.index') }}">@lang('All')</a>
            <a class="btn btn--outline-custom {{ menuActive('influencer.hiring.pending') }}" href="{{ route('influencer.hiring.pending') }}">@lang('Pending') ({{ $pendingHiring??0 }})</a>
            <a class="btn btn--outline-custom {{ menuActive('influencer.hiring.inprogress') }}" href="{{ route('influencer.hiring.inprogress') }}">@lang('Inprogessed')</a>
            <a class="btn btn--outline-custom {{ menuActive('influencer.hiring.jobDone') }}" href="{{ route('influencer.hiring.jobDone') }}">@lang('Job Done')</a>
            <a class="btn btn--outline-custom {{ menuActive('influencer.hiring.completed') }}" href="{{ route('influencer.hiring.completed') }}">@lang('Completed')</a>
            <a class="btn btn--outline-custom {{ menuActive('influencer.hiring.reported') }}" href="{{ route('influencer.hiring.reported') }}">@lang('Reported')</a>
            <a class="btn btn--outline-custom {{ menuActive('influencer.hiring.cancelled') }}" href="{{ route('influencer.hiring.cancelled') }}">@lang('Cancelled')</a>
        </div>

        <form action="" class="ms-auto service-search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}" placeholder="@lang('Search here')">
                <button class="input-group-text bg--base border-0 text-white px-4">
                    <i class="las la-search"></i>
                </button>
            </div>
        </form>
    </div>

</div>
<div class="row mt-2">
    <div class="col-lg-12">
        <table class="table--responsive--lg table">
            <thead>
                <tr>
                    <th>@lang('Hiring Number')</th>
                    <th>@lang('Username')</th>
                    <th class="text-center">@lang('Amount | Delivery')</th>
                    @if (request()->routeIs('influencer.hiring.index'))
                    <th>@lang('Status')</th>
                    @endif
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hirings as $hiring)
                <tr>
                    <td data-label="@lang('Hiring Number')">
                        {{ $hiring->hiring_no }}
                    </td>

                    <td data-label="@lang('User')">
                        <span class="fw-bold">{{ __(@$hiring->user->username) }}</span>
                    </td>

                    <td data-label="@lang('Amount | Delivery')" class="text-center">
                        <div>
                            <span class="fw-bold">{{ __($general->cur_sym) }}{{ showAmount($hiring->amount) }}</span><br>
                            {{ $hiring->delivery_date }}
                        </div>
                    </td>

                    @if (request()->routeIs('influencer.hiring.index'))
                    <td data-label="@lang('Status')">
                        @php echo $hiring->statusBadge @endphp
                    </td>
                    @endif

                    <td data-label="@lang('Action')">
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <a href="{{ route('influencer.hiring.detail',$hiring->id) }}" class="btn btn--sm btn--outline-base">
                                <i class="la la-desktop"></i> @lang('Detail')
                            </a>

                            <a href="{{ route('influencer.hiring.conversation.view',$hiring->id) }}" class="btn btn--sm btn--outline-info">
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
        {{ $hirings->links() }}
    </div>
</div>

<x-confirmation-modal></x-confirmation-modal>
@endsection
@push('style')
<style>
    .status-square {
        background: #1ca0f278;
        border: #1ca0f278;
    }

    .status-times {
        background: #ea535378;
        border: #ea535378;
    }

    .nav-link {
        color: rgb(var(--base));
    }
</style>
@endpush