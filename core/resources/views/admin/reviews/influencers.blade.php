@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Hiring Number')</th>
                                    <th>@lang('Reviewer')</th>
                                    <th>@lang('Influencer')</th>
                                    <th>@lang('Rating')</th>
                                    <th>@lang('Created At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td data-label="@lang('Hiring Number')">
                                            <span class="fw-bold">
                                                <a href="{{ route('admin.hiring.detail', $review->hiring_id) }}">{{ @$review->hiring->hiring_no }}</a>
                                            </span>
                                        </td>

                                        <td data-label="@lang('Reviewer')">
                                            <span class="fw-bold">
                                                {{ __(@$review->user->fullname) }}<br>
                                                <a href="{{ route('admin.users.detail', $review->user_id) }}">
                                                    <span>@</span>{{ @$review->user->username }}
                                                </a>
                                            </span>
                                        </td>

                                        <td data-label="@lang('Influencer')">
                                            <span class="fw-bold">
                                                {{ __(@$review->influencer->fullname) }}<br>
                                                <a href="{{ route('admin.influencers.detail', $review->influencer_id) }}">
                                                    <span>@</span>{{ @$review->influencer->username }}
                                                </a>
                                            </span>
                                        </td>

                                        <td data-label="@lang('Rating')">
                                            <span>{{ $review->star }} @lang('star')</span>
                                        </td>

                                        <td data-label="@lang('Created At')">
                                            <span>{{ showDateTime($review->created_at) }} <br> {{ diffForHumans($review->created_at) }}</span>
                                        </td>

                                        <td data-label="@lang('Action')">
                                            <button type="button" class="btn btn-sm btn-outline--info viewBtn"
                                                data-review="{{ $review->review }}">
                                                <i class="las la-desktop text--shadow"></i> @lang('View')
                                            </button>
                                            <a href="#" class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.reviews.influencer.delete',$review->id) }}" data-question="@lang('Are you sure remove this review?')" data-btn_class="btn btn--primary">
                                                <i class="las la-desktop text--shadow"></i> @lang('Delete')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($reviews->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($reviews) }}
                    </div>
                @endif
            </div>
        </div>


    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Review')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <div class="modal-body">
                    <p class="modal-detail"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark w-100" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <form action="" method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search here')"
                    value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');
                modal.find('.modal-detail').text($(this).data('review'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
