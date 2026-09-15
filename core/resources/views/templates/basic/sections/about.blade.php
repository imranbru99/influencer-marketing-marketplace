@php
$aboutUs = getContent('about.content', true);
@endphp
<section class="about-section pt-80 pb-80">
    <div class="container">
        <div class="row gy-4 gy-sm-5">
            <div class="col-lg-5">
                <div class="section-header mb-0">
                    <h2 class="section-header__title">{{ __(@$aboutUs->data_values->title) }}</h2>
                    <p>{{ __(@$aboutUs->data_values->short_detail) }}</p>
                    <a href="{{ @$aboutUs->data_values->button_url }}" class="cmn--btn">{{ __(@$aboutUs->data_values->button_name) }}</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="section-thumb about-thumb pb-lg-5 mb-lg-4">
                    <img src="{{ getImage('assets/images/frontend/about/' . @$aboutUs->data_values->image, '600x400') }}" alt="thumb">
                    <div class="thumb-content">
                        <span class="fw-bold mb-3 text-uppercase text-white">{{ __(@$aboutUs->data_values->heading) }}</span>
                        <h4 class="tilte mb-2 text-white">{{ __(@$aboutUs->data_values->subheading) }}</h4>
                        <p class="text-white">{{ __(@$aboutUs->data_values->description) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
