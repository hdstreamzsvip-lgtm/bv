<?php
/**
 * Singlo Rating System
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle AJAX rating request
 */
function singlo_handle_rating() {
    check_ajax_referer( 'singlo-rating-nonce', 'nonce' );

    $post_id = intval( $_POST['post_id'] );
    $rating  = intval( $_POST['rating'] );

    if ( $post_id <= 0 || $rating < 1 || $rating > 5 ) {
        wp_send_json_error( 'Invalid data' );
    }

    $current_avg = floatval( get_post_meta( $post_id, '_singlo_app_rating_value', true ) );
    $current_count = intval( get_post_meta( $post_id, '_singlo_app_rating_count', true ) );

    if ( empty( $current_avg ) ) $current_avg = 0;
    if ( empty( $current_count ) ) $current_count = 0;

    $new_count = $current_count + 1;
    $new_avg = ( ( $current_avg * $current_count ) + $rating ) / $new_count;

    update_post_meta( $post_id, '_singlo_app_rating_value', round( $new_avg, 2 ) );
    update_post_meta( $post_id, '_singlo_app_rating_count', $new_count );

    wp_send_json_success( [
        'new_avg' => round( $new_avg, 2 ),
        'new_count' => $new_count,
        'message' => 'Thank you for your rating!'
    ] );
}
add_action( 'wp_ajax_singlo_rate_post', 'singlo_handle_rating' );
add_action( 'wp_ajax_nopriv_singlo_rate_post', 'singlo_handle_rating' );

/**
 * Output Star Rating HTML with Hover Effect
 */
function singlo_display_star_rating( $post_id ) {
    $rating_value = get_post_meta( $post_id, '_singlo_app_rating_value', true );
    $rating_count = get_post_meta( $post_id, '_singlo_app_rating_count', true );

    if ( empty( $rating_value ) ) $rating_value = 4.5;
    if ( empty( $rating_count ) ) $rating_count = 100;

    ?>
    <div class="wVqUob singlo-star-rating" data-post-id="<?php echo $post_id; ?>" data-nonce="<?php echo wp_create_nonce('singlo-rating-nonce'); ?>">
        <div class="ClM7O">
            <div itemprop="starRating" itemscope itemtype="https://schema.org/AggregateRating">
                <meta itemprop="ratingValue" content="<?php echo $rating_value; ?>">
                <meta itemprop="bestRating" content="5">
                <meta itemprop="ratingCount" content="<?php echo $rating_count; ?>">
                <div class="TT9eCd" aria-label="Rated <?php echo $rating_value; ?> stars out of five stars">
                    <?php echo $rating_value; ?> <i class="google-material-icons notranslate ERwvGb" aria-hidden="true" style="font-style: normal; margin-left: 2px;">★</i>
                </div>
            </div>
        </div>
        <div class="g1rdde">
            <?php echo $rating_count; ?> <?php _e('reviews', 'singlo'); ?>
        </div>
        <div class="starblocks" aria-label="User ratings">
            <div class="stars-outer" style="font-size: 20px" data-rating="<?php echo $rating_value; ?>">
                <div class="stars-inner" style="width: <?php echo ( $rating_value / 5 ) * 100; ?>%;"></div>
                <div class="stars-hover"></div>
                <div class="stars-interact">
                    <span data-val="1"></span>
                    <span data-val="2"></span>
                    <span data-val="3"></span>
                    <span data-val="4"></span>
                    <span data-val="5"></span>
                </div>
            </div>
        </div>
    </div>
    <?php
}
