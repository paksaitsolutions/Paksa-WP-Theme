# Paksa IT Solutions — WordPress Theme Requirements

> **Source:** https://paksa.com.pk/ deep dive — September 16, 2026  
> **Purpose:** Requirements for building/uploading a WordPress theme for Paksa.com.pk

---

## 1. Company Profile

| Field | Details |
|---|---|
| **Company** | Paksa IT Solutions |
| **Founded** | 2019 |
| **HQ** | 13-A-1 Commercial Area, PIA Housing Society, Lahore, Pakistan |
| **Email** | info@paksa.com.pk, sales@paksa.com.pk |
| **Phone** | +92 305 7772572, +92 314 4676210 |
| **WhatsApp** | https://api.whatsapp.com/send/?phone=923144676210 |
| **Hours** | 9am – 6pm |
| **Social** | Facebook, Twitter/X, LinkedIn |
| **Website** | https://paksa.com.pk/ |
| **Industry** | IT Solutions, AI/ML, Data Science, Software Development |

---

## 2. Site Architecture & Navigation

### Main Menu (Header)

```
Home
Our Services ▾
  ├── AI & ML Solutions
  ├── AI Automation Services
  ├── Data Science & Analytics
  └── Software Development
Solutions ▾
  ├── AI Based ERP (Paksa ERP)
  ├── EventLogic (Marriage Hall Mgmt)
  ├── TourLedger (Tour Management)
  ├── Paksa PoultryPro (Poultry Farm)
  └── Salon Management (Salon Software)
About ▾
  ├── About Us
  ├── Blog
  ├── Open Source Projects
  └── Case Studies (with sub-item: Enterprise Collection Intelligence Case Study)
Contact Us
```

### Footer Links

| Column | Links |
|---|---|
| **Products** | Paksa AI Based ERP, Marriage Hall Solution, Poultry Farm Solutions, Tour Operators Solutions, Salon Software |
| **Services** | AI & ML Solutions, AI Automation Services, Data Analysis Services, Our Team (placeholder), Contact Us (placeholder) |
| **Company** | About Us, Services, Privacy Policy, Terms & Conditions, Our Pricing (placeholder), Refund policy |

---

## 3. Page-by-Page Requirements

### 3.1 Homepage (`/`)

**Layout:** Single-page scroll with multiple sections

| Section | Description | Notes |
|---|---|---|
| **Hero Banner** | Headline: "AI-Powered IT Solutions for Data-Driven Businesses" with description + "Get Started" CTA button | Has Home 1 / Home 2 variants (slider or page options) |
| **Feature Cards** | 4 cards in a row: Automation AI, Data & Analytics, AI & ML Solutions, Intelligent Digital Solutions | Each with icon, title, description |
| **About Us Section** | Company intro with "Advanced AI & Data Capabilities" and "What We Do" subsections | Includes icon cards: Automated AI Chatbots, Software & Web Development, Machine Learning, E-commerce Solutions |
| **Our Solutions (Products)** | 4 product cards: Paksa ERP, Paksa Poultry Pro, EventLogic, Tour Ledger | Each links to product page |
| **Stats / Counters** | "Worldwide Experience" section with animated counters: Customers, Positive Feedback, Users, Contributors | Currently shows 0 values (counters animate on scroll) |
| **Testimonials** | 4 client testimonials with star ratings (5★ each) | Names: Sheikh Abid Hussain, Sagheer Ch., Dr Majed Abdali, Sartaj Yousaf |
| **Partner Logos** | Client/partner logo grid (~26 logos) | Logo carousel/grid |
| **Latest News** | 3 blog post cards with thumbnails, titles, excerpts, "Read More" links | Posts: Salon Management, PoultryPro, Digitizing Poultry Farming |
| **Ad Banner** | 728×90 banner advertisement (Hostinger ad) | Should be configurable |
| **CTA Banner** | "Paksa IT Solutions delivers intelligent, data-driven IT solutions..." with product/service quick links | Full-width section |

**Homepage Variants:** Home 1, Home 2 (two layout options selectable from page attributes)

### 3.2 About Us (`/about-us/`)

