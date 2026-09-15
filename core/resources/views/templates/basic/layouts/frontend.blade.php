@extends($activeTemplate . 'layouts.app')
@section('app')
    @include($activeTemplate . 'partials.header')

    @if (!request()->routeIs('home'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif

    @yield('content')

    @include($activeTemplate . 'partials.footer')
@endsection

@push('script')
    <script>
        'use strict';
        (function($) {

            $(document).on('click', '.favoriteBtn', function() {
                let url;
                var influencerId = $(this).data('influencer_id');
                if($(this).hasClass('active')){
                    url = `{{ route('user.favorite.delete') }}`;
                }else{
                    url = `{{ route('user.favorite.add') }}`;
                }
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    type: "POST",
                    url: url,
                    data: {
                        influencerId: influencerId
                    },
                    success: function(response) {
                        if (response.success) {
                            notify('success', response.success);
                            if(response.remark == 'remove'){
                                $(document).find(`[data-influencer_id='${response.influencerId}']`).removeClass('active');
                                $(document).find(`[data-influencer_id='${response.influencerId}'] i`).removeClass('las');
                                $(document).find(`[data-influencer_id='${response.influencerId}'] i`).addClass('lar');
                            }else{
                                $(document).find(`[data-influencer_id='${response.influencerId}']`).addClass('active');
                                $(document).find(`[data-influencer_id='${response.influencerId}'] i`).removeClass('lar');
                                $(document).find(`[data-influencer_id='${response.influencerId}'] i`).addClass('las');
                            }
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
