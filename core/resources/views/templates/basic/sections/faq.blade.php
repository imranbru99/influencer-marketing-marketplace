@php
$faq = getContent('faq.content', true);
$faqElement = getContent('faq.element',false,null,true);
@endphp
<section class="pt-80 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="text-center">
                    <h2 class="section-header__title">{{ __(@$faq->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="faq-wrapper p-0">
                    @foreach ($faqElement as $faq)
                    <div class="faq-single">
                        <div class="faq-single__header">
                            <h6 class="faq-single__title">{{ __(@$faq->data_values->question) }}</h6>
                        </div>
                        <div class="faq-single__content">
                            <p>{{ __(@$faq->data_values->answer) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
