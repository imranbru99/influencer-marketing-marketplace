@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <form action="{{ route('influencer.service.store', @$service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label" for="title">@lang('Image')<span class="text--danger">*</span></label>
                        <div class="profile-thumb p-0 text-center shadow-none">
                            <div class="thumb">
                                <img id="upload-img" src="{{ getImage(getFilePath('service') . '/' . @$service->image, getFileSize('service')) }}" alt="userProfile">
                                <label class="badge badge--icon badge--fill-base update-thumb-icon" for="update-photo"><i class="las la-pen"></i></label>
                            </div>
                            <div class="profile__info">
                                <input type="file" name="image" class="form-control d-none" id="update-photo" @if (!@$service) required @endif>
                            </div>
                        </div>
                        <small class="text--warning">@lang('Supported files'): @lang('jpeg'), @lang('jpg'), @lang('png'). @lang('| Will be resized to'): {{ getFileSize('service') }}@lang('px').</small>
                    </div>
                    @php
                        if (@$service) {
                            $categoryId = $service->category_id;
                        } else {
                            $categoryId = old('category_id');
                        }
                    @endphp
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="form-label" for="category_id">@lang('Category')</label>
                            <select class="form-select form--control" name="category_id" id="category_id" required>
                                <option value="" selected disabled>@lang('Select category')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($categoryId == $category->id) selected="selected" @endif>
                                        {{ __($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="title">@lang('Title')</label>
                            <input type="text" class="form-control form--control" name="title" id="title" value="@if (@$service) {{ @$service->title }}@else{{ old('title') }} @endif" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="price">@lang('Price')</label>
                            <div class="input-group">
                                <input type="number" step="any" class="form-control form--control" name="price" id="price" value="@if (@$service) {{ getAmount(@$service->price) }}@else{{ old('price') }} @endif" required>
                                <span class="input-group-text">{{ $general->cur_text }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group skill-body">
                    <label for="skill" class="form-label">@lang('Service Tags')</label>
                    <select class="select2-auto-tokenize form-control form--control" multiple="multiple" name="tags[]" required>
                        @if (@$service)
                            @foreach (@$service->tags as $tag)
                                <option value="{{ @$tag->name }}" selected>{{ __(@$tag->name) }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required" for="description">@lang('Description')</label>
                    <textarea rows="4" class="form-control form--control nicEdit" name="description" id="description" placeholder="@lang('Write here')">
@if (@$service)
@php echo $service->description @endphp
@else
{{ old('description') }}
@endif
</textarea>
                </div>

                <div class="content w-100 ps-0">
                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <div class="form-label mb-0">
                            <p>@lang('Key Points')<span class="text--danger">*</span></p>
                        </div>
                        <button type="button" class="btn btn--outline-custom btn--sm pointBtn">
                            <i class="las la-plus"></i>@lang('Add More')
                        </button>
                    </div>
                </div>

                @if (@$service->key_points)
                    @foreach (@$service->key_points as $point)
                        <div class="key-point d-flex mb-3 gap-2">
                            <input type="text" class="form-control form--control" name="key_points[]" value="{{ __($point) }}" required>
                            <button class="btn btn--danger remove-button @if ($loop->first) disabled @endif border-0" type="button"><i class="fas fa-times"></i></button>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex mb-3 gap-2">
                        <input type="text" class="form-control form--control" name="key_points[]" required>
                        <button class="btn btn--danger disabled border-0" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                <div id="more-keyPoint">

                </div>

                <div class="form-group">
                    <label class="form-label">@lang('Images')</label>
                    <div class="input-images"></div>
                </div>


                <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
        </div>
        </form>
    </div>
    </div>
@endsection
@push('style')
    <style>
        .badge.badge--icon {
            border-radius: 5px 0 0 0;
        }
    </style>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lib/image-uploader.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/lib/image-uploader.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            const inputField = document.querySelector('#update-photo'),
                uploadImg = document.querySelector('#upload-img');
            inputField.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        const result = reader.result;
                        uploadImg.src = result;
                    }
                    reader.readAsDataURL(file);
                }
            });


            @if (isset($images))
                let preloaded = @json($images);
            @else
                let preloaded = [];
            @endif

            $('.input-images').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'images',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
            });

            $('.pointBtn').on('click', function() {
                var html = `
                <div class="key-point d-flex gap-2 mb-3">
                    <input type="text" class="form-control form--control" name="key_points[]" required>
                    <button class="btn btn--danger remove-button border-0" type="button"><i class="fas fa-times"></i></button>
                </div>`;
                $('#more-keyPoint').append(html);
            });

            $(document).on('click', '.remove-button', function() {
                $(this).closest('.key-point').remove();
            });


            $(".select2-auto-tokenize").select2({
                tags: true,
                tokenSeparators: [","],
                dropdownParent: $(".skill-body"),
            });

        })(jQuery);
    </script>
@endpush
