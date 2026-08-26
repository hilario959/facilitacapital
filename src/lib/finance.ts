export const ADVANCE_RATE = 0.9
export const MONTHLY_RATE = 0.02
export const DEFAULT_AMOUNT = 50_000
export const MIN_AMOUNT = 10_000
export const MAX_AMOUNT = 2_000_000
export const AMOUNT_STEP = 5_000
export const TERM_OPTIONS = [30, 60, 90, 120] as const

export type Simulation = {
  amount: number
  days: number
  advance: number
  cost: number
  today: number
  holdback: number
}

export function simulate(amount: number, days: number): Simulation {
  const safeAmount = Math.max(0, amount)
  const advance = Math.round(safeAmount * ADVANCE_RATE)
  const cost = Math.round(advance * MONTHLY_RATE * (days / 30))
  const today = Math.max(advance - cost, 0)
  const holdback = Math.max(safeAmount - advance, 0)
  return { amount: safeAmount, days, advance, cost, today, holdback }
}

export function formatMoney(value: number): string {
  return new Intl.NumberFormat('es-GT', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(value)
}

export function formatMoneyWithSign(value: number): string {
  return `Q${formatMoney(value)}`
}

export function parseMoney(raw: string): number {
  const cleaned = raw.replace(/,/g, '').replace(/[^\d.]/g, '')
  if (!cleaned) return 0
  return Number(cleaned)
}

export function clampAmount(value: number): number {
  if (!Number.isFinite(value)) return DEFAULT_AMOUNT
  return Math.min(MAX_AMOUNT, Math.max(MIN_AMOUNT, Math.round(value)))
}
