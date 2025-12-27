<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/* error_reporting(E_ALL);
ini_set('display_errors', 'on'); */
function singlo_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus( array(
		'header' => esc_html__( 'Header Menu', 'singlo' ),
		'sub_header' => esc_html__( 'Sub Header Menu', 'singlo' ),
		'mobile_header' => esc_html__( 'Mobile Header Menu', 'singlo' ),
		'footer'  => esc_html__( 'Footer Menu', 'singlo' ),
	) );
}
add_action( 'after_setup_theme', 'singlo_setup' );

function singlo_scripts() {
	wp_enqueue_style( 'singlo-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'singlo-extras-min', get_template_directory_uri() . '/assets/css/extras.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-main-min', get_template_directory_uri() . '/assets/css/main.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-kedance', get_template_directory_uri() . '/assets/css/kedance.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-style-block', get_template_directory_uri() . '/assets/css/style-block.css', array(), '1.0.0' );
	
	wp_enqueue_style( 'singlo-page-title', get_template_directory_uri() . '/assets/css/page-title.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-sidebar', get_template_directory_uri() . '/assets/css/sidebar.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-share-box', get_template_directory_uri() . '/assets/css/share-box.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-comments', get_template_directory_uri() . '/assets/css/comments.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-archive', get_template_directory_uri() . '/assets/css/archive.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-search', get_template_directory_uri() . '/assets/css/search.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-captcha', get_template_directory_uri() . '/assets/css/captcha.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-search-input', get_template_directory_uri() . '/assets/css/search-input.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-live-search', get_template_directory_uri() . '/assets/css/live-search.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-divider', get_template_directory_uri() . '/assets/css/divider.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-similar-apps', get_template_directory_uri() . '/assets/css/aap-similar-apps.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-weekly-views', get_template_directory_uri() . '/assets/css/weekly-views.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-recent-content', get_template_directory_uri() . '/assets/css/aap-recent-content.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-rating', get_template_directory_uri() . '/assets/css/rating.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-download', get_template_directory_uri() . '/assets/css/download.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-read-more', get_template_directory_uri() . '/assets/css/read-more.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-carousel', get_template_directory_uri() . '/assets/css/carousel.css', array(), '1.0.0' );
	wp_enqueue_style( 'singlo-accordion', get_template_directory_uri() . '/assets/css/accordion.css', array(), '1.0.0' );

	wp_enqueue_style( 'fancybox-5', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css', array(), '5.0.0' );
	wp_enqueue_script( 'fancybox-5', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', array(), '5.0.0', true );

	wp_enqueue_script( 'singlo-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery', 'fancybox-5' ), '1.0.0', true );
	wp_enqueue_script( 'singlo-rating-hover', get_template_directory_uri() . '/assets/js/rating-hover.js', array( 'jquery' ), '1.0.2', true );
    wp_add_inline_script( 'singlo-main', 'Fancybox.bind("[data-fancybox]", { Thumbs: false });' );
    wp_localize_script( 'singlo-main', 'singlo_ajax_obj', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'singlo_scripts', 99 );

require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/rating-system.php';
require get_template_directory() . '/inc/theme-settings.php';

class Singlo_Desktop_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Remove 'menu-item-has-children' to prevent any submenu hover/display logic
        $classes = array_diff($classes, array('menu-item-has-children'));

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts['class']  = 'ct-menu-link';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

class Singlo_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $has_children = in_array( 'menu-item-has-children', $classes );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts['class']  = 'ct-menu-link';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output = $args->before;

        if ( $has_children ) {
            $item_output .= '<span class="ct-sub-menu-parent">';
        }

        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';

        if ( $has_children ) {
            $item_output .= '<button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false">';
            $item_output .= '<svg class="ct-icon toggle-icon-2" width="15" height="15" viewBox="0 0 15 15" aria-hidden="true"><path d="M14.1,6.6H8.4V0.9C8.4,0.4,8,0,7.5,0S6.6,0.4,6.6,0.9v5.7H0.9C0.4,6.6,0,7,0,7.5s0.4,0.9,0.9,0.9h5.7v5.7C6.6,14.6,7,15,7.5,15s0.9-0.4,0.9-0.9V8.4h5.7C14.6,8.4,15,8,15,7.5S14.6,6.6,14.1,6.6z"></path></svg>';
            $item_output .= '</button>';
            $item_output .= '</span>';
        }

        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 * Comment Callback for Singlo
 */
function singlo_comment_callback( $comment, $args, $depth ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'ct-has-avatar' ); ?>>
        <article class="ct-comment-inner" id="ct-comment-inner-<?php comment_ID(); ?>" itemprop="comment" itemscope="" itemtype="https://schema.org/Comment">
            <footer class="ct-comment-meta">
                <figure class="ct-media-container">
                    <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'entered lazyloaded' ) ); ?>
                </figure>
                <h4 class="ct-comment-author" itemprop="author" itemscope="" itemtype="https://schema.org/Person">
                    <cite itemprop="name"><?php echo get_comment_author_link(); ?></cite>
                </h4>

                <div class="ct-comment-meta-data">
                    <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
                            <?php printf( _x( '%1$s / %2$s', '1: date, 2: time', 'singlo' ), get_comment_date(), get_comment_time() ); ?>
                        </time>
                    </a>

                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'add_below' => 'ct-comment-inner',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => __( 'Reply', 'singlo' )
                    ) ) );
                    ?>
                </div>
            </footer>

            <div class="ct-comment-content entry-content is-layout-flow" itemprop="text">
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'singlo' ); ?></em><br/>
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
        </article>
    <?php
}

