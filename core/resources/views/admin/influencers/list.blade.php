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
                                <th>@lang('Email-Phone')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Balance')</th>
                                <th>@lang('Complete Order')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($influencers as $influencer)
                            <tr>
                                <td data-label="@lang('Influencer')">
                                    <span class="fw-bold">{{$influencer->fullname}}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.influencers.detail', $influencer->id) }}"><span>@</span>{{ $influencer->username }}</a>
                                    </span>
                                </td>


                                <td data-label="@lang('Email-Phone')">
                                    {{ $influencer->email }}<br>{{ $influencer->mobile }}
                                </td>
                                <td data-label="@lang('Country')">
                                    <span class="fw-bold" title="{{ @$influencer->address->country }}">{{ $influencer->country_code }}</span>
                                </td>



                                <td data-label="@lang('Joined At')">
                                    {{ showDateTime($influencer->created_at) }} <br> {{ diffForHumans($influencer->created_at) }}
                                </td>


                                <td data-label="@lang('Balance')">
                                    <span class="fw-bold">
                                    {{ $general->cur_sym }}{{ showAmount($influencer->balance) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Complete Order')">
                                    <span class="fw-bold">{{ getAmount($influencer->completed_order) }}</span>
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.influencers.detail', $influencer->id) }}" class="btn btn-sm btn-outline--primary">
                                        <i class="las la-desktop text--shadow"></i> @lang('Details')
                                    </a>
                                    {{--  <a href="{{ route('admin.influencers.reviews', $influencer->id) }}" class="btn btn-sm btn-outline--info">
                                        <i class="las la-star"></i> @lang('Reviews')
                                    </a>  --}}
                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($influencers->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($influencers) }}
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
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search username')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush
