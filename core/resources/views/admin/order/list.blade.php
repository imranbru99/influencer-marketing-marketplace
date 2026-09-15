@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Order Number')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Influencer')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Delivery Date')</th>
                                @if(request()->routeIs('admin.order.index'))
                                <th>@lang('Status')</th>
                                @endif
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td data-label="@lang('Order Number')">
                                        <span class="fw-bold">{{ $order->order_no }}</span>
                                    </td>

                                    <td data-label="@lang('User')">
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail', $order->user_id) }}"><span>@</span>{{ @$order->user->username }}</a>
                                        </span>
                                    </td>

                                    <td data-label="@lang('Influencer')">
                                        <span class="small">
                                            <a href="{{ route('admin.influencers.detail', $order->influencer_id) }}"><span>@</span>{{ @$order->influencer->username }}</a>
                                        </span>
                                    </td>
                                    
                                    <td data-label="@lang('Amount')">
                                        <span class="fw-bold">{{ showAmount($order->amount) }} {{ $general->cur_text }}</span>
                                    </td>

                                    <td data-label="@lang('Delivery Date')">
                                        <span>{{ $order->delivery_date }}</span>
                                    </td>
                                    @if(request()->routeIs('admin.order.index'))
                                    <td data-label="@lang('Status')">
                                        @php echo $order->statusBadge @endphp
                                    </td>
                                    @endif

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.order.detail', $order->id) }}" class="btn btn-sm btn-outline--primary">
                                            <i class="las la-desktop text--shadow"></i> @lang('Details')
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($orders->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($orders) }}
                </div>
                @endif
            </div>
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <form action="" method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search influencer or category')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush
