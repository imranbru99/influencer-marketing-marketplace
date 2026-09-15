@extends($activeTemplate . 'layouts.frontend')
@section('content')
<div class="pt-80 pb-80">
    <div class="influencer-profile-area">
        <div class="container">
            <div class="influencer-profile-wrapper">
                <div class="d-flex justify-content-between flex-wrap gap-4">
                    <div class="left">
                        <div class="profile">
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('influencerProfile') . '/' . $influencer->image, getFileSize('influencerProfile'), true) }}" alt="profile thumb">
                            </div>
                            <div class="content">
                                <h5 class="fw-medium name account-status d-inline-block">{{ $influencer->fullname }}</h5>
                                <h6 class="text--base"> {{ $influencer->username }}</h6>

                                <span>@lang('Profession'): <i class="title text--small text--muted p-0 m-0">{{ $influencer->profession }}</i></span>
                                <ul class="list d-flex flex-wrap">
                                    <li>@lang('Member Since'): {{ $influencer->created_at->format('d M Y') }}</li>
                                    <li>
                                        <div class="rating-wrapper">
                                            <span class="text--warning service-rating">
                                                @php
                                                echo showRatings($influencer->rating);
                                                @endphp
                                                ({{ getAmount($influencer->total_review) }})
                                            </span>
                                        </div>
                                    </li>
                                </ul>

                                @if($influencer->categories)
                                    @foreach (@$influencer->categories as $category)
                                        <div class="justify-content-between skill-card mt-3">
                                            <span>{{ __(@$category->name) }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (!authInfluencerId())
                    <div class="right buttons-wrapper">
                        <a href="{{ route('user.hiring.request', [slug($influencer->username), $influencer->id]) }}" class="btn btn--outline-base btn--sm radius-0"><i class="fas fa-user-check"></i>
                            @lang('Hire Me Now')</a>

                        <a href="{{ route('user.conversation.create', $influencer->id) }}" class="btn btn--outline-info btn--sm radius-0"><i class="fas fa-sms"></i> @lang('Contact')</a>
                    </div>
                    @endif
                </div>

                <ul class="info d-flex justify-content-between border-top mt-4 flex-wrap gap-3 pt-4">
                    <li class="d-flex align-items-center gap-2">
                        <h4 class="text--warning d-inline-block">{{ $data['pending_job'] }}</h4>
                        <span>@lang('Pending Job')</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <h4 class="text--base d-inline-block">{{ $data['ongoing_job'] }}</h4>
                        <span>@lang('Ongoing Job')</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <h4 class="text--info d-inline-block">{{ $data['queue_job'] }}</h4>
                        <span>@lang('Queue Job')</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <h4 class="text--success d-inline-block">{{ $data['completed_job'] }}</h4>
                        <span>@lang('Completed Job')</span>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="profile-content mt-4">
                        <div class="custom--card">
                            <div class="card-body">
                                <div class="influencer-profile-sidebar">
                                    <h6 class="mb-3">@lang('Description')</h6>
                                    <p>
                                        @if ($influencer->summary)
                                        @php
                                        echo $influencer->summary;
                                        @endphp
                                        @else
                                        @lang('No summary have been added.')
                                        @endif
                                    </p>
                                </div>

                                @if ($influencer->skills)
                                <div class="influencer-profile-sidebar">
                                    <h6 class="mb-3">@lang('Skills')</h6>
                                    @foreach ($influencer->skills as $skill)

                                    <div class="justify-content-between skill-card my-1">
                                        <span>{{ __(@$skill) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                @if($influencer->languages)
                                    @foreach (@$influencer->languages as $key=>$profiencies)
                                    <div class="col-12 ">
                                        <div class="education-content py-3">
                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                <h6>{{ __($key) }}</h6>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 my-2">
                                                @foreach ($profiencies as $key=>$profiency)
                                                <span class="skill-card px-2 py-1 rounded">
                                                    {{ keyToTitle($key) }} : {{ $profiency }}
                                                </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif

                                @if ($influencer->education->count() > 0)
                                <div class="influencer-profile-sidebar">
                                    <h6 class="mb-3">@lang('Educations')</h6>
                                    @foreach ($influencer->education as $education)
                                    <div class="expertise-content">
                                        <div class="expertise-product">
                                            <div class="expertise-details">
                                                <h6 class="fs--15px mb-1 mt-3">{{ __($education->degree) }}
                                                </h6>
                                                <ul class="experties-meta fs--14px my-1">
                                                    <li class="text-dark">
                                                        <span>{{ __($education->institute) }},
                                                            {{ $education->country }}</span>
                                                    </li>
                                                </ul>
                                                <ul class="experties-meta fs--14px my-1">
                                                    <li class="text-dark">
                                                        <span>{{ __($education->start_year) }} -
                                                            {{ __($education->end_year) }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                @if ($influencer->qualification->count() > 0)
                                <div class="influencer-profile-sidebar">
                                    <h6 class="mb-3">@lang('Qualifications')</h6>
                                    @foreach ($influencer->qualification as $qualification)
                                    <div class="expertise-content">
                                        <div class="expertise-product">
                                            <div class="expertise-details">
                                                <h6 class="fs--15px mb-2">
                                                    {{ __($qualification->certificate) }}</h6>
                                                <ul class="experties-meta my-1">
                                                    <li class="text-dark">
                                                        <span>{{ __($qualification->organization) }},
                                                            {{ $qualification->year }}</span>
                                                    </li>
                                                </ul>
                                                <p>{{ __($qualification->summary) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    @if ($influencer->services->count())
                    <div class="profile-content mt-4">
                        <h4 class="mb-3">@lang('Services')</h4>
                        <div class="row gy-3">
                            @foreach ($influencer->services as $service)
                            <div class="col-lg-4 col-xl-4 col-md-6 col-sm-10">
                                <div class="service-item">
                                    <div class="service-item__thumb">
                                        <img src="{{ getImage(getFilePath('service') . '/thumb_' . $service->image, getFileThumb('service')) }}" alt="images">
                                    </div>
                                    <div class="service-item__content">

                                        <div class="d-flex flex-wrap justify-content-between my-1">
                                            <span class="service-rating">
                                                @php
                                                    echo showRatings(@$service->rating);
                                                @endphp
                                                ({{ $service->total_review ?? 0 }})
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
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if ($reviews->count() > 0)
                    <div class="profile-content mt-5">
                        <div class="custom--card">
                            <div class="card-body">
                                <h4 class="mb-3">@lang('Reviews')</h4>
                                @foreach ($reviews as $review)
                                <div class="d-flex justify-content-between review-item border-top flex-wrap gap-4 py-3">
                                    <div class="left">
                                        <div class="profile">
                                            <div class="thumb">
                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$review->user->image, getFileSize('userProfile'), true) }}" alt="profile thumb">
                                            </div>
                                            <div class="content">
                                                <h6 class="name">{{ __(@$review->user->fullname) }}
                                                </h6>
                                                <ul class="list d-flex fs--13px flex-wrap">
                                                    <li>{{ $review->created_at->format('d M Y') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="rating-wrapper">
                                            <ul class="rating d-inline-flex">
                                                @for ($i = 1; $i <= $review->star; $i++)
                                                    <i class="las la-star"></i>
                                                    @endfor

                                                    @for ($k = 1; $k <= 5 - $review->star; $k++)
                                                        <i class="lar la-star"></i>
                                                        @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p>{{ __($review->review) }}</p>
                                @endforeach
                                {{ $reviews->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('style')
<style>
    .profile .thumb {
        width: 100px;
        height: 100px;
    }
</style>
@endpush
