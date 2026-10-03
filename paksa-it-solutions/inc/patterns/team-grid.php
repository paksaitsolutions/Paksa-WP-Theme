<?php
/**
 * Paksa — Block Pattern: Team Grid
 *
 * A responsive grid of team member cards using existing card styles.
 * Replace placeholders with real team member profiles.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/team-grid',
    array(
        'title'      => __( 'Team — People Grid', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-team-v2' ),
        'keywords'   => array( 'team', 'people', 'members', 'about' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => paksa_visual_section(
            '',
            'The people behind the work',
            'We are a team of designers, engineers, and strategists who care about making technology useful.',
            'Replace each placeholder with a real team member profile.',
            paksa_visual_columns( array(
                paksa_builder_team_card( 'Team member', 'Role or specialist area' ),
                paksa_builder_team_card( 'Team member', 'Role or specialist area' ),
                paksa_builder_team_card( 'Team member', 'Role or specialist area' ),
                paksa_builder_team_card( 'Team member', 'Role or specialist area' ),
            ), 'pk-builder-team-grid' )
        )
    )
);
