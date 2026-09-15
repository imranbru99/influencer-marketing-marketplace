@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="card-title m-0">{{ $pageTitle }}</h4>
            <a href="{{ route('ticket') }}" class="btn btn--outline-custom btn--sm">@lang('My Tickets')</a>
        </div>
        <div class="card-body">
            <form class="row gy-3" action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                @csrf
                <input type="hidden" name="name" value="{{ @$user->fullname }}">
                <input type="hidden" name="email" value="{{ @$user->email }}">

                <div class="form--group col-sm-12">
                    <label for="subject" class="form-label">@lang('Subject')</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                           class="form-control form--control" required>
                </div>
                <div class="form--group col-md-12">
                    <label class="form-label">@lang('Priority')</label>
                    <select name="priority" class="form-control form--control form-select" required>
                        <option value="3">@lang('High')</option>
                        <option value="2">@lang('Medium')</option>
                        <option value="1">@lang('Low')</option>
                    </select>
                </div>
                <div class="form--group col-sm-12">
                    <label for="message" class="form-label">@lang('Message')</label>
                    <textarea id="message" name="message" class="form-control form--control" required>{{ old('message') }}</textarea>
                </div>
                <div class="form--group col-sm-12">
                    <label class="form-label">@lang('Attachments')</label>
                    <div class="form-group d-flex gap-2">
                        <input type="file" class="form-control form--control" name="attachments[]" id="file2">
                        <button class="btn btn--base addFile border-0" type="button">
                            <i class="las la-plus"></i>
                        </button>
                    </div>
                    <div id="more-attachment">

                    </div>
                    <span class="info fs-sm">
                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                        .@lang('pdf'), .@lang('doc'), .@lang('docx')
                    </span>
                </div>
                <div class="col-sm-12">
                    <button class="btn btn--base w-100" type="submit" id="recaptcha">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#more-attachment").append(`
                    <div class="form-group d-flex gap-2 mt-3">
                        <input type="file" class="form-control form--control " name="attachments[]" id="file2">
                        <button class="btn btn--danger border-0 remove-btn" type="button"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.form-group').remove();
            });
        })(jQuery);
    </script>
@endpush
