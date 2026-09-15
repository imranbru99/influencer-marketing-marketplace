@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="row justify-content-center gy-4">
    <div class="col-md-5">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="title">@lang('Client Information')</h5>
            </div>
            <div class="card-body p-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Name')</span>
                        <span>{{ __(@$hiring->user->fullname) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Email')</span>
                        <span>{{ __(@$hiring->user->email) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Country')</span>
                        <span>{{ __(@$hiring->user->address->country) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Member Since')</span>
                        <span>{{ showDateTime($hiring->user->created_at, 'd M, Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Total Order Offered')</span>
                        <span>{{ __(@$hiring->user->orderCompleted->count()) }}</span>
                    </li>
                </ul>
            </div>
        </div>
        @if ($hiring->status == 0 || $hiring->status == 2)
        <div class="card custom--card mt-4">
            <div class="card-header">
                <h5 class="title">@lang('Take Action')</h5>
            </div>

            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @if ($hiring->status == 0)
                    <button type="button" class="btn btn--sm btn--outline-danger confirmationBtn" data-action="{{ route('influencer.hiring.cancel.status', $hiring->id) }}" data-question="@lang('Are you sure to cancel this hiring?')" data-btn_class="btn btn--base btn--md"> <i class="las la-times"></i> @lang('Cancel')</button>

                    <button type="button" class="btn btn--sm btn--outline-success confirmationBtn" data-action="{{ route('influencer.hiring.accept.status', $hiring->id) }}" data-question="@lang('Are you sure to accept this hiring request?')" data-btn_class="btn btn--base btn--md"> <i class="las la-check-square"></i> @lang('Accept')</button>
                    @endif

                    @if ($hiring->status == 2)
                    <button type="button" class="btn btn--sm btn--outline-primary confirmationBtn" data-action="{{ route('influencer.hiring.jobDone.status', $hiring->id) }}" data-question="@lang('Are you sure job done successfully?')" data-btn_class="btn btn--base btn--md"> <i class="las la-check-square"></i> @lang('Job Done')</button>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-7">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="title">@lang('Hiring Information')</h5>
            </div>
            <div class="card-body p-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Title')</span>
                        <span>{{ $hiring->title }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Delivery Date')</span>
                        <span>{{ $hiring->delivery_date }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Amount')</span>
                        <span>{{ showAmount($hiring->amount) }} {{ $general->cur_text }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Hiring No')</span>
                        <span>{{ $hiring->hiring_no }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Order Status')</span>
                        <span> @php echo $hiring->statusBadge @endphp</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Description')</span>
                        <button class="btn btn--sm btn--outline-base descriptionBtn" data-description="{{ $hiring->description }}"><i class="las la-eye"></i> @lang('view')</button>
                    </li>
                    @if ($hiring->status == 4)
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Reason of Report')</span>
                        <button class="btn btn--sm btn--outline-dark reasonBtn" data-reason="{{ $hiring->reason }}"><i class="las la-gavel"></i> @lang('view')</button>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        @if (@$hiring->review)
        <div class="card custom--card mt-4">
            <div class="card-header">
                <h5 class="title">@lang('Review')</h5>
            </div>
            <div class="card-body p-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Rating')</span>
                        <span class="service-rating text--warning">
                            @php
                                echo showRatings(@$hiring->review->star);
                            @endphp
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                        <span class="fw-bold">@lang('Review')</span>
                        <span>{{ __(@$hiring->review->review) }}</span>
                    </li>
                </ul>

            </div>
        </div>
        @endif
    </div>
</div>
<div id="descriptionModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <p class="description"></p>
            </div>
        </div>
    </div>
</div>
<x-confirmation-modal></x-confirmation-modal>
@endsection
@push('script')
<script>
    (function($) {
            "use strict";

            $('.descriptionBtn').on('click',function () { 
                var modal = $("#descriptionModal");
                modal.find('.modal-title').text('Description')
                modal.find('.description').html($(this).data('description'));
                modal.modal('show');
            });
            $('.reasonBtn').on('click',function () { 
                var modal = $("#descriptionModal");
                modal.find('.modal-title').text('Reason of Report')
                modal.find('.description').text($(this).data('reason'));
                modal.modal('show');
            });
        })(jQuery)
</script>
@endpush