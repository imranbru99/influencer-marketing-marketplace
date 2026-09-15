<div class="col-xl-3">
    <div class="dash-sidebar">
        <button class="btn-close sidebar-close d-xl-none shadow-none"></button>
        <ul class="sidebar-menu">

            <li>
                <a href="{{ route('influencer.home') }}" class="{{ menuActive('influencer.home') }}"><i class="las la-home"></i> @lang('Dashboard')</a>
            </li>

            @php
                $pendingOrders = App\Models\Order::pending()->where('influencer_id', authInfluencerId())->count();
                $pendingHires = App\Models\Hiring::pending()->where('influencer_id', authInfluencerId())->count();
            @endphp

            <li class="{{ menuActive('influencer.service.*',2) }}">
                <a href="javascript:void(0)"><i class="las la-wallet"></i> @lang('Service') @if($pendingOrders) <span class="text--danger"><i class="la la-exclamation-circle" aria-hidden="true"></i></span> @endif</a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('influencer.service.create') }}" class="{{ menuActive('influencer.service.create') }}"><i class="la la-dot-circle"></i> @lang('Create New')</a>
                    </li>

                    <li>
                        <a href="{{ route('influencer.service.all') }}" class="{{ menuActive('influencer.service.all') }}"><i class="la la-dot-circle"></i> @lang('All Services')</a>
                    </li>

                    <li>
                        <a href="{{ route('influencer.service.order.index') }}" class="{{ menuActive('influencer.service.order.index') }}"><i class="la la-dot-circle"></i> @lang('Orders') @if($pendingOrders) <span class="text--danger"><i class="fas la-exclamation-circle" aria-hidden="true"></i></span>@endif</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('influencer.hiring.index') }}" class="{{ menuActive('influencer.hiring*') }}">
                    <i class="las la-list-ol"></i> @lang('Hirings')
                    @if($pendingHires) <span class="text--danger"><i class="fas la-exclamation-circle" aria-hidden="true"></i></span>@endif
                </a>
            </li>

            <li class="{{ menuActive('influencer.withdraw*',2) }}">
                <a href="javascript:void(0)"><i class="las la-wallet"></i> @lang('Withdraw')</a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('influencer.withdraw') }}" class="{{ menuActive('influencer.withdraw') }}"><i class="las la-dot-circle"></i> @lang('Withdraw Money')</a></li>
                    <li><a href="{{ route('influencer.withdraw.history') }}" class="{{ menuActive('influencer.withdraw.history') }}"><i class="las la-dot-circle"></i> @lang('Withdrawal History')</a></li>
                </ul>
            </li>
            <li class="{{ menuActive('influencer.ticket.*',2) }}">
                <a href="javascript:void(0)"><i class="las la-ticket-alt"></i> @lang('Support Ticket')</a>
                <ul class="sidebar-submenu">
                    <li><a href="{{ route('influencer.ticket.open') }}" class="{{ menuActive('influencer.ticket.open') }}"><i class="las la-dot-circle"></i> @lang('Open New Ticket')</a></li>
                    <li><a href="{{ route('influencer.ticket') }}" class="{{ menuActive('influencer.ticket') }}"><i class="las la-dot-circle"></i> @lang('My Tickets')</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('influencer.conversation.index', ['', '']) }}" class="{{ menuActive('influencer.conversation*') }}"><i class="las la-sms"></i> @lang('Conversations')</a>
            </li>
            <li>
                <a href="{{ route('influencer.transactions') }}" class="{{ menuActive('influencer.transactions') }}"><i class="las la-exchange-alt"></i> @lang('Transactions')</a>
            </li>
            <li>
                <a href="{{ route('influencer.profile.setting') }}" class="{{ menuActive('influencer.profile.setting') }}"><i class="las la-user-alt"></i> @lang('Profile Setting')</a>
            </li>
            <li>
                <a href="{{ route('influencer.change.password') }}" class="{{ menuActive('influencer.change.password') }}"><i class="las la-lock-open"></i> @lang('Change Password')</a>
            </li>
            <li>
                <a href="{{ route('influencer.twofactor') }}" class="{{ menuActive('influencer.twofactor') }}"><i class="las la-shield-alt"></i> @lang('2FA Security')</a>
            </li>
            <li>
                <a href="{{ route('influencer.logout') }}"><i class="las la-sign-in-alt"></i> @lang('Logout')</a>
            </li>
        </ul>
    </div>
</div>
