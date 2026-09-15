@php
$kycContent = getContent('influencer_kyc.content', true);
@endphp
@extends($activeTemplate . 'layouts.master')
@section('content')
@if (authInfluencer()->kv == 0)
<div class="alert alert-info" role="alert">
    <h4 class="alert-heading">@lang('KYC Verification required')</h4>
    <hr>
    <p class="mb-0">{{ __($kycContent->data_values->verification_content) }}
        <a href="{{ route('influencer.kyc.form') }}" class="text--base">@lang('Click Here to Verify')</a>
    </p>
</div>
@elseif(authInfluencer()->kv == 2)
<div class="alert alert-warning" role="alert">
    <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
    <hr>
    <p class="mb-0">{{ __($kycContent->data_values->pending_content) }}
        <a href="{{ route('influencer.kyc.data') }}" class="text--base">@lang('See KYC Data')</a>
    </p>
</div>
@endif
<div class="row justify-content-center gy-4">
    <div class="col-xxl-4 col-md-6 col-sm-10">
        <div class="dashboard-widget widget--base">
            <div class="dashboard-widget__icon">
                <i class="las la-money-check"></i>
            </div>
            <div class="dashboard-widget__content">
                <p>@lang('Current Balance')</p>
                <h4 class="title">{{ showAmount($data['current_balance']) }} {{ $general->cur_text }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-md-6 col-sm-10">
        <div class="dashboard-widget widget--primary">
            <div class="dashboard-widget__icon">
                <i class="las la-wallet"></i>
            </div>
            <div class="dashboard-widget__content">
                <p>@lang('Total Withdrawn')</p>
                <h4 class="title">{{ showAmount($data['withdraw_balance']) }} {{ $general->cur_text }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-md-6 col-sm-10">
        <div class="dashboard-widget widget--secondary">
            <div class="dashboard-widget__icon">
                <i class="las la-exchange-alt"></i>
            </div>
            <div class="dashboard-widget__content">
                <p>@lang('Total Transaction')</p>
                <h4 class="title">{{ $data['total_transaction'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-md-6 col-sm-10">
        <div class="dashboard-widget widget--info">
            <div class="dashboard-widget__icon">
                <i class="las la-list"></i>
            </div>
            <div class="dashboard-widget__content">
                <p>@lang('Total Hiring')</p>
                <h4 class="title">{{ $data['total_hiring'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-md-6 col-sm-10">
        <div class="dashboard-widget widget--purple">
            <div class="dashboard-widget__icon">
                <i class="las la-list-ol"></i>
            </div>
            <div class="dashboard-widget__content">
                <p>@lang('Total Order')</p>
                <h4 class="title">{{ $data['total_order'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-md-6 col-sm-10">
        <div class="dashboard-widget widget--warning">
            <div class="dashboard-widget__icon">
                <i class="las la-list-alt"></i>
            </div>
            <div class="dashboard-widget__content">
                <p>@lang('Total Service')</p>
                <h4 class="title">{{ $data['total_service'] }}</h4>
            </div>
        </div>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="job__completed my-4">
            <div class="job__completed-header d-flex align-items-center justify-content-between">
                <h5>@lang('Order Status')</h5>
            </div>
            <div class="job__completed-body">
                <div id="orderChart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="job__completed my-4">
            <div class="job__completed-header d-flex align-items-center justify-content-between">
                <h5>@lang('Hiring Status')</h5>
            </div>
            <div class="job__completed-body">
                <div id="hiringChart"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {
            var options = {
                series: [
                    {{ $data['pending_order'] }},
                    {{ $data['completed_order'] }},
                    {{ $data['inprogress_order'] }},
                    {{ $data['cancelled_order'] }},
                    {{ $data['job_done_order'] }},
                    {{ $data['reported_order'] }},
                    {{ $data['rejected_order'] }}
                ],
                chart: {
                width: 380,
                type: 'pie',
                },
                labels: [
                    `Pending ({{ @$data['pending_order'] }})`,
                    `Completed ({{ @$data['completed_order'] }})`,
                    `Inprogress ({{ @$data['inprogress_order'] }})`,
                    `Cancelled ({{ @$data['cancelled_order'] }})`,
                    `Job Done ({{ @$data['job_done_order'] }})`,
                    `Reported ({{ @$data['reported_order'] }})`,
                    `Rejected ({{ @$data['rejected_order'] }})`
                ],
                colors: [
                    "#868e96",
                    "#28c76f",
                    "#4634ff",
                    "#071251",
                    "#1e9ff2",
                    "#ff9f43",
                    "#ea5455"
                ],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#orderChart"), options);
            chart.render();

            var options = {
                series: [
                    {{ $data['pending_hiring'] }},
                    {{ $data['completed_hiring'] }},
                    {{ $data['inprogress_hiring'] }},
                    {{ $data['cancelled_hiring'] }},
                    {{ $data['job_done_hiring'] }},
                    {{ $data['reported_hiring'] }},
                    {{ $data['rejected_hiring'] }}
                ],
                chart: {
                width: 380,
                type: 'pie',
                },
                labels: [
                    `Pending ({{ @$data['pending_hiring'] }})`,
                    `Completed ({{ @$data['completed_hiring'] }})`,
                    `Inprogress ({{ @$data['inprogress_hiring'] }})`,
                    `Cancelled ({{ @$data['cancelled_hiring'] }})`,
                    `Job Done ({{ @$data['job_done_hiring'] }})`,
                    `Reported ({{ @$data['reported_hiring'] }})`,
                    `Rejected ({{ @$data['rejected_hiring'] }})`
                ],
                colors: [
                    "#868e96",
                    "#28c76f",
                    "#4634ff",
                    "#071251",
                    "#1e9ff2",
                    "#ff9f43",
                    "#ea5455"
                ],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#hiringChart"), options);
            chart.render();

        });
</script>
@endpush
