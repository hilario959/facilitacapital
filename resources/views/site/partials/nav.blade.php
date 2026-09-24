<header class="nav" data-nav>
    <div class="nav-inner">
        @include('site.partials.logo')
        <nav class="nav-links" aria-label="Principal">
            @foreach ($site['nav']['links'] as $link)
                <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
            @endforeach
        </nav>
        <div class="nav-cta">
            <a class="btn btn-primary" href="#calculadora">{{ $site['nav']['cta'] }}</a>
        </div>
        <button class="nav-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" data-nav-toggle>
            <span></span>
        </button>
    </div>
    <nav class="mobile-menu" aria-label="Móvil" data-mobile-menu hidden>
        @foreach ($site['nav']['links'] as $link)
            <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
        @endforeach
        <a class="btn btn-primary" href="#calculadora">{{ $site['nav']['cta'] }}</a>
    </nav>
</header>
