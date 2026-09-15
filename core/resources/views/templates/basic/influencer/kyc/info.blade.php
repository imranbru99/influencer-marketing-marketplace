@extends($activeTemplate . 'layouts.master')
@section('content')
@php
$kycContent = getContent('influencer_kyc.content', true);
@endphp
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card custom--card">
                <div class="card-body">
                    @if(authInfluencer()->kv == 2)
                    <div class="alert alert-warning mb-4" role="alert">
                        <p class="mb-0"> {{ __($kycContent->data_values->pending_content) }}</p>
                    </div>
                    @endif
                    @if ($influencer->kyc_data)
                        <ul class="list-group-flush">
                            @foreach ($influencer->kyc_data as $val)
                                @continue(!$val->value)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __($val->name) }}
                                    <span>
                                        @if ($val->type == 'checkbox')
                                            {{ implode(',', $val->value) }}
                                        @elseif($val->type == 'file')
                                            <a href="{{ route('influencer.attachment.download', encrypt(getFilePath('verify') . '/' . $val->value)) }}"
                                                class="text--base me-3">
                                                <i class="fa fa-file"></i> @lang('Attachment')
                                            </a>
                                        @else
                                            <p>{{ __($val->value) }}</p>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h5 class="text-center">@lang('KYC data not found')</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
