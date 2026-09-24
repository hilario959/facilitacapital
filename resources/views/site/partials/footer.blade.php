<footer class="footer">
    <div class="wrap footer-grid">
        <div>
            @include('site.partials.logo', ['class' => 'nav-dark'])
            <p>{{ $site['footer']['text'] }}</p>
        </div>
        <nav class="footer-links" aria-label="Pie de página">
            @foreach ($site['nav']['links'] as $link)
                <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
            @endforeach
        </nav>
    </div>
    <div class="wrap footer-bottom">
        © {{ now()->year }} {{ $site['footer']['copyright'] }}
    </div>
</footer>
