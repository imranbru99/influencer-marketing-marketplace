@extends('admin.layouts.app')
@section('panel')
<div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Reviews')</th>
                                    <th>@lang('Rating')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td data-label="@lang('Name')">
                                            <span class="fw-bold ms-2">
                                                <a href="{{ route('admin.users.detail', @$review->user->id) }}">{{ __(@$review->user->username) }}</a>
                                            </span>
                                        </td>

                                        <td data-label="@lang('Reviews')">
                                            <span>
                                                {{ strLimit($review->review, 40) }}
                                                
                                            </span>
                                        </td>

                                        <td data-label="@lang('Rating')">
                                            <span class="name">{{ getAmount($review->star) }} @lang('stars')</span>
                                        </td>

                                        <td data-label="@lang('Action')">
                                            <button class="btn btn-sm btn-outline--danger removeBtn" data-review_id="{{ $review->id }}">
                                                <i class="las la-trash"></i> @lang('Remove')
                                            </button>
                                            <button type="button" data-review="{{ $review->review }}" class="btn btn-sm btn-outline--info reviewBtn"><i class="las la-eye"></i>  @lang('View')</button>
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


 <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel">@lang('Review')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted review-detail"></p>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel">@lang('Confirmation Alert!')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted">@lang('Are you sure to remove this review?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.reviewBtn').on('click', function() {
                var modal = $('#reviewModal');
                var review = $(this).data('review');
                modal.find('.review-detail').text(review);
                modal.modal('show');
            });
            $('.removeBtn').on('click', function() {
                var modal = $('#deleteModal');
                modal.find('form').attr('action', `{{ route('admin.influencers.review.remove', '') }}/${$(this).data('review_id')}`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush