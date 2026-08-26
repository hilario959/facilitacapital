function IconAgil() {
  return (
    <svg className="benefit-icon" viewBox="0 0 56 56" aria-hidden="true">
      <circle cx="10" cy="44" r="6" fill="currentColor" />
      <rect x="20" y="26" width="10" height="24" rx="5" fill="currentColor" opacity="0.28" />
      <rect x="36" y="10" width="10" height="40" rx="5" fill="currentColor" opacity="0.28" />
      <circle cx="41" cy="10" r="6" fill="currentColor" />
    </svg>
  )
}

function IconSimple() {
  return (
    <svg className="benefit-icon" viewBox="0 0 56 56" aria-hidden="true">
      <circle cx="28" cy="10" r="6" fill="currentColor" />
      <circle cx="20" cy="26" r="6" fill="currentColor" />
      <circle cx="36" cy="26" r="6" fill="currentColor" opacity="0.28" />
      <circle cx="12" cy="42" r="6" fill="currentColor" />
      <circle cx="28" cy="42" r="6" fill="currentColor" />
      <circle cx="44" cy="42" r="6" fill="currentColor" />
    </svg>
  )
}

function IconFlexible() {
  return (
    <svg className="benefit-icon" viewBox="0 0 56 56" aria-hidden="true">
      <g transform="translate(28 28)">
        <rect
          x="-18"
          y="-7"
          width="36"
          height="14"
          rx="7"
          fill="currentColor"
          opacity="0.28"
          transform="rotate(-38)"
        />
        <rect
          x="-18"
          y="-7"
          width="36"
          height="14"
          rx="7"
          fill="currentColor"
          transform="rotate(38)"
        />
      </g>
    </svg>
  )
}

const BENEFITS = [
  {
    title: 'Ágil',
    text: 'Evaluamos oportunidades rápidamente.',
    icon: <IconAgil />,
  },
  {
    title: 'Simple',
    text: 'Un proceso claro, sin la burocracia de un banco tradicional.',
    icon: <IconSimple />,
  },
  {
    title: 'Flexible',
    text: 'Financiamiento que se adapta al ciclo de tu empresa.',
    icon: <IconFlexible />,
  },
]

export function Benefits() {
  return (
    <section className="section" id="beneficios">
      <div className="wrap">
        <span className="eyebrow">Por qué Facilita</span>
        <h2 className="sr-only">Ágil, simple y flexible</h2>
        <div className="benefit-grid">
          {BENEFITS.map((item) => (
            <article className="benefit-card" key={item.title}>
              {item.icon}
              <h3>{item.title}</h3>
              <p>{item.text}</p>
            </article>
          ))}
        </div>
        <div className="tagline">
          <p>Financiamiento al ritmo de los negocios.</p>
          <span>Capital que se adapta al ciclo de tu empresa, no al de un banco tradicional.</span>
        </div>
      </div>
    </section>
  )
}
