@php
    $sent = session('lead_sent');
    $reopen = $errors->hasAny(['email', 'whatsapp', 'nit', 'amount', 'days']);
@endphp

<section class="section calc" id="calculadora" data-calculator="{{ json_encode($calc) }}">
    <div class="wrap">
        <span class="eyebrow">{{ $site['calculator']['eyebrow'] }}</span>
        <h2>{{ $site['calculator']['title'] }}</h2>
        <p class="section-lead">{{ $site['calculator']['lead'] }}</p>

        <div class="calc-panel">
            <div class="calc-inputs">
                <div class="field">
                    <label for="invoice-amount">{{ $site['calculator']['amount_label'] }}</label>
                    <div class="money-input">
                        <span>Q</span>
                        <input id="invoice-amount" inputmode="numeric" value="{{ number_format($calc['default'], 2, '.', ',') }}" autocomplete="off">
                    </div>
                    <input class="range" type="range" min="{{ $calc['min'] }}" max="{{ $calc['max'] }}" step="{{ $calc['step'] }}" value="{{ $calc['default'] }}" aria-label="Ajustar monto" data-range>
                    <span class="field-hint" data-range-hint="{{ $site['calculator']['range_hint'] }}"></span>
                </div>

                <div class="field">
                    <span id="term-label">{{ $site['calculator']['term_label'] }}</span>
                    <div class="chips" role="group" aria-labelledby="term-label" data-chips>
                        @foreach ($calc['terms'] as $term)
                            <button type="button" class="chip{{ $term === $calc['initialDays'] ? ' active' : '' }}" data-days="{{ $term }}">{{ $term }} días</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="calc-result">
                <div class="calc-kicker">{{ $site['calculator']['result_kicker'] }}</div>
                <div class="calc-today" data-today>{{ \App\Support\Finance::money(0) }}</div>
                <p class="calc-vs" data-vs-template="{{ $site['calculator']['vs'] }}"></p>
                <div class="calc-rows">
                    <div class="calc-row"><span>{{ $site['calculator']['row_amount'] }}</span><span data-row="amount"></span></div>
                    <div class="calc-row"><span>{{ $site['calculator']['row_advance'] }}</span><span data-row="advance"></span></div>
                    <div class="calc-row"><span>{{ $site['calculator']['row_cost'] }}</span><span data-row="cost"></span></div>
                    <div class="calc-row"><span>{{ $site['calculator']['row_holdback'] }}</span><span data-row="holdback"></span></div>
                </div>
                <button class="btn btn-lime btn-block" type="button" data-open-lead>{{ $site['calculator']['cta'] }}</button>
                <p class="calc-note">{{ $site['calculator']['note'] }}</p>
            </div>
        </div>
    </div>

    <dialog class="lead-dialog" id="lead-dialog" @if ($sent) data-open-on-load="sent" @elseif ($reopen) data-open-on-load="errors" @endif>
        <div class="lead-dialog-body">
            <button class="lead-close" type="button" data-close-lead aria-label="Cerrar">×</button>

            <div id="lead-success" class="success" @unless ($sent) hidden @endunless>
                <div class="success-mark" aria-hidden="true">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                        <path d="M5 12.5 9.5 17 19 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 id="lead-success-title">{{ $sent['title'] ?? $site['lead_form']['success_title'] }}</h3>
                <p id="lead-success-text">{{ $sent['text'] ?? '' }}</p>
            </div>

            <form id="lead-form" method="post" action="{{ route('leads.store') }}" novalidate @if ($sent) hidden @endif
                data-submit-label="{{ $site['lead_form']['submit'] }}"
                data-sending-label="{{ $site['lead_form']['sending'] }}">
                @csrf
                <h3>{{ $site['lead_form']['title'] }}</h3>
                <p class="section-lead">{{ $site['lead_form']['lead'] }}</p>
                <p class="lead-summary" data-lead-summary></p>
                <input type="hidden" name="amount" id="lead-amount" value="{{ old('amount', $calc['default']) }}">
                <input type="hidden" name="days" id="lead-days" value="{{ old('days', $calc['initialDays']) }}">

                <div class="field">
                    <label for="lead-email">{{ $site['lead_form']['email_label'] }}</label>
                    <input id="lead-email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required>
                </div>
                <div class="field">
                    <label for="lead-whatsapp">{{ $site['lead_form']['whatsapp_label'] }}</label>
                    <input id="lead-whatsapp" name="whatsapp" type="tel" autocomplete="tel" inputmode="tel" value="{{ old('whatsapp') }}" placeholder="502 5555 5555" required>
                </div>
                <div class="field">
                    <label for="lead-nit">{{ $site['lead_form']['nit_label'] }}</label>
                    <input id="lead-nit" name="nit" inputmode="text" value="{{ old('nit') }}" autocomplete="off" required>
                </div>

                <p class="form-error" id="lead-error" @unless ($reopen) hidden @endunless>{{ $errors->first() }}</p>

                <button class="btn btn-primary btn-block" type="submit" id="lead-submit">{{ $site['lead_form']['submit'] }}</button>
                <p class="form-fine">{{ $site['lead_form']['fine'] }}</p>
            </form>
        </div>
    </dialog>
</section>
