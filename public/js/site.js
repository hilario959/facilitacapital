(() => {
    const money = (value) =>
        `Q${new Intl.NumberFormat('es-GT', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(value)}`

    const parseMoney = (raw) => {
        const cleaned = String(raw).replace(/,/g, '').replace(/[^\d.]/g, '')
        if (!cleaned) return 0
        return Number(cleaned)
    }

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches

    const nav = document.querySelector('[data-nav]')
    const toggle = document.querySelector('[data-nav-toggle]')
    const menu = document.querySelector('[data-mobile-menu]')

    if (nav) {
        const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 8)
        onScroll()
        window.addEventListener('scroll', onScroll, { passive: true })
    }

    const setMenu = (open) => {
        if (!toggle || !menu) return
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false')
        toggle.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú')
        menu.hidden = !open
        document.body.classList.toggle('menu-open', open)
    }

    toggle?.addEventListener('click', () => {
        setMenu(toggle.getAttribute('aria-expanded') !== 'true')
    })

    menu?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setMenu(false))
    })

    document.querySelectorAll('[data-count]').forEach((node) => {
        const target = Number(node.dataset.count) || 0
        if (reduced) {
            node.textContent = money(target)
            return
        }
        const start = performance.now()
        const duration = 1400
        const tick = (now) => {
            const progress = Math.min(1, (now - start) / duration)
            const eased = 1 - (1 - progress) ** 3
            node.textContent = money(Math.round(target * eased))
            if (progress < 1) requestAnimationFrame(tick)
        }
        requestAnimationFrame(tick)
    })

    const layer = document.querySelector('[data-parallax]')
    if (layer && !reduced) {
        const onScroll = () => {
            const section = layer.parentElement
            if (!section) return
            const rect = section.getBoundingClientRect()
            const progress = (window.innerHeight - rect.top) / (window.innerHeight + rect.height)
            layer.style.transform = `translate3d(0, ${(progress - 0.5) * 140}px, 0)`
        }
        onScroll()
        window.addEventListener('scroll', onScroll, { passive: true })
    }

    const calculator = document.querySelector('[data-calculator]')
    if (!calculator) return

    const config = JSON.parse(calculator.dataset.calculator)
    const amountInput = calculator.querySelector('#invoice-amount')
    const range = calculator.querySelector('[data-range]')
    const today = calculator.querySelector('[data-today]')
    const vs = calculator.querySelector('[data-vs-template]')
    const hint = calculator.querySelector('[data-range-hint]')
    const rows = {
        amount: calculator.querySelector('[data-row="amount"]'),
        advance: calculator.querySelector('[data-row="advance"]'),
        cost: calculator.querySelector('[data-row="cost"]'),
        holdback: calculator.querySelector('[data-row="holdback"]'),
    }
    const dialog = calculator.querySelector('#lead-dialog')
    const form = calculator.querySelector('#lead-form')
    const success = calculator.querySelector('#lead-success')
    const error = calculator.querySelector('#lead-error')
    const submit = calculator.querySelector('#lead-submit')
    const summary = calculator.querySelector('[data-lead-summary]')
    const leadAmount = calculator.querySelector('#lead-amount')
    const leadDays = calculator.querySelector('#lead-days')

    let amount = Number(leadAmount.value) || config.default
    let days = Number(leadDays.value) || config.initialDays

    const clamp = (value) => {
        if (!Number.isFinite(value)) return config.default
        return Math.min(config.max, Math.max(config.min, Math.round(value)))
    }

    amount = clamp(amount)
    amountInput.value = new Intl.NumberFormat('es-GT', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(amount)
    calculator.querySelectorAll('[data-days]').forEach((chip) => {
        chip.classList.toggle('active', Number(chip.dataset.days) === days)
    })

    const simulate = (value, term) => {
        const safe = Math.max(0, value)
        const advance = Math.round(safe * config.advanceRate)
        const cost = Math.round(advance * config.monthlyRate * (term / 30))
        return {
            amount: safe,
            advance,
            cost,
            today: Math.max(advance - cost, 0),
            holdback: Math.max(safe - advance, 0),
        }
    }

    const render = () => {
        const result = simulate(amount, days)
        today.textContent = money(result.today)
        rows.amount.textContent = money(result.amount)
        rows.advance.textContent = money(result.advance)
        rows.cost.textContent = money(result.cost)
        rows.holdback.textContent = money(result.holdback)
        vs.textContent = vs.dataset.vsTemplate.replaceAll('{days}', String(days))
        hint.textContent = hint.dataset.rangeHint
            .replaceAll('{min}', money(config.min))
            .replaceAll('{max}', money(config.max))
        range.value = String(amount)
        leadAmount.value = String(amount)
        leadDays.value = String(days)
        if (summary) {
            summary.textContent = `Facturas ${money(result.amount)} · ${days} días · hoy puedes recibir ${money(result.today)}`
        }
    }

    const commit = (value) => {
        amount = clamp(value)
        amountInput.value = new Intl.NumberFormat('es-GT', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(amount)
        render()
    }

    amountInput.addEventListener('input', () => {
        const parsed = parseMoney(amountInput.value)
        amountInput.value = new Intl.NumberFormat('es-GT', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(parsed)
        if (parsed >= config.min) amount = clamp(parsed)
        render()
    })
    amountInput.addEventListener('blur', () => commit(parseMoney(amountInput.value)))
    range.addEventListener('input', () => commit(Number(range.value)))

    calculator.querySelectorAll('[data-days]').forEach((chip) => {
        chip.addEventListener('click', () => {
            days = Number(chip.dataset.days)
            calculator.querySelectorAll('[data-days]').forEach((item) => {
                item.classList.toggle('active', item === chip)
            })
            render()
        })
    })

    const openDialog = () => {
        render()
        if (typeof dialog.showModal === 'function' && !dialog.open) dialog.showModal()
    }

    calculator.querySelector('[data-open-lead]')?.addEventListener('click', () => {
        success.hidden = true
        form.hidden = false
        openDialog()
    })
    calculator.querySelector('[data-close-lead]')?.addEventListener('click', () => dialog.close())

    if (dialog.dataset.openOnLoad) {
        render()
        if (dialog.dataset.openOnLoad === 'errors') {
            success.hidden = true
            form.hidden = false
        }
        if (typeof dialog.showModal === 'function') dialog.showModal()
    }

    const sticky = document.querySelector('.mobile-cta')
    if (sticky && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            ([entry]) => {
                sticky.hidden = Boolean(entry?.isIntersecting)
            },
            { threshold: 0.18 },
        )
        observer.observe(calculator)
    }

    form?.addEventListener('submit', async (event) => {
        event.preventDefault()
        error.hidden = true
        submit.disabled = true
        submit.textContent = form.dataset.sendingLabel
        render()

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    email: form.email.value,
                    whatsapp: form.whatsapp.value,
                    nit: form.nit.value,
                    amount: Number(leadAmount.value),
                    days: Number(leadDays.value),
                }),
            })
            const payload = await response.json()
            if (!response.ok) {
                error.textContent = payload.message || 'Revisa los datos e inténtalo de nuevo.'
                error.hidden = false
                return
            }
            document.querySelector('#lead-success-title').textContent = payload.title
            document.querySelector('#lead-success-text').textContent = payload.text
            form.hidden = true
            success.hidden = false
            form.reset()
        } catch {
            error.textContent = 'No pudimos enviar la solicitud. Inténtalo de nuevo.'
            error.hidden = false
        } finally {
            submit.disabled = false
            submit.textContent = form.dataset.submitLabel
        }
    })

    render()
})()
