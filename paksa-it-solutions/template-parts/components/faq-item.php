<?php
/**
 * Paksa IT Solutions — Component: FAQ Item
 *
 * Args:
 *   $args['question'] string  The question text
 *   $args['answer']   string  The answer text
 *   $args['index']    int     Item index for unique IDs
 *   $args['open']     bool    Whether open by default (first item)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$args     = isset( $args ) ? $args : array();
$question = isset( $args['question'] ) ? $args['question'] : '';
$answer   = isset( $args['answer'] ) ? $args['answer'] : '';
$index    = isset( $args['index'] ) ? (int) $args['index'] : 0;
$open     = isset( $args['open'] ) && $args['open'] ? true : false;

if ( empty( $question ) || empty( $answer ) ) {
    return;
}

$item_id    = 'pk-faq-' . $index;
$panel_id   = 'pk-faq-panel-' . $index;
?>
<div class="pk-faq-item<?php echo $open ? ' is-open' : ''; ?>">
    <button
        class="pk-faq-trigger"
        id="<?php echo esc_attr( $item_id ); ?>"
        aria-expanded="<?php echo $open ? 'true' : 'false'; ?>"
        aria-controls="<?php echo esc_attr( $panel_id ); ?>"
        type="button"
    >
        <span class="pk-faq-question"><?php echo esc_html( $question ); ?></span>
        <span class="pk-faq-icon" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="10" y1="4" x2="10" y2="16" class="pk-faq-icon-v"></line>
                <line x1="4" y1="10" x2="16" y2="10"></line>
            </svg>
        </span>
    </button>
    <div
        class="pk-faq-panel"
        id="<?php echo esc_attr( $panel_id ); ?>"
        role="region"
        aria-labelledby="<?php echo esc_attr( $item_id ); ?>"
        <?php echo $open ? '' : 'hidden'; ?>
    >
        <div class="pk-faq-answer">
            <p><?php echo esc_html( $answer ); ?></p>
        </div>
    </div>
</div>
