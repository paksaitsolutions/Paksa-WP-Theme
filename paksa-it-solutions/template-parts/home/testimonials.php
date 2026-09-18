<?php
/**
 * Paksa IT Solutions — Homepage: Testimonials
 * Real testimonials from paksa.com.pk
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$testimonials = apply_filters( 'paksa_testimonials', array(
    array(
        'name'    => 'Shiekh Abid Hussain',
        'role'    => 'Chairman GPC',
        'rating'  => 4,
        'content' => 'Paksa IT Solutions delivered a reliable and well-structured solution that aligned perfectly with our business needs. Their understanding of data and automation made a real impact on our operations.',
    ),
    array(
        'name'    => 'Sagheer Ch.',
        'role'    => 'Director, Skylinx Textile',
        'rating'  => 5,
        'content' => 'The team demonstrated strong technical expertise in AI and data analytics. Communication was clear, timelines were respected, and the final outcome exceeded expectations.',
    ),
    array(
        'name'    => 'Dr. Majed Abdali',
        'role'    => 'Director, Riyalux Innovates',
        'rating'  => 4,
        'content' => 'Working with Paksa IT Solutions was a smooth experience. Their approach to automation and software development helped us improve efficiency and reduce manual work.',
    ),
    array(
        'name'    => 'Sartaj Yousaf',
        'role'    => 'CEO, Futurefield',
        'rating'  => 4,
        'content' => 'Professional, responsive, and technically sound. Paksa IT Solutions provided valuable insights and practical solutions that supported our digital transformation goals.',
    ),
) );

if ( empty( $testimonials ) ) return;
?>
<section class="pk-testimonials section section-alt" aria-labelledby="pk-testimonials-heading">
    <div class="container">

        <header class="section-header">
            <h2 id="pk-testimonials-heading"><?php esc_html_e( 'What People Think About Us', 'paksa-it-solutions' ); ?></h2>
            <p><?php esc_html_e( 'Real feedback from businesses we have helped transform with technology.', 'paksa-it-solutions' ); ?></p>
        </header>

        <div class="pk-testimonials-grid">
            <?php foreach ( $testimonials as $i => $t ) : ?>
                <article class="pk-testimonial-card pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 2 ) * 100 ); ?>">
                    <div class="pk-testimonial-stars" aria-label="<?php echo esc_attr( $t['rating'] . ' out of 5 stars' ); ?>">
                        <?php for ( $s = 1; $s <= 5; $s++ ) : ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $s <= $t['rating'] ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                        <?php endfor; ?>
                    </div>
                    <blockquote class="pk-testimonial-content">
                        <p><?php echo esc_html( $t['content'] ); ?></p>
                    </blockquote>
                    <footer class="pk-testimonial-meta">
                        <div class="pk-testimonial-avatar" aria-hidden="true">
                            <?php echo esc_html( mb_substr( $t['name'], 0, 1 ) ); ?>
                        </div>
                        <div>
                            <div class="pk-testimonial-name"><?php echo esc_html( $t['name'] ); ?></div>
                            <div class="pk-testimonial-role"><?php echo esc_html( $t['role'] ); ?></div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
