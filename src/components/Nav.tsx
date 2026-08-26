import { useEffect, useState, type MouseEvent } from 'react'
import { Logo } from './Logo'

const LINKS = [
  { href: '#como-funciona', label: 'Cómo funciona' },
  { href: '#calculadora', label: 'Calculadora' },
  { href: '#casos', label: 'Casos de uso' },
  { href: '#califico', label: '¿Califico?' },
]

export function Nav() {
  const [scrolled, setScrolled] = useState(false)
  const [open, setOpen] = useState(false)

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 8)
    onScroll()
    window.addEventListener('scroll', onScroll, { passive: true })
    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  useEffect(() => {
    document.body.classList.toggle('menu-open', open)
    return () => document.body.classList.remove('menu-open')
  }, [open])

  const goTo = (href: string) => (event: MouseEvent<HTMLAnchorElement>) => {
    event.preventDefault()
    setOpen(false)
    window.setTimeout(() => {
      document.querySelector(href)?.scrollIntoView({ behavior: 'smooth' })
    }, 50)
  }

  return (
    <header className={`nav${scrolled ? ' scrolled' : ''}`}>
      <div className="nav-inner">
        <Logo />
        <nav className="nav-links" aria-label="Principal">
          {LINKS.map((link) => (
            <a key={link.href} href={link.href}>
              {link.label}
            </a>
          ))}
        </nav>
        <div className="nav-cta">
          <a className="btn btn-primary" href="#califico">
            Solicitar financiamiento
          </a>
        </div>
        <button
          className="nav-toggle"
          type="button"
          aria-label={open ? 'Cerrar menú' : 'Abrir menú'}
          aria-expanded={open}
          onClick={() => setOpen((value) => !value)}
        >
          <span />
        </button>
      </div>
      {open ? (
        <nav className="mobile-menu" aria-label="Móvil">
          {LINKS.map((link) => (
            <a key={link.href} href={link.href} onClick={goTo(link.href)}>
              {link.label}
            </a>
          ))}
          <a className="btn btn-primary" href="#califico" onClick={goTo('#califico')}>
            Solicitar financiamiento
          </a>
        </nav>
      ) : null}
    </header>
  )
}
