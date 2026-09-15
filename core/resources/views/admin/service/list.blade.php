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
                                    <th>@lang('Influencer')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Order')</th>
                                    @if(request()->routeIs('admin.service.index'))
                                    <th>@lang('Status')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                <tr>
                                    <td data-label="@lang('Influencer')">
                                        <span class="fw-bold">{{@$service->influencer->fullname}}</span>
                                        <br>
                                        <span class="small">
                                        <a href="{{ route('admin.influencers.detail', @$service->influencer->id) }}"><span>@</span>{{ @$service->influencer->username }}</a>
                                        </span>
                                    </td>

                                    <td data-label="@lang('Category')">
                                        <span class="fw-bold">{{@$service->category->name}}</span>
                                    </td>

                                    <td data-label="@lang('Title')">
                                        <span>{{ strLimit($service->title,40) }}</span>
                                    </td>

                                    <td data-label="@lang('Order')">
                                        <span> @lang('Total') : {{ getAmount($service->total_order_count) }}</span><br>
                                        <span> @lang('Done') : {{ getAmount($service->complete_order_count) }}</span><br>
                                    </td>

                                    @if(request()->routeIs('admin.service.index'))
                                    <td data-label="@lang('Status')">
                                        @php echo $service->statusBadge @endphp
                                    </td>
                                    @endif

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.service.detail', $service->id) }}" class="btn btn-sm btn-outline--primary">
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
                @if ($services->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($services) }}
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
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search here')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush
