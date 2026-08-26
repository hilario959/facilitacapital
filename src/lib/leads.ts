export type Lead = {
  name: string
  company: string
  phone: string
  email: string
  amount: number
}

const STORAGE_KEY = 'facilita-leads'

export function saveLeadLocal(lead: Lead): void {
  const prev = readLeadsLocal()
  prev.push({ ...lead, createdAt: new Date().toISOString() })
  localStorage.setItem(STORAGE_KEY, JSON.stringify(prev))
}

export function readLeadsLocal(): Array<Lead & { createdAt: string }> {
  try {
    const raw = localStorage.getItem(STORAGE_KEY)
    if (!raw) return []
    const parsed = JSON.parse(raw) as Array<Lead & { createdAt: string }>
    return Array.isArray(parsed) ? parsed : []
  } catch {
    return []
  }
}

export async function submitLead(lead: Lead): Promise<void> {
  saveLeadLocal(lead)
  try {
    const response = await fetch('/api/leads', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(lead),
    })
    if (!response.ok) {
      throw new Error('No se pudo guardar el lead en el servidor')
    }
  } catch {
    // El lead queda en localStorage para no perder la solicitud.
  }
}

export function isValidEmail(email: string): boolean {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim())
}

export function isValidPhone(phone: string): boolean {
  const digits = phone.replace(/\D/g, '')
  return digits.length >= 8 && digits.length <= 15
}
