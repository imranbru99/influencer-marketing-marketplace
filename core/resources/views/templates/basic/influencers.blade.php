@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="influencer-section pt-80 pb-80">
        <div class="container ">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-3">
                    <div class="d-flex justify-content-between dash-sidebar filter-sidebar p-xl-0 flex-wrap gap-4 shadow-none">
                        <button class="btn-close sidebar-close d-xl-none shadow-none"></button>
                        <div class="w-100 search-widget">
                            <div class="input-group">
                                <input type="text" name="" class="form-control form--control mySearch" placeholder="@lang('Search here')" value="{{ request()->search }}">
                                <button class="input-group-text bg--base border--base searchBtn border-0 px-3 text-white" type="button"><i class="fas fa-search"></i></button>
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

                        <div class="sidebar-widget has-select2 position-relative">
                            <h6 class="sidebar-widget__title">@lang('Country')</h6>
                            <select class="form-control form--control country form-select select2-basic" name="country">
                                <option value="">@lang('All')</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country }}">{{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sidebar-widget">
                            <h6 class="sidebar-widget__title">@lang('Rating')</h6>
                            <div class="action-widget__body" style="">

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input sortRating" value="" type="radio" name="star" id="ratings-0">
                                        <label class="form-check-label" for="ratings-0">@lang('All') </label>
                                    </div>
                                </div>

                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input sortRating" value="4" type="radio" name="star" id="ratings-4">
                                        <label class="form-check-label" for="ratings-4">
                                            <span class="text--warning">
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star-o"></i>
                                            </span>
                                            & @lang('up')
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input sortRating" value="3" type="radio" name="star" id="ratings-3">
                                        <label class="form-check-label" for="ratings-3">
                                            <span class="text--warning">
                                                <i class="las la-star"></i>
                                                <i class="las la-star"></i>
                                                <i class="las la-star"></i>
                                                <i class="la la-star-o"></i>
                                                <i class="la la-star-o"></i>
                                            </span>
                                            & @lang('up')
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input sortRating" value="2" type="radio" name="star" id="ratings-2">
                                        <label class="form-check-label" for="ratings-2">
                                            <span class="text--warning">
                                                <i class="las la-star"></i>
                                                <i class="las la-star"></i>
                                                <i class="la la-star-o"></i>
                                                <i class="la la-star-o"></i>
                                                <i class="la la-star-o"></i>

                                            </span>
                                            & @lang('up')
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check custom--radio d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <input class="form-check-input sortRating" value="1" type="radio" name="star" id="ratings-1">
                                        <label class="form-check-label" for="ratings-1">
                                            <span class="text--warning">
                                                <i class="las la-star"></i>
                                                <i class="la la-star-o"></i>
                                                <i class="la la-star-o"></i>
                                                <i class="la la-star-o"></i>
                                                <i class="la la-star-o"></i>
                                            </span>
                                            & @lang('up')
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h6 class="sidebar-widget__title">@lang('Sort By')</h6>
                            <div class="radio-wrapper">
                                <div class="custom--radio my-2">
                                    <input class="form-check-input sortInfluencer" type="radio" value="latest" name="sort" id="latest" checked>
                                    <label class="form-check-label" for="latest">
                                        @lang('Latest')
                                    </label>
                                </div>
                                <div class="custom--radio my-2">
                                    <input class="form-check-input sortInfluencer" type="radio" value="top_rated" name="sort" id="top_rated">
                                    <label class="form-check-label" for="top_rated">
                                        @lang('Top Rated')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h6 class="sidebar-widget__title">@lang('Completed Jobs')</h6>
                            <div class="radio-wrapper">
                                <div class="custom--radio my-2">
                                    <input class="form-check-input completedJob" type="radio" value="" name="complete_job" id="job0" checked>
                                    <label class="form-check-label" for="job0">
                                        @lang('All')
                                    </label>
                                </div>
                                <div class="custom--radio my-2">
                                    <input class="form-check-input completedJob" type="radio" value="10" name="complete_job" id="job1">
                                    <label class="form-check-label" for="job1">
                                        @lang('More than 10')
                                    </label>
                                </div>
                                <div class="custom--radio my-2">
                                    <input class="form-check-input completedJob" type="radio" value="30" name="complete_job" id="job2">
                                    <label class="form-check-label" for="job2">
                                        @lang('More than 30')
                                    </label>
                                </div>
                                <div class="custom--radio my-2">
                                    <input class="form-check-input completedJob" type="radio" value="50" name="complete_job" id="job3">
                                    <label class="form-check-label" for="job3">
                                        @lang('More than 50')
                                    </label>
                                </div>
                                <div class="custom--radio my-2">
                                    <input class="form-check-input completedJob" type="radio" value="80" name="complete_job" id="job4">
                                    <label class="form-check-label" for="job4">
                                        @lang('More than 80')
                                    </label>
                                </div>
                                <div class="custom--radio my-2">
                                    <input class="form-check-input completedJob" type="radio" value="100" name="complete_job" id="job5">
                                    <label class="form-check-label" for="job5">
                                        @lang('More than 100')
                                    </label>
                                </div>
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
                    <div class="row gy-4 justify-content-center" id="influencers">
                        @include($activeTemplate . 'filtered_influencer')
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
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";
            let page = null;
            $('.loader-wrapper').addClass('d-none');
            $('.sortCategory, .completedJob, .sortInfluencer').on('click', function() {
                $('#category0').removeAttr('checked', 'checked');
                if ($('#category0').is(':checked')) {
                    $("input[type='checkbox'][name='category']").not(this).prop('checked', false);
                }

                if ($("input[type='checkbox'][name='category']:checked").length == 0) {
                    $('#category0').attr('checked', 'checked');
                }
                fetchInfluencer();
            });

            $('.sortRating').on('click', function() {
                if ($('#ratings-0').is(':checked')) {
                    $("input[type='radio'][name='star']").not(this).prop('checked', false);
                }
                fetchInfluencer();
            });

            $('.country').on('change', function() {
                fetchInfluencer();
            });

            $('.searchBtn').on('click', function() {
                $(this).attr('disabled', 'disabled');
                fetchInfluencer();
            });

            function fetchInfluencer() {
                $('.loader-wrapper').removeClass('d-none');
                let data = {};
                data.categories = [];

                $.each($("[name=category]:checked"), function() {
                    if ($(this).val()) {
                        data.categories.push($(this).val());
                    }
                });

                data.search = $('.mySearch').val();
                data.sort = $('.sortInfluencer:checked').val();
                data.completedJob = $('.completedJob:checked').val();
                data.rating = $('.sortRating:checked').val();
                data.country = $('.country').find(":selected").val();
                data.categoryId = "{{ @$id }}";

                let url = `{{ route('influencer.filter') }}`;

                if (page) {
                    url = `{{ route('influencer.filter') }}?page=${page}`;
                }

                $.ajax({
                    method: "GET",
                    url: url,
                    data: data,
                    success: function(response) {
                        $('#influencers').html(response);
                        $('.searchBtn').removeAttr('disabled');
                    }
                }).done(function() {
                    $('.loader-wrapper').addClass('d-none')
                });
            }

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                page = $(this).attr('href').split('page=')[1];
                fetchInfluencer();
            });

            $(".select2-basic").select2({
                dropdownParent: $('.has-select2')
            });
        })(jQuery);
    </script>
@endpush
