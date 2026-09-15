@php
$socialIcons = getContent('social_icon.element', false, null, true);
$policyPages = getContent('policy_pages.element', false, null, true);
$contact = getContent('contact_us.content', true);
$footer = getContent('footer.content', true);
@endphp
<footer class="bg--accent footer pt-80">
    <div class="container">
        <div class="row gy-4 justify-content-between">
            <div class="col-lg-3 col-sm-6 col-md-5">
                <div class="footer-widget">
                    <a class="logo mb-4" href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="Logo"></a>
                    <p>{{ __(@$footer->data_values->description) }}</p>
                    <ul class="social-links d-flex mt-4 flex-wrap gap-3">
                        @foreach ($socialIcons as $social)
                            <li>
                                <a href="{{ @$social->data_values->url }}">
                                    @php
                                        echo @$social->data_values->social_icon;
                                    @endphp
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-md-5">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text--base mb-sm-3 mb-2 pb-1">@lang('Quick Links')</h5>
                    <ul class="footer-links">
                        <li>
                            <a href="{{ route('services') }}" class="{{ menuActive('services') }}">@lang('Services')</a>
                        </li>
                        <li>
                            <a href="{{ route('influencers') }}" class="{{ menuActive('influencers') }}">@lang('Influencers')</a>
                        </li>
                        <li>
                            <a href="{{ route('campaign.brief') }}" class="{{ menuActive('campaign.brief') }}">@lang('Brief Generator')</a>
                        </li>
                        <li>
                            <a href="{{ route('roi.calculator') }}" class="{{ menuActive('roi.calculator') }}">@lang('ROI Calculator')</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="{{ menuActive('contact') }}">@lang('Contact')</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-md-5">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text--base mb-sm-3 mb-2 pb-1">@lang('Usefull Links')</h5>
                    <ul class="footer-links">
                        @foreach ($policyPages as $policy)
                            <li>
                                <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">
                                    {{ __(@$policy->data_values->title) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-5">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text--base mb-sm-3 mb-2 pb-1">@lang('Contacts Info')</h5>
                    <ul class="footer-links">
                        <li><a href="mailto:{{ @$contact->data_values->email_address }}"><i class="las la-envelope-open"></i> {{ __(@$contact->data_values->email_address) }}</a></li>
                        <li><a href="tel:{{ @$contact->data_values->contact_number_one }}"><i class="las la-phone-volume"></i> {{ @$contact->data_values->contact_number_one }}</a></li>
                        <li><a href="tel:{{ @$contact->data_values->contact_number_two }}"><i class="las la-phone-volume"></i> {{ @$contact->data_values->contact_number_two }}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <p class="text-center border-top my-4 flex-wrap pt-4">
            @lang('Copyright') &copy; @php echo date('Y') @endphp. @lang('All Rights Reserved')
        </p>
    </div>
</footer>
