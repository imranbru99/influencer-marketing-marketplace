@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center gy-4">
        <div class="col-md-5">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="title">@lang('Influencer Information')</h5>
                </div>

                <div class="card-body p-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between flex-wrap">
                            <span class="fw-bold">@lang('Name')</span>
                            <span>{{ __(@$hiring->influencer->fullname) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between flex-wrap">
                            <span class="fw-bold">@lang('Email')</span>
                            <span>{{ __(@$hiring->influencer->email) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between flex-wrap">
                            <span class="fw-bold">@lang('Country')</span>
                            <span>{{ __(@$hiring->influencer->address->country) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between flex-wrap">
                            <span class="fw-bold">@lang('Member Since')</span>
                            <span>{{ showDateTime($hiring->influencer->created_at, 'd M, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between flex-wrap">
                            <span class="fw-bold">@lang('Order Complted')</span>
                            <span>{{ getAmount($hiring->influencer->completed_order) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between flex-wrap">
                            <span class="fw-bold">@lang('Visit Profile')</span>
                            <span>
                                <a href="{{ route('influencer.profile', [slug($hiring->influencer->username), $hiring->influencer_id]) }}" class="text--base"><i class="las la-external-link-alt"></i> @lang('Link')</a>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            @if ($hiring->status == 3)
                <div class="card custom--card mt-4">
                    <div class="card-header"><h5 class="title">@lang('Take Action')</h5></div>

                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn--sm btn--outline-dark reportBtn" data-id="{{ $hiring->id }}">
                                <i class="las la-gavel"></i> @lang('Report to Admin')
                            </button>

                            <button type="button" class="btn btn--sm btn--outline-success confirmationBtn" data-action="{{ route('user.hiring.complete.status', $hiring->id) }}" data-question="@lang('Are you sure to complete this hiring?')" data-btn_class="btn btn--base btn--md">
                                <i class="las la-check-double"></i> @lang('Complete')
                            </button>
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
                            <span class="fw-bold">@lang('Hiring Status')</span>
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
        </div>
    </div>
    <div id="reportModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Report to Admin')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group report-reason">
                            <label class="form-label">@lang('Reason')</label>
                            <textarea name="reason" class="form-control form--control">{{ old('reason') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark btn--md"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--base btn--md">@lang('Yes')</button>
                    </div>
                </form>
            </div>
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
            $('.reportBtn').on('click', function() {
                var modal = $('#reportModal');
                let id = $(this).data('id');
                modal.find('form').attr('action', `{{ route('user.hiring.report.status', '') }}/${id}`);
                modal.modal('show');
            });

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
        })(jQuery);
    </script>
@endpush
