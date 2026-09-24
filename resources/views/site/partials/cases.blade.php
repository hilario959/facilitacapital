<section class="section cases" id="casos">
    <div class="wrap">
        <span class="eyebrow">{{ $site['cases']['eyebrow'] }}</span>
        <h2>{{ $site['cases']['title'] }}</h2>
        <p class="section-lead">{{ $site['cases']['lead'] }}</p>
        <div class="cases-grid">
            @foreach ($site['cases']['items'] as $item)
                <article class="case-card">
                    <div class="case-photo">
                        <img src="{{ \App\Support\SiteContent::url($item['image'] ?? null) }}" alt="{{ $item['name'] }}, {{ $item['sector'] }}">
                    </div>
                    <div class="case-body">
                        <p class="case-person">{{ $item['name'] }} · {{ $item['sector'] }}</p>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['text'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