| Section | Description |
|---|---|
| **Breadcrumb** | Home / About Us |
| **Hero** | Title + description: "Delivering AI-driven, data-focused IT solutions..." |
| **About Text** | Company story since 2019, AI/ML/Automation focus |
| **Mission** | "To empower businesses with intelligent, data-driven technology solutions..." |
| **Vision** | "To be a trusted technology partner recognized for delivering innovative AI and data solutions..." |
| **Our Expertise** | Data, intelligence, automation intersection — predictive analytics, ML models, AI chatbots, automation workflows |
| **Our Approach** | Business-first analysis, Data-driven design, Scalable implementation, Ongoing optimization |
| **Why Choose Us** | End-to-end IT services, quality, transparency, reliability |
| **CTA** | Company description + social links |

### 3.3 Our Services (`/our-services/`)

| Section | Description |
|---|---|
| **Breadcrumb** | Home / Our Services |
| **Intro** | Description of AI-driven, data-focused IT services |
| **10 Service Cards** (2-column grid) | AI & ML Solutions, AI Automation Solutions, Software Development, Data Science & Analytics, Website & WordPress Development, E-commerce Solutions, Brand Development & Digital Solutions, IT Consultancy Services, IT HR Services |
| **CTA** | "Let's Build Intelligent Solutions" with Contact Us link |

**Sub-pages (4):**
- `/ai-ml-solutions/` — Custom AI & ML Models, NLP & Chatbots, Predictive Analytics, Recommendation Systems, Computer Vision, AI Automation. Includes FAQ section (5 questions) and implementation approach (5 steps).
- `/ai-automation-services/` — AI chatbots, WhatsApp automation, intelligent workflow automation
- `/data-science-analytics-services/` — Analytics, reporting, predictive modeling, BI solutions
- `/custom-software-development-services/` — Enterprise apps, API integrations, custom development

### 3.4 Business & AI Solutions (`/business-ai-solutions/`)

5 Product solutions with detailed descriptions:

| Product | Type | Key Features |
|---|---|---|
| **Paksa ERP** | Desktop ERP (.NET/WPF/SQLite) | 17 modules: Finance, Inventory, Procurement, Sales, HRMS, AI Analytics, Reporting, Workflow Automation, etc. Sub-pages: Dashboard, Finance, HRMS, AI Center, Reports, Sales, Procurement |
| **EventLogic** | Marriage Hall Management | Bookings, scheduling, costing, inventory, billing, invoicing |
| **TourLedger** | Tour/Travel Management | Bookings, packages, departures, CRM, expenses, financial reports |
| **Paksa PoultryPro** | Poultry Farm ERP | 26+ modules: Farm management, shed operations, health tracking, feed management, profitability |
| **Salon Management** | Salon Software | Appointments, staff, services, customer management, scheduling |

**Each product page** has:
- Feature bullet list (icon tags like 🔹)
- Dashboard screenshots/gallery
- Sub-page navigation (dashboards, settings, reports)
- FAQ section

### 3.5 Blog (`/blog-2/`)

| Feature | Details |
|---|---|
| **Layout** | Blog archive with list/grid view, thumbnails, titles, dates, excerpts |
| **Pagination** | "Load More" button (page 2+ exists) |
| **Categories** | Salon Management, Poultry, AI Technologies, ERP, Data-Driven Businesses |
| **Posts found** | 6+ posts (dated Jun–Sep 2026) |
| **Individual post** | Single post template with featured image, title, date, content, comments section |

### 3.6 Case Studies (`/case-studies/`)

| Feature | Details |
|---|---|
| **Layout** | Case study archive/grid |
| **Items** | 1 case study: "Enterprise Collection Intelligence Case Study" |
| **Single case study** | Project description, challenges, solutions, results format |

### 3.7 Open Source Projects (`/open-source-enterprise-software-ai-projects/`)

| Feature | Details |
|---|---|
| **Layout** | Showcase/grid of GitHub repositories |
| **Repos** | Paksa Financial System, Lab-PDF-To-Dataset, Paksa Cart Recovery, PaksaTalker, Paksa Daily Expense |
| **Each repo** | Name, description, GitHub link, tech stack info |
| **Content** | "Why We Open Source" narrative section |

### 3.8 Contact Us (`/contact-us-2/`)

