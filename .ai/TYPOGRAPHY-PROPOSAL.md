# Typography Proposal — Pending Client Approval

Date noted: 2026-07-17

This proposal was tested locally but reverted pending client approval.

## Direction

Use a more polished, technical typography system:

- Font family: `Manrope`
- Google Fonts import:
  `https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap`
- Tokens:
  - `--bright-font-heading: 'Manrope', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;`
  - `--bright-font-body: 'Manrope', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;`

## Global Typography Changes

- Body:
  - `font-size: 1rem`
  - `line-height: 1.65`
- Headings:
  - Base heading weight: `700`
  - Base heading line-height: `1.14`
  - Base heading letter-spacing: `-0.02em`
  - `h1`: `font-weight: 800`, `line-height: 1.08`, `letter-spacing: -0.035em`
  - `h2`: `font-weight: 700`, `line-height: 1.12`
  - `h3`: `font-size: 2.25rem`, `line-height: 1.16`
  - `h4`: `line-height: 1.2`
  - `h5`: `line-height: 1.35`, `letter-spacing: -0.01em`
  - `h6`: `line-height: 1.4`, `letter-spacing: 0`

## Section-Level Adjustments

Update hardcoded `font-family: Roboto` values in custom CSS to use tokens:

- `font-family: var(--bright-font-body);`

Improve section headings:

- Hero title:
  - `font-weight: 800`
  - `line-height: 1.08`
  - `letter-spacing: -0.035em`
- Content intro title:
  - `font-weight: 700`
  - `line-height: 1.18`
  - `letter-spacing: -0.025em`
- 50/50 title, feature title, contact title, testimonial title:
  - `font-weight: 700`
  - `line-height: 1.12`
  - `letter-spacing: -0.03em`

## Files Touched During Test

- `functions.php`
- `style.css`
- `assets/css/bright-autonomy-design-style.css`
- `faisal.css`
- `imran.css`

If the client approves, reapply this proposal carefully and visually review desktop/mobile headings before committing.
