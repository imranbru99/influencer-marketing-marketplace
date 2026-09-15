<!-- ==========================================================================
     INFULAB ESCROW TRUST & CREATOR TOOLS SHOWCASE
     ========================================================================== -->
<section class="escrow-trust-section">
    <div class="container">
        <!-- Section Header -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="modern-badge modern-badge--gradient mb-3">
                    <i class="las la-shield-alt me-1"></i> @lang('Safe, Seamless & Guaranteed Collaborations')
                </span>
                <h2 class="section-heading-modern">@lang('How Infulab Escrow Protects Brands & Creators')</h2>
                <p class="section-subheading-modern text-muted">
                    @lang('Eliminate risks. Your campaign budget is held securely in escrow and released only when deliverables are verified.')
                </p>
            </div>
        </div>

        <!-- 4 Step Workflow Cards -->
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-sm-6">
                <div class="trust-step-card">
                    <span class="trust-step-number">1</span>
                    <div class="trust-step-icon">
                        <i class="las la-wallet"></i>
                    </div>
                    <h5 class="fs--17px fw-bold mb-2">@lang('Escrow Deposit')</h5>
                    <p class="fs--14px text-muted mb-0">
                        @lang('Client deposits campaign budget into secure escrow. Funds are locked until work is delivered.')
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="trust-step-card">
                    <span class="trust-step-number">2</span>
                    <div class="trust-step-icon">
                        <i class="las la-video"></i>
                    </div>
                    <h5 class="fs--17px fw-bold mb-2">@lang('Content Production')</h5>
                    <p class="fs--14px text-muted mb-0">
                        @lang('Creator produces high-quality content aligned with your campaign brief and submits draft for review.')
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="trust-step-card">
                    <span class="trust-step-number">3</span>
                    <div class="trust-step-icon">
                        <i class="las la-check-double"></i>
                    </div>
                    <h5 class="fs--17px fw-bold mb-2">@lang('Review & Approve')</h5>
                    <p class="fs--14px text-muted mb-0">
                        @lang('Review draft assets, request revisions if needed, or approve content once published live.')
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="trust-step-card">
                    <span class="trust-step-number">4</span>
                    <div class="trust-step-icon">
                        <i class="las la-coins"></i>
                    </div>
                    <h5 class="fs--17px fw-bold mb-2">@lang('Instant Release')</h5>
                    <p class="fs--14px text-muted mb-0">
                        @lang('Upon approval, escrow releases earnings directly to the creator with zero delay or disputes.')
                    </p>
                </div>
            </div>
        </div>

        <!-- Interactive Creator Tools Highlight Cards -->
        <div class="row g-4 mt-2">
            <!-- Card 1: AI Campaign Brief Generator -->
            <div class="col-md-6">
                <div class="modern-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between" style="background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(var(--base-rgb, 108, 92, 231), 0.05) 100%);">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill fs--12px fw-bold">
                                <i class="las la-magic"></i> @lang('Featured Tool')
                            </span>
                            <span class="fs--12px text-muted">@lang('Free for Brands & Agencies')</span>
                        </div>
                        <h3 class="fw-bold mb-2">@lang('AI Campaign Brief Generator')</h3>
                        <p class="text-muted fs--15px">
                            @lang('Generate structured, crystal-clear influencer briefs in seconds. Specify deliverables, talking points, hashtags, and FTC guidelines with 1-click export.')
                        </p>
                        <ul class="list-unstyled mb-4 fs--14px text-muted">
                            <li class="mb-1"><i class="las la-check-circle text-success me-2"></i> @lang('Standardized milestone checklist')</li>
                            <li class="mb-1"><i class="las la-check-circle text-success me-2"></i> @lang('One-click Markdown & text export')</li>
                            <li class="mb-1"><i class="las la-check-circle text-success me-2"></i> @lang('Pre-fills into direct hiring proposals')</li>
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('campaign.brief') }}" class="btn btn--base rounded-pill px-4">
                            <i class="las la-arrow-right me-1"></i> @lang('Launch Brief Generator')
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2: Influencer Rate & ROI Calculator -->
            <div class="col-md-6">
                <div class="modern-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between" style="background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255, 118, 117, 0.05) 100%);">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill fs--12px fw-bold">
                                <i class="las la-chart-bar"></i> @lang('Pricing Benchmark')
                            </span>
                            <span class="fs--12px text-muted">@lang('Live Industry CPM Algorithm')</span>
                        </div>
                        <h3 class="fw-bold mb-2">@lang('Influencer Rate & ROI Calculator')</h3>
                        <p class="text-muted fs--15px">
                            @lang('Forecast impressions, projected click-throughs, and fair creator fee ranges across Instagram, TikTok, YouTube, and UGC campaigns.')
                        </p>
                        <ul class="list-unstyled mb-4 fs--14px text-muted">
                            <li class="mb-1"><i class="las la-check-circle text-success me-2"></i> @lang('Nano to Macro tier benchmarking')</li>
                            <li class="mb-1"><i class="las la-check-circle text-success me-2"></i> @lang('Projected sales and ROAS multiplier')</li>
                            <li class="mb-1"><i class="las la-check-circle text-success me-2"></i> @lang('Creator media kit preview')</li>
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('roi.calculator') }}" class="btn btn--outline-base rounded-pill px-4">
                            <i class="las la-calculator me-1"></i> @lang('Calculate Campaign ROI')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
