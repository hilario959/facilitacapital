import { useEffect, useRef } from 'react'
import { publicUrl } from '../lib/assets'

export function Problem() {
  const bgRef = useRef<HTMLDivElement>(null)

  useEffect(() => {
    const layer = bgRef.current
    if (!layer) return
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches
    if (reduce) return

    const onScroll = () => {
      const section = layer.parentElement
      if (!section) return
      const rect = section.getBoundingClientRect()
      const progress = (window.innerHeight - rect.top) / (window.innerHeight + rect.height)
      const shift = (progress - 0.5) * 140
      layer.style.transform = `translate3d(0, ${shift}px, 0)`
    }

    onScroll()
    window.addEventListener('scroll', onScroll, { passive: true })
    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  return (
    <section className="problem" id="problema">
      <div className="problem-bg" ref={bgRef}>
        <img
          src={publicUrl('hero/negocio.jpg')}
          alt="Emprendedores atendiendo su negocio"
        />
      </div>
      <div className="problem-content wrap">
        <h2>
          <span>Tu empresa vende hoy.</span>
          ¿Por qué esperar 30, 60 o 90 días para utilizar ese dinero?
        </h2>
        <p>
          Facilita te permite adelantar el cobro de tus facturas para que el
          flujo de caja no limite el crecimiento de tu negocio.
        </p>
      </div>
    </section>
  )
}
