@php
$featureContent = getContent('feature.content', true);
$featureElement = getContent('feature.element', false, null, true);
@endphp
<section class="why-choose pt-80 pb-80 bg--light position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="section-header text-center">
                    <h2 class="section-header__title">{{ __(@$featureContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-sm-5 gy-4 justify-content-center align-items-center">
            <div class="col-xl-4 col-md-6 col-sm-10">
                @foreach ($featureElement as $feature)
                    @if ($loop->odd)
                        <div class="choose-item">
                            <div class="choose-item__icon">
                                @php
                                    echo @$feature->data_values->icon;
                                @endphp
                            </div>
                            <div class="choose-item__content">
                                <h5 class="title">{{ __(@$feature->data_values->title) }}</h5>
                                <p>{{ __(@$feature->data_values->description) }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="col-xl-4 col-md-6 col-sm-10 d-none d-xl-block px-xxl-5 align-self-end">
                <div class="why-thumb">
                    <img src="{{ getImage('assets/images/frontend/feature/' . @$featureContent->data_values->image, '440x570') }}" alt="images"
                         class="mw-100">
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-10">
                @foreach ($featureElement as $feature)
                    @if ($loop->even)
                        <div class="choose-item">
                            <div class="choose-item__icon">
                                @php
                                    echo @$feature->data_values->icon;
                                @endphp
                            </div>
                            <div class="choose-item__content">
                                <h5 class="title">{{ __(@$feature->data_values->title) }}</h5>
                                <p>{{ __(@$feature->data_values->description) }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>


