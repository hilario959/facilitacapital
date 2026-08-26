import fs from 'node:fs'
import path from 'node:path'

const dist = 'dist'
const published = ['index.html', '404.html', 'assets', 'clients', 'hero', 'favicon.svg', '.nojekyll']

if (!fs.existsSync(path.join(dist, 'index.html'))) {
  throw new Error('No hay build en dist/. Corre npm run build primero.')
}

fs.copyFileSync(path.join(dist, 'index.html'), path.join(dist, '404.html'))

for (const name of published) {
  const from = path.join(dist, name)
  const to = path.join('.', name)
  if (!fs.existsSync(from)) continue
  fs.rmSync(to, { recursive: true, force: true })
  fs.cpSync(from, to, { recursive: true })
}

console.log('GitHub Pages: copiado dist/ a la raíz del repo')
