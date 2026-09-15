@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--19">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-money-bill-wave-alt"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym }}{{ showAmount($influencer->balance) }}</h3>
                            <p class="text-white">@lang('Balance')</p>
                        </div>
                        <a href="{{ route('admin.report.transaction') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ getAmount($totalService) }}</h3>
                            <p class="text-white">@lang('Services')</p>
                        </div>
                        <a href="{{ route('admin.service.index') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--1">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym }}{{ showAmount($totalWithdrawals) }}</h3>
                            <p class="text-white">@lang('Withdrawals')</p>
                        </div>
                        <a href="{{ route('admin.withdraw.log') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--17">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-exchange-alt"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $totalTransaction }}</h3>
                            <p class="text-white">@lang('Transactions')</p>
                        </div>
                        <a href="{{ route('admin.report.transaction') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--orange">
                        <div class="widget-two__icon b-radius--5 bg--orange">
                            <i class="las la-hourglass-start"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['pending_order'] }}</h3>
                            <p class="text-white">@lang('Pending Order')</p>
                        </div>
                        <a href="{{ route('admin.order.pending') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--info">
                        <div class="widget-two__icon b-radius--5 bg--info">
                            <i class="las la-tasks"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['inprogress_order'] }}</h3>
                            <p class="text-white">@lang('Inprogress Order')</p>
                        </div>
                        <a href="{{ route('admin.order.inprogress') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--18">
                        <div class="widget-two__icon b-radius--5 bg--18">
                            <i class="las la-check"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['job_done_order'] }}</h3>
                            <p class="text-white">@lang('Job Done')</p>
                        </div>
                        <a href="{{ route('admin.order.jobDone') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--green">
                        <div class="widget-two__icon b-radius--5 bg--green">
                            <i class="las la-check-circle"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['completed_order'] }}</h3>
                            <p class="text-white">@lang('Completed Order')</p>
                        </div>
                        <a href="{{ route('admin.order.completed') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--dark">
                        <div class="widget-two__icon b-radius--5 bg--dark">
                            <i class="las la-gavel"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['reported_order'] }}</h3>
                            <p class="text-white">@lang('Reported Order')</p>
                        </div>
                        <a href="{{ route('admin.order.reported') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--14">
                        <div class="widget-two__icon b-radius--5 bg--14">
                            <i class="las la-times-circle"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['cancelled_order'] }}</h3>
                            <p class="text-white">@lang('Cancelled Order')</p>
                        </div>
                        <a href="{{ route('admin.order.cancelled') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--warning">
                        <div class="widget-two__icon b-radius--5 bg--warning">
                            <i class="las la-spinner"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['pending_hiring'] }}</h3>
                            <p class="text-white">@lang('Pending Hiring')</p>
                        </div>
                        <a href="{{ route('admin.hiring.pending') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--blue">
                        <div class="widget-two__icon b-radius--5 bg--blue">
                            <i class="las la-tasks"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['inprogress_hiring'] }}</h3>
                            <p class="text-white">@lang('Inprogress Hiring')</p>
                        </div>
                        <a href="{{ route('admin.hiring.inprogress') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--indigo">
                        <div class="widget-two__icon b-radius--5 bg--indigo">
                            <i class="las la-check-double"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['job_done_hiring'] }}</h3>
                            <p class="text-white">@lang('Job Done Hiring')</p>
                        </div>
                        <a href="{{ route('admin.hiring.jobDone') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--success">
                        <div class="widget-two__icon b-radius--5 bg--success">
                            <i class="las la-check-square"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['completed_hiring'] }}</h3>
                            <p class="text-white">@lang('Completed Hiring')</p>
                        </div>
                        <a href="{{ route('admin.hiring.completed') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--black">
                        <div class="widget-two__icon b-radius--5 bg--black">
                            <i class="las la-hammer"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['reported_hiring'] }}</h3>
                            <p class="text-white">@lang('Reported Hiring')</p>
                        </div>
                        <a href="{{ route('admin.hiring.reported') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--danger">
                        <div class="widget-two__icon b-radius--5 bg--danger">
                            <i class="las la-times"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $data['cancelled_hiring'] }}</h3>
                            <p class="text-white">@lang('Cancelled Hiring')</p>
                        </div>
                        <a href="{{ route('admin.hiring.cancelled') }}?search={{ $influencer->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>

            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                        <i class="las la-plus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                        <i class="las la-minus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <a href="{{route('admin.report.login.history')}}?search={{ $influencer->username }}" class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.influencers.notification.log',$influencer->id) }}" class="btn btn--secondary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{route('admin.influencers.login',$influencer->id)}}" target="_blank" class="btn btn--primary btn--gradi btn--shadow w-100 btn-lg">
                        <i class="las la-sign-in-alt"></i>@lang('Login as Influencer')
                    </a>
                </div>

                @if($influencer->kyc_data)
                <div class="flex-fill">
                    <a href="{{ route('admin.influencers.kyc.details', $influencer->id) }}" target="_blank" class="btn btn--dark btn--shadow w-100 btn-lg">
                        <i class="las la-user-check"></i>@lang('KYC Data')
                    </a>
                </div>
                @endif

                <div class="flex-fill">
                    @if($influencer->status == 1)
                    <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                        <i class="las la-ban"></i>@lang('Ban Influencer')
                    </button>
                    @else
                    <button type="button" class="btn btn--success btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                        <i class="las la-undo"></i>@lang('Unban Influencer')
                    </button>
                    @endif
                </div>
            </div>


            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{$influencer->fullname}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.influencers.update',[$influencer->id])}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required value="{{$influencer->firstname}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required value="{{$influencer->lastname}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email') </label>
                                    <input class="form-control" type="email" name="email" value="{{$influencer->email}}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address" value="{{@$influencer->address->address}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city" value="{{@$influencer->address->city}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state" value="{{@$influencer->address->state}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip" value="{{@$influencer->address->zip}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Country')</label>
                                    <select name="country" class="form-control">
                                        @foreach($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group  col-xl-3 col-md-6 col-12">
                                <label>@lang('Email Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                       @if($influencer->ev) checked @endif>

                            </div>

                            <div class="form-group  col-xl-3 col-md-6 col-12">
                                <label>@lang('Mobile Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                       @if($influencer->sv) checked @endif>

                            </div>
                            <div class="form-group col-xl-3 col-md- col-12">
                                <label>@lang('2FA Verification') </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="ts" @if($influencer->ts) checked @endif>
                            </div>
                            <div class="form-group col-xl-3 col-md- col-12">
                                <label>@lang('KYC') </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="kv" @if($influencer->kv) checked @endif>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>



    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.influencers.add.sub.balance',$influencer->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control" placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __($general->cur_text) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($influencer->status == 1)
                        <span>@lang('Ban Influencer')</span>
                        @else
                        <span>@lang('Unban Influencer')</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.influencers.status',$influencer->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if($influencer->status == 1)
                        <h6 class="mb-2">@lang('If you ban this influencer he/she won\'t able to access his/her dashboard.')</h6>
                        <div class="form-group">
                            <label>@lang('Reason')</label>
                            <textarea class="form-control" name="reason" rows="4" required></textarea>
                        </div>
                        @else
                        <p><span>@lang('Ban reason was'):</span></p>
                        <p>{{ $influencer->ban_reason }}</p>
                        <h4 class="text-center mt-3">@lang('Are you sure to unban this influencer?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if($influencer->status == 1)
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
<script>
    (function($){
    "use strict"
        $('.bal-btn').click(function(){
            var act = $(this).data('act');
            $('#addSubModal').find('input[name=act]').val(act);
            if (act == 'add') {
                $('.type').text('Add');
            }else{
                $('.type').text('Subtract');
            }
        });
        let mobileElement = $('.mobile-code');
        $('select[name=country]').change(function(){
            mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
        });

        $('select[name=country]').val('{{@$influencer->country_code}}');
        let dialCode        = $('select[name=country] :selected').data('mobile_code');
        let mobileNumber    = `{{ $influencer->mobile }}`;
        mobileNumber        = mobileNumber.replace(dialCode,'');
        $('input[name=mobile]').val(mobileNumber);
        mobileElement.text(`+${dialCode}`);

    })(jQuery);
</script>
@endpush
