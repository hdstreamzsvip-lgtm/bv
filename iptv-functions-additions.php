<?php
/**
 * IPTV File Layout - Functions.php Additions
 *
 * Add this code to your theme's functions.php file to enable the IPTV File Layout
 * with custom meta fields and template selection in WordPress admin.
 */

// Add IPTV File Layout template to post template dropdown
add_filter('template_include', 'singlo_iptv_template_include');
function singlo_iptv_template_include($template) {
    if (is_single()) {
        $post_id = get_the_ID();
        $use_iptv_template = get_post_meta($post_id, '_singlo_use_iptv_template', true);

        if ($use_iptv_template === 'yes') {
            $iptv_template = locate_template('single-iptv-file.php');
            if ($iptv_template) {
                return $iptv_template;
            }
        }
    }
    return $template;
}

// Add meta box for IPTV template selection
add_action('add_meta_boxes', 'singlo_iptv_template_meta_box');
function singlo_iptv_template_meta_box() {
    add_meta_box(
        'singlo_iptv_template_box',
        'Template Selection',
        'singlo_iptv_template_box_callback',
        'post',
        'side',
        'high'
    );
}

function singlo_iptv_template_box_callback($post) {
    wp_nonce_field('singlo_iptv_template_nonce', 'singlo_iptv_template_nonce');
    $use_iptv = get_post_meta($post->ID, '_singlo_use_iptv_template', true);
    ?>
    <p>
        <label>
            <input type="checkbox" name="singlo_use_iptv_template" value="yes" <?php checked($use_iptv, 'yes'); ?>>
            Use IPTV File Layout
        </label>
    </p>
    <p class="description">Check this to use the IPTV File Layout instead of the default post template.</p>
    <?php
}

// Add meta box for IPTV custom fields
add_action('add_meta_boxes', 'singlo_iptv_fields_meta_box');
function singlo_iptv_fields_meta_box() {
    add_meta_box(
        'singlo_iptv_fields_box',
        'IPTV File Information',
        'singlo_iptv_fields_box_callback',
        'post',
        'normal',
        'high'
    );
}

function singlo_iptv_fields_box_callback($post) {
    wp_nonce_field('singlo_iptv_fields_nonce', 'singlo_iptv_fields_nonce');

    $iptv_type = get_post_meta($post->ID, '_singlo_iptv_type', true);
    $iptv_format = get_post_meta($post->ID, '_singlo_iptv_format', true);
    $iptv_category = get_post_meta($post->ID, '_singlo_iptv_category', true);
    $iptv_size = get_post_meta($post->ID, '_singlo_iptv_size', true);
    $iptv_downloads = get_post_meta($post->ID, '_singlo_iptv_downloads', true);
    ?>
    <style>
        .iptv-field-row {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .iptv-field-row label {
            width: 150px;
            font-weight: 600;
        }
        .iptv-field-row input {
            flex: 1;
            max-width: 400px;
        }
    </style>

    <div class="iptv-field-row">
        <label for="singlo_iptv_type">Type:</label>
        <input type="text" id="singlo_iptv_type" name="singlo_iptv_type" value="<?php echo esc_attr($iptv_type); ?>" placeholder="e.g., XXX Adult, Sports, Movies">
    </div>

    <div class="iptv-field-row">
        <label for="singlo_iptv_format">Format:</label>
        <input type="text" id="singlo_iptv_format" name="singlo_iptv_format" value="<?php echo esc_attr($iptv_format); ?>" placeholder="e.g., M3U, M3U8, XSPF">
    </div>

    <div class="iptv-field-row">
        <label for="singlo_iptv_category">Category:</label>
        <input type="text" id="singlo_iptv_category" name="singlo_iptv_category" value="<?php echo esc_attr($iptv_category); ?>" placeholder="e.g., IPTV Codes, Free IPTV">
    </div>

    <div class="iptv-field-row">
        <label for="singlo_iptv_size">File Size:</label>
        <input type="text" id="singlo_iptv_size" name="singlo_iptv_size" value="<?php echo esc_attr($iptv_size); ?>" placeholder="e.g., 64 KB, 2 MB">
    </div>

    <div class="iptv-field-row">
        <label for="singlo_iptv_downloads">Downloads:</label>
        <input type="text" id="singlo_iptv_downloads" name="singlo_iptv_downloads" value="<?php echo esc_attr($iptv_downloads); ?>" placeholder="e.g., 1076433+">
    </div>

    <p class="description">
        <strong>Note:</strong> The Playlist Name uses the post title. Last Updated uses the post's modified date.
    </p>
    <?php
}

// Save IPTV meta fields
add_action('save_post', 'singlo_save_iptv_meta_fields');
function singlo_save_iptv_meta_fields($post_id) {
    // Check nonce for template selection
    if (isset($_POST['singlo_iptv_template_nonce']) && wp_verify_nonce($_POST['singlo_iptv_template_nonce'], 'singlo_iptv_template_nonce')) {
        $use_iptv = isset($_POST['singlo_use_iptv_template']) ? 'yes' : 'no';
        update_post_meta($post_id, '_singlo_use_iptv_template', $use_iptv);
    }

    // Check nonce for IPTV fields
    if (!isset($_POST['singlo_iptv_fields_nonce']) || !wp_verify_nonce($_POST['singlo_iptv_fields_nonce'], 'singlo_iptv_fields_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'singlo_iptv_type',
        'singlo_iptv_format',
        'singlo_iptv_category',
        'singlo_iptv_size',
        'singlo_iptv_downloads'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
