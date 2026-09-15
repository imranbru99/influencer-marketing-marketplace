@extends($activeTemplate . 'layouts.master')
@section('content')
@php
$kycContent = getContent('influencer_kyc.content', true);
@endphp
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card custom--card">
                <div class="card-body">
                    @if (authInfluencer()->kv == 0)
                    <div class="alert alert-info mb-4" role="alert">
                        <h4 class="alert-heading">@lang('KYC Verification')</h4>
                        <hr>
                        <p class="mb-0">{{ __($kycContent->data_values->verification_content) }}</p>
                    </div>
                    @endif
                    <form action="{{ route('influencer.kyc.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <x-viser-form identifier="act" identifierValue="influencer_kyc"></x-viser-form>
                        </div>
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
