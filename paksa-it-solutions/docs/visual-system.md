# Paksa Theme visual system

Paksa Theme now uses one design system across the frontend and Gutenberg. It remains a hybrid theme: the established PHP templates continue to power the existing marketing pages while new pages can be assembled from editable core-block patterns.

## Editing a page

Open a page in the block editor and choose **Add block → Patterns**. Paksa patterns are grouped into:

- Paksa Hero
- Paksa Sections
- Paksa Calls to Action
- Paksa Social Proof
- Paksa FAQs
- Paksa Contact
- Paksa Layouts

Every Phase 14 pattern uses native WordPress blocks. Headings, paragraphs, media, buttons, Groups, Columns, Covers, Details, colors, spacing, borders, and layout are editable in the normal block sidebar.

## Global styling

The editor exposes Paksa’s semantic color palette, fluid typography sizes, spacing scale, layout widths, gradients, border settings, and shadows through `theme.json`. Use these presets before entering custom values to keep pages cohesive.

Native block styles add:

- Button: **Paksa Outline** and **Paksa Ghost**
- Group: **Paksa Card** and **Paksa Dark Card**

## Icons

Use **Paksa Icon** from the Paksa Components category. It shares the theme’s single icon registry, includes accessible-label support for meaningful icons, and treats unlabeled icons as decorative. It is intentionally the only custom block: all page structure uses WordPress core blocks.

## Parts and section boundaries

| Type | Where it is managed | Intended use |
|---|---|---|
| Part | Global Site Settings / menu locations | Repeated header, footer, announcement, and CTA behavior |
| Section | Patterns panel | Reusable page-level content such as heroes, service grids, FAQs, and contact layouts |
| Pattern | Patterns panel | A ready-made arrangement of core blocks |
| Block | Inserter | Small, independently editable content/function unit |
| Template | Theme PHP files | Full conventional page structures and content-type layouts |

## Header and footer variants

In **Appearance → Customize → Global Site Settings**, select a header or footer variation. Navigation remains controlled by the registered WordPress menu locations; the settings change the presentation, not the menu data.

The footer CTA uses the same Customizer panel and does not require a separate content system.

## Motion and accessibility

Existing reveal effects use `IntersectionObserver`. New patterns use only subtle CSS transitions; continuous gradient motion is disabled when the visitor requests reduced motion. FAQ patterns use the native Details block, which provides keyboard-accessible disclosure without custom scripts.

## Contact patterns

Contact patterns use the `[paksa_contact_form]` shortcode, which renders the established theme form and retains its existing nonce, validation, honeypot, and delivery handling. Configure delivery details under **Global Site Settings → Contact Information**.
