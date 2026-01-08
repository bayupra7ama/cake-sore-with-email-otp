@props([
    'title' => '',
    'links' => [], // array: ['label' => '', 'url' => null]
])

<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="breadcrumb__text">
                    <h2>{{ $title }}</h2>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="breadcrumb__links">
                    @foreach ($links as $link)
                        @if (!empty($link['url']))
                            <a href="{{ $link['url'] }}">
                                {{ $link['label'] }}
                            </a>
                        @else
                            <span>{{ $link['label'] }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
