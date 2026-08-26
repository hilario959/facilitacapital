import { Logo } from './Logo'

export function Footer() {
  return (
    <footer className="footer">
      <div className="wrap footer-grid">
        <div>
          <Logo className="nav-dark" />
          <p>
            Financiamiento al ritmo de los negocios. Adelantamos el cobro de
            tus facturas para que el flujo de caja no limite tu crecimiento.
          </p>
        </div>
        <nav className="footer-links" aria-label="Pie de página">
          <a href="#como-funciona">Cómo funciona</a>
          <a href="#calculadora">Calculadora</a>
          <a href="#casos">Casos de uso</a>
          <a href="#califico">Solicitar</a>
        </nav>
      </div>
      <div className="wrap footer-bottom">
        © {new Date().getFullYear()} Facilita Capital. Todos los derechos reservados.
      </div>
    </footer>
  )
}
