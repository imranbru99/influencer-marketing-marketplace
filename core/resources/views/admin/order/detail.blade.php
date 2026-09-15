@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-4 col-md-6 mb-30">
            @if ($order->status == 4)
                <div class="card b-radius--10 box--shadow1 mb-4 overflow-hidden">
                    <div class="card-header">
                        <h4 class="card-title mb-0 text-center"> <i class="la la-exclamation-triangle text--warning"></i> @lang('Reason of Report')</h4>
                    </div>
                    <div class="card-body">
                        <p class="text--danger">{{ $order->reason }}</p>
                    </div>
                    <div class="card-footer">
                        <p>@lang('Reported by') <a href="{{ route('admin.users.detail', $order->user_id) }}" target="blank">{{ $order->user->username }}</a> (@lang('Client'))</p>
                    </div>
                </div>

                <div class="card b-radius--10 box--shadow1 mb-4 overflow-hidden">
                    <div class="card-header">
                        <h4 class="card-title mb-0 text-center">@lang('Take Action')</h4>
                    </div>
                    <div class="card-body">
                        @if ($order->status == 4)
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-outline--danger confirmationBtn" data-action="{{ route('admin.order.action', [$order->id, 6]) }}" data-question="@lang("If you click on the 'yes' button, the client will get the balance. which was deducted during his order and the order will be rejected")" data-btn_class="btn btn--primary">
                                    <i class="la la-user-astronaut"></i>
                                    @lang('In Favour of Client')
                                </button>

                                <button type="button" class="btn btn-outline--success confirmationBtn" data-action="{{ route('admin.order.action', [$order->id, 1]) }}" data-question="@lang("If you click on the 'yes' button, the balance will be added to the influencer account and the order will be completed.")" data-btn_class="btn btn--primary">
                                    <i class="la la-user"></i>
                                    @lang('In Favour of Influencer')
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title mb-0 text-center">@lang('Order Information')</h4>
                </div>
                <div class="card-body p-0">

                    <ul class="list-group list-group-flush">


                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold"> @lang('Job Title')</span>
                            <span>{{ $order->title }} </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('order Date')</span>
                            <span>{{ showDateTime($order->created_at, 'd M, Y') }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Influencer')</span>
                            <span>
                                <a class="fw-bold" href="{{ route('admin.influencers.detail', $order->influencer_id) }}" target="blank">
                                    {{ '@' . $order->influencer->username }}
                                </a>
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Client')</span>
                            <span>
                                <a class="text--cyan fw-bold" href="{{ route('admin.users.detail', $order->user_id) }}" target="blank">
                                    {{ '@' . $order->user->username }}
                                </a>
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Amount')</span>
                            <span>{{ showAmount($order->amount) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold"> @lang('Delivery Date') <i class="fa fa-info-circle text--primary" title="@lang('Estimated delivary date from client end')"></i> </span>
                            <span>{{ showDateTime($order->delivery_date, 'd M, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Description')</span>
                            <button class="btn btn-sm btn-outline--primary descriptionBtn" data-description="{{ $order->description }}">@lang('View')</button>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Status')</span>
                            @php
                                echo $order->statusBadge;
                            @endphp
                        </li>

                    </ul>
                </div>
            </div>

        </div>
        <div class="col-xl-8 col-md-6 mb-30">
            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">@lang('Conversations')</h5>
                    <button type="button" class="btn btn-sm btn-outline--primary reloadBtn"><i class="las la-redo-alt"></i></button>

                </div>
                <div class="card-body">
                    <div class="chat-box" id="message">
                        @include('admin.order.conversation')
                    </div>
                    @if ($order->status == 4)
                        <div class="message-admin mt-5">
                            <form action="" method="POST" id="messageForm">
                                @csrf
                                <div class="input-group mb-3">
                                    <textarea name="message" class="form-control" placeholder="@lang('Write here.....')"></textarea>
                                </div>
                                <div class="input-group">
                                    <button type="submit" class="btn btn--primary w-100">@lang('Send Message')</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="descriptionModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="description"></p>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection
@push('style')
    <style>
        .gap-1 {
            gap: 5px;
        }

        .chat-box {
            max-height: 500px;
            overflow-y: scroll;
            scrollbar-width: thin;
            scrollbar-color: #ddd #fff;
        }

        .chat-box::-webkit-scrollbar {
            width: 12px;
        }

        .chat-box::-webkit-scrollbar-track {
            background: #fff;
        }

        .chat-box::-webkit-scrollbar-thumb {
            background-color: #ddd;
            border-radius: 20px;
            border: 3px solid #fff;
        }

        .single-message {
            width: 80%;
            padding: 20px;
            background-color: #f5f4fb;
            border-radius: 5px;
        }

        @media (max-width: 575px) {
            .single-message {
                width: 100%;
            }
        }

        .single-message+.single-message {
            margin-top: 15px;
        }

        .single-message.admin-message {
            margin-left: auto;
            background-color: #f7f7f7;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.descriptionBtn').on('click', function() {
                var modal = $('#descriptionModal');
                modal.find('.modal-title').text(`@lang('Description')`)
                modal.find('.description').html($(this).data('description'));
                modal.modal('show');
            });
            $('.viewReport').on('click', function() {
                var modal = $('#descriptionModal');
                modal.find('.modal-title').text(`@lang('Report Reason')`)
                modal.find('.description').text($(this).data('reason'));
                modal.modal('show');
            });

            $(".reloadBtn").on('click', function() {
                loadMore(10);
            });

            var messageCount = 10
            $(".chat-box").on('scroll', function() {
                if ($(this).scrollTop() == 0) {
                    messageCount += 10;
                    loadMore(messageCount);
                }
            });

            function loadMore(messageCount) {
                $.ajax({
                    method: "GET",
                    data: {
                        order_id: `{{ @$order->id }}`,
                        messageCount: messageCount
                    },
                    url: "{{ route('admin.order.conversation.message') }}",
                    success: function(response) {
                        $("#message").html(response);
                    }
                });
            }

            function scrollHeight() {
                $('.chat-box').animate({
                    scrollTop: $('.chat-box')[0].scrollHeight
                });
            }

            scrollHeight();

            $("#messageForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('admin.order.conversation.store', @$order->id) }}",
                    method: "POST",
                    data: formData,
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.error) {
                            notify('error', response.error);
                        } else {
                            $('#messageForm')[0].reset();
                            $("#message").append(response);
                            scrollHeight();
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
