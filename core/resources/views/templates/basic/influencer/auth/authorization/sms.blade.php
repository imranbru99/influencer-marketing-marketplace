@extends($activeTemplate .'layouts.frontend')
@section('content')
<section class="pt-80 pb-80">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper">
                <div class="verification-area">
                    <h5 class="border-bottom pb-3 text-center">@lang('Verify Mobile Number')</h5>
                    <form action="{{route('influencer.verify.mobile')}}" method="POST" class="submit-form">
                        @csrf
                        <p class="mt-3">@lang('A 6 digit verification code sent to your mobile number') :  +{{ showMobileNumber(authInfluencer()->mobile) }}</p>
                        @include($activeTemplate.'partials.verification_code')
                        <div class="mb-3">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                        <div class="form-group">
                            <p>
                                @lang('If you don\'t get any code'), <a href="{{route('user.send.verify.code', 'phone')}}" class="forget-pass text--base"> @lang('Try again')</a>
                            </p>
                            @if($errors->has('resend'))
                                <br/>
                                <small class="text-danger">{{ $errors->first('resend') }}</small>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
