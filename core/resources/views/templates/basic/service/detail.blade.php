@php
$content = getContent('top_influencer.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
<section class="story-details pt-80 pb-80">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-9">
                <div class="story-item border-0 p-0 shadow-none">
                    <div class="service-order-wrapper__left">
                        <div class="service-details-slider">

                            <div class="single-slide">
                                <div class="slider-preview-thumb">
                                    <img src="{{ getImage(getFilePath('service') . '/' . $service->image, getFileSize('service')) }}" alt="image">
                                </div>
                            </div>

                            @foreach ($service->gallery as $gallery)
                            <div class="single-slide">
                                <div class="slider-preview-thumb">
                                    <img src="{{ getImage(getFilePath('service') . '/' . $gallery->image, getFileSize('service')) }}" alt="image">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="service-nav-slider">
                            @if ($service->gallery->count())
                            <div class="single-slide">
                                <div class="slider-nav-thumb">
                                    <img src="{{ getImage(getFilePath('service') . '/thumb_' . $service->image, getFileThumb('service')) }}" alt="image">
                                </div>
                            </div>
                            @endif
                            @foreach ($service->gallery as $gallery)
                            <div class="single-slide">
                                <div class="slider-nav-thumb">
                                    <img src="{{ getImage(getFilePath('service') . '/thumb_' . $gallery->image, getFileThumb('service')) }}" alt="image">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="story-item__content details-content">
                        <div class="story-meta d-flex justify-content-between flex-wrap">
                            <div class="story-meta">
                                @foreach ($service->tags as $tag)
                                <a href="{{ route('service.tag', [@$tag->id, slug(@$tag->name)]) }}" class="tag badge badge--base">{{ __(@$tag->name) }}</a>
                                @endforeach
                            </div>
                            <span class="text--warning service-rating">
                                @php
                                echo showRatings(@$service->rating);
                                @endphp
                                ({{ @$service->total_review ?? 0 }})
                            </span>

                        </div>
                        <h3 class="title">{{ __($service->title) }}</h3>
                        <p>@php echo $service->description; @endphp</p>
                    </div>
                </div>
                <div class="col-lg-12" id="review-section">
                    <ul class="nav nav-tabs custom--nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(!@$orderId) active @endif" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" >@lang('About')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(@$orderId) active @endif" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" >@lang('Reviews')</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade @if(!@$orderId) show active @endif" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p>
                                @php
                                echo @$service->influencer->summary;
                                @endphp
                            </p>
                        </div>
                        <div class="tab-pane fade @if(@$orderId) show active @endif" id="review" role="tabpanel" aria-labelledby="review-tab">
                            @if ($orderId)
                            <form action="{{ route('user.review.service.add', $orderId) }}" method="POST" class="row review-form rating gy-3">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-dark me-5">@lang('Your Ratings') :</label>
                                        <div class="rating-form-group">
                                            <label class="star-label">
                                                <input type="radio" name="star" value="1" />
                                                <span class="icon"><i class="las la-star"></i></span>
                                            </label>
                                            <label class="star-label">
                                                <input type="radio" name="star" value="2" />
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                            </label>
                                            <label class="star-label">
                                                <input type="radio" name="star" value="3" />
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                            </label>
                                            <label class="star-label">
                                                <input type="radio" name="star" value="4" />
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                            </label>
                                            <label class="star-label">
                                                <input type="radio" name="star" value="5" />
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                                <span class="icon"><i class="las la-star"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label text--dark">@lang('Say something about this service')</label>
                                        <textarea name="review" class="form-control form--control" placeholder="@lang('Write here')..." required>{{ old('review') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn--base w-100 btn--md">@lang('Submit')</button>
                                </div>
                            </form>
                            @endif
                            <div class="custom--card mt-4">
                                <div class="card-body">
                                    <h4 class="mb-3">@lang('Reviews')</h4>
                                    @forelse($service->reviews as $review)
                                    <div class="d-flex justify-content-between review-item border-top flex-wrap gap-4 py-3">
                                        <div class="left">
                                            <div class="profile">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$review->user->image, getFileSize('userProfile'), true) }}" alt="profile thumb">
                                                </div>
                                                <div class="content">
                                                    <h6 class="name">{{ __(@$review->user->fullname) }}</h6>
                                                    <ul class="list d-flex fs--13px flex-wrap">
                                                        <li>{{ $review->created_at->format('d M Y') }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="rating-wrapper">
                                                <ul class="rating d-inline-flex">
                                                    @php
                                                    echo showRatings(@$review->star);
                                                    @endphp

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="@if(!$loop->last) mb-3 @endif">{{ __($review->review) }}</p>
                                    @empty
                                    <h6 class="fw-light text--danger text-center">@lang('No Review found')</h6>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="text-center">
                        <ul class="share-links d-flex justify-content-center flex-wrap">
                            <li class="caption">@lang('Share') : </li>
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="lab la-facebook-f"></i></a>
                            </li>
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Linkedin">
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ __($service->title) }}&amp;summary={{ __($service->description) }}"><i class="lab la-linkedin-in"></i></a>
                            </li>
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter">
                                <a href="https://twitter.com/intent/tweet?text={{ __($service->title) }}%0A{{ url()->current() }}"><i class="lab la-twitter"></i></a>
                            </li>
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="pinterest">
                                <a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ __($service->title) }}&media={{ getImage(getFilePath('service') . '/' . $service->image, getFileSize('service')) }}"><i class="lab la-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="sidebar">

                    <div class="card custom--card">
                        <div class="card-header bg--light">
                            <h6 class="text--base">@lang('Price')</h6>
                            <h3 class="text--base">{{ $general->cur_sym }}{{ showAmount($service->price) }}</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list list-style-one ps-3 mb-3">
                                @foreach ($service->key_points as $point)
                                <li>{{ __($point) }}</li>
                                @endforeach
                            </ul>
                            @if(!authInfluencerId())
                            <a href="{{ route('user.order.form', $service->id) }}" class="btn btn--outline-base btn--md w-100">
                                @lang('Order Now')
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="sidebar-item mt-5">
                        <div class="influencer-item">
                            <div class="influencer-thumb">
                                <img src="{{ getImage(getFilePath('influencerProfile') . '/' . @$service->influencer->image, getFileSize('influencerProfile'), true) }}" alt="cover">
                                <span class="influencer-status @if (@$service->influencer->isOnline()) active @endif"></span>
                            </div>

                            <div class="influencer-item__content">

                                <h5 class="name text--muted">{{ __(@$service->influencer->fullname) }}</h5>
                                <p class="text--muted">{{ __(@$service->influencer->profession) }}</p>

                                <div class="rating d-flex justify-content-center align-items-center mt-2">

                                    <span class="me-1">
                                        @php
                                        echo showRatings(@$service->influencer->rating);
                                        @endphp
                                    </span>
                                    ({{ getAmount(@$service->influencer->total_review) ?? 0 }})
                                </div>


                                <div class="d-flex justify-content-center my-2 flex-wrap gap-4">
                                    <a href="{{ route('influencer.profile', [slug(@$service->influencer->username), @$service->influencer_id]) }}" class="btn btn--sm btn--outline-base radius-0">@lang('View Profile')</a>
                                </div>
                                <ul class="social-links d-flex justify-content-center flex-wrap">
                                    @foreach (@$service->influencer->socialLink as $social)
                                    <li><a href="{{ $social->url }}" data-bs-toggle="tooltip" data-placement="top" title="{{ __($social->followers) }}">@php echo $social->social_icon @endphp</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @php
                            $skills = array_slice(@$service->influencer->skills ?? [], 0, 4);
                            @endphp
                            <div class="skills-wrapper">
                                @if (@$service->influencer->skills)
                                @foreach (@$skills as $skill)
                                <span class="skill">{{ __($skill) }}</span>
                                @endforeach
                                @else
                                <span class="skill m-auto">@lang('No Specific Skill')</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($anotherServices->count() > 0)
                    <h4 class="mt-5 mb-3">@lang('Other Services')</h4>
                    @foreach ($anotherServices as $service)
                    <div class="sidebar-item">
                        <div class="recent-story story-item">
                            <div class="story-item__thumb">
                                <img src="{{ getImage(getFilePath('service') . '/thumb_' . $service->image, getFileThumb('service')) }}" alt="story">
                            </div>
                            <div class="story-item__content">
                                <h6 class="title"><a href="{{ route('service.details', [slug($service->title), $service->id]) }}">{{ __($service->title) }}</a></h6>
                                <div class="story-meta">
                                    @lang('Posted by') - <a href="{{ route('influencer.profile', [slug($service->influencer->username), $service->influencer_id]) }}"><span class="text--base"><span>@</span>{{ __(@$service->influencer->username) }}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<x-confirmation-modal></x-confirmation-modal>

