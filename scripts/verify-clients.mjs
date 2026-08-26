import { chromium } from 'playwright-core'
import path from 'node:path'

const chrome = path.join(
  process.env.HOME,
  'Library/Caches/ms-playwright/chromium-1234/chrome-mac-arm64/Google Chrome for Testing.app/Contents/MacOS/Google Chrome for Testing',
)

const browser = await chromium.launch({ executablePath: chrome, headless: true })
const errors = []

const page = await browser.newPage({ viewport: { width: 1440, height: 1100 } })
page.on('console', (msg) => {
  if (msg.type() === 'error') errors.push(msg.text())
})
await page.goto('http://127.0.0.1:5173/#casos', { waitUntil: 'networkidle' })
await page.waitForTimeout(400)
await page.evaluate(() => {
  document.getElementById('casos')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await page.waitForTimeout(300)
await page.screenshot({ path: 'scripts/screens/clients-desktop.png' })

const imgs = await page.locator('.case-photo img').evaluateAll((els) =>
  els.map((el) => ({
    src: el.getAttribute('src'),
    w: el.naturalWidth,
    h: el.naturalHeight,
    complete: el.complete,
  })),
)

const mobile = await browser.newPage({ viewport: { width: 390, height: 844 } })
await mobile.goto('http://127.0.0.1:5173/#casos', { waitUntil: 'networkidle' })
await mobile.waitForTimeout(400)
await mobile.evaluate(() => {
  document.getElementById('casos')?.scrollIntoView({ behavior: 'instant', block: 'start' })
})
await mobile.waitForTimeout(300)
await mobile.screenshot({ path: 'scripts/screens/clients-mobile.png' })

await browser.close()
console.log(JSON.stringify({ imgs, errors }, null, 2))
