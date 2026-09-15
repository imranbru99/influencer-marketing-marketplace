@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="card-title">@lang('Withdraw Via') {{ $withdraw->method->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('influencer.withdraw.submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    @php
                        echo $withdraw->method->description;
                    @endphp
                </div>
                <div class="row">
                    <x-viser-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}"></x-viser-form>
                </div>
                @if (authInfluencer()->ts)
                    <div class="form-group">
                        <label class="col-form-label">@lang('Google Authenticator Code')</label>
                        <input type="text" name="authenticator_code" class="form-control form--control" required>
                    </div>
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
@endsection

