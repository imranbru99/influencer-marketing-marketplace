@php
$pages = App\Models\Page::where('tempname', $activeTemplate)
    ->where('is_default', 0)
    ->get();

$condition = request()->routeIs('user.*') || request()->routeIs('influencer.*') || request()->routeIs('ticket*');
@endphp


<div class="header @if($condition) dash-header @endif">
    <div class="header-bottom">
        <div class="container">
            <div class="header-bottom-area align-items-center">
                <div class="logo"><a href="{{ route('home') }}"><img src="@if(!$condition) {{ getImage(getFilePath('logoIcon') . '/logo.png') }} @else {{ getImage(getFilePath('logoIcon') . '/logo_dark.png') }} @endif " alt="logo"></a></div>
                <ul class="menu">
                    <li class="d-lg-none p-0 border-0 header-close ">
                        <span class="fs--20px text-white"><i class="las la-times"></i></span>
                    </li>

                    <li>
                        <a href="{{ route('home') }}" class="{{ menuActive('home') }}">@lang('Home')</a>
                    </li>

                    @foreach ($pages as $k => $data)
                        <li><a href="{{ route('pages', [$data->slug]) }}" class="{{ menuActive('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                    @endforeach

                    <li>
                        <a href="{{ route('services') }}" class="{{ menuActive('services') }}">@lang('Services')</a>
                    </li>

                    <li>
                        <a href="{{ route('influencers') }}" class="{{ menuActive('influencers') }}">@lang('Influencers')</a>
                    </li>

                    <li>
                        <a href="{{ route('campaign.brief') }}" class="{{ menuActive('campaign.brief') }} nav-feature-pill">
                            <i class="las la-magic"></i> @lang('Brief Generator')
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('roi.calculator') }}" class="{{ menuActive('roi.calculator') }}">
                            <i class="las la-calculator text--base"></i> @lang('ROI Calc')
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('contact') }}" class="{{ menuActive('contact') }}">@lang('Contact')</a>
                    </li>

                    <li class="d-lg-none">
                        @if (!(auth()->id() || authInfluencerId()))
                            <a href="{{ route('user.login') }}" class="btn btn-md btn--base">@lang('Login')</a>
                        @endif

                        @auth
                            <a href="{{ route('user.home') }}" class="btn btn-md btn--base">@lang('Dashboard')</a>
                        @endauth

                        @auth('influencer')
                            <a href="{{ route('influencer.home') }}" class="btn btn-md btn--base">@lang('Dashboard')</a>
                        @endauth
                    </li>
                </ul>
                <div class="header-trigger-wrapper d-flex align-items-center">
                    <div class="button-wrapper d-flex align-items-center flex-wrap" style="gap:8px 15px">
                        @if (!(auth()->id() || authInfluencerId()))
                            <ul class="d-flex align-items-center flex-wrap" style="gap:8px 15px">
                                <li class="me-0">
                                    <a href="{{ route('user.login') }}" class="login-btn btn btn--md btn--outline-base d-none d-sm-grid text-white">@lang('Login')</a>
                                </li>
                                <li class="me-0">
                                    <a href="{{ route('user.register') }}" class="login-btn btn btn--md btn--outline-base d-none d-sm-grid text-white">@lang('Register')</a>
                                </li>
                            </ul>
                        @endif

                        @auth
                            <ul class="d-flex align-items-center flex-wrap">
                                <li class="me-0">
                                    <a href="{{ route('user.home') }}" class="login-btn btn btn--md btn--outline-base d-none d-sm-grid text-white">@lang('Dashboard')</a>
                                </li>
                            </ul>
                        @endauth

                        @auth('influencer')
                            <ul class="d-flex align-items-center flex-wrap">
                                <li class="me-0">
                                    <a href="{{ route('influencer.home') }}" class="login-btn btn--md btn btn--outline-base d-none d-sm-grid text-white">@lang('Dashboard')</a>
                                </li>
                            </ul>
                        @endauth

                        @if($language->count())
                            <select class="language langSel form--control h-auto px-2 py-2">
                                @foreach ($language as $item)
                                    <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>
                                        {{ __($item->name) }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="header-trigger d-lg-none">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
