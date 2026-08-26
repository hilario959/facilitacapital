import { publicUrl } from '../lib/assets'

const CASES = [
  {
    title: 'Compra inventario',
    text: 'No pierdas oportunidades por esperar un pago.',
    name: 'Daniela',
    sector: 'Distribuidora',
    image: publicUrl('clients/daniela.jpg'),
  },
  {
    title: 'Paga proveedores',
    text: 'Mantén buenas relaciones y negocia mejores condiciones.',
    name: 'Andrés',
    sector: 'Alimentos',
    image: publicUrl('clients/andres.jpg'),
  },
  {
    title: 'Toma nuevos proyectos',
    text: 'Financia el crecimiento sin detener tu operación.',
    name: 'Camila',
    sector: 'Manufactura',
    image: publicUrl('clients/camila.jpg'),
  },
  {
    title: 'Cubre capital de trabajo',
    text: 'Haz que tus ventas trabajen para ti desde hoy.',
    name: 'Luis',
    sector: 'Logística',
    image: publicUrl('clients/luis.jpg'),
  },
]

export function UseCases() {
  return (
    <section className="section cases" id="casos">
      <div className="wrap">
        <span className="eyebrow">Emprendedores Facilita</span>
        <h2>Liquidez con un propósito.</h2>
        <p className="section-lead">
          Empresas que venden a crédito y adelantan el cobro para seguir
          operando. Esto es lo que desbloqueas cuando dejas de esperar el pago.
        </p>
        <div className="cases-grid">
          {CASES.map((item) => (
            <article className="case-card" key={item.title}>
              <div className="case-photo">
                <img src={item.image} alt={`${item.name}, ${item.sector}`} />
              </div>
              <div className="case-body">
                <p className="case-person">
                  {item.name} · {item.sector}
                </p>
                <h3>{item.title}</h3>
                <p>{item.text}</p>
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  )
}