| Section | Details |
|---|---|
| **Breadcrumb** | Home / Contact Us |
| **Title** | "Get in Touch with Our AI Specialists" |
| **Contact Form** | Fields: Your name, Your email, Subject, Your message |
| **Company Mail** | info@paksa.com.pk, sales@paksa.com.pk |
| **Phone** | +92 305 7772572 |
| **Office Location** | 13-A-1 Commercial Area, PIA Housing Society, Lahore |
| **Map** | Google Maps embed (implied by location section) |
| **Social** | Facebook, Twitter, LinkedIn icons |
| **WhatsApp** | Floating/fixed WhatsApp button |

---

## 4. Design & Style Requirements

### Color Palette (extracted from site)

| Role | Color | Hex |
|---|---|---|
| **Primary** | Steel Blue | `#4A6FA5` (from brand identity) |
| **Secondary** | Dark Blue/Navy | `#1E3A5F` (headings) |
| **Accent** | Teal/Cyan | `#0097A7` (CTA highlights) |
| **Background** | White | `#FFFFFF` |
| **Background Alt** | Light Gray | `#F5F7FA` (section backgrounds) |
| **Text** | Dark Gray | `#333333` |
| **Text Light** | Medium Gray | `#666666` |
| **Border** | Light Gray | `#E0E0E0` |
| **Placeholder** | Light Blue-Gray | `#C6D4DB` (from image placeholders) |
| **CTA Button** | Blue | `#4A6FA5` or `#0097A7` |
| **Success/Stars** | Gold/Amber | `#FFC107` |

### Typography

| Element | Font | Weight |
|---|---|---|
| **Headings** | Inter / Poppins / Sans-serif | 600–700 |
| **Body** | Inter / Roboto / Sans-serif | 400 |
| **Small/Label** | Sans-serif | 500 |

### Design Patterns

| Pattern | Usage |
|---|---|
| **Card-based layouts** | Services, products, blog posts, testimonials |
| **Hero sections** | Large heading + description + CTA (most pages) |
| **Icon + text grids** | Features, capabilities, quick links |
| **Testimonial cards** | Avatar + name + role + stars + quote |
| **Star ratings** | 5-star display for testimonials |
| **Animated counters** | Stats section on homepage |
| **Logo grid/carousel** | Partner/client logos |
| **FAQ accordions** | AI & ML page, Paksa ERP page |
| **Breadcrumb navigation** | All inner pages |
| **Sticky header** | Navigation menu stays visible on scroll |
| **WhatsApp floating button** | Fixed position, visible on all pages |
| **Breadcrumb + page title** | Consistent inner page header |

---

## 5. Content Types (WordPress Custom Post Types Needed)

| CPT | Slug | Key Fields |
|---|---|---|
| **Services** | `service` | Title, description, icon, features list, linked_product (optional), gallery |
| **Products/Solutions** | `product` | Title, description, features (icon+text), gallery/dashboard images, sub-pages (nested), FAQ, tech_stack, pricing (optional) |
| **Blog Posts** | `post` (default) | Standard WP post with categories, featured image |
| **Case Studies** | `case_study` | Title, description, challenge/solution/results, gallery, client info |
| **Testimonials** | `testimonial` | Name, role/company, quote, rating (1-5 stars), avatar |
| **Partners/Logos** | `partner` | Name, logo image, website link |
| **Team Members** | `team_member` | Name, role, photo, email, phone, social links (Our Team page - placeholder) |
| **Open Source Projects** | `project` | Name, GitHub repo URL, description, tech stack |

---

## 6. Custom Taxonomies Needed

| Taxonomy | For CPT | Terms |
|---|---|---|
| **Service Category** | Service | AI & ML, AI Automation, Data Science, Software Dev, etc. |
| **Product Category** | Product | ERP, Event Management, Travel, Agriculture, Salon |
| **Blog Category** | Post | AI, ERP, Poultry, Salon, Data, etc. |
| **Case Study Type** | Case Study | Industry-specific tags |

---

## 7. Theme Features & Functionality Required

### Core Features

