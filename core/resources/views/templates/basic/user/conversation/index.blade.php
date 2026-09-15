@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="" class="d-flex flex-wrap justify-content-end ms-auto table--form mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}"
                        placeholder="@lang('Search by name')">
                    <button class="input-group-text bg--base text-white border-0 px-4"><i class="las la-search"></i></button>
                </div>
            </form>
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('Influencer')</th>
                        <th>@lang('Message')</th>
                        <th>@lang('Last Sent')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($conversations as $conversation)
                   
                        <tr>
                            <td data-label="@lang('Influencer')">
                                <div>
                                    <span class="fw-bold">{{ __(@$conversation->influencer->fullname) }}</span>
                                    <br>
                                    <small> {{ __(@$conversation->influencer->username) }} </small>
                                </div>
                            </td>
    
                            <td data-label="@lang('Message')">
                                <span>{{ strLimit(@$conversation->lastMessage->message,30) }}</span>
                            </td>
    
                            <td data-label="@lang('Last Sent')">
                                {{ showDateTime(@$conversation->lastMessage->created_at) }}<br>{{ diffForHumans(@$conversation->lastMessage->created_at) }}
                            </td>
    
                            <td data-label="@lang('Action')">
                                <a href="{{ route('user.conversation.view',$conversation->id) }}" class="btn btn--sm btn--outline-base">
                                    <i class="las la-sms"></i> @lang('Chat')
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="justify-content-center text-center" colspan="100%">
                                <i class="la la-4x la-frown"></i>
                                <br>
                                @lang('No messages yet')
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($conversations)
        {{ $conversations->links() }}
        @endif
    </div>
@endsection
