<section class="hero" id="inicio">
    <div class="wrap-wide hero-grid">
        <div>
            <span class="eyebrow">{{ $site['hero']['eyebrow'] }}</span>
            <h1>{{ $site['hero']['title'] }}</h1>
            <p class="hero-lead">{{ $site['hero']['lead'] }}</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="#calculadora">{{ $site['hero']['primary_cta'] }}</a>
                <a class="btn btn-secondary" href="#como-funciona">{{ $site['hero']['secondary_cta'] }}</a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-photo">
                <img src="{{ \App\Support\SiteContent::url($site['hero']['image']) }}" alt="{{ $site['hero']['image_alt'] }}">
            </div>
            <aside class="hero-float" aria-label="{{ $site['hero']['float_kicker'] }}">
                <p class="hero-float-kicker">{{ $site['hero']['float_kicker'] }}</p>
                <p class="hero-float-amount" data-count="{{ (int) $site['hero']['float_amount'] }}">{{ \App\Support\Finance::money(0) }}</p>
                <p class="hero-float-meta">{{ $site['hero']['float_meta'] }}</p>
            </aside>
        </div>
    </div>
</section>
