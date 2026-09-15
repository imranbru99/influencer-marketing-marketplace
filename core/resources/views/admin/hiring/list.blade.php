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
                                <th>@lang('Hiring Number')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Influencer')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Delivery Date')</th>
                                @if(request()->routeIs('admin.hiring.index'))
                                <th>@lang('Status')</th>
                                @endif
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($hirings as $hiring)
                                <tr>
                                    <td data-label="@lang('Hiring Number')">
                                        <span class="fw-bold">{{ $hiring->hiring_no }}</span>
                                    </td>

                                    <td data-label="@lang('User')">
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail', $hiring->user_id) }}"><span>@</span>{{ @$hiring->user->username }}</a>
                                        </span>
                                    </td>

                                    <td data-label="@lang('Influencer')">
                                        <span class="small">
                                            <a href="{{ route('admin.influencers.detail', $hiring->influencer_id) }}"><span>@</span>{{ @$hiring->influencer->username }}</a>
                                        </span>
                                    </td>
                                    
                                    <td data-label="@lang('Amount')">
                                        <span class="fw-bold">{{ showAmount($hiring->amount) }} {{ $general->cur_text }}</span>
                                    </td>

                                    <td data-label="@lang('Delivery Date')">
                                        <span>{{ $hiring->delivery_date }}</span>
                                    </td>
                                    @if(request()->routeIs('admin.hiring.index'))
                                    <td data-label="@lang('Status')">
                                        @php echo $hiring->statusBadge @endphp
                                    </td>
                                    @endif

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.hiring.detail', $hiring->id) }}" class="btn btn-sm btn-outline--primary">
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
                @if ($hirings->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($hirings) }}
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
