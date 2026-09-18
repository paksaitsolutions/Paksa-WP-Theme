<?php
/**
 * Generate screenshot.png for Paksa IT Solutions theme.
 * Run once: php generate-screenshot.php
 * Requires GD extension.
 */

$w = 1200;
$h = 900;
$img = imagecreatetruecolor( $w, $h );

// Colors
$bg_dark   = imagecolorallocate( $img, 18,  22,  25  ); // #121619
$bg_card   = imagecolorallocate( $img, 26,  32,  38  ); // #1a2026
$primary   = imagecolorallocate( $img, 97,  146, 248 ); // #6192F8
$white     = imagecolorallocate( $img, 255, 255, 255 );
$white_60  = imagecolorallocate( $img, 153, 170, 200 );
$white_30  = imagecolorallocate( $img, 80,  95,  120 );
$purple    = imagecolorallocate( $img, 139, 92,  246 );
$sky       = imagecolorallocate( $img, 14,  165, 233 );
$green     = imagecolorallocate( $img, 16,  185, 129 );
$amber     = imagecolorallocate( $img, 245, 158, 11  );

// Background
imagefilledrectangle( $img, 0, 0, $w, $h, $bg_dark );

// Dot grid pattern (subtle)
for ( $x = 0; $x < $w; $x += 28 ) {
    for ( $y = 0; $y < $h; $y += 28 ) {
        imagesetpixel( $img, $x, $y, imagecolorallocatealpha( $img, 97, 146, 248, 110 ) );
    }
}

// Top nav bar
imagefilledrectangle( $img, 0, 0, $w, 64, imagecolorallocate( $img, 15, 18, 22 ) );
imageline( $img, 0, 64, $w, 64, imagecolorallocate( $img, 30, 38, 48 ) );

// Logo area (left nav)
imagefilledrectangle( $img, 32, 18, 100, 46, $primary );
imagestring( $img, 5, 38, 22, 'PAKSA', $white );

// Nav items
$nav_items = array( 'Home', 'Services', 'Solutions', 'About', 'Contact' );
$nx = 200;
foreach ( $nav_items as $item ) {
    imagestring( $img, 3, $nx, 24, $item, $white_60 );
    $nx += strlen( $item ) * 8 + 32;
}

// CTA button (nav right)
imagefilledrectangle( $img, 1060, 18, 1168, 46, $primary );
imagestring( $img, 3, 1072, 24, 'Get in Touch', $white );

// Hero section
$hero_y = 100;

// Eyebrow pill
imagefilledrectangle( $img, 60, $hero_y + 20, 340, $hero_y + 48, imagecolorallocate( $img, 25, 40, 70 ) );
imagerectangle( $img, 60, $hero_y + 20, 340, $hero_y + 48, imagecolorallocate( $img, 60, 100, 180 ) );
imagestring( $img, 2, 72, $hero_y + 28, 'AI / ML  |  Automation  |  Data Science', $primary );

// Main headline
$headline1 = 'Paksa IT Solutions';
$headline2 = 'Enterprise Software & AI';
imagettftext_safe( $img, 48, 0, 60, $hero_y + 100, $white, $headline1 );
imagettftext_safe( $img, 32, 0, 60, $hero_y + 150, $primary, $headline2 );

// Sub headline
imagestring( $img, 3, 60, $hero_y + 175, 'AI & ML  |  Automation  |  Data Science  |  Custom Software', $white_60 );
imagestring( $img, 3, 60, $hero_y + 198, 'Built in Pakistan. Used across the region.', $white_30 );

// CTA buttons
imagefilledrectangle( $img, 60, $hero_y + 230, 240, $hero_y + 268, $primary );
imagestring( $img, 4, 80, $hero_y + 242, 'Get Started', $white );
imagerectangle( $img, 260, $hero_y + 230, 400, $hero_y + 268, $white_30 );
imagestring( $img, 4, 278, $hero_y + 242, 'Our Services', $white_60 );

