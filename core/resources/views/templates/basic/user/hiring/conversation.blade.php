@extends($activeTemplate.'layouts.master')
@section('content')
<div class="inbox">
    <div class="row justify-content-center gy-4">
        <div class="col-lg-12">
            <div class="card custom--card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show fade active" id="abc">
                            <div class="chat__msg" id="coversation_body">
                                <div class="chat__msg-header border-bottom">
                                    <div class="post__creator align-items-center d-flex flex-wrap justify-content-between">
                                        <div class="post__creator-content mb-3">
                                            <h5 class="name">{{ __(@$influencer->fullname) }}</h5>
                                            @if ($influencer->status == 0)
                                                <span class="text--base">@lang('Banned')</span>
                                            @else
                                            <small>
                                                @if ($influencer)
                                                    @if ($influencer->isOnline())
                                                    <span class="text--base">@lang('Online')</span>
                                                    @else
                                                    <span>@lang('Offline')</span>
                                                    @endif
                                                @endif
                                            </small>
                                            @endif
                                        </div>
                                        <div class="post__creator-content mb-3">
                                            <button class="btn btn--outline-custom btn--sm reloadBtn"><i class="las la-sync-alt"></i> @lang('Reload')</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat__msg-body position-relative">
                                    <div class="message-loader-wrapper">
                                        <div class="message-loader mx-auto"></div>
                                    </div>
                                    <ul class="msg__wrapper mt-3" id="message">
                                        @if($influencer)
                                            @include($activeTemplate.'user.conversation.message')
                                        @endif
                                    </ul>
                                </div>
                                @if (!($hiring->status == 1 || $hiring->status == 5 || $hiring->status == 6))
                                <div class="chat__msg-footer">
                                    <span class="file-count"></span>
                                    <form action="" method="POST" class="send__msg" enctype="multipart/form-data" id="messageForm">
                                        <div class="d-flex gap-2">
                                            <textarea type="text" class="form-control form--control messageVal" name="message" contenteditable="true" placeholder="@lang('Write Message')..." required></textarea>
                                            <button class="btn btn--base px-3 send-btn flex-shrink-0" type="submit">@lang('Send')</button>
                                        </div>
                                        <label class="upload-file" for="upload-file">@ @lang('Add Attachment')</label>
                                        <input id="upload-file" type="file" name="attachments[]" class="form-control d-none" accept=".png, .jpg, .jpeg, .pdf, .doc, .docx, .txt" multiple>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
<style>
    textarea {
        resize: none;
    }
</style>
@endpush
@push('script')
<script>
    (function($) {
            "use strict";
            $('.message-loader-wrapper').fadeOut(300);
            $('#upload-file').on('change', function() {
                var fileCount = $(this)[0].files.length;
                $('.file-count').text(`${fileCount} files upload`)
            });

            $(".reloadBtn").on('click',function () {
                loadMore(10);
            });

            var messageCount = 10
            $(".chat__msg-body").on('scroll',function () {
                if($(this).scrollTop() == 0) {
                    messageCount += 10;
                    loadMore(messageCount);
                }
            });

            function loadMore(messageCount){
                $('.message-loader-wrapper').fadeIn(300)
                $.ajax({
                    method: "GET",
                    data: {
                        hiring_id:`{{ @$hiring->id }}`,
                        messageCount:messageCount
                    },
                    url: "{{ route('user.hiring.conversation.message')}}",
                    success: function (response) {
                        $("#message").html(response);
                    }
                }).done(function() {
                    $('.message-loader-wrapper').fadeOut(500)
                });
            }

            $("#messageForm").submit(function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);

                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                    url:"{{ route('user.hiring.conversation.store', @$hiring->id) }}",
                    method:"POST",
                    data:formData,
                    async:false,
                    processData: false,
                    contentType: false,
                    success:function(response)
                    {
                        if(response.error){
                            notify('error', response.error);
                        }else{
                            $('#messageForm')[0].reset();
                            $('.file-count').text('')
                            $("#message").append(response);
                            scrollHeight();
                        }
                    }
                });
            });
        })(jQuery);
</script>
@endpush
