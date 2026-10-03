<?php
/**
 * WP-CLI import script — Paksa ERP product page
 * Run: wp eval-file paksa-erp-import.php
 *
 * Reference: https://paksa.com.pk/paksa-erp-ai-powered-enterprise-resource-planning-software/
 * Target URL: /solutions/paksa-erp/
 */

// Check for existing post to avoid duplicates
$existing = get_posts( array(
    'post_type'   => 'paksa_product',
    'name'        => 'paksa-erp',
    'post_status' => 'any',
    'numberposts' => 1,
) );

if ( $existing ) {
    $post_id = $existing[0]->ID;
    WP_CLI::log( "Updating existing post ID: $post_id" );
} else {
    $post_id = wp_insert_post( array(
        'post_type'    => 'paksa_product',
        'post_status'  => 'publish',
        'post_title'   => 'Paksa ERP',
        'post_name'    => 'paksa-erp',
        'post_excerpt' => 'AI-powered Enterprise Resource Planning software that unifies finance, inventory, HR, manufacturing, and sales into one intelligent platform — built for Pakistani businesses.',
        'menu_order'   => 1,
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::error( $post_id->get_error_message() );
        return;
    }
    WP_CLI::log( "Created post ID: $post_id" );
}

// Assign taxonomy category
$term = term_exists( 'Enterprise Resource Planning', 'paksa_product_cat' );
if ( ! $term ) {
    $term = wp_insert_term( 'Enterprise Resource Planning', 'paksa_product_cat', array( 'slug' => 'erp' ) );
}
if ( ! is_wp_error( $term ) ) {
    wp_set_object_terms( $post_id, (int) $term['term_id'], 'paksa_product_cat' );
}

// ── META ─────────────────────────────────────────────────────────────────────

$meta = array(

    // Identity
    'tagline'        => 'AI-Powered Enterprise Resource Planning Software',
    'category_label' => 'Enterprise Resource Planning',
    'badge'          => 'AI-Powered',
    'featured'       => '1',

    // Hero
    'hero_eyebrow'     => 'Enterprise Resource Planning',
    'hero_heading'     => 'Paksa ERP — AI-Powered Business Management',
    'hero_description' => 'Unify your entire business on one intelligent platform. Paksa ERP connects finance, inventory, HR, manufacturing, procurement, and sales with real-time AI insights — purpose-built for Pakistani enterprises.',
    'hero_cta1_text'   => 'Request a Demo',
    'hero_cta1_url'    => '/contact/',
    'hero_cta2_text'   => 'Explore Modules',
    'hero_cta2_url'    => '#pk-product-modules',

    // Overview
    'overview_eyebrow' => 'What is Paksa ERP?',
    'overview_heading' => 'One Platform. Every Business Function.',
    'overview_content' => "Paksa ERP is a comprehensive, AI-powered Enterprise Resource Planning solution designed specifically for the operational realities of Pakistani businesses. From SMEs scaling up to large enterprises managing complex multi-site operations, Paksa ERP delivers the tools, automation, and intelligence needed to compete in today's market.\nBuilt on a modern, cloud-ready architecture, Paksa ERP eliminates data silos by connecting every department — finance, inventory, HR, manufacturing, procurement, and sales — into a single source of truth. Every transaction, every workflow, and every decision is informed by real-time data and AI-driven recommendations.\nUnlike generic ERP systems that require expensive customisation, Paksa ERP ships with Pakistan-specific compliance built in: FBR tax integration, multi-currency PKR support, local payroll rules, and Urdu language support. Your team gets up and running faster, with less friction and lower total cost of ownership.",

    // Features
    'features_eyebrow' => 'Core Capabilities',
    'features_heading'  => 'Key Features of Paksa ERP',
    'features_desc'     => 'Every feature is engineered to reduce manual work, improve accuracy, and give your leadership team the visibility they need to make confident decisions.',
    'features_list'     => "AI-Powered Analytics & Reporting | Real-time dashboards and predictive analytics surface trends, anomalies, and opportunities across every business unit — no manual report building required.\nFBR Tax & Compliance Integration | Built-in FBR e-invoicing, sales tax returns, and withholding tax management keep your business compliant without third-party add-ons.\nMulti-Company & Multi-Branch | Manage multiple legal entities, branches, and warehouses from a single login with consolidated reporting and inter-company transactions.\nReal-Time Inventory Management | Track stock levels, movements, valuations, and reorder points across all locations with barcode and RFID support.\nIntegrated Financial Accounting | Full double-entry accounting with chart of accounts, bank reconciliation, budgeting, and financial statements aligned to Pakistani standards.\nHR & Payroll Management | Automate payroll calculations, EOBI, PESSI, and income tax deductions with employee self-service and leave management.\nManufacturing & Production Planning | Bill of materials, work orders, production scheduling, and quality control for discrete and process manufacturers.\nProcurement & Supplier Management | Streamline purchase requisitions, RFQs, purchase orders, and supplier performance tracking with three-way matching.\nSales & CRM Integration | Manage leads, quotations, sales orders, and customer accounts with full pipeline visibility and commission tracking.\nProject Management & Costing | Track project budgets, timesheets, milestones, and profitability with real-time cost-to-complete analysis.",

    // Modules
    'modules_eyebrow' => 'Product Modules',
    'modules_heading'  => 'Complete ERP Module Suite',
    'modules_desc'     => 'Paksa ERP is modular — deploy what you need today and activate additional modules as your business grows. All modules share a unified data layer.',
    'modules_list'     => "Financial Management | General ledger, accounts payable, accounts receivable, bank reconciliation, budgeting, and multi-currency financial reporting.\nInventory & Warehouse | Multi-location stock management, lot and serial tracking, cycle counting, landed costs, and warehouse operations.\nHuman Resources & Payroll | Employee records, recruitment, attendance, leave, payroll, EOBI/PESSI compliance, and employee self-service portal.\nManufacturing | Bill of materials, routing, work orders, MRP, shop floor control, quality management, and production costing.\nProcurement | Purchase requisitions, vendor management, RFQ, purchase orders, goods receipt, and supplier scorecards.\nSales & Distribution | Quotations, sales orders, delivery management, invoicing, returns, and territory management.\nCRM & Customer Management | Lead management, opportunity tracking, customer 360 view, service tickets, and customer portal.\nProject Management | Project planning, task management, resource allocation, timesheet tracking, and project profitability.\nPoint of Sale | Retail POS with offline capability, loyalty programmes, multi-payment methods, and real-time sync to inventory and accounting.\nAsset Management | Fixed asset register, depreciation schedules, maintenance tracking, and asset disposal management.",

    // Benefits
    'benefits_eyebrow' => 'Business Value',
    'benefits_heading'  => 'Why Businesses Choose Paksa ERP',
    'benefits_list'     => "Eliminate Data Silos | A single unified database means finance, operations, and management always work from the same real-time information — no more reconciling spreadsheets.\nAccelerate Month-End Close | Automated journal entries, bank feeds, and reconciliation tools compress your financial close cycle from weeks to days.\nScale Without Complexity | The modular architecture grows with your business — add users, locations, and modules without re-implementation or data migration.\nReduce Operational Costs | Automation of repetitive tasks across procurement, payroll, and invoicing frees your team to focus on higher-value work.\nMake Faster, Smarter Decisions | AI-powered dashboards and alerts give leadership real-time visibility into KPIs, cash flow, and operational bottlenecks.\nStay Compliant Automatically | Built-in FBR, SECP, and labour law compliance rules update with regulatory changes so your business is always audit-ready.\nImprove Customer Satisfaction | Integrated CRM and order management ensure accurate delivery commitments, faster invoicing, and proactive customer communication.",

    // Industries
    'industries_list' => "Manufacturing | manufacturing\nDistribution & Trading | distribution\nRetail & Ecommerce | retail\nHealthcare & Pharma | healthcare\nConstruction & Real Estate | enterprise\nAgriculture & Food Processing | agriculture\nHospitality & Services | hospitality\nProfessional Services | services",

    // FAQ
    'faq_items' => "Is Paksa ERP suitable for small and medium businesses? | Yes. Paksa ERP is designed to scale from SMEs with 10 users to large enterprises with hundreds of concurrent users. The modular pricing means you only pay for what you use.\nDoes Paksa ERP support FBR e-invoicing? | Yes. Paksa ERP includes native FBR PRAL integration for real-time e-invoicing, sales tax return preparation, and withholding tax management — no third-party connector required.\nCan Paksa ERP be deployed on-premise? | Paksa ERP supports both cloud (SaaS) and on-premise deployment. We also offer a hybrid model for businesses with specific data residency requirements.\nHow long does implementation take? | A standard implementation for an SME takes 4–8 weeks. Enterprise deployments with complex integrations and data migration typically take 3–6 months. We provide a dedicated implementation team.\nDoes Paksa ERP support multiple currencies? | Yes. Full multi-currency support including PKR, USD, EUR, AED, and GBP with real-time exchange rate feeds and revaluation.\nWhat kind of support is included? | All plans include onboarding training, documentation, and email support. Premium plans include dedicated account management, phone support, and SLA-backed response times.\nCan we migrate data from our existing system? | Yes. Our implementation team provides data migration services from common ERP systems, accounting software, and Excel-based systems. We validate data integrity before go-live.",

    // CTA Override
    'cta_heading'     => 'See Paksa ERP in Action',
    'cta_description' => 'Book a personalised demo with our ERP consultants. We will walk you through the modules most relevant to your industry and answer your specific questions.',
    'cta_btn1_text'   => 'Request a Demo',
    'cta_btn1_url'    => '/contact/',
    'cta_btn2_text'   => 'Talk to a Consultant',
    'cta_btn2_url'    => '/contact/',
);

foreach ( $meta as $key => $value ) {
    update_post_meta( $post_id, '_paksa_prod_' . $key, $value );
}

WP_CLI::success( "Paksa ERP page created/updated. URL: " . get_permalink( $post_id ) );
