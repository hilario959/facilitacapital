<a href="#inicio" class="logo {{ $class ?? '' }}" aria-label="{{ $site['brand']['line1'] }} {{ $site['brand']['line2'] }}">
    @if (! empty($site['brand']['logo']))
        <img class="logo-mark" src="{{ \App\Support\SiteContent::url($site['brand']['logo']) }}" alt="">
    @else
        <svg class="logo-mark" viewBox="0 0 80 70" aria-hidden="true">
            <path class="logo-shadow" d="M16 34.5 68 12.5 38 41 29 60Z" fill="currentColor" />
            <path d="M14 32.5 66 10.5 36 39Z" fill="#ffffff" />
            <path class="logo-stroke" d="M14 32.5 66 10.5 36 39Z" fill="none" stroke-width="2.6" stroke-linejoin="round" stroke-linecap="round" />
            <path class="logo-stroke" d="M36 39 66 10.5 27 58Z" fill="none" stroke-width="2.6" stroke-linejoin="round" stroke-linecap="round" />
            <path class="logo-stroke" d="M14 32.5 36 39 27 58" fill="none" stroke-width="2.6" stroke-linejoin="round" stroke-linecap="round" />
            <g class="logo-stroke" stroke-width="2.4" stroke-linecap="round" fill="none">
                <path d="M6 37.5 16 33.2" />
                <path d="M7.2 44 18.5 38.4" />
                <path d="M9.5 50.5 19.8 45.2" />
            </g>
        </svg>
    @endif
    <span class="logo-word">
        <span class="logo-facilita">{{ $site['brand']['line1'] }}</span>
        <span class="logo-capital">{{ $site['brand']['line2'] }}</span>
    </span>
</a>
