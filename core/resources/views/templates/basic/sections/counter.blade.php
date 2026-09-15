@php
$counters = getContent('counter.element', false, null, true);
@endphp
<div class="counter-section bg--accent pb-40 pt-40">
    <div class="container">
        <div class="row gy-3">
            @foreach ($counters as $counter)
                <div class="col-lg-6 col-sm-6 col-xl-3">
                    <div class="counter__item">
                        <div class="inner">
                            <div class="counter__item-icon">
                                @php
                                    echo @$counter->data_values->counter_icon;
                                @endphp
                            </div>
                            <div class="counter__item-content">
                                <h3 class="counter__item-title text-white">{{ @$counter->data_values->counter_digit }}</h3>
                                <span class="info">{{ __(@$counter->data_values->title) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
