@php
$testimonialContent = getContent('testimonial.content', true);
$testimonials = getContent('testimonial.element', false, null, true);
@endphp
<section class="testimonial-section pt-80 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xxl-7">
                <div class="section-header text-center">
                    <h2 class="section-header__title">{{ __(@$testimonialContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="testimonial-slider">
            @foreach ($testimonials as $testimonial)
                <div class="single-slide">
                    <div class="testimonial-item">
                        <div class="testimonial-item__content">
                            <ul class="rating">
                                @php
                                echo showRatings($testimonial->data_values->rating);
                                @endphp
                            </ul>
                            <p>{{ __(@$testimonial->data_values->review) }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="testimonial-thumb-wrapper">
                                <div class="testimonial-thumb">
                                    <img src="{{ getImage('assets/images/frontend/testimonial/' . @$testimonial->data_values->profile_image, '150x150') }}" alt="cover">
                                </div>
                                <div class="testimonial-content">
                                    <h5 class="name">{{ __(@$testimonial->data_values->name) }}</h5>
                                    <p class="text--muted">{{ __(@$testimonial->data_values->designation) }}</p>
                                </div>
                            </div>
                            <span class="icon"><i class="fas fa-quote-right"></i></span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
