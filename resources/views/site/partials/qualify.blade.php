<section class="section section-dark" id="califico">
    <div class="wrap">
        <span class="eyebrow light">{{ $site['qualify']['eyebrow'] }}</span>
        <h2>{{ $site['qualify']['title'] }}</h2>
        <div class="qualify-grid">
            <div>
                <p class="section-lead">{{ $site['qualify']['lead'] }}</p>
                <ul class="qualify-list">
                    @foreach ($site['qualify']['items'] as $item)
                        <li>
                            <span class="check" aria-hidden="true">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M2.5 6.2 4.8 8.5 9.5 3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            {{ is_array($item) ? ($item['item'] ?? $item['text'] ?? '') : $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