| Feature | Details |
|---|---|
| **Multi-language ready** | RTL/LTR support (Urdu/English potential — Pakistan market) |
| **Responsive design** | Mobile, tablet, desktop (375px, 768px, 1024px, 1440px) |
| **Sticky header** | Navigation stays on scroll |
| **Mobile menu** | Hamburger menu with nested sub-menus |
| **WhatsApp floating button** | Fixed, configurable phone number |
| **Contact form** | Custom form (Name, Email, Subject, Message) — integrate with WP Mail or SMTP |
| **Google Maps** | Embedded map on Contact page |
| **Testimonial slider/carousel** | Auto-rotating testimonials |
| **Animated counters** | Number animation on scroll ( homepage stats) |
| **Blog with pagination** | Load More or numbered pagination |
| **Search** | Site search functionality |
| **SEO optimized** | Meta titles, descriptions, Open Graph, schema.org markup |
| **Fast loading** | Optimized images, lazy loading, caching support |
| **Security** | WP security best practices |
| **Accessibility** | WCAG 2.1 AA compliance |
| **Dark/Light mode** | Optional (based on brand preference) |

### Customizer Options

| Option | Type | Default |
|---|---|---|
| **Homepage layout** | Select | Home 1 |
| **Logo** | Media upload | Paksa logo |
| **Primary color** | Color picker | `#4A6FA5` |
| **Accent color** | Color picker | `#0097A7` |
| **WhatsApp number** | Text | +92 314 4676210 |
| **Contact info** | Repeater | Email, phone, address, hours |
| **Social links** | Repeater | Facebook, Twitter, LinkedIn |
| **Footer widgets** | Widget area | Products, Services, Company columns |
| **Ad banner code** | Code injection | 728×90 banner |
| **Preloader** | Toggle/select | Brand preloader |
| **Scroll-to-top** | Toggle | Enabled |
| **Google Maps API key** | Text | Empty |
| **Facebook Pixel** | Text | Empty |
| **Analytics code** | Code injection | Empty |

---

## 8. Header & Footer Requirements

### Header

```
[Logo] [Main Menu (mega-menu dropdowns for Services & Solutions)] [WhatsApp Button]
```

- Logo links to home
- Mega-menu dropdowns under "Our Services" and "Solutions"
- WhatsApp button (fixed right side or in header)
- Sticky on scroll

### Footer

```
[Company description + social icons]

[Products links]  [Services links]  [Company links]

Copyright © 2026 Paksa IT Solutions
[Online/Offline status] [Privacy policy link]
[WhatsApp us button]
```

---

## 9. Technical Requirements

| Requirement | Details |
|---|---|
| **WordPress version** | 6.0+ (block theme compatible) |
| **PHP version** | 7.4+ |
| **Theme type** | Block Theme (modern) or Classic Theme (flexible) |
| **Page builder compatibility** | Compatible with Gutenberg native blocks; optionally Gutenberg-friendly |
| **ACF (Advanced Custom Fields)** | Required for custom fields on products, services, testimonials |
| **Custom REST API endpoints** | For dynamic data loading (optional, for performance) |
| **WPML/Polylang ready** | If multi-language is needed |
| **WooCommerce** | Not required (no e-commerce on this site, but compatible if needed) |
| **Cache compatible** | Works with WP Super Cache, W3 Total Cache, LiteSpeed Cache |
| **Security plugins** | Compatible with Wordfence, Sucuri, iThemes Security |

---

## 10. Assets Needed

### Images/Icons

| Asset | Qty | Notes |
|---|---|---|
| **Logo** | 1 | SVG/PNG with dark and light variants |
| **Hero images** | 2 | Home 1, Home 2 variants |
| **Service icons** | 10+ | Custom SVG icons for each service |
| **Product screenshots** | 20+ | Dashboard screenshots for each product module |
| **Partner logos** | 26 | Client/partner logo images |
| **Testimonial avatars** | 4 | Client photos |
| **Blog thumbnails** | 6+ | Featured images for blog posts |
| **About images** | 3+ | Company photos |
| **Contact images** | 2+ | Location/office photos |
| **Favicon** | 1 | Paksa logo favicon |
| **Social share images** | 3-5 | OG images for key pages |
| **Loader/Preloader** | 1 | Animation file |

### Placeholder/Ad Assets

| Asset | Dimensions | Notes |
|---|---|---|
| **Ad banner** | 728×90 | Currently Hostinger ad |
| **CTA banner** | Full-width | Repeating on inner pages |

---

## 11. Navigation/Menu Structure

