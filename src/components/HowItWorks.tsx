const STEPS = [
  {
    n: '01',
    title: 'Cuéntanos sobre tu empresa',
    text: 'Completa una solicitud sencilla.',
  },
  {
    n: '02',
    title: 'Evaluamos tus cuentas por cobrar',
    text: 'Analizamos la operación y las facturas que quieres anticipar.',
  },
  {
    n: '03',
    title: 'Recibe liquidez',
    text: 'Obtén capital para seguir operando y creciendo.',
  },
]

function DottedConnector() {
  return (
    <div className="step-connector" aria-hidden="true">
      <span className="step-dots-line" />
      <span className="step-pulse" />
    </div>
  )
}

export function HowItWorks() {
  return (
    <section className="section how" id="como-funciona">
      <div className="wrap">
        <span className="eyebrow">Cómo funciona</span>
        <h2>Sólo tres pasos.</h2>
        <p className="section-lead">
          El objetivo es simple: pasar de una factura pendiente a capital
          disponible, sin un proceso de banco tradicional.
        </p>
        <div className="steps">
          {STEPS.flatMap((step, index) => {
            const card = (
              <article className="step" key={step.n}>
                <span className="step-num">{step.n}</span>
                <h3>{step.title}</h3>
                <p>{step.text}</p>
              </article>
            )
            if (index === STEPS.length - 1) return [card]
            return [card, <DottedConnector key={`${step.n}-line`} />]
          })}
        </div>
      </div>
    </section>
  )
}
