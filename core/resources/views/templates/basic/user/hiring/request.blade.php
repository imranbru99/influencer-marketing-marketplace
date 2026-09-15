@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="pt-80 pb-80">
        <div class="container">
            <div class="card custom--card">
                <div class="card-header">
                    <h4 class="card-title text-start">
                        @lang('Influencer Name') :
                        {{ __($influencer->fullname) }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.hiring.influencer', $influencer->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Title') </label>
                                    <input type="text" name="title" class="form-control form--control" value="{{ old('title') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Estimated Delivery Date') </label>
                                    <input type="text" class="datepicker-here form-control form--control" data-language='en' data-date-format="yyyy-mm-dd" data-position='bottom left' placeholder="@lang('Select date')" name="delivery_date" autocomplete="off" required>
                                    <small class="text-small"> <i class="la la-info-circle"></i> @lang('Year-Month-Date')</small>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Remuneration')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control form--control" name="amount" value="{{ old('amount') }}" required>
                                        <span class="input-group-text">{{ $general->cur_text }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Payment Type')</label>
                                    <select class="form-control form--control form-select" name="payment_type" required>
                                        <option value="" disabled selected>@lang('Select One')</option>
                                        <option value="2">@lang('Direct Payment')</option>
                                        <option value="1">@lang('Deposited Wallet') ({{ showAmount(auth()->user()->balance) }} {{ $general->cur_text }})</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">@lang('Description')</label>
                                    <textarea rows="4" class="form-control form--control nicEdit" name="description" id="description" placeholder="@lang('Description')">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/datepicker.min.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/datepicker.en.js') }}"></script>
@endpush
@push('script')
    <script>
        $('.datepicker-here').datepicker({
            changeYear: true,
            changeMonth: true,
            minDate: new Date(),
        });
    </script>
@endpush
