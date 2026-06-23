import { test, expect } from "@playwright/test";
import AxeBuilder from "@axe-core/playwright";

const routes = [
  { path: "/", name: "Homepage" },
  { path: "/contact/", name: "Contact" },
  { path: "/nyheder/", name: "News archive" },
];

for (const route of routes) {
  test.describe(`A11y — ${route.name}`, () => {
    test(`passes axe WCAG 2.x scan (${route.path})`, async ({ page }) => {
      const response = await page.goto(route.path);

      if (response?.status() === 404) {
        test.skip(true, `${route.path} not available in this environment`);
      }

      const results = await new AxeBuilder({ page })
        .withTags(["wcag2a", "wcag2aa", "wcag21a", "wcag21aa"])
        .analyze();

      expect(results.violations, formatViolations(results.violations)).toEqual([]);
    });
  });
}

function formatViolations(violations: { id: string; impact?: string; description: string; nodes: unknown[] }[]) {
  if (!violations.length) {
    return "";
  }

  return violations
    .map((v) => `${v.id} (${v.impact}): ${v.description} — ${v.nodes.length} node(s)`)
    .join("\n");
}
