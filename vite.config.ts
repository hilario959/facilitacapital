import { defineConfig, type Plugin } from 'vite'
import react from '@vitejs/plugin-react'
import fs from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'

const repoRoot = path.dirname(fileURLToPath(import.meta.url))

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

function githubPages(): Plugin {
  const outDir = path.join(repoRoot, 'docs')
  return {
    name: 'github-pages',
    closeBundle() {
      const index = path.join(outDir, 'index.html')
      if (!fs.existsSync(index)) return
      fs.copyFileSync(index, path.join(outDir, '404.html'))
      fs.writeFileSync(path.join(outDir, '.nojekyll'), '')
      fs.writeFileSync(path.join(outDir, 'CNAME'), 'facilitacapital.com\n')
    },
  }
}

export default defineConfig({
  root: path.join(repoRoot, 'src'),
  publicDir: path.join(repoRoot, 'public'),
  // Dominio propio: GitHub Pages sirve el sitio en la raíz, no en /facilitacapital/.
  base: '/',
  plugins: [react(), leadsApi(), githubPages()],
  build: {
    outDir: path.join(repoRoot, 'docs'),
    emptyOutDir: true,
    rollupOptions: {
      output: {
        entryFileNames: 'assets/app.js',
        chunkFileNames: 'assets/[name].js',
        assetFileNames: 'assets/[name][extname]',
      },
    },
  },
})
