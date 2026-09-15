@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
    $policyPages = getContent('policy_pages.element', false, null, true);
    $register = getContent('influencer_register.content', true);
    $registerUser = getContent('user_register.content', true);
    @endphp
    <div class="account-section pt-80 pb-80">
        <div class="container">
            <div class="account-wrapper">
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="account-thumb-wrapper">
                            <img src="{{ getImage('assets/images/frontend/influencer_register/' . @$register->data_values->image, '660x450') }}" class="mw-100 h-100">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="account-content">
                            <div class="d-flex justify-content-between flex-wrap gap-3 pb-5">
                                <div class="account-content-left">
                                    <h3 class="this-page-title">{{ __(@$register->data_values->title) }}</h3>
                                </div>
                                <div class="account-content-right">
                                    <button type="button" class="btn btn--md btn--outline-base actionBtn" data-type="client">@lang('Client')</button>
                                    <button type="button" class="btn btn--md btn--outline-base actionBtn active" data-type="influencer">@lang('Influencer')</button>
                                </div>
                            </div>
                            <form action="{{ route('influencer.register') }}" method="POST" class="form verify-gcaptcha">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="username">@lang('Username')</label>
                                            <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control form--control checkUser" required>
                                            <small class="text-danger usernameExist"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="email">@lang('Email Address')</label>
                                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control form--control checkUser" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="email">@lang('Country')</label>
                                            <select name="country" class="form-select form--control" required>
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">
                                                        {{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="mobile">@lang('Mobile')</label>
                                            <div class="input-group">
                                                <span class="input-group-text mobile-code"></span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" required>
                                            </div>
                                            <small class="text-danger mobileExist"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="password">@lang('Password')</label>
                                            <input type="password" id="password" name="password" class="form-control form--control" required>
                                            @if ($general->secure_password)
                                                <div class="input-popup">
                                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                                    <p class="error number">@lang('1 number minimum')</p>
                                                    <p class="error special">@lang('1 special character minimum')</p>
                                                    <p class="error minimum">@lang('6 character password')</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="password_confirm">@lang('Confirm Password')</label>
                                            <input type="password" id="password_confirm" name="password_confirmation" class="form-control form--control" required>
                                        </div>
                                    </div>

                                    <x-captcha></x-captcha>

                                    @if ($general->agree)
                                        <div class="form-group custom--checkbox">
                                            <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                            <label for="agree" class="ms-2">@lang('I agree with')
                                                @foreach ($policyPages as $policy)
                                                    <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}" class="text--base">
                                                        {{ __(@$policy->data_values->title) }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </label>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" id="recaptcha" class="btn btn--base w-100">@lang('Submit')</button>
                            </form>
                            <div class="text-center">
                                <p class="mt-3">@lang('Have an account? ')
                                    <a href="{{ route('influencer.login') }}" class="text--base login-url">@lang('Login here')</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('influencer.login') }}" class="btn btn--base btn--sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobile_code)
                $(`option[data-code={{ $mobile_code }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('influencer.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });

            $('.actionBtn').on('click',function () {
                let action;
                let loginUrl;
                let pageTitle;

                if($(this).data('type') == 'client'){
                    action = `{{ route('user.register') }}`;
                    loginUrl = `{{ route('user.login') }}`;
                    pageTitle = `{{ __(@$registerUser->data_values->title) }}`;
                }else{
                    action = `{{ route('influencer.register') }}`;
                    loginUrl = `{{ route('influencer.login') }}`;
                    pageTitle = `{{ __(@$register->data_values->title) }}`;
                }
                $('form')[0].action = action;

                $(this).addClass('active');
                $('.login-url').attr('href',loginUrl);
                $('.this-page-title').text(pageTitle);
                $('.actionBtn').not($(this)).removeClass('active');
            });
        })(jQuery);
    </script>
@endpush
