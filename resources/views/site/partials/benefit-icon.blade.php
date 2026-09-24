@if ($index % 3 === 0)
    <svg class="benefit-icon" viewBox="0 0 56 56" aria-hidden="true">
        <circle cx="10" cy="44" r="6" fill="currentColor" />
        <rect x="20" y="26" width="10" height="24" rx="5" fill="currentColor" opacity="0.28" />
        <rect x="36" y="10" width="10" height="40" rx="5" fill="currentColor" opacity="0.28" />
        <circle cx="41" cy="10" r="6" fill="currentColor" />
    </svg>
@elseif ($index % 3 === 1)
    <svg class="benefit-icon" viewBox="0 0 56 56" aria-hidden="true">
        <circle cx="28" cy="10" r="6" fill="currentColor" />
        <circle cx="20" cy="26" r="6" fill="currentColor" />
        <circle cx="36" cy="26" r="6" fill="currentColor" opacity="0.28" />
        <circle cx="12" cy="42" r="6" fill="currentColor" />
        <circle cx="28" cy="42" r="6" fill="currentColor" />
        <circle cx="44" cy="42" r="6" fill="currentColor" />
    </svg>
@else
    <svg class="benefit-icon" viewBox="0 0 56 56" aria-hidden="true">
        <g transform="translate(28 28)">
            <rect x="-18" y="-7" width="36" height="14" rx="7" fill="currentColor" opacity="0.28" transform="rotate(-38)" />
            <rect x="-18" y="-7" width="36" height="14" rx="7" fill="currentColor" transform="rotate(38)" />
        </g>
    </svg>
@endif
