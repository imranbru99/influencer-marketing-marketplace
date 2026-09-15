@php
$influencerContent = getContent('top_influencer.content', true);
$influencers = App\Models\Influencer::with('socialLink')->where('completed_order','>',0)->orderBy('completed_order','desc')
    ->take(4)
    ->get();

$favorite    = App\Models\Favorite::where('user_id', auth()->id())->select('influencer_id')->pluck('influencer_id');
$influencersId = json_decode($favorite);
@endphp

@if ($influencers->count() > 0)
    <section class="influencer-section pt-80 pb-80 bg--light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xxl-6">
                    <div class="section-header text-center">
                        <h2 class="section-header__title">{{ __(@$influencerContent->data_values->heading) }}</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                @foreach ($influencers as $influencer)
                    <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-10">
                        <div class="influencer-item">
                            @auth
                                @if (in_array($influencer->id, @$influencersId))
                                <a href="javascript:void(0)" class="favoriteBtn active" data-influencer_id="{{ $influencer->id }}"><i class="las la-heart"></i></a>
                                @else
                                <a href="javascript:void(0)" class="favoriteBtn" data-influencer_id="{{ $influencer->id }}"><i class="lar la-heart"></i></a>
                                @endif
                            @endauth
                            <div class="influencer-thumb">
                                <img src="{{ getImage(getFilePath('influencerProfile') . '/' . @$influencer->image, getFileSize('influencerProfile'), true) }}" alt="cover">
                                <span class="influencer-status @if ($influencer->isOnline()) active @endif"></span>
                            </div>

                            <div class="influencer-item__content text-center">
                                <h5 class="name text-dark fw-bold mb-1">
                                    {{ __($influencer->fullname) }}
                                    <span class="verified-check-pill"><i class="las la-check-circle"></i> @lang('Verified')</span>
                                </h5>
                                <p class="text-muted fs--14px mb-2">{{ __($influencer->profession) }}</p>

                                <div class="rating d-flex justify-content-center align-items-center mb-3">
                                    <span class="me-1 text-warning">
                                        @php
                                        echo showRatings($influencer->rating);
                                        @endphp
                                    </span>
                                    <span class="fs--13px text-muted">({{ $influencer->total_review ?? 0 }})</span>
                                </div>

                                <div class="d-flex justify-content-center mb-3 flex-wrap gap-2">
                                    <a href="{{ route('influencer.profile', [slug($influencer->username), $influencer->id]) }}" class="btn btn--sm btn--base rounded-pill px-4">
                                        <i class="las la-user-circle me-1"></i> @lang('View Profile')
                                    </a>
                                </div>

                                <ul class="social-links d-flex justify-content-center flex-wrap">
                                    @foreach ($influencer->socialLink as $social)
                                        <li><a href="{{ $social->url }}" data-bs-toggle="tooltip" data-placement="top" title="{{ __($social->followers) }}">@php echo $social->social_icon @endphp</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="skills-wrapper">
                                @if($influencer->skills)
                                    @foreach (@$influencer->skills as $skill)
                                        <span class="skill">{{ __($skill) }}</span>
                                    @endforeach
                                @else
                                    <span class="skill m-auto">@lang('No Specific Skill')</span>
                                @endif
                            </div>


                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ route('influencers') }}" class="cmn--btn mt-5">@lang('View More')</a>
            </div>
        </div>
    </section>
@endif
