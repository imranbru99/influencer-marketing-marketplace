@extends($activeTemplate . 'layouts.app')
@section('app')
    @include($activeTemplate . 'partials.header')
    <section class="dashbaord-section pt-80 pb-80">
        <div class="container">
            <div class="row">
                @if (request()->routeIs('influencer.*'))
                    @include($activeTemplate . 'partials.influencer_sidebar')
                @else
                    @include($activeTemplate . 'partials.user_sidebar')
                @endif

                <div class="col-xl-9">
                    <div class="dashboard-toggler-wrapper text-end radius-5 d-xl-none d-inline-block mb-4">
                        <div class="dashboard-toggler">
                            <i class="las la-align-center"></i>
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    @include($activeTemplate . 'partials.footer')
@endsection

@push('script')
    <script>
        'use strict';
        if ($('.chat__msg-body').length) {
            function scrollHeight() {
                $('.chat__msg-body').animate({
                    scrollTop: $('.chat__msg-body')[0].scrollHeight
                });
            }
            scrollHeight();
        }
    </script>
@endpush
