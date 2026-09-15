@php
$content = getContent('category.content', true);
@endphp
@if($categories->count())
<section class="pt-80 pb-80 bg--light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="section-header text-center">
                    <h2 class="section-header__title">{{ __($content->data_values->heading) }}</h2>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap cate-container justify-content-center">
            @foreach ($categories as $category)
            <a href="{{ route('influencer.category', [$category->id, slug($category->name)]) }}" class="d-blck cate-outer">
                <div class="category-item">
                    <div class="category-thumb">
                        <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}" alt="">
                    </div>
                    <h6 class="fs--15px cate-title">{{ __($category->name) }}</h6>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif