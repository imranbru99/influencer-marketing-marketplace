@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="dashboard-body">
                <div class="card custom--card">
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-xxl-4 col-md-5 col-sm-6 col-xs-2">
                                    <div class="d-flex flex-md-wrap-reverse flex-wrap gap-2">
                                        <div class="form-group order-1">
                                            <label for="firstname" class="col-form-label">@lang('Profile Photo')</label>
                                            <div class="profile-thumb text-center">
                                                <div class="thumb">
                                                    <img id="upload-img" src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile'), true) }}" alt="userProfile">
                                                    <label class="badge badge--icon badge--fill-base update-thumb-icon" for="update-photo"><i class="las la-pen"></i></label>
                                                </div>
                                                <div class="profile__info">
                                                    <input type="file" name="image" class="form-control d-none" id="update-photo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="order-0">
                                            <div class="d-flex mb-1 flex-wrap">
                                                <span class="me-1" data-bs-toggle="tooltip" title="@lang('Username')">
                                                    <i class="la la-user"></i>
                                                </span>
                                                <span>{{ $user->username }}</span>
                                            </div>

                                            <div class="d-flex mb-1 flex-wrap">
                                                <span class="me-1" data-bs-toggle="tooltip" title="@lang('Email')">
                                                    <i class="la la-envelope"></i>
                                                </span>
                                                <span>{{ $user->email }}</span>
                                            </div>

                                            <div class="d-flex mb-1 flex-wrap">
                                                <span class="me-1" data-bs-toggle="tooltip" title="@lang('Mobile')">
                                                    <i class="la la-mobile"></i>
                                                </span>
                                                <span>{{ $user->mobile }}</span>
                                            </div>

                                            <div class="d-flex mb-1 flex-wrap">
                                                <span class="me-1" data-bs-toggle="tooltip" title="@lang('Country')">
                                                    <i class="la la-globe"></i>
                                                </span>
                                                <span>{{ @$user->address->country }}</span>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-xxl-8 col-md-7">
                                    <div class="form-group">
                                        <label for="firstname" class="col-form-label">@lang('First Name')</label>
                                        <input type="text" class="form-control form--control" id="firstname" name="firstname" value="{{ $user->firstname }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="lastname" class="col-form-label">@lang('Last Name')</label>
                                        <input type="text" class="form-control form--control" id="lastname" name="lastname" value="{{ $user->lastname }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="state" class="col-form-label">@lang('State')</label>
                                        <input type="text" class="form-control form--control" id="state" name="state" placeholder="@lang('State')" value="{{ @$user->address->state }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="zip" class="col-form-label">@lang('Zip Code')</label>
                                        <input type="text" class="form-control form--control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{ @$user->address->zip }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-form-label">@lang('City')</label>
                                        <input type="text" class="form-control form--control" id="city" name="city" placeholder="@lang('City')" value="{{ @$user->address->city }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-form-label">@lang('Address')</label>
                                        <input type="text" class="form-control form--control" id="address" name="address" placeholder="@lang('Address')" value="{{ @$user->address->address }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="cmn--btn w-100 mt-2">@lang('Update Profile')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .badge.badge--icon {
            border-radius: 5px 0 0 0;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            const inputField = document.querySelector('#update-photo'),
                uploadImg = document.querySelector('#upload-img');
            inputField.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        const result = reader.result;
                        uploadImg.src = result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        })(jQuery);
    </script>
@endpush
