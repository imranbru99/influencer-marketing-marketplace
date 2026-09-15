@extends($activeTemplate . 'layouts.frontend')
@section('content')
<div class="campaign-brief-section pt-80 pb-80">
    <div class="container">
        <!-- Header Banner -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="modern-badge modern-badge--gradient mb-3">
                    <i class="las la-magic me-1"></i> @lang('Creator Match & Proposal Suite')
                </span>
                <h2 class="section-heading-modern">@lang('AI Campaign Brief & Proposal Generator')</h2>
                <p class="section-subheading-modern">
                    @lang('Craft crystal-clear, high-converting influencer briefs in minutes. Align on deliverables, brand voice, and escrow payment milestones effortlessly.')
                </p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left: Interactive Form -->
            <div class="col-lg-7">
                <div class="modern-card p-4 p-md-5">
                    <h4 class="modern-card-title mb-4">
                        <i class="las la-sliders-h text--base me-2"></i> @lang('Campaign Specifications')
                    </h4>

                    <form id="briefForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">@lang('Brand / Company Name') <span class="text-danger">*</span></label>
                                <input type="text" id="brandName" class="form-control form--control" placeholder="e.g. Aura Glow Skincare" value="Luxe Lifestyle Co.">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">@lang('Campaign Name') <span class="text-danger">*</span></label>
                                <input type="text" id="campaignName" class="form-control form--control" placeholder="e.g. Summer Glow Launch 2026" value="Q4 Festive Product Launch">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">@lang('Primary Objective')</label>
                                <select id="campaignGoal" class="form-control form--control form-select">
                                    <option value="Brand Awareness & Reach" selected>@lang('Brand Awareness & Reach')</option>
                                    <option value="Direct Sales & Conversions">@lang('Direct Sales & Conversions')</option>
                                    <option value="New Product Launch">@lang('New Product Launch')</option>
                                    <option value="UGC Content Creation for Ads">@lang('UGC Content Creation for Ads')</option>
                                    <option value="App Downloads & Signups">@lang('App Downloads & Signups')</option>
                                    <option value="Event Promotion">@lang('Event Promotion')</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">@lang('Target Platform')</label>
                                <select id="platformSelect" class="form-control form--control form-select">
                                    <option value="Instagram (Reel + Stories)" selected>Instagram (Reel + Stories)</option>
                                    <option value="TikTok (Short-form Video)">TikTok (Short-form Video)</option>
                                    <option value="YouTube (Dedicated / Integration)">YouTube (Dedicated / Integration)</option>
                                    <option value="UGC Video (Raw & Ad Rights)">UGC Content (Organic & Paid Rights)</option>
                                    <option value="Multi-Platform (Omnichannel)">Multi-Platform (Omnichannel)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">@lang('Campaign Category / Niche')</label>
                                <select id="nicheCategory" class="form-control form--control form-select">
                                    @if(isset($categories) && $categories->count())
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->name }}">{{ __($cat->name) }}</option>
                                        @endforeach
                                    @else
                                        <option value="Fashion & Beauty">Fashion & Beauty</option>
                                        <option value="Tech & Gadgets">Tech & Gadgets</option>
                                        <option value="Health & Fitness">Health & Fitness</option>
                                        <option value="Lifestyle & Travel">Lifestyle & Travel</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">@lang('Creator Tier Recommendation')</label>
                                <select id="creatorTier" class="form-control form--control form-select">
                                    <option value="Micro Influencer (10K - 50K followers)" selected>Micro-Creator (10K - 50K)</option>
                                    <option value="Nano Influencer (1K - 10K followers)">Nano-Creator (1K - 10K)</option>
                                    <option value="Mid-Tier Influencer (50K - 500K followers)">Mid-Tier (50K - 500K)</option>
                                    <option value="Macro Influencer (500K - 1M+ followers)">Macro-Creator (500K+)</option>
                                </select>
                            </div>

                            <!-- Deliverables Checkboxes -->
                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold mb-2">@lang('Required Deliverables')</label>
                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input deliv-check" type="checkbox" id="deliv1" value="1x Dedicated Reel / TikTok (30-60s)" checked>
                                            <label class="form-check-label" for="deliv1">1x Reel / TikTok Video (30-60s)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input deliv-check" type="checkbox" id="deliv2" value="3x Instagram Story Frames with Link Sticker" checked>
                                            <label class="form-check-label" for="deliv2">3x Story Frames with Link Sticker</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input deliv-check" type="checkbox" id="deliv3" value="Link in Bio inclusion for 48 hours" checked>
                                            <label class="form-check-label" for="deliv3">Link in Bio for 48 hours</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input deliv-check" type="checkbox" id="deliv4" value="High-Res Raw Video Assets for Brand Paid Ads">
                                            <label class="form-check-label" for="deliv4">Raw Video Files (Ad Whitelisting)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-semibold">@lang('Allocated Budget') ($)</label>
                                <input type="number" id="campaignBudget" class="form-control form--control" placeholder="e.g. 500" value="450">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-semibold">@lang('Delivery Turnaround')</label>
                                <select id="turnaround" class="form-control form--control form-select">
                                    <option value="5 Business Days" selected>5 Business Days</option>
                                    <option value="3 Days (Express)">3 Days (Express)</option>
                                    <option value="7 Business Days">7 Business Days</option>
                                    <option value="14 Days">14 Days</option>
                                </select>
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">@lang('Key Message / Talking Points')</label>
                                <textarea id="keyMessages" class="form-control form--control" rows="3" placeholder="List 2-3 main features or value propositions to highlight...">Highlight 100% organic ingredients, effortless daily routine integration, and provide a unique 15% discount code for followers.</textarea>
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">@lang('Do’s & Don’ts / Mandatory Guidelines')</label>
                                <textarea id="guidelines" class="form-control form--control" rows="2" placeholder="Mandatory requirements...">Include #ad or #sponsored clearly in first 3 lines of caption. Tag @brandname in video and audio. Do NOT mention direct competitors.</textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-2 d-flex flex-wrap gap-3">
                            <button type="button" id="generateBriefBtn" class="btn btn--base px-4 py-2">
                                <i class="las la-sync-alt me-1"></i> @lang('Regenerate Brief Preview')
                            </button>
                            <button type="button" id="copyBriefBtn" class="btn btn--outline-base px-4 py-2">
                                <i class="las la-copy me-1"></i> @lang('Copy Brief to Clipboard')
                            </button>
                            <button type="button" id="downloadBriefBtn" class="btn btn--outline-info px-4 py-2">
                                <i class="las la-download me-1"></i> @lang('Download as Markdown')
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Live Formatted Brief Output & Action Box -->
            <div class="col-lg-5">
                <div class="modern-card p-4 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 class="m-0 fw-bold">
                            <i class="las la-file-alt text--base me-1"></i> @lang('Generated Brief Preview')
                        </h5>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill fs--12px">
                            <i class="las la-check-circle"></i> @lang('Escrow Ready')
                        </span>
                    </div>

                    <!-- Live Render Box -->
                    <div id="briefPreviewContainer" class="brief-preview-box flex-grow-1 p-3 mb-3">
                        <pre id="briefOutputText" class="brief-output-pre"></pre>
                    </div>

                    <!-- Escrow Trust Guarantee Mini Card -->
                    <div class="escrow-mini-banner p-3 rounded-3 mt-auto">
                        <div class="d-flex align-items-center gap-3">
                            <div class="escrow-icon-bubble">
                                <i class="las la-shield-alt fs-2 text--base"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs--15px">@lang('100% Infulab Escrow Protection')</h6>
                                <p class="mb-0 fs--13px text--muted">
                                    @lang('Your payment is held safely until you review and approve creator content.')
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('influencers') }}" class="btn btn--base w-100 btn--sm">
                                <i class="las la-search me-1"></i> @lang('Find & Hire Matching Influencers')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .brief-preview-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        max-height: 480px;
        overflow-y: auto;
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 13px;
        line-height: 1.6;
        color: #1e293b;
    }
    .brief-output-pre {
        white-space: pre-wrap;
        word-break: break-word;
        margin: 0;
        font-family: inherit;
    }
    .escrow-mini-banner {
        background: rgba(var(--base-rgb, 108, 92, 231), 0.06);
        border: 1px dashed rgba(var(--base-rgb, 108, 92, 231), 0.35);
    }
    .escrow-icon-bubble {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        flex-shrink: 0;
    }