/**
 * Math Captcha for Comments
 */
function singlo_get_math_captcha() {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    return array(
        'question' => "$num1 + $num2 = ?",
        'answer'   => $num1 + $num2
    );
}

function singlo_add_math_captcha_field() {
    $captcha = singlo_get_math_captcha();
    ?>
    <div id="page0x-captcha-container">
        <div class="comment-form-captcha">
            <label for="ga_math_captcha_answer">
                <strong>Security Check:</strong> Please solve this simple math problem:
            </label>
            <div class="captcha-question-wrapper">
                <span class="captcha-question"><?php echo $captcha['question']; ?></span>
                <input type="number" name="ga_math_captcha_answer" id="ga_math_captcha_answer" class="captcha-input" required="" autocomplete="off" placeholder="Your answer">
                <input type="hidden" name="ga_math_captcha_correct_answer" value="<?php echo $captcha['answer']; ?>">
            </div>
        </div>
    </div>
    <div class="captcha-error" style="display:none;color:#d63638;background:#fcf0f1;border:1px solid #f0b7b8;padding:8px;border-radius:4px;margin-top:5px;">
        ❌ Incorrect answer. Please try again.
    </div>
    <?php
}
add_action( 'comment_form_after_fields', 'singlo_add_math_captcha_field' );
add_action( 'comment_form_logged_in_after', 'singlo_add_math_captcha_field' );

function singlo_verify_math_captcha( $commentdata ) {
    if ( ! is_user_logged_in() || current_user_can( 'moderate_comments' ) === false ) {
        if ( isset( $_POST['ga_math_captcha_answer'] ) && isset( $_POST['ga_math_captcha_correct_answer'] ) ) {
            if ( intval( $_POST['ga_math_captcha_answer'] ) !== intval( $_POST['ga_math_captcha_correct_answer'] ) ) {
                wp_die( __( 'Error: Please solve the math problem correctly to post a comment.', 'singlo' ) );
            }
        } else {
            wp_die( __( 'Error: Please solve the math problem to post a comment.', 'singlo' ) );
        }
    }
    return $commentdata;
}

/**
 * Post Views Counter
 * Tracks post view counts.
 */
function apkt_set_post_views($post_id)
{
    $meta_key = 'wpb_post_views_count';
    $count    = (int) get_post_meta($post_id, $meta_key, true);

    if ($count < 1) {
        delete_post_meta($post_id, $meta_key);
        add_post_meta($post_id, $meta_key, 1);
    } else {
        update_post_meta($post_id, $meta_key, $count + 1);
    }
}

// Hook into wp_head to track post views
function apkt_track_post_views()
{
    if (!is_single()) {
        return;
    }

    global $post;
    if ($post instanceof WP_Post) {
        apkt_set_post_views($post->ID);
    }
}
add_action('wp_head', 'apkt_track_post_views');

add_action('init', function () {
    add_rewrite_endpoint('download', EP_PERMALINK);
});

add_action('template_redirect', function () {
    global $wp_query;

    if (!isset($wp_query->query_vars['download'])) {
        return;
    }

    $download_var = $wp_query->query_vars['download'];
    $template     = '';

    // Check if it's /download/{id}
    if (is_numeric($download_var)) {
        $GLOBALS['custom_download_id'] = (int) $download_var;
        $template = locate_template('template-parts/download.php');
    } else {
        $template = locate_template('template-parts/download.php');
    }

    if ($template) {
        include $template;
        exit;
    }
});

