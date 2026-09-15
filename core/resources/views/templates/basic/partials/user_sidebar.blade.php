<div class="col-xl-3">
    <div class="dash-sidebar">
        <button class="btn-close sidebar-close d-xl-none shadow-none"></button>
        <ul class="sidebar-menu">

            <li>
                <a href="{{ route('user.home') }}" class="{{ menuActive('user.home') }}"><i class="las la-home"></i> @lang('Dashboard')</a>
            </li>

            <li class="{{ menuActive('user.deposit*',2) }}">
                <a href="javascript:void(0)"><i class="las la-wallet"></i> @lang('Deposit')</a>

                <ul class="sidebar-submenu  }}">
                    <li><a href="{{ route('user.deposit') }}" class="{{ menuActive('user.deposit') }}"><i class="las la-dot-circle"></i> @lang('Deposit Money')</a></li>
                    <li><a href="{{ route('user.deposit.history') }}" class="{{ menuActive('user.deposit.history') }}"><i class="las la-dot-circle"></i> @lang('Deposit History')</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('user.order.all') }}" class="{{ menuActive('user.order.*') }}"><i class="las la-list"></i> @lang('Orders')</a>
            </li>

            <li>
                <a href="{{ route('user.hiring.history') }}" class="{{ menuActive('user.hiring.*') }}"> <i class="las la-list-ol"></i> @lang('Hirings')</a>
            </li>

            <li class="{{ menuActive('ticket*',2) }}">
                <a href="javascript:void(0)"><i class="las la-ticket-alt"></i> @lang('Support Ticket')</a>
                <ul class="sidebar-submenu {{ menuActive('ticket*') }}">
                    <li><a href="{{ route('ticket.open') }}" class="{{ menuActive('ticket.open') }}"><i class="las la-dot-circle"></i> @lang('Open New Ticket')</a></li>
                    <li><a href="{{ route('ticket') }}" class="{{ menuActive('ticket') }}"><i class="las la-dot-circle"></i> @lang('My Tickets')</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('user.conversation.index', ['', '']) }}" class="{{ menuActive('user.conversation.*') }}"><i class="las la-sms"></i> @lang('Conversations')</a>
            </li>

            <li>
                <a href="{{ route('user.favorite.list') }}" class="{{ menuActive('user.favorite.list') }}"><i class="lar la-heart"></i> @lang('Favorite List')</a>
            </li>

            <li class="{{ menuActive('user.review*',2) }}">
                <a href="javascript:void(0)"><i class="la la-star-o"></i> @lang('Reviews')</a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('user.review.order.index') }}" class="{{ menuActive('user.review.order.index') }}">
                            <i class="las la-dot-circle"></i> @lang('Order Reviews')
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.review.hiring.index') }}" class="{{ menuActive('user.review.hiring.index') }}">
                            <i class="las la-dot-circle"></i> @lang('Hiring Reviews')
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('user.transactions') }}" class="{{ menuActive('user.transactions') }}"><i class="las la-exchange-alt"></i> @lang('Transactions')</a>
            </li>

            <li>
                <a href="{{ route('user.profile.setting') }}" class="{{ menuActive('user.profile.setting') }}"><i class="las la-user-alt"></i> @lang('Profile Setting')</a>
            </li>

            <li>
                <a href="{{ route('user.change.password') }}" class="{{ menuActive('user.change.password') }}"><i class="las la-lock-open"></i> @lang('Change Password')</a>
            </li>

            <li>
                <a href="{{ route('user.twofactor') }}" class="{{ menuActive('user.twofactor') }}"><i class="las la-shield-alt"></i> @lang('2FA Security')</a>
            </li>

            <li>
                <a href="{{ route('user.logout') }}"><i class="las la-sign-in-alt"></i> @lang('Logout')</a>
            </li>
        </ul>
    </div>
</div>