</style>
@endpush

@push('script')
<script>
(function($) {
    "use strict";

    function buildBrief() {
        const brand = $('#brandName').val() || 'Brand Partner';
        const campaign = $('#campaignName').val() || 'Social Activation';
        const goal = $('#campaignGoal').val();
        const platform = $('#platformSelect').val();
        const niche = $('#nicheCategory').val();
        const tier = $('#creatorTier').val();
        const budget = $('#campaignBudget').val() || 'Negotiable';
        const turnaround = $('#turnaround').val();
        const keyMsg = $('#keyMessages').val();
        const guidelines = $('#guidelines').val();

        let deliverables = [];
        $('.deliv-check:checked').each(function() {
            deliverables.push('- ' + $(this).val());
        });

        if (deliverables.length === 0) {
            deliverables.push('- Custom deliverables as agreed in contract');
        }

        const brief = 
`==============================================
📋 INFLUENCER CAMPAIGN BRIEF: ${campaign.toUpperCase()}
==============================================

🏢 Brand / Client: ${brand}
🎯 Campaign Objective: ${goal}
🏷️ Target Niche: ${niche}
📱 Platform Focus: ${platform}
👥 Ideal Creator Tier: ${tier}
💰 Allocated Budget: $${budget} (Infulab Escrow Protected)
⏱️ Turnaround Window: ${turnaround}

----------------------------------------------
📦 REQUIRED DELIVERABLES:
----------------------------------------------
${deliverables.join('\n')}

----------------------------------------------
💬 KEY MESSAGING & TALKING POINTS:
----------------------------------------------
${keyMsg}

----------------------------------------------
🛡️ MANDATORY GUIDELINES & COMPLIANCE:
----------------------------------------------
${guidelines}
- Infulab Escrow Policy: Payment released upon client draft review & verified publication.
- FTC / Local Compliance: Mandatory #ad or #sponsored declaration.

Generated via Infulab Campaign Suite`;

        $('#briefOutputText').text(brief);
        return brief;
    }

    $(document).ready(function() {
        buildBrief();

        $('#briefForm input, #briefForm select, #briefForm textarea').on('input change', function() {
            buildBrief();
        });

        $('#generateBriefBtn').on('click', function() {
            buildBrief();
            notify('info', 'Campaign brief refreshed!');
        });

        $('#copyBriefBtn').on('click', function() {
            const briefText = buildBrief();
            navigator.clipboard.writeText(briefText).then(function() {
                notify('success', 'Brief copied to clipboard successfully!');
            }, function() {
                const temp = $('<textarea>');
                $('body').append(temp);
                temp.val(briefText).select();
                document.execCommand('copy');
                temp.remove();
                notify('success', 'Brief copied to clipboard!');
            });
        });

        $('#downloadBriefBtn').on('click', function() {
            const briefText = buildBrief();
            const blob = new Blob([briefText], { type: 'text/markdown;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'influencer_campaign_brief.md';
            link.click();
            notify('success', 'Brief downloaded as Markdown file!');
        });
    });
})(jQuery);
</script>
@endpush