// Stats row
$stats = array(
    array( '150+', 'Projects' ),
    array( '8+',   'Years' ),
    array( '50+',  'ML Models' ),
    array( '100%', 'In-house' ),
);
$sx = 60;
foreach ( $stats as $stat ) {
    imagestring( $img, 5, $sx, $hero_y + 310, $stat[0], $white );
    imagestring( $img, 2, $sx, $hero_y + 334, $stat[1], $white_60 );
    $sx += 160;
}

// Divider
imageline( $img, 0, 430, $w, 430, imagecolorallocate( $img, 30, 38, 48 ) );

// Service cards row
$card_colors = array( $primary, $purple, $sky, $amber );
$card_labels = array( 'AI & ML', 'Automation', 'Data Science', 'Software Dev' );
$card_descs  = array( 'Predictive models', 'Workflow automation', 'BI & analytics', 'Custom platforms' );
$cx = 40;
for ( $i = 0; $i < 4; $i++ ) {
    $cy = 450;
    $cw = 260;
    $ch = 160;
    // Card bg
    imagefilledrectangle( $img, $cx, $cy, $cx + $cw, $cy + $ch, $bg_card );
    // Top accent border
    imagefilledrectangle( $img, $cx, $cy, $cx + $cw, $cy + 3, $card_colors[ $i ] );
    // Icon circle
    imagefilledellipse( $img, $cx + 28, $cy + 30, 32, 32, imagecolorallocate( $img, 30, 40, 60 ) );
    // Label
    imagestring( $img, 4, $cx + 14, $cy + 50, $card_labels[ $i ], $white );
    // Desc
    imagestring( $img, 2, $cx + 14, $cy + 74, $card_descs[ $i ], $white_60 );
    // Learn more
    imagestring( $img, 2, $cx + 14, $cy + 130, 'Learn more ->', $card_colors[ $i ] );
    $cx += $cw + 20;
}

// Bottom section — dark with product cards
imagefilledrectangle( $img, 0, 640, $w, $h, imagecolorallocate( $img, 15, 23, 42 ) );

// Section label
imagestring( $img, 2, 60, 660, 'OUR PRODUCTS', $primary );
imagestring( $img, 4, 60, 682, 'Industry-Specific Software Built in Pakistan', $white );

// Product pills
$products = array( 'Paksa ERP', 'EventLogic', 'TourLedger', 'PoultryPro', 'Salon Mgmt' );
$prod_colors = array( $primary, $purple, $sky, $amber, $green );
$px = 60;
foreach ( $products as $pi => $prod ) {
    $pw = strlen( $prod ) * 9 + 28;
    imagefilledrectangle( $img, $px, 730, $px + $pw, 762, imagecolorallocate( $img, 20, 30, 50 ) );
    imagerectangle( $img, $px, 730, $px + $pw, 762, $prod_colors[ $pi ] );
    imagestring( $img, 3, $px + 10, 739, $prod, $white );
    $px += $pw + 16;
}

// Footer strip
imagefilledrectangle( $img, 0, 840, $w, $h, imagecolorallocate( $img, 10, 14, 18 ) );
imagestring( $img, 2, 60,  858, 'paksa.com.pk', $white_60 );
imagestring( $img, 2, 60,  876, 'Lahore, Pakistan  |  info@paksa.com.pk  |  +92 305 777 2572', $white_30 );
imagestring( $img, 2, 900, 858, 'Paksa IT Solutions — Enterprise WordPress Theme v1.4.0', $white_30 );

// Glow effect top-right
for ( $r = 200; $r > 0; $r -= 10 ) {
    $alpha = (int) ( 120 - $r * 0.5 );
    if ( $alpha < 0 ) $alpha = 0;
    imagefilledellipse( $img, 1100, 200, $r * 2, $r * 2,
        imagecolorallocatealpha( $img, 97, 146, 248, $alpha ) );
}

// Save
imagepng( $img, __DIR__ . '/screenshot.png' );
imagedestroy( $img );
echo "screenshot.png generated.\n";

function imagettftext_safe( $img, $size, $angle, $x, $y, $color, $text ) {
    // Fallback to imagestring if no TTF font available
    $font_size = max( 1, min( 5, (int)( $size / 10 ) ) );
    imagestring( $img, $font_size, $x, $y - $size, $text, $color );
}
