@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="pt-80 pb-80">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper">
                    <div class="verification-area">
                        <h5 class="border-bottom pb-3 text-center">@lang('Verify Email Address')</h5>
                        <form action="{{ route('influencer.verify.email') }}" method="POST" class="submit-form">
                            @csrf
                            <p class="mt-3">@lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(authInfluencer()->email) }}</p>

                            @include($activeTemplate . 'partials.verification_code')

                            <div class="my-3">
                                <button type="submit" class="cmn--btn w-100">@lang('Submit')</button>
                            </div>

                            <div class="mb-3">
                                <p>
                                    @lang('If you don\'t get any code'), <a href="{{ route('influencer.send.verify.code', 'email') }}" class="text--base"> @lang('Try again')</a>
                                </p>

                                @if ($errors->has('resend'))
                                    <small class="text-danger d-block">{{ $errors->first('resend') }}</small>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
