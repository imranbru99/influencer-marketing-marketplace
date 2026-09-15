@php
$favorite    = App\Models\Favorite::where('user_id', auth()->id())->select('influencer_id')->pluck('influencer_id');
$influencersId = json_decode($favorite);
$emptyMsgImage = getContent('empty_message.content', true);
@endphp
@if (request()->search)
<p>@lang('Search Result For') <span class="text--base">{{ __(request()->search) }}</span> : @lang('Total') <span class="text--base">{{ $influencers->count() }}</span> @lang('Influencers Found')</p>
@endif
@forelse ($influencers as $influencer)
<div class="col-md-6 col-lg-4 col-xl-4 col-sm-9 col-xs-10">
    <div class="influencer-item">
        @auth
            @if (in_array($influencer->id, @$influencersId))
            <a href="javascript:void(0)" class="favoriteBtn active" data-influencer_id="{{ $influencer->id }}"><i class="las la-heart"></i></a>
            @else
            <a href="javascript:void(0)" class="favoriteBtn" data-influencer_id="{{ $influencer->id }}"><i class="lar la-heart"></i></a>
            @endif
        @endauth
        <div class="influencer-thumb">
            <img src="{{ getImage(getFilePath('influencerProfile') . '/' . $influencer->image, getFileSize('influencerProfile'), true) }}" alt="cover">
            <span class="influencer-status @if ($influencer->isOnline()) active @endif"></span>
        </div>

        <div class="influencer-item__content">

            <h5 class="name text--muted">{{ __($influencer->fullname) }}</h5>
            <p class="text--muted">{{ __($influencer->profession) }}</p>

            <div class="rating d-flex justify-content-center align-items-center mt-2">

                <span class="me-1">
                    @php
                    echo showRatings($influencer->rating);
                    @endphp
                </span>
                ({{ getAmount($influencer->total_review) ?? 0 }})
            </div>


            <div class="d-flex justify-content-center mt-3 flex-wrap gap-4">
                <a href="{{ route('influencer.profile', [slug($influencer->username), $influencer->id]) }}" class="btn btn--sm btn--outline-base radius-0">@lang('View Profile')</a>
            </div>

            <ul class="social-links d-flex justify-content-center flex-wrap">
                @foreach ($influencer->socialLink as $social)
                <li><a href="{{ $social->url }}" data-bs-toggle="tooltip" data-placement="top" title="{{ __($social->followers) }}">@php echo $social->social_icon @endphp</a></li>
                @endforeach
            </ul>
        </div>
        @php
        $skills = array_slice($influencer->skills ?? [], 0, 4);
        @endphp
        <div class="skills-wrapper">
            @if ($influencer->skills)
            @foreach (@$skills as $skill)
            <span class="skill">{{ __($skill) }}</span>
            @endforeach
            @else
            <span class="skill m-auto">@lang('No Specific Skill')</span>
            @endif
        </div>


    </div>
</div>

@empty
<div class="col-md-6 col-lg-8">
    <img src="{{ getImage('assets/images/frontend/empty_message/' . @$emptyMsgImage->data_values->image, '800x600') }}" alt="" class="w-100">
</div>
@endforelse
{{ $influencers->links() }}

<script>
    try {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
    } catch (error) {

    }
</script>
