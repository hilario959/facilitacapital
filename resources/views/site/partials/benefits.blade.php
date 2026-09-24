<section class="section" id="beneficios">
    <div class="wrap">
        <span class="eyebrow">{{ $site['benefits']['eyebrow'] }}</span>
        <h2 class="sr-only">{{ collect($site['benefits']['items'])->pluck('title')->implode(', ') }}</h2>
        <div class="benefit-grid">
            @foreach ($site['benefits']['items'] as $index => $item)
                <article class="benefit-card">
                    @include('site.partials.benefit-icon', ['index' => $index])
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['text'] }}</p>
                </article>
            @endforeach
        </div>
        <div class="tagline">
            <p>{{ $site['benefits']['tagline'] }}</p>
            <span>{{ $site['benefits']['tagline_note'] }}</span>
        </div>
    </div>
</section>
