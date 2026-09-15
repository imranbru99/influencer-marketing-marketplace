@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h4 class="card-title text-start">
                @lang('Title'): {{ __(@$order->service->title) }}
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('user.review.service.add', @$order->id) }}" method="POST"
                  class="row review-form rating gy-2">
                @csrf
                <div class="form-group col-md-6">
                    <label class="form-label text-dark" for="description">@lang('Influencer Name')</label>
                    <input type="text" class="form-control form--control" value="{{ __(@$order->influencer->fullname) }}"
                           readonly required>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label text-dark" for="description">@lang('Email')</label>
                    <input type="text" class="form-control form--control" value="{{ __(@$order->influencer->email) }}"
                           readonly required>
                </div>
                <div class="form-group col-md-6 d-flex mt-3 flex-wrap">
                    <label class="form-label text-dark me-5">@lang('Rating')
                        :</label>
                    <div class="rating-form-group">
                        <label class="star-label">
                            <input type="radio" name="star" value="1" @if(@$order->review) {{ @$order->review->star == 1 ? 'checked': '' }} @endif/>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input type="radio" name="star" value="2" @if(@$order->review) {{ @$order->review->star == 2 ? 'checked': '' }} @endif/>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input type="radio" name="star" value="3" @if(@$order->review) {{ @$order->review->star == 3 ? 'checked': '' }} @endif/>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input type="radio" name="star" value="4" @if(@$order->review) {{ @$order->review->star == 4 ? 'checked': '' }} @endif/>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input type="radio" name="star" value="5" @if(@$order->review) {{ @$order->review->star == 5 ? 'checked': '' }} @endif/>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-12 d-flex flex-wrap">
                    <label class="form-label text-dark" for="review-comments">@lang('Review')</label>
                    <textarea name="review" class="form-control form--control" id="review-comments"
                              placeholder="@lang('Write here')..." required>@if(@$order->review) {{ @$order->review->review }} @else {{ old('review') }} @endif</textarea>
                </div>
                <div class="col-lg-12 mt-3">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
