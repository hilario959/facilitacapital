<section class="section how" id="como-funciona">
    <div class="wrap">
        <span class="eyebrow">{{ $site['steps']['eyebrow'] }}</span>
        <h2>{{ $site['steps']['title'] }}</h2>
        <p class="section-lead">{{ $site['steps']['lead'] }}</p>
        <div class="steps">
            @foreach ($site['steps']['items'] as $index => $step)
                <article class="step">
                    <span class="step-num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['text'] }}</p>
                </article>
                @if (! $loop->last)
                    <div class="step-connector" aria-hidden="true">
                        <span class="step-dots-line"></span>
                        <span class="step-pulse"></span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
