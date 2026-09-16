<?php
/**
 * Paksa IT Solutions — Customizer Settings
 * All homepage content is controlled from here. Nothing is hardcoded.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Customizer panels, sections, and settings.
 */
function paksa_customizer_register( $wp_customize ) {

    // =========================================================
    // PANEL: Homepage
    // =========================================================
    $wp_customize->add_panel( 'paksa_homepage', array(
        'title'    => __( 'Homepage', 'paksa-it-solutions' ),
        'priority' => 30,
    ) );

    // ---------------------------------------------------------
    // SECTION: Hero
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_hero', array(
        'title' => __( 'Hero Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_hero_eyebrow', 'paksa_hero',
        __( 'Eyebrow Label', 'paksa-it-solutions' ),
        __( 'Enterprise Technology Solutions', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_hero_heading', 'paksa_hero',
        __( 'Main Heading', 'paksa-it-solutions' ),
        __( 'Technology That Moves Business Forward', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_hero_subheading', 'paksa_hero',
        __( 'Sub-heading Lines', 'paksa-it-solutions' ),
        __( "Build Smarter.\nOperate Better.\nGrow With Confidence.", 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_hero_description', 'paksa_hero',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'Paksa IT Solutions builds enterprise software, AI-powered solutions and intelligent digital systems designed around real business challenges.', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_hero_cta_primary_text', 'paksa_hero',
        __( 'Primary CTA Text', 'paksa-it-solutions' ),
        __( 'Get a Free Consultation', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_hero_cta_primary_url', 'paksa_hero',
        __( 'Primary CTA URL', 'paksa-it-solutions' ),
        '#contact'
    );
    paksa_customizer_text( $wp_customize, 'paksa_hero_cta_secondary_text', 'paksa_hero',
        __( 'Secondary CTA Text', 'paksa-it-solutions' ),
        __( 'Explore Our Solutions', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_hero_cta_secondary_url', 'paksa_hero',
        __( 'Secondary CTA URL', 'paksa-it-solutions' ),
        '#solutions'
    );

    // ---------------------------------------------------------
    // SECTION: Trust Strip
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_trust_strip', array(
        'title' => __( 'Trust / Capability Strip', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    for ( $i = 1; $i <= 6; $i++ ) {
        paksa_customizer_text( $wp_customize, 'paksa_trust_item_' . $i, 'paksa_trust_strip',
            sprintf( __( 'Capability %d', 'paksa-it-solutions' ), $i ),
            paksa_trust_default( $i )
        );
    }

    // ---------------------------------------------------------
    // SECTION: Business Challenge
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_challenge', array(
        'title' => __( 'Business Challenge Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_challenge_eyebrow', 'paksa_challenge',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'The Problem', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_challenge_heading', 'paksa_challenge',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'Technology Should Solve Business Problems.', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_challenge_description', 'paksa_challenge',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'Most businesses operate with disconnected systems, manual processes and fragmented data. The result is slow decisions, limited visibility and missed opportunities.', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_challenge_transition', 'paksa_challenge',
        __( 'Transition Statement', 'paksa-it-solutions' ),
        __( 'We turn these challenges into connected digital systems.', 'paksa-it-solutions' )
    );

    for ( $i = 1; $i <= 6; $i++ ) {
        paksa_customizer_text( $wp_customize, 'paksa_challenge_problem_' . $i, 'paksa_challenge',
            sprintf( __( 'Problem %d', 'paksa-it-solutions' ), $i ),
            paksa_challenge_problem_default( $i )
        );
    }

    // ---------------------------------------------------------
    // SECTION: What We Build (Capabilities)
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_capabilities', array(
        'title' => __( 'What We Build — Capabilities', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_capabilities_eyebrow', 'paksa_capabilities',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'What We Build', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_capabilities_heading', 'paksa_capabilities',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'Technology Built Around Your Business', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_capabilities_description', 'paksa_capabilities',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'From enterprise platforms to intelligent automation — we build the systems that power serious business operations.', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: Process (How We Work)
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_process', array(
        'title' => __( 'How We Work — Process', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_process_eyebrow', 'paksa_process',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'Our Process', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_process_heading', 'paksa_process',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'How We Work', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_process_description', 'paksa_process',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'A structured approach that moves from business understanding to deployed, evolving technology.', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: Why Paksa
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_why', array(
        'title' => __( 'Why Paksa Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_why_eyebrow', 'paksa_why',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'Why Paksa', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_why_heading', 'paksa_why',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'Technology With Business Thinking Behind It.', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_why_description', 'paksa_why',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'We combine deep technical capability with genuine understanding of how businesses operate.', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: Industries
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_industries', array(
        'title' => __( 'Industries Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_industries_eyebrow', 'paksa_industries',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'Industries', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_industries_heading', 'paksa_industries',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'Built for the Industries That Drive Business', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_industries_description', 'paksa_industries',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'Our solutions are designed around the operational realities of specific industries — not generic software adapted to fit.', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: FAQ
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_faq', array(
        'title' => __( 'FAQ Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_faq_eyebrow', 'paksa_faq',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'FAQ', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_faq_heading', 'paksa_faq',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'Common Questions', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: Technology Capabilities
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_technology', array(
        'title' => __( 'Technology Capabilities Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_technology_eyebrow', 'paksa_technology',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'Our Capabilities', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_technology_heading', 'paksa_technology',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'From Business Requirements to Intelligent Systems', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_technology_description', 'paksa_technology',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'A complete capability stack — from initial analysis through to deployed, intelligent business systems.', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: AI & Business Intelligence
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_intelligence', array(
        'title' => __( 'AI & Business Intelligence Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_intelligence_eyebrow', 'paksa_intelligence',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'AI & Business Intelligence', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_intelligence_heading', 'paksa_intelligence',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'Turn Business Data Into Intelligence.', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_intelligence_description', 'paksa_intelligence',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'We apply AI and analytics where they create genuine business value — not as a feature, but as a capability embedded in your operations.', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: How We Are Different
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_differentiation', array(
        'title' => __( 'How We Are Different Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_diff_eyebrow', 'paksa_differentiation',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'Our Difference', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_diff_heading', 'paksa_differentiation',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'More Than Software Development.', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_diff_description', 'paksa_differentiation',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'The difference between a technology vendor and a technology partner.', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: Business Outcomes
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_outcomes', array(
        'title' => __( 'Business Outcomes Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_outcomes_eyebrow', 'paksa_outcomes',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'Business Outcomes', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_outcomes_heading', 'paksa_outcomes',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'What Changes When Technology Works Properly', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_outcomes_description', 'paksa_outcomes',
        __( 'Description', 'paksa-it-solutions' ),
        __( 'The measurable difference that well-designed business technology makes to operations.', 'paksa-it-solutions' )
    );

    // ---------------------------------------------------------
    // SECTION: Final CTA
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_final_cta', array(
        'title' => __( 'Final CTA Section', 'paksa-it-solutions' ),
        'panel' => 'paksa_homepage',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_cta_eyebrow', 'paksa_final_cta',
        __( 'Eyebrow', 'paksa-it-solutions' ),
        __( 'Get Started', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_cta_heading', 'paksa_final_cta',
        __( 'Heading', 'paksa-it-solutions' ),
        __( 'Have a Business Challenge?', 'paksa-it-solutions' )
    );
    paksa_customizer_textarea( $wp_customize, 'paksa_cta_description', 'paksa_final_cta',
        __( 'Description', 'paksa-it-solutions' ),
        __( "Let's turn your requirements into a technology solution built for the way your business works.", 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_cta_primary_text', 'paksa_final_cta',
        __( 'Primary Button Text', 'paksa-it-solutions' ),
        __( 'Get a Free Consultation', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_cta_primary_url', 'paksa_final_cta',
        __( 'Primary Button URL', 'paksa-it-solutions' ),
        '#contact'
    );
    paksa_customizer_text( $wp_customize, 'paksa_cta_secondary_text', 'paksa_final_cta',
        __( 'Secondary Button Text', 'paksa-it-solutions' ),
        __( 'Discuss Your Project', 'paksa-it-solutions' )
    );
    paksa_customizer_text( $wp_customize, 'paksa_cta_secondary_url', 'paksa_final_cta',
        __( 'Secondary Button URL', 'paksa-it-solutions' ),
        '#contact'
    );

    // ---------------------------------------------------------
    // SECTION: Homepage Section Visibility
    // ---------------------------------------------------------
    $wp_customize->add_section( 'paksa_home_visibility', array(
        'title'       => __( 'Section Visibility', 'paksa-it-solutions' ),
        'description' => __( 'Show or hide individual homepage sections. All sections are visible by default.', 'paksa-it-solutions' ),
        'panel'       => 'paksa_homepage',
        'priority'    => 200,
    ) );

    $visibility_sections = array(
        'paksa_home_show_hero'            => __( 'Hero', 'paksa-it-solutions' ),
        'paksa_home_show_trust_strip'     => __( 'Trust / Capability Strip', 'paksa-it-solutions' ),
        'paksa_home_show_challenge'       => __( 'Business Challenge', 'paksa-it-solutions' ),
        'paksa_home_show_capabilities'    => __( 'What We Build', 'paksa-it-solutions' ),
        'paksa_home_show_technology'      => __( 'Technology Capabilities', 'paksa-it-solutions' ),
        'paksa_home_show_products'        => __( 'Featured Products', 'paksa-it-solutions' ),
        'paksa_home_show_intelligence'    => __( 'AI & Business Intelligence', 'paksa-it-solutions' ),
        'paksa_home_show_process'         => __( 'How We Work', 'paksa-it-solutions' ),
        'paksa_home_show_why_paksa'       => __( 'Why Paksa', 'paksa-it-solutions' ),
        'paksa_home_show_differentiation' => __( 'How We Are Different', 'paksa-it-solutions' ),
        'paksa_home_show_industries'      => __( 'Industries', 'paksa-it-solutions' ),
        'paksa_home_show_case_studies'    => __( 'Case Studies', 'paksa-it-solutions' ),
        'paksa_home_show_outcomes'        => __( 'Business Outcomes', 'paksa-it-solutions' ),
        'paksa_home_show_faq'             => __( 'FAQ', 'paksa-it-solutions' ),
        'paksa_home_show_final_cta'       => __( 'Final CTA', 'paksa-it-solutions' ),
    );

    foreach ( $visibility_sections as $setting_id => $label ) {
        $wp_customize->add_setting( $setting_id, array(
            'default'           => '1',
            'sanitize_callback' => function( $val ) { return $val === '0' ? '0' : '1'; },
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $setting_id, array(
            'label'   => $label,
            'section' => 'paksa_home_visibility',
            'type'    => 'select',
            'choices' => array(
                '1' => __( 'Show', 'paksa-it-solutions' ),
                '0' => __( 'Hide', 'paksa-it-solutions' ),
            ),
        ) );
    }

    // =========================================================
    // PANEL: Global Site Settings
    // =========================================================
    $wp_customize->add_panel( 'paksa_global', array(
        'title'    => __( 'Global Site Settings', 'paksa-it-solutions' ),
        'priority' => 25,
    ) );

    $wp_customize->add_section( 'paksa_contact_info', array(
        'title' => __( 'Contact Information', 'paksa-it-solutions' ),
        'panel' => 'paksa_global',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_phone', 'paksa_contact_info',
        __( 'Phone Number', 'paksa-it-solutions' ), '+92 305 7772572' );
    paksa_customizer_text( $wp_customize, 'paksa_email', 'paksa_contact_info',
        __( 'Email Address', 'paksa-it-solutions' ), 'info@paksa.com.pk' );
    paksa_customizer_text( $wp_customize, 'paksa_address', 'paksa_contact_info',
        __( 'Address', 'paksa-it-solutions' ), '13-A-1 Commercial Area, PIA Housing Society, Lahore, Pakistan' );
    paksa_customizer_text( $wp_customize, 'paksa_whatsapp_url', 'paksa_contact_info',
        __( 'WhatsApp URL', 'paksa-it-solutions' ), 'https://api.whatsapp.com/send/?phone=923144676210' );

    // WhatsApp floating button visibility
    $wp_customize->add_setting( 'paksa_whatsapp_show', array(
        'default'           => '1',
        'sanitize_callback' => function( $val ) { return $val === '0' ? '0' : '1'; },
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'paksa_whatsapp_show', array(
        'label'   => __( 'Show WhatsApp Button', 'paksa-it-solutions' ),
        'section' => 'paksa_contact_info',
        'type'    => 'select',
        'choices' => array(
            '1' => __( 'Show', 'paksa-it-solutions' ),
            '0' => __( 'Hide', 'paksa-it-solutions' ),
        ),
    ) );

    $wp_customize->add_section( 'paksa_social_section', array(
        'title' => __( 'Social Media Links', 'paksa-it-solutions' ),
        'panel' => 'paksa_global',
    ) );

    paksa_customizer_text( $wp_customize, 'paksa_social_facebook', 'paksa_social_section',
        __( 'Facebook URL', 'paksa-it-solutions' ), 'https://www.facebook.com/PaksaITSolutions' );
    paksa_customizer_text( $wp_customize, 'paksa_social_twitter', 'paksa_social_section',
        __( 'Twitter/X URL', 'paksa-it-solutions' ), 'https://twitter.com/PaksaPk' );
    paksa_customizer_text( $wp_customize, 'paksa_social_linkedin', 'paksa_social_section',
        __( 'LinkedIn URL', 'paksa-it-solutions' ), 'https://www.linkedin.com/company/paksaitsolutions' );
    paksa_customizer_text( $wp_customize, 'paksa_social_github', 'paksa_social_section',
        __( 'GitHub URL', 'paksa-it-solutions' ), 'https://github.com/paksaitsolutions' );
}
add_action( 'customize_register', 'paksa_customizer_register' );

// =========================================================
// HELPER: Register text setting + control
// =========================================================
function paksa_customizer_text( $wp_customize, $id, $section, $label, $default = '' ) {
    $wp_customize->add_setting( $id, array(
        'default'           => $default,
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( $id, array(
        'label'   => $label,
        'section' => $section,
        'type'    => 'text',
    ) );
}

// =========================================================
// HELPER: Register textarea setting + control
// =========================================================
function paksa_customizer_textarea( $wp_customize, $id, $section, $label, $default = '' ) {
    $wp_customize->add_setting( $id, array(
        'default'           => $default,
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( $id, array(
        'label'   => $label,
        'section' => $section,
        'type'    => 'textarea',
    ) );
}

// =========================================================
// DEFAULT DATA HELPERS
// =========================================================
function paksa_trust_default( $i ) {
    $defaults = array(
        1 => 'Enterprise Software',
        2 => 'AI & Machine Learning',
        3 => 'Business Intelligence',
        4 => 'Custom Development',
        5 => 'System Integration',
        6 => 'Digital Transformation',
    );
    return isset( $defaults[ $i ] ) ? $defaults[ $i ] : '';
}

function paksa_challenge_problem_default( $i ) {
    $defaults = array(
        1 => 'Disconnected systems',
        2 => 'Manual processes',
        3 => 'Fragmented data',
        4 => 'Inefficient workflows',
        5 => 'Limited reporting',
        6 => 'Slow decision-making',
    );
    return isset( $defaults[ $i ] ) ? $defaults[ $i ] : '';
}

// =========================================================
// HELPER: Get customizer value with fallback
// =========================================================
function paksa_get_option( $key, $fallback = '' ) {
    return get_theme_mod( $key, $fallback );
}
