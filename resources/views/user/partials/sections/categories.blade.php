<div class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">

                @foreach ($categories as $category)
                    <div class="categories__item">
                        <a href="{{ route('shop', ['category' => $category->id]) }}"
                            class="category-chip
               {{ request('category') == $category->id ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
