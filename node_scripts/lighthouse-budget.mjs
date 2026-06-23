/**
 * Lighthouse performance budget — runs when WP_BASE_URL points at a live site.
 * Skips gracefully in CI without WordPress (use test:budget for static checks).
 */
import lighthouse from 'lighthouse';
import chromeLauncher from 'chrome-launcher';

const baseURL = process.env.WP_BASE_URL;
const targetPath = process.env.LH_PATH ?? '/';

if (!baseURL) {
	console.log('SKIP lighthouse-budget: WP_BASE_URL not set');
	process.exit(0);
}

const url = new URL(targetPath, baseURL).href;

const chrome = await chromeLauncher.launch({ chromeFlags: ['--headless', '--no-sandbox'] });

try {
	const result = await lighthouse(url, {
		logLevel: 'error',
		output: 'json',
		port: chrome.port,
		onlyCategories: ['performance'],
	});

	const score = result.lhr.categories.performance.score * 100;
	const fcp = result.lhr.audits['first-contentful-paint'].numericValue;
	const lcp = result.lhr.audits['largest-contentful-paint'].numericValue;

	const minScore = Number(process.env.LH_MIN_SCORE ?? 70);
	const maxLcp = Number(process.env.LH_MAX_LCP_MS ?? 4000);

	console.log(`Performance score: ${score.toFixed(0)} (min ${minScore})`);
	console.log(`LCP: ${(lcp / 1000).toFixed(2)}s (max ${(maxLcp / 1000).toFixed(2)}s)`);
	console.log(`FCP: ${(fcp / 1000).toFixed(2)}s`);

	let failed = false;
	if (score < minScore) {
		console.error('FAIL: performance score below budget');
		failed = true;
	}
	if (lcp > maxLcp) {
		console.error('FAIL: LCP above budget');
		failed = true;
	}

	process.exit(failed ? 1 : 0);
} finally {
	await chrome.kill();
}
