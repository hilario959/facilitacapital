import { useEffect, useMemo, useState } from 'react'
import {
  AMOUNT_STEP,
  MAX_AMOUNT,
  MIN_AMOUNT,
  TERM_OPTIONS,
  clampAmount,
  formatMoney,
  formatMoneyWithSign,
  parseMoney,
  simulate,
} from '../lib/finance'

type CalculatorProps = {
  amount: number
  onAmountChange: (value: number) => void
}

export function Calculator({ amount, onAmountChange }: CalculatorProps) {
  const [days, setDays] = useState<(typeof TERM_OPTIONS)[number]>(60)
  const [draft, setDraft] = useState(formatMoney(amount))
  const result = useMemo(() => simulate(amount, days), [amount, days])

  useEffect(() => {
    setDraft(formatMoney(amount))
  }, [amount])

  const commit = (raw: string | number) => {
    const next = clampAmount(typeof raw === 'number' ? raw : parseMoney(raw))
    onAmountChange(next)
    setDraft(formatMoney(next))
  }

  return (
    <section className="section calc" id="calculadora">
      <div className="wrap">
        <span className="eyebrow">Calculadora</span>
        <h2>¿Cuánto podrías recibir hoy?</h2>
        <p className="section-lead">
          Estima tu liquidez al adelantar el cobro. Es una referencia, no una
          oferta. Las condiciones se definen al evaluar tu operación.
        </p>

        <div className="calc-panel">
          <div className="calc-inputs">
            <div className="field">
              <label htmlFor="invoice-amount">Monto de tus facturas</label>
              <div className="money-input">
                <span>Q</span>
                <input
                  id="invoice-amount"
                  inputMode="numeric"
                  value={draft}
                  onChange={(event) => {
                    const parsed = parseMoney(event.target.value)
                    setDraft(formatMoney(parsed))
                    if (parsed >= MIN_AMOUNT) onAmountChange(clampAmount(parsed))
                  }}
                  onBlur={() => commit(draft)}
                />
              </div>
              <input
                className="range"
                type="range"
                min={MIN_AMOUNT}
                max={MAX_AMOUNT}
                step={AMOUNT_STEP}
                value={amount}
                onChange={(event) => commit(Number(event.target.value))}
                aria-label="Ajustar monto"
              />
              <span className="field-hint">
                De {formatMoneyWithSign(MIN_AMOUNT)} a {formatMoneyWithSign(MAX_AMOUNT)}
              </span>
            </div>

            <div className="field">
              <span id="term-label">Plazo de pago de tus clientes</span>
              <div className="chips" role="group" aria-labelledby="term-label">
                {TERM_OPTIONS.map((option) => (
                  <button
                    key={option}
                    type="button"
                    className={`chip${days === option ? ' active' : ''}`}
                    onClick={() => setDays(option)}
                  >
                    {option} días
                  </button>
                ))}
              </div>
            </div>
          </div>

          <div className="calc-result">
            <div className="calc-kicker">Hoy puedes recibir</div>
            <div className="calc-today">{formatMoneyWithSign(result.today)}</div>
            <p className="calc-vs">
              Si esperas {days} días, hoy tienes Q0.00. Con Facilita, ese capital
              puede empezar a trabajar ahora.
            </p>
            <div className="calc-rows">
              <div className="calc-row">
                <span>Valor de facturas</span>
                <span>{formatMoneyWithSign(result.amount)}</span>
              </div>
              <div className="calc-row">
                <span>Adelanto (90%)</span>
                <span>{formatMoneyWithSign(result.advance)}</span>
              </div>
              <div className="calc-row">
                <span>Costo estimado</span>
                <span>{formatMoneyWithSign(result.cost)}</span>
              </div>
              <div className="calc-row">
                <span>Saldo al cobro</span>
                <span>{formatMoneyWithSign(result.holdback)}</span>
              </div>
            </div>
            <a className="btn btn-lime btn-block" href="#califico">
              Solicitar este monto
            </a>
            <p className="calc-note">
              Estimación referencial con un adelanto del 90% y una tasa ilustrativa
              del 2% mensual. No constituye una solicitud formal ni una obligación
              de financiamiento.
            </p>
          </div>
        </div>
      </div>
    </section>
  )
}
