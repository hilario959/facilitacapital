import { useEffect, useState } from 'react'
import { formatMoneyWithSign } from '../lib/finance'

const TARGET = 43_200

export function HeroVisual() {
  const [amount, setAmount] = useState(0)

  useEffect(() => {
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches
    if (reduce) {
      setAmount(TARGET)
      return
    }
    const start = performance.now()
    const duration = 1400
    let frame = 0
    const tick = (now: number) => {
      const progress = Math.min(1, (now - start) / duration)
      const eased = 1 - (1 - progress) ** 3
      setAmount(Math.round(TARGET * eased))
      if (progress < 1) frame = requestAnimationFrame(tick)
    }
    frame = requestAnimationFrame(tick)
    return () => cancelAnimationFrame(frame)
  }, [])

  return (
    <div className="hero-visual">
      <div className="hero-photo">
        <img
          src="/hero/emprendedora.jpg"
          alt="Emprendedora adelantando facturas desde Facilita"
        />
      </div>
      <aside className="hero-float" aria-label="Liquidez disponible hoy">
        <p className="hero-float-kicker">Hoy puedes recibir</p>
        <p className="hero-float-amount">{formatMoneyWithSign(amount)}</p>
        <p className="hero-float-meta">Factura F-1842 · 60 días</p>
      </aside>
    </div>
  )
}
