<?php
/**
 * Template part for displaying apps in archive grids
 */

$post_id = get_the_ID();
$rating = get_post_meta($post_id, '_singlo_app_rating_value', true) ?: '4.5';
$size   = get_post_meta($post_id, '_singlo_app_size', true) ?: 'N/A';
$version = get_post_meta($post_id, '_singlo_app_version', true);
?>

<a href="<?php the_permalink(); ?>" class="aap_similar-app-item" id="post-<?php the_ID(); ?>">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('thumbnail', array('alt' => get_the_title(), 'title' => get_the_title())); ?>
    <?php else : ?>
        <img width="64" height="64" src="<?php echo get_template_directory_uri(); ?>/assets/images/default-icon.png" alt="<?php the_title(); ?>">
    <?php endif; ?>

    <div class="aap_app-details">
        <span class="aap_app-name"><?php the_title(); ?></span>
        <div class="aap_app-size"><?php echo esc_html($size); ?><?php if($version) echo ' • v' . esc_html($version); ?></div>
        <div class="aap_app-rating"><?php echo esc_html($rating); ?> ★</div>
    </div>
</a>