/**
 * AJAX Live Search with Thumbnails
 */
add_action( 'wp_ajax_singlo_live_search', 'singlo_live_search_handler' );
add_action( 'wp_ajax_nopriv_singlo_live_search', 'singlo_live_search_handler' );
function singlo_live_search_handler() {
    check_ajax_referer( 'ct-live-results', 'nonce' );

    $query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

    if ( empty( $query ) || strlen( $query ) < 2 ) {
        wp_send_json_success( array( 'results' => array() ) );
        return;
    }

    $posts = get_posts( array(
        's'              => $query,
        'posts_per_page' => 8,
        'post_type'      => 'post',
        'post_status'    => 'publish',
    ) );

    $results = array();
    foreach ( $posts as $post ) {
        $thumbnail_url = get_the_post_thumbnail_url( $post->ID, array( 50, 50 ) );
        $version = get_post_meta( $post->ID, '_singlo_app_version', true );
        $size = get_post_meta( $post->ID, '_singlo_app_size', true );

        $results[] = array(
            'id'        => $post->ID,
            'title'     => get_the_title( $post->ID ),
            'url'       => get_permalink( $post->ID ),
            'thumbnail' => $thumbnail_url ? $thumbnail_url : '',
            'version'   => $version,
            'size'      => $size,
        );
    }

    wp_send_json_success( array( 'results' => $results ) );
}

/**
 * Increment Download Count via AJAX
 */
add_action( 'wp_ajax_singlo_increment_download_count', 'singlo_increment_download_count' );
add_action( 'wp_ajax_nopriv_singlo_increment_download_count', 'singlo_increment_download_count' );
function singlo_increment_download_count() {
    $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
    if ( $post_id ) {
        $count = (int) get_post_meta( $post_id, '_singlo_download_counts', true );
        update_post_meta( $post_id, '_singlo_download_counts', $count + 1 );
        wp_send_json_success( array( 'new_count' => $count + 1 ) );
    }
    wp_send_json_error();
}

/**
 * Handle Homepage Redirect
 */
add_action( 'template_redirect', function() {
    if ( is_front_page() || is_home() ) {
        $redirect_id = get_theme_mod( 'singlo_home_redirect_id', 0 );
        if ( $redirect_id && get_post_status( $redirect_id ) === 'publish' ) {
            wp_redirect( get_permalink( $redirect_id ), 301 );
            exit;
        }
    }
}, 1 );

/**
 * Use custom template for 'apps' category and its subcategories
 */
function singlo_subcategory_template( $template ) {
    if ( is_category() ) {
        $cat = get_queried_object();
        $apps_cat = get_category_by_slug('apps');
        if ( $apps_cat ) {
            if ( $cat->term_id == $apps_cat->term_id || cat_is_ancestor_of( $apps_cat->term_id, $cat->term_id ) ) {
                $custom_template = locate_template( 'category-apps.php' );
                if ( $custom_template ) {
                    return $custom_template;
                }
            }
        }
    }
    return $template;
}
add_filter( 'template_include', 'singlo_subcategory_template' );
/* Remove category base from URLs */
add_filter('category_link', function ($link) {
    return str_replace('/category/', '/', $link);
});

/* Add rewrite rules so WP understands clean category URLs */
add_action('init', function () {
    $categories = get_categories(['hide_empty' => false]);

    foreach ($categories as $cat) {
        add_rewrite_rule(
            '^' . $cat->slug . '/?$',
            'index.php?category_name=' . $cat->slug,
            'top'
        );
    }
});

/* Redirect old category URLs to new clean URLs (301) */
add_action('template_redirect', function () {
    if (is_category() && strpos($_SERVER['REQUEST_URI'], '/category/') !== false) {
        wp_redirect(
            home_url(str_replace('/category/', '/', $_SERVER['REQUEST_URI'])),
            301
        );
        exit;
    }
});
// Disable caching for debugging
function disable_caching_for_debug() {
    if (!defined('DONOTCACHEPAGE')) {
        define('DONOTCACHEPAGE', true);
    }
    if (!defined('DONOTCACHEDB')) {
        define('DONOTCACHEDB', true);
    }
    if (!defined('DONOTCACHCEOBJECT')) {
        define('DONOTCACHCEOBJECT', true);
    }
}
add_action('init', 'disable_caching_for_debug');
