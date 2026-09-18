# Phase 14 inventory — visual editing system

This inventory was recorded before the Phase 14 visual-system work began.

## Theme architecture

- **Theme type:** classic PHP theme with `theme.json` and Gutenberg support.
- **Global templates:** `header.php` and `footer.php`; navigation is managed by registered WordPress menu locations.
- **Reusable PHP components:** `template-parts/components/` contains section headers, breadcrumbs, FAQ items, product cards, service cards, and the WhatsApp button.
- **Page sections:** `template-parts/home/`, `about/`, `services/`, `service/`, `products/`, `product/`, and `contact/` compose the conventional page templates.
- **Patterns:** 35 PHP-registered block patterns across hero, heading, paragraph, services, and home categories.
- **Editor baseline:** `theme.json` exposes a palette, basic type sizes, layout widths, border controls, and wide alignment. Existing patterns are Gutenberg blocks, but the visual choices are not yet unified through a complete block-style system.

## Existing visual systems

- `assets/css/variables.css` is the source of the current `--pk-*` color, spacing, radius, shadow, and transition tokens.
- `assets/css/main.css` supplies the base layout, button, card, header, footer, form, and responsive rules.
- `assets/css/animations.css` and `assets/js/animations.js` use `IntersectionObserver` for reveal animations and include a reduced-motion override.
- `inc/icons.php` is the single icon registry; templates call `paksa_icon()` and compatibility helpers rather than maintaining independent icon sets.
- `inc/customizer.php` manages global contact, social, logo, CTA, and existing page-section options.

## Phase 14 direction

Phase 14 extends this hybrid architecture rather than converting it to a block theme mid-product. The work introduces editor-visible design tokens and block styles, configurable global parts, a small justified custom icon block, and core-block patterns for reusable editable sections. Existing PHP sections remain available for the established marketing pages.

