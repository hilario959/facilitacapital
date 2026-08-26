import { chromium } from 'playwright-core'
import path from 'node:path'

const chrome = path.join(
  process.env.HOME,
  'Library/Caches/ms-playwright/chromium-1234/chrome-mac-arm64/Google Chrome for Testing.app/Contents/MacOS/Google Chrome for Testing',
)

const browser = await chromium.launch({ executablePath: chrome, headless: true })
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } })
await page.goto('http://127.0.0.1:5173/', { waitUntil: 'networkidle' })
await page.waitForTimeout(800)
await page.screenshot({ path: 'scripts/screens/gtq-hero.png' })
await page.evaluate(() => {
  document.getElementById('problema')?.scrollIntoView({ behavior: 'instant', block: 'center' })
})
await page.waitForTimeout(250)
await page.screenshot({ path: 'scripts/screens/gtq-problem.png' })
await page.evaluate(() => {
  document.getElementById('calculadora')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await page.waitForTimeout(250)
await page.screenshot({ path: 'scripts/screens/gtq-calc.png' })
await page.evaluate(() => {
  document.getElementById('califico')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await page.waitForTimeout(250)
await page.screenshot({ path: 'scripts/screens/gtq-dark.png' })
await browser.close()
console.log('ok')
