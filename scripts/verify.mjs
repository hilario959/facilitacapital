import { chromium } from 'playwright-core'
import fs from 'node:fs'
import path from 'node:path'

const chrome = path.join(
  process.env.HOME,
  'Library/Caches/ms-playwright/chromium-1234/chrome-mac-arm64/Google Chrome for Testing.app/Contents/MacOS/Google Chrome for Testing',
)
const out = path.resolve('scripts/screens')
fs.mkdirSync(out, { recursive: true })

const browser = await chromium.launch({
  executablePath: chrome,
  headless: true,
})

async function shot(page, name) {
  await page.screenshot({
    path: path.join(out, `${name}.png`),
    fullPage: name.includes('full'),
  })
}

const consoleErrors = []

async function attach(page) {
  page.on('pageerror', (err) => consoleErrors.push(err.message))
  page.on('console', (msg) => {
    if (msg.type() === 'error') consoleErrors.push(msg.text())
  })
}

{
  const page = await browser.newPage({ viewport: { width: 1440, height: 900 } })
  await attach(page)
  await page.goto('http://127.0.0.1:5173/', { waitUntil: 'networkidle' })
  await page.waitForTimeout(800)
  await shot(page, 'desktop-hero')
  await shot(page, 'desktop-full')

  await page.click('a[href="#como-funciona"]')
  await page.waitForTimeout(400)
  await shot(page, 'desktop-how')

  await page.goto('http://127.0.0.1:5173/#calculadora')
  await page.waitForTimeout(400)
  await page.locator('#invoice-amount').fill('')
  await page.locator('#invoice-amount').type('500000')
  await page.locator('#invoice-amount').blur()
  await page.getByRole('button', { name: '90 días' }).click()
  const today = await page.locator('.calc-today').innerText()
  await shot(page, 'desktop-calc')

  await page.goto('http://127.0.0.1:5173/#califico')
  await page.waitForTimeout(400)
  await page.locator('#name').scrollIntoViewIfNeeded()
  await shot(page, 'desktop-form-empty')
  await page.locator('#name').fill('María López')
  await page.locator('#company').fill('Comercial del Valle')
  await page.locator('#phone').fill('5551234567')
  await page.locator('#email').fill('maria@comercialdelvalle.mx')
  await shot(page, 'desktop-form')
  await page.getByRole('button', { name: 'Quiero saber si califico' }).click()
  await page.waitForSelector('text=Recibimos tu solicitud')
  await shot(page, 'desktop-success')

  console.log('CALC_TODAY', today)
  await page.close()
}

{
  const page = await browser.newPage({ viewport: { width: 390, height: 844 } })
  await attach(page)
  await page.goto('http://127.0.0.1:5173/', { waitUntil: 'networkidle' })
  await page.waitForTimeout(800)
  await shot(page, 'mobile-hero')
  await shot(page, 'mobile-full')
  await page.getByRole('button', { name: 'Abrir menú' }).click()
  await page.waitForTimeout(200)
  await shot(page, 'mobile-menu')
  await page.getByLabel('Móvil').getByRole('link', { name: 'Calculadora' }).click()
  await page.waitForTimeout(900)
  await shot(page, 'mobile-calc')
  await page.evaluate(() => {
    document.getElementById('califico')?.scrollIntoView({ behavior: 'instant', block: 'start' })
  })
  await page.waitForTimeout(200)
  await shot(page, 'mobile-form')
  await page.close()
}

await browser.close()

if (consoleErrors.length) {
  console.log('CONSOLE_ERRORS')
  for (const err of consoleErrors) console.log(err)
} else {
  console.log('NO_CONSOLE_ERRORS')
}

const leads = JSON.parse(fs.readFileSync('data/leads.json', 'utf8'))
console.log('LEADS', leads.length, JSON.stringify(leads.at(-1)))
