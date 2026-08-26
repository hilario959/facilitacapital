import { useEffect, useMemo, useState, type FormEvent } from 'react'
import {
  formatMoney,
  formatMoneyWithSign,
  parseMoney,
} from '../lib/finance'
import { isValidEmail, isValidPhone, submitLead } from '../lib/leads'

type QualifyProps = {
  amount: number
  onAmountChange: (value: number) => void
}

const CRITERIA = [
  'Vendes a empresas.',
  'Facturas a crédito.',
  'Tus clientes pagan a 30, 60, 90 o más días.',
  'Tu empresa necesita liquidez antes de recibir esos pagos.',
]

type FormState = {
  name: string
  company: string
  phone: string
  email: string
}

const EMPTY: FormState = { name: '', company: '', phone: '', email: '' }

export function Qualify({ amount, onAmountChange }: QualifyProps) {
  const [form, setForm] = useState<FormState>(EMPTY)
  const [error, setError] = useState('')
  const [sending, setSending] = useState(false)
  const [sent, setSent] = useState(false)
  const [amountDraft, setAmountDraft] = useState(formatMoney(amount))

  useEffect(() => {
    setAmountDraft(formatMoney(amount))
  }, [amount])

  const amountLabel = useMemo(() => formatMoneyWithSign(amount), [amount])

  const update = (key: keyof FormState, value: string) => {
    setForm((prev) => ({ ...prev, [key]: value }))
  }

  const onSubmit = async (event: FormEvent) => {
    event.preventDefault()
    setError('')

    if (!form.name.trim() || !form.company.trim()) {
      setError('Necesitamos tu nombre y el de tu empresa.')
      return
    }
    if (!isValidPhone(form.phone)) {
      setError('Ingresa un teléfono o WhatsApp válido.')
      return
    }
    if (!isValidEmail(form.email)) {
      setError('Ingresa un correo válido.')
      return
    }
    if (amount <= 0) {
      setError('Indica el monto aproximado que necesitas.')
      return
    }

    setSending(true)
    await submitLead({
      name: form.name.trim(),
      company: form.company.trim(),
      phone: form.phone.trim(),
      email: form.email.trim(),
      amount,
    })
    setSending(false)
    setSent(true)
  }

  return (
    <section className="section section-dark" id="califico">
      <div className="wrap">
        <span className="eyebrow light">Califica en un minuto</span>
        <h2>¿Es Facilita para mi empresa?</h2>
        <div className="qualify-grid">
          <div>
            <p className="section-lead">
              Facilita puede ser para ti si:
            </p>
            <ul className="qualify-list">
              {CRITERIA.map((item) => (
                <li key={item}>
                  <span className="check" aria-hidden="true">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                      <path
                        d="M2.5 6.2 4.8 8.5 9.5 3.5"
                        stroke="currentColor"
                        strokeWidth="1.8"
                        strokeLinecap="round"
                        strokeLinejoin="round"
                      />
                    </svg>
                  </span>
                  {item}
                </li>
              ))}
            </ul>
          </div>

          <div className="form-card">
            {sent ? (
              <div className="success">
                <div className="success-mark" aria-hidden="true">
                  <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                    <path
                      d="M5 12.5 9.5 17 19 7"
                      stroke="currentColor"
                      strokeWidth="2.2"
                      strokeLinecap="round"
                      strokeLinejoin="round"
                    />
                  </svg>
                </div>
                <h3>Recibimos tu solicitud.</h3>
                <p>
                  Te contactamos por WhatsApp o correo en un día hábil para
                  decirte si Facilita es para tu empresa. No pedimos documentos
                  en este paso.
                </p>
              </div>
            ) : (
              <form onSubmit={onSubmit} noValidate>
                <h3>Cuéntanos sobre tu empresa</h3>
                <p className="section-lead">
                  Sólo lo necesario para empezar. El objetivo es saber si
                  calificas, no pedirte documentos todavía.
                </p>

                <div className="form-row">
                  <div className="field">
                    <label htmlFor="name">Nombre</label>
                    <input
                      id="name"
                      name="name"
                      autoComplete="name"
                      value={form.name}
                      onChange={(e) => update('name', e.target.value)}
                    />
                  </div>
                  <div className="field">
                    <label htmlFor="company">Empresa</label>
                    <input
                      id="company"
                      name="company"
                      autoComplete="organization"
                      value={form.company}
                      onChange={(e) => update('company', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-row">
                  <div className="field">
                    <label htmlFor="phone">Teléfono / WhatsApp</label>
                    <input
                      id="phone"
                      name="phone"
                      type="tel"
                      autoComplete="tel"
                      value={form.phone}
                      onChange={(e) => update('phone', e.target.value)}
                    />
                  </div>
                  <div className="field">
                    <label htmlFor="email">Correo</label>
                    <input
                      id="email"
                      name="email"
                      type="email"
                      autoComplete="email"
                      value={form.email}
                      onChange={(e) => update('email', e.target.value)}
                    />
                  </div>
                </div>

                <div className="field">
                  <label htmlFor="amount">Monto aproximado que necesitas</label>
                  <div className="money-input">
                    <span>Q</span>
                    <input
                      id="amount"
                      name="amount"
                      inputMode="numeric"
                      value={amountDraft}
                      onChange={(e) => {
                        const parsed = parseMoney(e.target.value)
                        setAmountDraft(formatMoney(parsed))
                        onAmountChange(parsed)
                      }}
                      onBlur={() => setAmountDraft(formatMoney(amount))}
                    />
                  </div>
                </div>

                {error ? <p className="form-error">{error}</p> : null}

                <button className="btn btn-primary btn-block" type="submit" disabled={sending}>
                  {sending ? 'Enviando…' : 'Quiero saber si califico'}
                </button>
                <p className="form-fine">
                  Solicitud actual: {amountLabel}. Sin documentos en este paso.
                  Usamos estos datos sólo para contactarte y evaluar si Facilita
                  es para ti.
                </p>
              </form>
            )}
          </div>
        </div>
      </div>
    </section>
  )
}
