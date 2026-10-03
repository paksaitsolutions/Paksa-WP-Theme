<?php
/**
 * Paksa IT Solutions — Custom Nav Walker
 *
 * Adds accessible dropdown toggle buttons to top-level menu items
 * that have children, keeping the link and toggle as separate interactive elements.
 *
 * Keyboard behaviour (handled in assets/js/main.js):
 *   - Enter/Space on toggle button: open/close submenu
 *   - Escape: close open submenu, return focus to toggle
 *   - Tab out of last submenu item: close submenu
 *
 * CSS: assets/css/main.css — .pk-primary-menu .pk-has-dropdown
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Paksa_Nav_Walker
 * Extends Walker_Nav_Menu to inject accessible dropdown toggles.
 */
class Paksa_Nav_Walker extends Walker_Nav_Menu {

    private $current_parent_id = 0;

    /**
     * Start the element output.
     *
     * @param string   $output Passed by reference.
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item.
     * @param stdClass $args   Walker args.
     * @param int      $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes, true );

        if ( $has_children && $depth === 0 ) {
            $classes[] = 'pk-has-dropdown';
            $this->current_parent_id = $item->ID;
        }

        $class_names = implode( ' ', array_filter( array_map( 'trim', $classes ) ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id_attr = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id_attr = $id_attr ? ' id="' . esc_attr( $id_attr ) . '"' : '';

        $output .= $indent . '<li' . $id_attr . $class_names . ' role="none">';

        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';

        if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) ) {
            $atts['aria-current'] = 'page';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        if ( ! empty( $item->target ) && '_blank' === $item->target && false === strpos( $attributes, ' rel="' ) ) {
            $attributes .= ' rel="noopener noreferrer"';
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output  = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . esc_html( $title ) . ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';

    /**
     * Start the submenu output — add id and role for ARIA.
     *
     * @param string   $output Passed by reference.
     * @param int      $depth  Depth of menu item.
     * @param stdClass $args   Walker args.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $submenu_id = $this->current_parent_id ? ' id="pk-submenu-' . esc_attr( $this->current_parent_id ) . '"' : '';
        $output .= "\n$indent<ul class=\"pk-submenu\"$submenu_id role=\"menu\">\n";
    }
}

/**
 * Paksa_Footer_Nav_Walker
 * Renders footer menu items as plain <a> tags to match .footer-links a CSS.
 * No list markup — items_wrap is set to '%3$s' in wp_nav_menu() call.
 */
class Paksa_Footer_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        // No nested levels in footer nav
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        // No nested levels in footer nav
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $atts          = array();
        $atts['href']  = ! empty( $item->url ) ? $item->url : '';
        $atts['title'] = ! empty( $item->attr_title ) ? $item->attr_title : '';

        if ( ! empty( $item->target ) ) {
            $atts['target'] = $item->target;
            if ( '_blank' === $item->target ) {
                $atts['rel'] = 'noopener noreferrer';
            }
        }

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        if ( in_array( 'current-menu-item', $classes, true ) ) {
            $atts['aria-current'] = 'page';
        }

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title   = apply_filters( 'the_title', $item->title, $item->ID );
        $output .= '<a' . $attributes . '>' . esc_html( $title ) . '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        // No closing tag needed — plain <a> elements
    }
}
