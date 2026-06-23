/**
 * Copy block-scoped CSS into theme/css/blocks/ for wp_enqueue_block_style.
 */
import { copyFileSync, mkdirSync, readdirSync } from 'node:fs';
import { join, basename } from 'node:path';

const root = new URL('..', import.meta.url).pathname;
const sourceDir = join(root, 'tailwind/custom/blocks');
const targetDir = join(root, 'theme/css/blocks');

mkdirSync(targetDir, { recursive: true });

const map = {
	'agency-usp-tabs.css': 'usp-tabs.css',
	'agency-logo-marquee.css': 'logo-cloud.css',
	'agency-hero-interactive.css': 'hero-interactive.css',
	'agency-media-slider.css': 'media-slider.css',
	'agency-content-block.css': 'content-block.css',
	'agency-faq-section.css': 'faq-section.css',
	'agency-cta-glow.css': 'cta-glow.css',
};

for (const file of readdirSync(sourceDir)) {
	if (!file.endsWith('.css')) {
		continue;
	}

	const dest = map[file] ?? basename(file);
	copyFileSync(join(sourceDir, file), join(targetDir, dest));
}
