import { defineConfig, type Plugin } from 'vite'
import react from '@vitejs/plugin-react'
import fs from 'node:fs'
import path from 'node:path'

function leadsApi(): Plugin {
  const file = path.resolve('data/leads.json')

  function ensureFile() {
    const dir = path.dirname(file)
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true })
    if (!fs.existsSync(file)) fs.writeFileSync(file, '[]\n')
  }

  return {
    name: 'leads-api',
    configureServer(server) {
      server.middlewares.use('/api/leads', (req, res, next) => {
        if (req.method !== 'POST') {
          next()
          return
        }

        const chunks: Buffer[] = []
        req.on('data', (chunk) => {
          chunks.push(Buffer.isBuffer(chunk) ? chunk : Buffer.from(chunk))
        })
        req.on('end', () => {
          try {
            ensureFile()
            const body = Buffer.concat(chunks).toString('utf8') || '{}'
            const lead = JSON.parse(body) as Record<string, unknown>
            const leads = JSON.parse(fs.readFileSync(file, 'utf8') || '[]') as unknown[]
            if (!Array.isArray(leads)) {
              throw new Error('Archivo de leads inválido')
            }
            leads.push({ ...lead, createdAt: new Date().toISOString() })
            fs.writeFileSync(file, `${JSON.stringify(leads, null, 2)}\n`)
            res.statusCode = 201
            res.setHeader('Content-Type', 'application/json')
            res.end(JSON.stringify({ ok: true }))
          } catch {
            res.statusCode = 400
            res.setHeader('Content-Type', 'application/json')
            res.end(JSON.stringify({ ok: false }))
          }
        })
      })
    },
  }
}

export default defineConfig(({ command }) => ({
  // GitHub Pages sirve el sitio en /facilitacapital/, no en la raíz del dominio.
  base: command === 'build' ? '/facilitacapital/' : '/',
  plugins: [react(), leadsApi()],
}))
