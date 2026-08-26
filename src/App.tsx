import { useEffect, useState } from 'react'
import { Benefits } from './components/Benefits'
import { Calculator } from './components/Calculator'
import { Footer } from './components/Footer'
import { Hero } from './components/Hero'
import { HowItWorks } from './components/HowItWorks'
import { Nav } from './components/Nav'
import { Problem } from './components/Problem'
import { Qualify } from './components/Qualify'
import { UseCases } from './components/UseCases'
import { DEFAULT_AMOUNT } from './lib/finance'

export default function App() {
  const [amount, setAmount] = useState(DEFAULT_AMOUNT)
  const [formInView, setFormInView] = useState(false)

  useEffect(() => {
    const node = document.getElementById('califico')
    if (!node) return
    const observer = new IntersectionObserver(
      ([entry]) => setFormInView(Boolean(entry?.isIntersecting)),
      { threshold: 0.18 },
    )
    observer.observe(node)
    return () => observer.disconnect()
  }, [])

  return (
    <>
      <Nav />
      <main>
        <Hero />
        <Problem />
        <Benefits />
        <HowItWorks />
        <UseCases />
        <Calculator amount={amount} onAmountChange={setAmount} />
        <Qualify amount={amount} onAmountChange={setAmount} />
      </main>
      <Footer />
      {formInView ? null : (
        <div className="mobile-cta">
          <a className="btn btn-primary btn-block" href="#califico">
            Solicitar financiamiento
          </a>
        </div>
      )}
    </>
  )
}
