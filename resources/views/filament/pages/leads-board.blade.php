<x-filament-panels::page>
    @php
        $columns = $this->columns();
        $selected = $this->selectedLead();
    @endphp

    <div class="fc-board">
        @foreach (\App\Models\Lead::STATUSES as $status => $label)
            <section
                class="fc-column"
                data-status="{{ $status }}"
                x-on:dragover.prevent="$el.classList.add('is-over')"
                x-on:dragleave="$el.classList.remove('is-over')"
                x-on:drop.prevent="
                    $el.classList.remove('is-over');
                    $wire.move(Number($event.dataTransfer.getData('text/plain')), '{{ $status }}')
                "
            >
                <header class="fc-column-head">
                    <h2>{{ $label }}</h2>
                    <span>{{ $columns[$status]->count() }}</span>
                </header>
                <div class="fc-cards">
                    @forelse ($columns[$status] as $lead)
                        <article
                            class="fc-card {{ $selectedId === $lead->id ? 'is-selected' : '' }}"
                            draggable="true"
                            x-on:dragstart="$event.dataTransfer.setData('text/plain', '{{ $lead->id }}')"
                            wire:click="open({{ $lead->id }})"
                            wire:key="lead-{{ $lead->id }}"
                        >
                            <strong>{{ \App\Support\Finance::money($lead->payout_amount) }}</strong>
                            <p>{{ $lead->email }}</p>
                            <p>{{ $lead->whatsapp }}</p>
                            <p class="fc-meta">NIT {{ $lead->nit }} · {{ $lead->term_days }} días</p>
                            <p class="fc-meta">Facturas {{ \App\Support\Finance::money($lead->invoice_amount) }}</p>
                            @if ($lead->email_error)
                                <p class="fc-warn">El correo no se envió</p>
                            @elseif ($lead->email_sent_at)
                                <p class="fc-ok">Correo enviado</p>
                            @endif
                        </article>
                    @empty
                        <p class="fc-empty">Suelta un lead aquí</p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>

    @if ($selected)
        <aside class="fc-drawer">
            <header>
                <h2>Solicitud</h2>
                <button type="button" wire:click="close">Cerrar</button>
            </header>
            <dl>
                <div><dt>Correo</dt><dd>{{ $selected->email }}</dd></div>
                <div><dt>WhatsApp</dt><dd>{{ $selected->whatsapp }}</dd></div>
                <div><dt>NIT</dt><dd>{{ $selected->nit }}</dd></div>
                <div><dt>Facturas</dt><dd>{{ \App\Support\Finance::money($selected->invoice_amount) }}</dd></div>
                <div><dt>Plazo</dt><dd>{{ $selected->term_days }} días</dd></div>
                <div><dt>Hoy podría recibir</dt><dd>{{ \App\Support\Finance::money($selected->payout_amount) }}</dd></div>
                <div><dt>Adelanto</dt><dd>{{ \App\Support\Finance::money($selected->advance_amount) }}</dd></div>
                <div><dt>Costo estimado</dt><dd>{{ \App\Support\Finance::money($selected->cost_amount) }}</dd></div>
                <div><dt>Recibida</dt><dd>{{ $selected->created_at?->timezone(config('app.timezone'))->format('d/m/Y H:i') }}</dd></div>
                <div>
                    <dt>Correo de confirmación</dt>
                    <dd>
                        @if ($selected->email_sent_at)
                            Enviado {{ $selected->email_sent_at->timezone(config('app.timezone'))->format('d/m/Y H:i') }}
                        @elseif ($selected->email_error)
                            No se envió: {{ $selected->email_error }}
                        @else
                            Pendiente
                        @endif
                    </dd>
                </div>
            </dl>

            <label>
                Estado
                <select wire:model="status">
                    @foreach (\App\Models\Lead::STATUSES as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label>
                Notas
                <textarea wire:model="notes" rows="4"></textarea>
            </label>

            <div class="fc-drawer-actions">
                <button type="button" class="fc-primary" wire:click="saveSelected">Guardar</button>
                <button type="button" class="fc-danger" x-on:click="if (confirm('¿Eliminar este lead?')) $wire.deleteSelected()">Eliminar</button>
            </div>
        </aside>
    @endif

    <style>
        .fc-board { display: grid; grid-template-columns: repeat(5, minmax(220px, 1fr)); gap: 12px; align-items: start; }
        .fc-column { background: rgba(0,0,0,.04); border-radius: 16px; min-height: 280px; padding: 12px; }
        .fc-column.is-over { outline: 2px solid #128a3e; }
        .fc-column-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .fc-column-head h2 { margin: 0; font-size: 14px; font-weight: 700; }
        .fc-column-head span { font-size: 12px; font-weight: 700; background: white; border-radius: 99px; padding: 2px 8px; }
        .fc-cards { display: grid; gap: 8px; }
        .fc-card { background: white; border-radius: 12px; padding: 12px; cursor: grab; box-shadow: 0 1px 2px rgba(0,0,0,.06); }
        .fc-card.is-selected { outline: 2px solid #128a3e; }
        .fc-card strong { display: block; font-size: 16px; }
        .fc-card p { margin: 4px 0 0; font-size: 13px; word-break: break-word; }
        .fc-meta, .fc-empty { color: #667; font-size: 12px; }
        .fc-ok { color: #128a3e; font-weight: 700; }
        .fc-warn { color: #b42318; font-weight: 700; }
        .fc-empty { margin: 8px 4px; }
        .fc-drawer { position: fixed; top: 0; right: 0; z-index: 40; width: min(380px, 100%); height: 100%; overflow: auto; background: white; padding: 20px; box-shadow: -12px 0 40px rgba(0,0,0,.12); }
        .fc-drawer header { display: flex; justify-content: space-between; align-items: center; }
        .fc-drawer h2 { margin: 0; font-size: 18px; }
        .fc-drawer dl { display: grid; gap: 10px; margin: 16px 0; }
        .fc-drawer dt { font-size: 12px; color: #667; }
        .fc-drawer dd { margin: 0; font-weight: 650; }
        .fc-drawer label { display: grid; gap: 6px; font-size: 13px; font-weight: 700; margin-bottom: 12px; }
        .fc-drawer select, .fc-drawer textarea { width: 100%; border: 1px solid #d5d5d0; border-radius: 10px; padding: 8px 10px; font: inherit; }
        .fc-drawer-actions { display: flex; gap: 8px; }
        .fc-drawer button { border: 0; border-radius: 10px; padding: 8px 12px; font-weight: 700; cursor: pointer; background: #eee; }
        .fc-primary { background: #128a3e !important; color: white; }
        .fc-danger { background: #fde8e6 !important; color: #b42318; }
        @media (max-width: 1100px) {
            .fc-board { grid-template-columns: repeat(5, 240px); overflow-x: auto; }
        }
    </style>
</x-filament-panels::page>
