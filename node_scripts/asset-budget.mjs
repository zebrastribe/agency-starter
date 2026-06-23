/**
 * Static asset size budgets (CI-safe; no running WordPress required).
 */
import { statSync } from 'node:fs';
import { join } from 'node:path';

const root = new URL('..', import.meta.url).pathname;

const budgets = [
	{ path: 'theme/style.css', maxBytes: 95 * 1024, label: 'Core front-end CSS' },
	{ path: 'theme/css/prose-content.css', maxBytes: 45 * 1024, label: 'Prose bundle' },
	{ path: 'theme/js/script.min.js', maxBytes: 4 * 1024, label: 'Mobile nav script' },
];

let failed = false;

for (const { path, maxBytes, label } of budgets) {
	const file = join(root, path);
	const size = statSync(file).size;
	const kb = (size / 1024).toFixed(1);

	if (size > maxBytes) {
		console.error(`FAIL ${label}: ${path} is ${kb} KB (budget ${(maxBytes / 1024).toFixed(1)} KB)`);
		failed = true;
	} else {
		console.log(`OK   ${label}: ${kb} KB`);
	}
}

if (failed) {
	process.exit(1);
}
