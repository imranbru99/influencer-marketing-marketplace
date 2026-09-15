@php
$emptyMsgImage = getContent('empty_message.content', true);
@endphp
@if(request()->search)
<p>@lang('Search Result For') <span class="text--base">{{ __(request()->search) }}</span> : @lang('Total') <span class="text--base">{{ $services->count() }}</span> @lang('Service Found')</p>
@endif
@forelse ($services as $service)
    <div class="col-lg-4 col-xl-4 col-md-6 col-sm-10">
        <div class="service-item">
            <div class="service-item__thumb">
                <img src="{{ getImage(getFilePath('service') . '/thumb_' . $service->image, getFileThumb('service')) }}" alt="images">
            </div>
            <div class="service-item__content">
                <div class="influencer-thumb">
                    <img src="{{ getImage(getFilePath('influencerProfile') . '/' . @$service->influencer->image, getFileSize('influencerProfile'), true) }}" alt="images">
                </div>
                <div class="d-flex flex-wrap justify-content-between mb-1">
                    <h6 class="name"><i class="la la-user"></i> {{ __(@$service->influencer->username) }}</h6>
                    <span class="service-rating">
                        @php
                            echo showRatings(@$service->rating);
                        @endphp
                        ({{ @$service->total_review ?? 0 }})
                    </span>
                </div>
                <h6 class="title mb-3 mt-2"><a href="{{ route('service.details', [slug($service->title), $service->id]) }}">{{ __(@$service->title) }}</a></h6>
                <div class="service-footer border-top pt-1 d-flex flex-wrap justify-content-between align-items-center">
                    <span class="fs--14px"><i class="fas fa-tag fs--13px me-1"></i> {{ __(@$service->category->name) }}</span>
                    <h6 class="service-price fs--15px"><small>{{ $general->cur_sym }}</small>{{ showAmount($service->price) }}</h6>
                </div>
            </div>
        </div>
    </div>
@empty
<div class="col-md-6 col-lg-8">
    <img src="{{ getImage('assets/images/frontend/empty_message/' . @$emptyMsgImage->data_values->image, '800x600') }}" alt="" class="w-100">
</div>
@endforelse
{{ $services->links() }}
