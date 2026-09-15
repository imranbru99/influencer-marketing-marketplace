@php
$banner = getContent('banner.content', true);
@endphp
<section class="banner-section bg_img overflow-hidden mb-0">
    <div class="container position-relative">
        <div class="d-flex justify-content-lg-between align-items-center flex-wrap">
            <div class="banner-content py-4">
                <span class="modern-badge modern-badge--gradient mb-3">
                    <i class="las la-shield-alt me-1"></i> @lang('100% Escrow Protected • Verified Creators')
                </span>
                <h1 class="title">{{ __(@$banner->data_values->heading) }}</h1>
                <p>{{ __(@$banner->data_values->subheading) }}</p>

                <!-- Modern Glass Search Box -->
                <form action="{{ route('influencers') }}" class="banner-search-wrapper" method="GET">
                    <div class="d-flex align-items-center">
                        <div class="icon ps-2 text-white-50"><i class="fas fa-search"></i></div>
                        <input type="text" name="search" class="form-control" placeholder="@lang('Search creators by niche, platform, or skills...')">
                        <button type="submit" class="btn btn--base">@lang('Explore')</button>
                    </div>
                </form>

                <!-- Platform Quick Filter Chips -->
                <div class="platform-filter-chips">
                    <span class="text-white-50 fs--13px align-self-center me-1">@lang('Popular'):</span>
                    <a href="{{ route('influencers') }}?search=Instagram" class="platform-chip">
                        <i class="lab la-instagram text-danger"></i> Instagram
                    </a>
                    <a href="{{ route('influencers') }}?search=TikTok" class="platform-chip">
                        <i class="lab la-tiktok text-info"></i> TikTok
                    </a>
                    <a href="{{ route('influencers') }}?search=YouTube" class="platform-chip">
                        <i class="lab la-youtube text-danger"></i> YouTube
                    </a>
                    <a href="{{ route('influencers') }}?search=UGC" class="platform-chip">
                        <i class="las la-video text-warning"></i> UGC Creator
                    </a>
                    <a href="{{ route('campaign.brief') }}" class="platform-chip" style="border-color: rgba(var(--base-rgb, 108, 92, 231), 0.5); color: #a29bfe;">
                        <i class="las la-magic"></i> @lang('Brief Tool')
                    </a>
                </div>

                @if($tags->count())
                <ul class="tags mt-4 pt-2">
                    <li class="text-white-50 fs--13px">@lang('Trending Tags') :</li>
                    @foreach ($tags as $tag)
                        <li>
                            <a class="btn btn--sm btn--outline-light rounded-pill px-3" href="{{ route('service.tag', [$tag->id, slug($tag->name)]) }}">
                            #{{ __($tag->name) }}</a>
                        </li>
                    @endforeach
                </ul>
                @endif
            </div>

            <!-- Right Hero Image with Floating Badges -->
            <div class="banner-thumb ps-xl-5 ps-lg-4 d-lg-block d-none position-relative">
                <div class="hero-floating-badge badge-top-left">
                    <div class="rounded-circle bg-warning p-2 text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="las la-star fs-5"></i>
                    </div>
                    <div>
                        <h6 class="m-0 fs--14px fw-bold text-dark">4.9 / 5.0 Rating</h6>
                        <small class="text-muted fs--12px">Over 50K+ Collaborations</small>
                    </div>
                </div>

                <img src="{{ getImage('assets/images/frontend/banner/' . @$banner->data_values->image, '500x735') }}" alt="Influencer Hero" class="rounded-4">

                <div class="hero-floating-badge badge-bottom-right">
                    <div class="rounded-circle bg-success p-2 text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="las la-lock fs-5"></i>
                    </div>
                    <div>
                        <h6 class="m-0 fs--14px fw-bold text-dark">Escrow Security</h6>
                        <small class="text-muted fs--12px">Funds Released on Approval</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@php
    $partnerContent = getContent('partner.content', true);
    $partnerElement = getContent('partner.element', false, null, true);
@endphp

<section class="brand-section bg--light pt-30 pb-30 overflow-hidden">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-md-3 col-lg-2">
                <h5 class="text-center text-md-start">{{ __(@$partnerContent->data_values->heading) }}</h5>
            </div>
            <div class="col-md-9 col-lg-10">
                <div class="brands-slider">
                    @foreach ($partnerElement as $partner)
                    <div class="single-slide">
                        <div class="brand-item">
                            <img src="{{ getImage('assets/images/frontend/partner/' . @$partner->data_values->image, '130x65') }}" alt="brands">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

