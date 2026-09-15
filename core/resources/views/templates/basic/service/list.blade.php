@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="story-section pt-80 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-3">
                    <div class="d-flex flex-wrap justify-content-between gap-4 dash-sidebar filter-sidebar p-xl-0 shadow-none">
                        <button class="btn-close sidebar-close shadow-none d-xl-none"></button>
                        <div class="w-100 search-widget">
                            <div class="input-group">
                                <input type="text" name="" class="form-control form--control mySearch" placeholder="@lang('Search here')" value="{{ request()->search }}">
                                <button class="input-group-text bg--base border--base border-0 searchBtn px-3 text-white" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </div>

                        @if (@$allCategory)
                            <div class="sidebar-widget">
                                <h6 class="sidebar-widget__title">@lang('Categories')</h6>
                                <div class="checkbox-wrapper">
                                    <div class="custom--checkbox">
                                        <input class="form-check-input sortCategory" type="checkbox" name="category" value="" id="category0" checked>
                                        <label class="form-check-label" for="category0">@lang('All Categories')</label>
                                    </div>
                                    @foreach ($allCategory as $category)
                                        <div class="custom--checkbox my-2">
                                            <input class="form-check-input sortCategory" type="checkbox" name="category" value="{{ $category->id }}" id="category{{ $category->id }}">
                                            <label class="form-check-label" for="category{{ $category->id }}">{{ __($category->name) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="sidebar-widget">
                            <h6 class="sidebar-widget__title">@lang('Sort by')</h6>
                            <div class="radio-wrapper">
                                <div class="form-check custom--radio mb-2">
                                    <input class="form-check-input sortService" type="radio" value="id_desc" name="sort" id="service1" checked>
                                    <label class="form-check-label" for="service1">
                                        @lang('Latest')
                                    </label>
                                </div>
                                <div class="form-check custom--radio mb-2">
                                    <input class="form-check-input sortService" type="radio" value="price_asc" name="sort" id="service2">
                                    <label class="form-check-label" for="service2">
                                        @lang('Low to High Price')
                                    </label>
                                </div>
                                <div class="form-check custom--radio mb-2">
                                    <input class="form-check-input sortService" type="radio" value="price_desc" name="sort" id="service3">
                                    <label class="form-check-label" for="service3">
                                        @lang('High to Low Price')
                                    </label>
                                </div>
                            </div>
                            <div class="input-group mt-3">
                                <input type="text" name="min" class="form--control form-control form-control-sm" placeholder="@lang('Min')">
                                <input type="text" name="max" class="form--control form-control form-control-sm" placeholder="@lang('Max')">
                                <button type="button" class="btn btn--base priceBtn px-3"><i class="las la-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 position-relative">
                    <div class="dashboard-toggler-wrapper text-end radius-5 d-xl-none d-inline-block mb-4">
                        <div class="filter-toggler dashboard-toggler">
                            <i class="fas fa-sliders-h"></i>
                        </div>
                    </div>
                    <div class="loader-wrapper">
                        <div class="loader-pre"></div>
                    </div>
                    <div class="row gy-4 justify-content-center" id="services">
                        @include($activeTemplate . 'service.filtered')
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let page = null;
            $('.loader-wrapper').addClass('d-none');
            $('.sortCategory, .sortService').on('click', function() {
                $('#category0').removeAttr('checked','checked');
                if ($('#category0').is(':checked')) {
                    $("input[type='checkbox'][name='category']").not(this).prop('checked', false);
                }

                if($("input[type='checkbox'][name='category']:checked").length == 0){
                    $('#category0').attr('checked','checked');
                }
                fetchService();
            });

            $('.searchBtn').on('click', function() {
                $(this).attr('disabled', 'disabled');
                fetchService();
            });

            $('.priceBtn').on('click', function() {
                fetchService();
            });


            function fetchService() {
                $('.loader-wrapper').removeClass('d-none');
                let data = {};
                data.categories = [];

                $.each($("[name=category]:checked"), function() {
                    if ($(this).val()) {
                        data.categories.push($(this).val());
                    }
                });

                data.search = $('.mySearch').val();
                data.sort = $('.sortService:checked').val();
                data.min = $("[name=min]").val();
                data.max = $("[name=max]").val();
                data.tagId = "{{ @$id }}";

                let url = `{{ route('service.filter') }}`;

                if (page) {
                    url = `{{ route('service.filter') }}?page=${page}`;
                }

                $.ajax({
                    method: "GET",
                    url: url,
                    data: data,
                    success: function(response) {
                        $('#services').html(response);
                        $('.searchBtn').removeAttr('disabled');
                    }
                }).done(function() {
                    $('.loader-wrapper').addClass('d-none')
                });
            }

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                page = $(this).attr('href').split('page=')[1];
                fetchService();
            });
        })(jQuery);
    </script>
@endpush