@endsection

@push('style')
<style>
    .service-details-slider .single-slide img {
        max-height: 450px;
        display: inline-block;
    }

    .service-nav-slider {
        margin-top: 1.875rem;
    }

    .service-nav-slider .slick-list {
        margin: 0 -10px;
    }

    .service-nav-slider .single-slide {
        padding: 0 10px;
    }

    .service-nav-slider .slick-arrow {
        top: 50%;
        margin-top: -15px;
        width: 30px;
        height: 30px;
        border: 1px solid #3b2020;
        box-shadow: 0 0 3px rgba(116, 11, 11, 0.05);
        background-color: rgb(102, 34, 34);
        opacity: 0;
        visibility: hidden;
    }

    .service-nav-slider .slick-arrow.prev {
        left: 0px;
    }

    .service-nav-slider .slick-arrow.next {
        right: 0px;
    }

    .service-details-slider .single-slide {
        text-align: center;
    }

    .service-order-wrapper__left {
        width: 100%;
    }

    @media (max-width: 991px) {
        .service-order-wrapper__left {
            width: 100%;
        }
    }

    .service-order-wrapper__left:hover .service-nav-slider .slick-arrow {
        opacity: 1;
        visibility: visible;
    }

    .service-order-wrapper__left:hover .service-nav-slider .slick-arrow.prev {
        left: -20px;
    }

    .service-order-wrapper__left:hover .service-nav-slider .slick-arrow.next {
        right: -20px;
    }

    .service-order-wrapper__left {
        background-color: #fff;
    }

    .custom--nav-tabs {
        border-bottom: 1px solid #e5e5e5;
    }

    .nav {
        display: flex;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .custom--nav-tabs .nav-item .nav-link {
        background-color: transparent;
        border: none;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        -ms-border-radius: 0px;
        -o-border-radius: 0px;
        padding: 0.75rem 1.5625rem;
        font-weight: 500;
        border-bottom: 2px solid transparent;
    }

    .custom--nav-tabs .nav-item .nav-link.active {
        border-color: rgb(var(--base));
        ;
    }

    .custom--nav-tabs .nav-item .nav-link.active {
        color: rgb(var(--base));
    }

    .nav-link {
        color: #000;
    }
</style>
@endpush

@push('script')
<script>
    (function($){
        "use strict";
        @if(@$orderId)
            $('body,html').animate({scrollTop: 1000});
        @endif
    })(jQuery)
</script>
@endpush
