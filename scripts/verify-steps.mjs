import { chromium } from 'playwright-core'
import path from 'node:path'

const chrome = path.join(
  process.env.HOME,
  'Library/Caches/ms-playwright/chromium-1234/chrome-mac-arm64/Google Chrome for Testing.app/Contents/MacOS/Google Chrome for Testing',
)

const browser = await chromium.launch({ executablePath: chrome, headless: true })
const mobile = await browser.newPage({ viewport: { width: 390, height: 900 } })
await mobile.goto('http://127.0.0.1:5173/#como-funciona', { waitUntil: 'networkidle' })
await mobile.waitForTimeout(400)
await mobile.evaluate(() => {
  document.getElementById('como-funciona')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await mobile.waitForTimeout(300)
await mobile.screenshot({ path: 'scripts/screens/steps-mobile.png' })

const desktop = await browser.newPage({ viewport: { width: 1440, height: 900 } })
await desktop.goto('http://127.0.0.1:5173/#como-funciona', { waitUntil: 'networkidle' })
await desktop.waitForTimeout(300)
await desktop.evaluate(() => {
  document.getElementById('como-funciona')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await desktop.waitForTimeout(250)
await desktop.screenshot({ path: 'scripts/screens/steps-desktop.png' })
await browser.close()
console.log('ok')
