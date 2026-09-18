<?php
/**
 * Services Page — Technology Stack
 * Grouped tech badges by category — SEO keyword-rich
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow = __( 'Technology', 'paksa-it-solutions' );
$heading = __( 'Technologies We Work With', 'paksa-it-solutions' );
$desc    = __( 'We select the right technology for each requirement — not a fixed stack applied to every project. Our team works across a broad range of languages, frameworks and platforms.', 'paksa-it-solutions' );

$tech_groups = apply_filters( 'paksa_svc_tech_groups', array(
    array(
        'label' => __( 'Languages', 'paksa-it-solutions' ),
        'items' => array( 'Python', 'PHP', 'JavaScript', 'TypeScript', 'SQL', 'R', 'Bash' ),
    ),
    array(
        'label' => __( 'Frameworks & Libraries', 'paksa-it-solutions' ),
        'items' => array( 'Laravel', 'Django', 'FastAPI', 'React', 'Vue.js', 'Node.js', 'TensorFlow', 'PyTorch', 'scikit-learn' ),
    ),
    array(
        'label' => __( 'Databases', 'paksa-it-solutions' ),
        'items' => array( 'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'SQLite', 'MariaDB' ),
    ),
    array(
        'label' => __( 'Platforms & Tools', 'paksa-it-solutions' ),
        'items' => array( 'WordPress', 'WooCommerce', 'Docker', 'Linux', 'Git', 'REST APIs', 'GraphQL' ),
    ),
    array(
        'label' => __( 'Cloud & Infrastructure', 'paksa-it-solutions' ),
        'items' => array( 'AWS', 'DigitalOcean', 'Nginx', 'Apache', 'CI/CD Pipelines' ),
    ),
) );

if ( empty( $tech_groups ) ) { return; }
?>
<section class="section pk-svc-tech" aria-labelledby="pk-svc-tech-heading">
    <div class="container">

        <div class="pk-svc-tech-header pk-animate-on-scroll" data-anim="fade-up">
            <span class="pk-section-label"><?php echo esc_html( $eyebrow ); ?></span>
            <h2 id="pk-svc-tech-heading"><?php echo esc_html( $heading ); ?></h2>
            <p class="pk-svc-tech-intro"><?php echo esc_html( $desc ); ?></p>
        </div>

        <div class="pk-svc-tech-groups">
            <?php foreach ( $tech_groups as $index => $group ) : ?>
                <div class="pk-svc-tech-group pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 80 ); ?>">
                    <h3 class="pk-svc-tech-group-label"><?php echo esc_html( $group['label'] ); ?></h3>
                    <ul class="pk-svc-tech-tags" role="list">
                        <?php foreach ( $group['items'] as $tech ) : ?>
                            <li class="pk-svc-tech-tag"><?php echo esc_html( $tech ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
