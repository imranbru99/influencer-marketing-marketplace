@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="d-flex justify-content-between align-items-center position-relative mb-4 flex-wrap gap-4">

    <div class="d-flex align-items-start flex-wrap gap-2">
        <a class="btn btn--outline-custom {{ menuActive('influencer.service.all') }}" aria-current="page" href="{{ route('influencer.service.all') }}">@lang('All')</a>
        <a class="btn btn--outline-custom {{ menuActive('influencer.service.pending') }}" href="{{ route('influencer.service.pending') }}">@lang('Pending')</a>
        <a class="btn btn--outline-custom {{ menuActive('influencer.service.approved') }}" href="{{ route('influencer.service.approved') }}">@lang('Approved')</a>
        <a class="btn btn--outline-custom {{ menuActive('influencer.service.rejected') }}" href="{{ route('influencer.service.rejected') }}">@lang('Rejected')</a>
    </div>
    <form action="" class="service-search-form flex-fill">
        <div class="input-group">
            <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}" placeholder="@lang('Title / Category')">
            <button class="input-group-text bg--base border-0 px-4 text-white"><i class="las la-search"></i></button>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table--responsive--lg table">
            <thead>
                <tr>
                    <th>@lang('Title')</th>
                    <th>@lang('Category | Price')</th>
                    <th>@lang('Order')</th>
                    @if(request()->routeIs('influencer.service.all'))
                    <th>@lang('Status')</th>
                    @endif
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td data-label="@lang('Title')">
                        {{ strLimit($service->title, 60) }}
                    </td>

                    <td data-label="@lang('Category | Price')">
                        <div>
                            <span>{{ __(@$service->category->name) }}</span><br>
                            <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount(@$service->price) }}</span>
                        </div>
                    </td>

                    <td data-label="@lang('Order')">
                        <div>
                            <span> @lang('Total') : {{ getAmount($service->total_order_count) }}</span><br>
                            <span> @lang('Done') : {{ getAmount($service->complete_order_count) }}</span><br>
                        </div>
                    </td>
                    @if(request()->routeIs('influencer.service.all'))
                    <td data-label="@lang('Status')">
                        <div class="">
                            @php echo $service->statusBadge @endphp
                            @if ($service->status == 2)
                            <button type="button" class="btn btn--sm btn--outline-warning detailBtn" data-admin_feedback="{{ $service->admin_feedback }}"><i class="la la-info"></i></button>
                            @endif
                        </div>
                    </td>
                    @endif
                    <td data-label="@lang('Action')">
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <a href="{{ route('influencer.service.edit', $service->id) }}" class="btn btn--sm btn--outline-base @if ($service->status == 2) disabled @endif">
                                <i class="la la-edit"></i> @lang('Edit')
                            </a>

                            <a href="{{ route('influencer.service.orders', $service->id) }}" class="btn btn--sm btn--outline-info @if ($service->status != 1) disabled @endif">
                                <i class="las la-list-ul"></i> @lang('Orders')
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
        {{ $services->links() }}
    </div>
</div>
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Reason of Rejection')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <p class="modal-detail"></p>
            </div>
        </div>
    </div>
</div>
<x-confirmation-modal></x-confirmation-modal>
@endsection

@push('style')
<style>
    .nav-link {
        color: rgb(var(--base));
    }

    .nav-tabs .nav-link:focus,
    .nav-tabs .nav-link:hover {
        border-color: rgb(var(--base)) rgb(var(--base)) rgb(var(--base));
        color: rgb(var(--base));
        isolation: isolate;
    }
</style>
@endpush

@push('script')
<script>
    (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                modal.find('.modal-detail').text($(this).data('admin_feedback'));
                modal.modal('show');
            });

        })(jQuery);
</script>
@endpush