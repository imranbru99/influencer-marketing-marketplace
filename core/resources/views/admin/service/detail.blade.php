@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-4 col-md-6 mb-30">
            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-header">
                    <h6>@lang('Influencer Information')</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Fullname')
                            <span class="fw-bold">
                                <a href="{{ route('admin.influencers.detail', $service->influencer_id) }}">{{ __(@$service->influencer->fullname) }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="fw-bold">
                                <a href="{{ route('admin.influencers.detail', $service->influencer_id) }}">{{ __(@$service->influencer->username) }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span class="fw-bold">{{ __(@$service->influencer->email) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Mobile')
                            <span class="fw-bold">{{ __(@$service->influencer->mobile) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Country')
                            <span class="fw-bold">{{ __(@$service->influencer->address->country) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Balance')
                            <span class="fw-bold">{{ showAmount(@$service->influencer->balance) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Created_at')
                            <span class="fw-bold">{{ showDateTime($service->created_at) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @php echo $service->statusBadge @endphp
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6 mb-30">
            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title border-bottom mb-3 pb-2">@lang('Service Information')</h5>
                    <div class="row gy-3">
                        <div class="col-md-12">
                            <h6 class="mb-2">@lang('Category')</h6>
                            <p>{{ __(@$service->category->name) }}</p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="mb-2">@lang('Title')</h6>
                            <p>{{ __($service->title) }}</p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="mb-2">@lang('Price')</h6>
                            <p>{{ getAmount($service->price) }} {{ $general->cur_text }}</p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="mb-2">@lang('Tags')</h6>
                            @foreach ($service->tags as $tag)
                                <span>{{ __($tag->name) }} @if (!$loop->last),@endif </span>
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <h6 class="mb-2">@lang('Image')</h6>
                            <img src="{{ getImage(getFilePath('service') . '/' . $service->image, getFileSize('service')) }}" alt="" class="w-50">
                        </div>
                        <div class="col-md-12">
                            <h6 class="mb-2">@lang('Description')</h6>
                            <p>
                                @php echo $service->description @endphp
                            </p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="mb-2">@lang('key Point')</h6>
                            <ul>
                                @foreach ($service->key_points as $point)
                                <li>{{ __($point) }}</li>                                    
                                @endforeach
                            </ul>
                        </div>
                        @if (@$service->gallery->count())
                        <div class="col-md-12">
                            <h6 class="mb-2">@lang('Images')</h6>
                            @foreach ($service->gallery as $gallery)
                                <img src="{{ getImage(getFilePath('service') . '/' . $gallery->image, getFileSize('service')) }}" alt="" class="w-25 m-2">
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @if ($service->status == 0)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button class="btn btn--success statusBtn" data-status="1" data-id="{{ $service->id }}"><i class="fas fa-check"></i>
                                    @lang('Approve')
                                </button>

                                <button class="btn btn--danger ms-1 statusBtn" data-status="2" data-id="{{ $service->id }}"><i class="fas fa-ban"></i>
                                    @lang('Reject')
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="statusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.service.status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status">
                    <div class="modal-body">
                        <p class="modal-detail"></p>
                        <div class="form-group admin-feedback">
                            <label class="fw-bold mt-2">@lang('Reason for Rejection')</label>
                            <textarea name="admin_feedback" maxlength="255" class="form-control" rows="5">{{ old('admin_feedback') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
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
            $('.statusBtn').on('click', function() {
                var modal = $('#statusModal');
                var status = $(this).data('status')
                modal.find('form').attr('action', `{{ route('admin.service.status', '') }}/${$(this).data('id')}`);
                modal.find('[name=status]').val(status);
                if (status == 1) {
                    $('.modal-detail').text(`@lang('Are you sure to approve this service?')`)
                    $('.admin-feedback').addClass('d-none')
                } else {
                    $('.modal-detail').text(`@lang('Are you sure to reject this service?')`)
                    $('.admin-feedback').removeClass('d-none')
                }
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
