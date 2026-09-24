<section class="problem" id="problema">
    <div class="problem-bg" data-parallax>
        <img src="{{ \App\Support\SiteContent::url($site['problem']['image']) }}" alt="{{ $site['problem']['image_alt'] }}">
    </div>
    <div class="problem-content wrap">
        <h2>
            <span>{{ $site['problem']['line_1'] }}</span>
            {{ $site['problem']['line_2'] }}
        </h2>
        <p>{{ $site['problem']['text'] }}</p>
    </div>
</section>