| Menu | Location | Items |
|---|---|---|
| **Primary Menu** | Header | Home, Our Services (dropdown), Solutions (dropdown), About (dropdown), Contact Us |
| **Footer Menu** | Footer column 1 | Products (5 links), Services (5 links), Company (6 links) |
| **Mobile Menu** | Hamburger | All primary items with collapsible sub-menus |

---

## 12. WordPress-Specific Theme Notes

1. **Page Templates needed:**
   - `front-page.php` / `index.php` — Homepage with section-based layout
   - `page.php` — Default inner page
   - `page-home.php` — Home variant 1
   - `page-home-2.php` — Home variant 2
   - `archive-service.php` — Services archive
   - `archive-product.php` — Products archive
   - `single-service.php` — Single service
   - `single-product.php` — Single product (with sub-page tabs)
   - `single-blog.php` — Single blog post
   - `archive-blog.php` — Blog archive (`/blog-2/`)
   - `page-contact.php` — Contact page with form
   - `page-about.php` — About page
   - `case-study.php` — Case studies archive/single
   - `projects.php` — Open source projects

2. **ACF Field Groups:**
   - `service_fields` — icon, features, gallery, linked product
   - `product_fields` — features (repeater: icon+title+content), gallery (gallery), sub_pages (repeater: title+url), faq (repeater: question+answer), tech_stack (text), pricing (text)
   - `testimonial_fields` — name, role, company, quote, rating, avatar
   - `contact_fields` — email, phone, address, hours, map_lat, map_lng
   - `hero_fields` — hero_image, hero_title, hero_description, hero_cta_text, hero_cta_url
   - `section_fields` — section_title, section_description, section_bg_color

3. **Custom blocks (Block Theme):**
   - Hero block (reusable across pages)
   - Service cards block
   - Product/solution cards block
   - Testimonial slider block
   - Stats/counter block
   - CTA banner block
   - Contact info block
   - FAQ accordion block

---

## 13. Open Source Projects Data (GitHub Repos)

| Repo | Description |
|---|---|
| `paksaitsolutions/PaksaFinancialSystem` | Enterprise-grade financial management platform |
| `paksaitsolutions/Lab-PDF-To-Dataset` | Medical lab report PDF → CSV/Excel data extraction |
| `paksaitsolutions/Paksa-Abandoned-Cart` | WooCommerce abandoned cart recovery (COD-market focused) |
| `paksaitsolutions/PaksaTalker` | AI talking head video generation with lip-sync |
| `paksaitsolutions/Paksa-Daily-Expenses-Tracker` | Income/expense tracking with analytics |

---

## 14. Blog Posts (Current Content)

| Post | Date | Category |
|---|---|---|
| Harnessing Efficiency: Salon Management Software | Sep 3, 2026 | Salon Management |
| Revolutionizing Poultry Management (PoultryPro) | Jun 17, 2026 | Poultry / ERP |
| Digitizing Poultry Farming in Pakistan | Jun 11, 2026 | Poultry |
| The Future of AI Technologies | Jun 2, 2026 | AI Technologies |
| Unlocking the Power of Paksa ERP | May 15, 2026 | ERP |
| Empowering Data-Driven Businesses with IT Solutions | Apr 24, 2026 | Data / IT Solutions |

---

## 15. Pending/Placeholder Items (Needs Client Input)

| Item | Status | Notes |
|---|---|---|
| Our Team page content | Placeholder link (`#`) | Needs team member data |
| Our Pricing page | Placeholder link (`#`) | Needs pricing structure |
| Refund policy page | Placeholder link (`#`) | Needs policy content |
| Services footer links | Placeholder (`#`) | Our Team, Contact Us |
| Company footer links | Placeholder (`#`) | Our Team links to `#` |
| Partner/client logos | Need assets | 26 logos needed |
| Product screenshots | Need assets | Dashboard images for all products |
| Google Maps API key | Needs configuration | For contact page map |
| Analytics/tracking | Needs setup | Facebook Pixel, Google Analytics |
| Favicon | Needs final version | Current logo used as placeholder |
| Ad banner | Client provides | 728×90 banner |
| Testimonial avatars | Need assets | 4 client photos |
| Blog post images | Need assets | 6+ featured images |
| WhatsApp API integration | Optional | Chat widget vs button |
