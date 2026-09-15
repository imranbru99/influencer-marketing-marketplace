@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    @if ($layout == 'frontend')
        <div class="pt-80 pb-80">
            <div class="container">
    @endif
    <div class="card custom--card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h6 class="card-title m-0">
                @php echo $myTicket->statusBadge; @endphp [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
            </h6>
            @if ($myTicket->status != 3 && $myTicket->user)
                <button class="btn btn--danger btn--sm confirmationBtn" type="button" data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('ticket.close', $myTicket->id) }}" data-btn_class="btn btn--base btn--md"><i class="la la-lg la-times-circle"></i></button>
            @endif
        </div>

        <div class="card-body">
            @if ($myTicket->status != 4)
                <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <textarea name="message" class="form-control form--control shadow-none" id="inputMessage" placeholder="@lang('Your Reply')" rows="4" cols="10">{{ old('message') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputAttachments" class="form-label">@lang('Attachments')</label>
                        <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is')
                            {{ ini_get('upload_max_filesize') }}</small>
                        <div class="d-flex gap-2">
                            <input type="file" name="attachments[]" id="inputAttachments" class="form--control form-control">
                            <a href="javascript:void(0)" class="btn btn--base d-flex align-items-center addFile">
                                <i class="la la-plus"></i>
                            </a>
                        </div>
                        <div id="fileUploadsContainer"></div>
                        <p class="ticket-attachments-message text-muted mt-2 fs--13px">
                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'),
                            .@lang('png'), .@lang('pdf'),
                            .@lang('doc'), .@lang('docx')
                        </p>
                    </div>
                    <button type="submit" class="btn btn--base w-100 h-40">
                        <i class="fa fa-reply"></i> @lang('Reply')
                    </button>
                </form>
            @endif
        </div>
    </div>
    <div class="card custom--card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @foreach ($messages as $message)
                        @if ($message->admin_id == 0)
                            <div class="row border-radius-3 my-sm-3 mx-sm-2 ticket-reply-user my-2 mx-0 border py-3">
                                <div class="col-md-3 border--right text-end">
                                    <h5 class="text--base my-3">{{ @$message->ticket->name }}</h5>
                                </div>
                                <div class="col-md-9 ps-2">
                                    <p class="text-muted fw-bold">
                                        @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                    </p>
                                    <p>
                                        {{ __($message->message) }}
                                    </p>
                                    @if ($message->attachments->count() > 0)
                                        <div class="d-flex mt-2 flex-wrap gap-4">
                                            @foreach ($message->attachments as $k => $image)
                                                <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="text--base mr-3"><i class="fa fa-file"></i>
                                                    @lang('Attachment') {{ ++$k }} </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="row border-warning border-radius-3 my-sm-3 mx-sm-2 my-2 mx-0 border py-3">
                                <div class="col-md-3 border--right text-end">
                                    <h5 class="text--base my-3">{{ @$message->admin->name }}</h5>
                                </div>
                                <div class="col-md-9 ps-2">
                                    <p class="text-muted fw-bold">
                                        @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                    </p>
                                    <p>{{ __($message->message) }}</p>
                                    @if ($message->attachments->count() > 0)
                                        <div class="d-flex mt-2 flex-wrap gap-4">
                                            @foreach ($message->attachments as $k => $image)
                                                <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="text--base mr-3"><i class="la la-file"></i>
                                                    @lang('Attachment') {{ ++$k }} </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if ($layout == 'frontend')
        </div>
        </div>
    @endif
    <x-confirmation-modal></x-confirmation-modal>
@endsection

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
                $("#fileUploadsContainer").append(`
                    <div class="form-group d-flex gap-2 mt-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required/>
                        <button class="btn btn--danger radius-5 remove-btn" type="button"><i class="las la-times"></i></button>
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
