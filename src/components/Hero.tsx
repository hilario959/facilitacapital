import { HeroVisual } from './HeroVisual'

export function Hero() {
  return (
    <section className="hero" id="inicio">
      <div className="wrap-wide hero-grid">
        <div>
          <span className="eyebrow">Financiamiento al ritmo de los negocios</span>
          <h1>Capital al ritmo de tu empresa.</h1>
          <p className="hero-lead">
            Transforma tus cuentas por cobrar en liquidez para comprar inventario,
            pagar proveedores, tomar nuevas oportunidades y seguir creciendo.
          </p>
          <div className="hero-actions">
            <a className="btn btn-primary" href="#califico">
              Solicitar financiamiento
            </a>
            <a className="btn btn-secondary" href="#como-funciona">
              ¿Cómo funciona?
            </a>
          </div>
        </div>
        <HeroVisual />
      </div>
    </section>
  )
}
