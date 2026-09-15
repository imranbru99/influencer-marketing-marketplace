@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
    $contact = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false, null, true);
    @endphp
    <section class="contact-area pt-80 pb-80">
        <div class="container">
            <div class="card custom--card">
                <div class="card-body">
                    <div class="row gy-5 justify-content-center align-items-center">
                        <div class="col-lg-7">
                            <div class="contact-form">
                                <h3 class="mb-4">{{ __(@$contact->data_values->heading) }}</h3>
                                <form method="post" action="" class="verify-gcaptcha">
                                    @csrf
                                    <div class="row gy-3">
                                        @php
                                            if(auth()->user()){
                                                $user = auth()->user();
                                            }elseif (auth()->guard('influencer')->user()) {
                                                $user = auth()->guard('influencer')->user();
                                            }
                                        @endphp

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Name')</label>
                                                <input type="text" name="name" id="name" class="form-control form--control" placeholder="@lang('Name')" value="{{ old('name', @$user->fullname) }}" required @if (@$user) readonly @endif>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Email')</label>
                                                <input type="email" name="email" id="email" class="form-control form--control" placeholder="@lang('Email')" value="{{ old('email', @$user->email) }}"required @if (@$user) readonly @endif>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="msg_subject">@lang('Subject')</label>
                                                <input type="text" name="subject" id="msg_subject" class="form-control form--control" placeholder="@lang('Subject')" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group has-error">
                                                <label class="form-label" for="message">@lang('Message')</label>
                                                <textarea name="message" class="form-control form--control" id="message" cols="30" rows="4" placeholder="@lang('Write your message')" required></textarea>
                                            </div>
                                        </div>

                                        <x-captcha></x-captcha>

                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="btn btn--base w-100">@lang('Send Message')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-5 ps-lg-4 ps-xl-5">
                            <div class="contacts-info">
                                <img src="{{ getImage('assets/images/frontend/contact_us/' . @$contact->data_values->image, '350x270') }}" class="contact-img mb-4" alt="image">
                                <div class="address row gy-4">
                                    <div class="location col-12">
                                        <div class="contact-card">
                                            <span class="icon"><i class="las la-map-marker"></i></span>
                                            <span>{{ __(@$contact->data_values->contact_details) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="contact-card">
                                            <span class="icon"><i class="las la-phone-volume"></i></span>
                                            <a href="tel:{{ @$contact->data_values->contact_number_one }}">{{ @$contact->data_values->contact_number_one }}</a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="contact-card">
                                            <span class="icon"><i class="las la-envelope-open"></i></span>
                                            <a href="mailto:{{ @$contact->data_values->email_address }}">{{ __(@$contact->data_values->email_address) }}</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="footer-widget">
                                    <ul class="social-links d-flex align-items-center mt-4 flex-wrap pt-2">
                                        <li>
                                            <h6 class="fs--15px me-2">@lang('Social'):</h6>
                                        </li>
                                        @foreach ($socialIcons as $social)
                                            <li class="me-2">
                                                <a href="{{ @$social->data_values->url }}" target="_blank">
                                                    @php
                                                        echo @$social->data_values->social_icon;
                                                    @endphp
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="map-area">
        <div class="map-wrap">
            <iframe src="https://maps.google.com/maps?q={{ @$contact->data_values->latitude }},{{ @$contact->data_values->longitude }}&hl=es;z=14&amp;output=embed"></iframe>
        </div>
    </div>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
