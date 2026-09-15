@php
$service = getContent('service.content', true);
$services = App\Models\Service::approved()
    ->with('influencer', 'category')
    ->latest()
    ->take(8)
    ->get();
@endphp
@if ($services->count() > 0)
    <section class="counter-section pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6">
                    <div class="section-header text-center">
                        <h2 class="section-header__title">{{ __(@$service->data_values->heading) }}</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                @foreach ($services as $service)
                    <div class="col-lg-4 col-xl-3 col-md-6 col-sm-10">
                        <div class="service-item">
                            <div class="service-item__thumb">
                                <img src="{{ getImage(getFilePath('service') . '/thumb_' . $service->image, getFileThumb('service')) }}" alt="images">
                            </div>
                            <div class="service-item__content">
                                <div class="influencer-thumb">
                                    <img src="{{ getImage(getFilePath('influencerProfile') . '/' . @$service->influencer->image, getFileSize('influencerProfile'), true) }}" alt="images">
                                </div>
                                <div class="d-flex justify-content-between mb-1 flex-wrap">
                                    <h6 class="name"> <i class="la la-user"></i> {{ __(@$service->influencer->username) }}</h6>
                                    <span class="service-rating">
                                        @php
                                            echo showRatings(@$service->rating);
                                        @endphp
                                        ({{ $service->reviews_count ?? 0 }})
                                    </span>
                                </div>
                                <h6 class="title mb-3 mt-2"><a href="{{ route('service.details', [slug($service->title), $service->id]) }}">{{ __(@$service->title) }}</a></h6>
                                <div class="service-footer border-top d-flex justify-content-between align-items-center flex-wrap pt-1">
                                    <span class="fs--14px"><i class="fas fa-tag fs--13px me-1"></i> {{ __(@$service->category->name) }}</span>
                                    <h6 class="service-price fs--15px"><small>{{ $general->cur_sym }}</small>{{ showAmount($service->price) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ route('services') }}" class="cmn--btn mt-5">@lang('View More')</a>
            </div>
        </div>
    </section>
@endif
