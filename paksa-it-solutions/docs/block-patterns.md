# Paksa IT Solutions — Block Patterns Guide

## Overview

All block patterns are registered via `register_block_pattern()` in `patterns/` and loaded by `paksa_register_block_patterns()` in `functions.php`. Patterns are grouped into three categories:

| Category | Slug | Description |
|---|---|---|
| **Paksa Hero** | `paksa-hero` | Hero sections and full intros |
| **Paksa Headings** | `paksa-headings` | Heading variants with modern styling |
| **Paksa Paragraphs** | `paksa-paragraphs` | Paragraph formats and callouts |

## Inserting Patterns

1. Edit a page or post in the WordPress block editor
2. Open the Inserter (⊕)
3. Switch to the **Patterns** tab
4. Search by name (e.g., "Heading Display") or browse by category
5. Click to insert

## Heading Patterns

### Heading — Display

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/heading-display` |
| Category | `paksa-headings` |
| Use case | Major page introductions, hero titles |

**Content structure:**

```
eyebrow (accent, uppercase) → h1.display (clamp 2.5rem–4rem) → body-large paragraph
```

**Classes applied:** `.eyebrow`, `.display`, `.pk-animate-on-scroll`, `.body-large`

**Animation:** Fade-up on all elements, staggered by 100ms delay

---

### Heading — Section

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/heading-section` |
| Category | `paksa-headings` |
| Use case | Standard centered section headers |

**Content structure:**

```
eyebrow (centered, accent) → h2 (clamp 1.5rem–2.25rem) → body-large description
```

**Classes applied:** `.eyebrow`, `.pk-animate-on-scroll`, `.body-large`

**Animation:** Fade-up heading, fade-up paragraph (150ms delay)

---

### Heading — Section Left

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/heading-section-left` |
| Category | `paksa-headings` |
| Use case | Left-aligned section headers |

**Content structure:**

```
eyebrow (left, accent) → h2 (left) → body-large description
```

**Classes applied:** `.section-header`, `.align-left`, `.pk-animate-on-scroll`, `.body-large`

**Animation:** Fade-up on the entire section header group

---

### Heading — Compact

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/heading-compact` |
| Category | `paksa-headings` |
| Use case | Cards, sidebars, smaller sections |

**Content structure:**

```
eyebrow (small, accent) → h3 (clamp 1.25rem–1.5rem) → small paragraph
```

**Classes applied:** `.eyebrow`, `.pk-animate-on-scroll`

---

## Paragraph Patterns

### Paragraph — Lead

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/paragraph-lead` |
| Category | `paksa-paragraphs` |
| Use case | Opening sections, page intros |

**Content structure:**

```
body-large paragraph (secondary text color, 1.125rem)
```

**Styling:** `.body-large` class — 1.125rem, 1.7 line-height, secondary text color

---

### Paragraph — Callout

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/paragraph-callout` |
| Category | `paksa-paragraphs` |
| Use case | Highlighted info, quotes, notes |

**Content structure:**

```
group (accent-light bg, accent left border, rounded) → paragraph text
```

**Styling:**

- Background: `var(--pk-accent-light)` (#e6f9fd)
- Left border: 4px solid `var(--pk-accent)` (#00b5d8)
- Padding: 1rem 1.5rem
- Border radius: var(--pk-radius-md)

---

### Paragraph — Highlight

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/paragraph-highlight` |
| Category | `paksa-paragraphs` |
| Use case | Feature blocks, key takeaways |

**Content structure:**

```
group (bg-alt bg, border, rounded) → paragraph → button
```

**Styling:**

- Background: `var(--pk-bg-alt)` (#f7fafc)
- Border: 1px solid `var(--pk-border)` (#e2e8f0)
- Border radius: var(--pk-radius-lg)
- Includes a primary CTA button

---

### Paragraph — CTA

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/paragraph-cta` |
| Category | `paksa-paragraphs` |
| Use case | Conversion-focused sections |

**Content structure:**

```
paragraph (1.125rem) → primary button + outline button (inline-flex)
```

**Styling:** Two inline buttons — primary (solid) + outline (bordered)

---

## Combined Patterns

### Intro — Hero

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/heading-paragraph-hero` |
| Category | `paksa-hero` |
| Use case | Full hero introduction |

**Content structure:**

```
eyebrow → h1.display → body-large (max-width: 600px) → primary button + outline button
```

**Animation:** All elements fade-up staggered (0ms, 100ms, 200ms, 250ms)

---

### Intro — Section

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/heading-paragraph-section` |
| Category | `paksa-hero` |
| Use case | Wide CTA section |

**Content structure:**

```
cta-global (gradient bg, rounded, centered) → h2 (inverse text) → paragraph (inverse muted) → primary + outline buttons
```

**Styling:** Uses `.cta-global` — gradient background (primary → primary-hover), inverse text colors

---

## Pattern Reference Table

| Pattern | Category | Heading Level | Width | Elements |
|---|---|---|---|---|
| Heading — Display | `paksa-headings` | h1 | 1280px | eyebrow + h1 + paragraph |
| Heading — Section | `paksa-headings` | h2 | 1280px | eyebrow + h2 + paragraph |
| Heading — Section Left | `paksa-headings` | h2 | 1280px | eyebrow + h2 + paragraph |
| Heading — Compact | `paksa-headings` | h3 | 600px | eyebrow + h3 + paragraph |
| Paragraph — Lead | `paksa-paragraphs` | — | 720px | paragraph |
| Paragraph — Callout | `paksa-paragraphs` | — | 720px | group + paragraph |
| Paragraph — Highlight | `paksa-paragraphs` | — | 720px | group + paragraph + button |
| Paragraph — CTA | `paksa-paragraphs` | — | 720px | paragraph + 2 buttons |
| Intro — Hero | `paksa-hero` | h1 | 1280px | eyebrow + h1 + paragraph + 2 buttons |
| Intro — Section | `paksa-hero` | h2 | 1280px | group + h2 + paragraph + 2 buttons |

---

## CSS Classes Used

All patterns reference existing CSS classes and variables from:

- `assets/css/variables.css` — Design tokens
- `assets/css/main.css` — Component styles
- `assets/css/animations.css` — Animation classes

### Key Classes

| Class | Purpose |
|---|---|
| `.eyebrow` | Small uppercase accent label |
| `.display` | Large display heading (clamp 2.5rem–4rem) |
| `.body-large` | 1.125rem, 1.7 line-height |
| `.pk-animate-on-scroll` | Scroll-triggered animation |
| `.cta-global` | Gradient CTA section |
| `.section-header` | Centered section header |
| `.pk-contact-form` | Callout group container |

### Animation Classes

| Class | Data Attr | Effect |
|---|---|---|
| `.pk-animate-on-scroll` | `data-anim="fade-up"` | Fade in + slide up |
| `.pk-animate-on-scroll` | `data-anim="fade-in"` | Fade in |
| `data-delay="N"` | — | Delay in milliseconds |

---

## Adding Custom Patterns

1. Create `patterns/{name}.php` in the patterns directory
2. Use `register_block_pattern('paksa-it-solutions/{name}', ...)`
3. Assign to one of the three categories: `paksa-headings`, `paksa-paragraphs`, `paksa-hero`
4. Add the file name to the `$pattern_files` array in `functions.php`
5. Add documentation to this file

## Category Registration

Categories are registered via `paksa_block_categories()` in `functions.php` using the `block_categories_all` filter. To add a new category:

1. Add entry to the array in `paksa_block_categories()`
2. Use the slug in your pattern's `categories` parameter
