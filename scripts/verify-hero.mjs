import { chromium } from 'playwright-core'
import path from 'node:path'

const chrome = path.join(
  process.env.HOME,
  'Library/Caches/ms-playwright/chromium-1234/chrome-mac-arm64/Google Chrome for Testing.app/Contents/MacOS/Google Chrome for Testing',
)

const browser = await chromium.launch({ executablePath: chrome, headless: true })
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } })
await page.goto('http://127.0.0.1:5173/', { waitUntil: 'networkidle' })
await page.waitForTimeout(900)
await page.screenshot({ path: 'scripts/screens/rev-hero.png' })
await page.evaluate(() => {
  document.getElementById('como-funciona')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await page.waitForTimeout(300)
await page.screenshot({ path: 'scripts/screens/rev-steps.png' })
await page.evaluate(() => {
  document.getElementById('califico')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await page.waitForTimeout(250)
await page.screenshot({ path: 'scripts/screens/rev-dark.png' })
await page.evaluate(() => {
  document.getElementById('beneficios')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await page.waitForTimeout(200)
await page.screenshot({ path: 'scripts/screens/rev-cards.png' })

const mobile = await browser.newPage({ viewport: { width: 390, height: 844 } })
await mobile.goto('http://127.0.0.1:5173/', { waitUntil: 'networkidle' })
await mobile.waitForTimeout(800)
await mobile.screenshot({ path: 'scripts/screens/rev-mobile.png' })
await browser.close()
console.log('ok')
