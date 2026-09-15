@extends($activeTemplate . 'layouts.frontend')
@section('content')
<div class="roi-calculator-section pt-80 pb-80">
    <div class="container">
        <!-- Header Banner -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="modern-badge modern-badge--gradient mb-3">
                    <i class="las la-calculator me-1"></i> @lang('Influencer Analytics & Pricing Suite')
                </span>
                <h2 class="section-heading-modern">@lang('Influencer Rate & ROI Calculator')</h2>
                <p class="section-subheading-modern">
                    @lang('Accurately benchmark creator pricing, forecast impressions, click-throughs, and calculate expected return on ad spend (ROAS) based on live industry algorithms.')
                </p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left: Calculator Inputs -->
            <div class="col-lg-6">
                <div class="modern-card p-4 p-md-5">
                    <h4 class="modern-card-title mb-4">
                        <i class="las la-chart-pie text--base me-2"></i> @lang('Campaign Parameters')
                    </h4>

                    <!-- Platform Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">@lang('Primary Platform')</label>
                        <div class="row g-2 platform-selector-grid">
                            <div class="col-3">
                                <label class="platform-btn active" data-platform="instagram">
                                    <input type="radio" name="platform" value="instagram" checked class="d-none">
                                    <i class="lab la-instagram fs-3 mb-1"></i>
                                    <span>Instagram</span>
                                </label>
                            </div>
                            <div class="col-3">
                                <label class="platform-btn" data-platform="tiktok">
                                    <input type="radio" name="platform" value="tiktok" class="d-none">
                                    <i class="lab la-tiktok fs-3 mb-1"></i>
                                    <span>TikTok</span>
                                </label>
                            </div>
                            <div class="col-3">
                                <label class="platform-btn" data-platform="youtube">
                                    <input type="radio" name="platform" value="youtube" class="d-none">
                                    <i class="lab la-youtube fs-3 mb-1"></i>
                                    <span>YouTube</span>
                                </label>
                            </div>
                            <div class="col-3">
                                <label class="platform-btn" data-platform="ugc">
                                    <input type="radio" name="platform" value="ugc" class="d-none">
                                    <i class="las la-video fs-3 mb-1"></i>
                                    <span>UGC Ads</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Follower Count Input & Slider -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold m-0">@lang('Follower / Audience Reach')</label>
                            <span id="followersDisplay" class="badge bg--base fs--14px px-3 py-1 text-white">45,000</span>
                        </div>
                        <input type="range" class="form-range modern-range" id="followersSlider" min="2000" max="1000000" step="1000" value="45000">
                        <div class="d-flex justify-content-between text-muted fs--12px mt-1">
                            <span>2K (Nano)</span>
                            <span>50K (Micro)</span>
                            <span>250K (Mid)</span>
                            <span>1M+ (Macro)</span>
                        </div>
                    </div>

                    <!-- Engagement Rate Slider -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold m-0">@lang('Average Engagement Rate')</label>
                            <span id="engagementDisplay" class="badge bg-secondary fs--14px px-3 py-1 text-white">3.5%</span>
                        </div>
                        <input type="range" class="form-range modern-range" id="engagementSlider" min="0.5" max="15.0" step="0.1" value="3.5">
                        <div class="d-flex justify-content-between text-muted fs--12px mt-1">
                            <span>0.5% (Low)</span>
                            <span>3.5% (Healthy)</span>
                            <span>7.0% (High)</span>
                            <span>15.0% (Viral)</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">@lang('Avg. Order Value (AOV)') ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" id="aovInput" class="form-control form--control" value="65" min="5" step="5">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">@lang('Website Conversion Rate') (%)</label>
                            <div class="input-group">
                                <input type="number" id="cvrInput" class="form-control form--control" value="2.5" min="0.1" max="20" step="0.1">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <button type="button" id="resetCalcBtn" class="btn btn--outline-base btn--sm">
                            <i class="las la-undo me-1"></i> @lang('Reset Defaults')
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Live Forecast Metrics & ROI Summary -->
            <div class="col-lg-6">
                <div class="modern-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="modern-card-title m-0">
                                <i class="las la-poll text--base me-2"></i> @lang('Performance Projections')
                            </h4>
                            <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 rounded-pill fs--12px">
                                <i class="las la-bolt"></i> @lang('Real-time Simulation')
                            </span>
                        </div>

                        <!-- 4 Metric Cards Grid -->
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="metric-card p-3 rounded-3 text-center">
                                    <span class="metric-label">@lang('Est. Impressions')</span>
                                    <h3 class="metric-value text--base mt-1 mb-0" id="estImpressions">18,000</h3>
                                    <span class="fs--11px text-muted">~40% reach ratio</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="metric-card p-3 rounded-3 text-center">
                                    <span class="metric-label">@lang('Est. Engagements')</span>
                                    <h3 class="metric-value text-primary mt-1 mb-0" id="estEngagements">1,575</h3>
                                    <span class="fs--11px text-muted">Likes & comments</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="metric-card p-3 rounded-3 text-center">
                                    <span class="metric-label">@lang('Estimated Clicks')</span>
                                    <h3 class="metric-value text-warning mt-1 mb-0" id="estClicks">315</h3>
                                    <span class="fs--11px text-muted">Link / Bio clicks</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="metric-card p-3 rounded-3 text-center">
                                    <span class="metric-label">@lang('Projected Orders')</span>
                                    <h3 class="metric-value text-success mt-1 mb-0" id="estOrders">8</h3>
                                    <span class="fs--11px text-muted">Based on 2.5% CVR</span>
                                </div>
                            </div>
                        </div>

                        <!-- ROI Highlight Box -->
                        <div class="roi-highlight-box p-4 rounded-3 mb-4">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm-6 border-end-sm">
                                    <span class="fs--13px text-muted d-block mb-1">@lang('Suggested Fair Rate')</span>
                                    <h3 class="m-0 text-dark fw-bold" id="suggestedRate">$350 - $450</h3>
                                    <small class="text-success fs--12px"><i class="las la-check"></i> @lang('Competitive Escrow Rate')</small>
                                </div>
                                <div class="col-sm-6 ps-sm-4">
                                    <span class="fs--13px text-muted d-block mb-1">@lang('Projected Return (ROI)')</span>
                                    <h3 class="m-0 text--base fw-bold" id="projectedRoi">2.4x</h3>
                                    <small class="text-muted fs--12px" id="projectedRevenue">~$520 Gross Revenue</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action CTAs -->
                    <div class="pt-3 border-top d-flex flex-wrap gap-3">
                        <a href="{{ route('influencers') }}" class="btn btn--base flex-grow-1">
                            <i class="las la-search me-1"></i> @lang('Browse Creators in This Tier')
                        </a>
                        <a href="{{ route('campaign.brief') }}" class="btn btn--outline-base">
                            <i class="las la-magic me-1"></i> @lang('Generate Brief Now')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .platform-selector-grid .platform-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 14px 8px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.25s ease;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-align: center;
        width: 100%;
    }
    .platform-selector-grid .platform-btn:hover {
        border-color: rgba(var(--base-rgb, 108, 92, 231), 0.5);
        background: #ffffff;
    }
    .platform-selector-grid .platform-btn.active {
        border-color: var(--base-color, #6c5ce7);
        background: rgba(var(--base-rgb, 108, 92, 231), 0.08);
        color: var(--base-color, #6c5ce7);
    }
    .modern-range {
        height: 6px;
        border-radius: 3px;
        accent-color: var(--base-color, #6c5ce7);
    }
    .metric-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
    }
    .metric-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: #64748b;
    }
    .metric-value {
        font-size: 26px;
        font-weight: 700;
    }
    .roi-highlight-box {
        background: linear-gradient(135deg, rgba(var(--base-rgb, 108, 92, 231), 0.08) 0%, rgba(var(--base-rgb, 108, 92, 231), 0.02) 100%);
        border: 1px solid rgba(var(--base-rgb, 108, 92, 231), 0.25);
    }
    @media (min-width: 576px) {
        .border-end-sm {
            border-right: 1px solid rgba(0,0,0,0.1);
        }
    }
</style>
@endpush

@push('script')
<script>
(function($) {
    "use strict";

    let currentPlatform = 'instagram';

    function calculateROI() {
        const followers = parseInt($('#followersSlider').val());
        const engagementRate = parseFloat($('#engagementSlider').val());
        const aov = parseFloat($('#aovInput').val()) || 50;
        const cvr = parseFloat($('#cvrInput').val()) || 2.0;

        // Platform multipliers
        let reachRatio = 0.40;
        let cpmRate = 12; // $/1000 impressions
        let clickRatio = 0.02;

        if (currentPlatform === 'tiktok') {
            reachRatio = 0.55;
            cpmRate = 10;
            clickRatio = 0.018;
        } else if (currentPlatform === 'youtube') {
            reachRatio = 0.35;
            cpmRate = 22;
            clickRatio = 0.035;
        } else if (currentPlatform === 'ugc') {
            reachRatio = 0.50;
            cpmRate = 15;
            clickRatio = 0.025;
        }

        const impressions = Math.round(followers * reachRatio);
        const engagements = Math.round(followers * (engagementRate / 100));
        const clicks = Math.round(engagements * clickRatio * 5);
        const orders = Math.max(1, Math.round(clicks * (cvr / 100)));
        const grossRevenue = Math.round(orders * aov);

        // Fair creator fee estimate
        const baseCost = Math.round((impressions / 1000) * cpmRate * (1 + (engagementRate / 10)));
        const minRate = Math.max(50, Math.round(baseCost * 0.85));
        const maxRate = Math.max(75, Math.round(baseCost * 1.25));

        const avgCost = (minRate + maxRate) / 2;
        const roi = (grossRevenue / avgCost).toFixed(1);

        // Update displays
        $('#followersDisplay').text(followers.toLocaleString());
        $('#engagementDisplay').text(engagementRate.toFixed(1) + '%');
        $('#estImpressions').text(impressions.toLocaleString());
        $('#estEngagements').text(engagements.toLocaleString());
        $('#estClicks').text(clicks.toLocaleString());
        $('#estOrders').text(orders.toLocaleString());
        $('#suggestedRate').text('$' + minRate.toLocaleString() + ' - $' + maxRate.toLocaleString());
        $('#projectedRoi').text(roi + 'x');
        $('#projectedRevenue').text('~$' + grossRevenue.toLocaleString() + ' Gross Sales');
    }

    $(document).ready(function() {
        calculateROI();

        $('.platform-btn').on('click', function() {
            $('.platform-btn').removeClass('active');
            $(this).addClass('active');
            currentPlatform = $(this).data('platform');
            calculateROI();
        });

        $('#followersSlider, #engagementSlider, #aovInput, #cvrInput').on('input change', function() {
            calculateROI();
        });

        $('#resetCalcBtn').on('click', function() {
            $('#followersSlider').val(45000);
            $('#engagementSlider').val(3.5);
            $('#aovInput').val(65);
            $('#cvrInput').val(2.5);
            $('.platform-btn[data-platform="instagram"]').trigger('click');
            calculateROI();
            notify('info', 'Calculator reset to standard benchmarks');
        });
    });
})(jQuery);
</script>
@endpush
