@extends($activeTemplate . 'layouts.master')
@section('content')
    <table class="table table--responsive--lg">
        <thead>
            <tr>
                <th>@lang('Subject')</th>
                <th>@lang('Status')</th>
                <th>@lang('Priority')</th>
                <th>@lang('Last Reply')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supports as $key => $support)
                <tr>
                    <td data-label="@lang('Subject')">
                        <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold">
                            [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}</a>
                    </td>
                    <td data-label="@lang('Status')">
                        @php echo $support->statusBadge; @endphp
                    </td>
                    <td data-label="@lang('Priority')">
                        @if ($support->priority == 1)
                            <span class="badge badge--dark">@lang('Low')</span>
                        @elseif($support->priority == 2)
                            <span class="badge badge--success">@lang('Medium')</span>
                        @elseif($support->priority == 3)
                            <span class="badge badge--primary">@lang('High')</span>
                        @endif
                    </td>
                    <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }}
                    </td>

                    <td data-label="@lang('Action')">
                        <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--sm btn--outline-base">
                            <i class="la la-desktop"></i> @lang('View')
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="justify-content-center text-center" colspan="100%">
                        <i class="la la-4x la-frown"></i>
                        <br>
                        {{ __($emptyMessage) }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $supports->links() }}
@endsection
