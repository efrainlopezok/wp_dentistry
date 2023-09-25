<?php
/**
 * Functions
 */

/******************************************************************************
 * Included Functions
 ******************************************************************************/


// override nextgen gallery templates
add_filter(
    'ngg_' . NGG_BASIC_THUMBNAILS . '_template_dirs',
    function($dirs) {
//        var_dump($dirs);
//        var_dump(get_theme_file_path() . '/ngg/' . NGG_BASIC_THUMBNAILS . '/templates');
        $dirs['custom'] = get_theme_file_path() . '/ngg/' . NGG_BASIC_THUMBNAILS . '/templates';
        return $dirs;
    }
);

// Helpers function
require_once get_stylesheet_directory() . '/inc/helpers.php';
// Install Recommended plugins
require_once get_stylesheet_directory() . '/inc/recommended-plugins.php';
// Walker modification
require_once get_stylesheet_directory() . '/inc/class-foundation-navigation.php';
// Home slider function
include_once get_stylesheet_directory() . '/inc/home-slider.php';
// Dynamic admin
include_once get_stylesheet_directory() . '/inc/class-dynamic-admin.php';
// SVG Support
include_once get_stylesheet_directory() . '/inc/svg-support.php';
// Lazy Load
include_once get_stylesheet_directory() . '/inc/class-lazyload.php';
// Extend WP Search with Custom fields
include_once get_stylesheet_directory() . '/inc/custom-fields-search.php';
// Include all additional shortcodes
//include_once get_stylesheet_directory() . '/inc/shortcodes.php';
// Constants
define('IMAGE_PLACEHOLDER', get_stylesheet_directory_uri() . '/images/placeholder.jpg');


/******************************************************************************
 * Global Functions
 ******************************************************************************/

/**
 * WP 5.2 wp_body_open backward compatibility
 */
if (!function_exists('wp_body_open')) {
    function wp_body_open()
    {
        do_action('wp_body_open');
    }
}

// By adding theme support, we declare that this theme does not use a
// hard-coded <title> tag in the document head, and expect WordPress to
// provide it for us.
add_theme_support('title-tag');

//  Add widget support shortcodes
add_filter('widget_text', 'do_shortcode');

// Support for Featured Images
add_theme_support('post-thumbnails');

// Custom Background
add_theme_support('custom-background', array('default-color' => 'fff'));

// Custom Header
add_theme_support('custom-header', array(
    'default-image' => get_template_directory_uri() . '/images/custom-logo.png',
    'height' => '200',
    'flex-height' => true,
    'uploads' => true,
    'header-text' => false
));

// Custom Logo
add_theme_support('custom-logo', array(
    'height' => '150',
    'flex-height' => true,
    'flex-width' => true,
));

function show_custom_logo($size = 'medium')
{
    if ($custom_logo_id = get_theme_mod('custom_logo')) {
        $attachment_array = wp_get_attachment_image_src($custom_logo_id, $size);
        $logo_url = $attachment_array[0];
    } else {
        $logo_url = get_stylesheet_directory_uri() . '/images/custom-logo.png';
    }
    $logo_image = '<img src="' . $logo_url . '" class="custom-logo" itemprop="siteLogo" alt="' . get_bloginfo('name') . '">';
    $html = sprintf('<a href="%1$s" class="custom-logo-link" rel="home" title="%2$s" itemscope>%3$s</a>', esc_url(home_url('/')), get_bloginfo('name'), $logo_image);
    echo apply_filters('get_custom_logo', $html);
}

// Add HTML5 elements
add_theme_support('html5', array(
    'comment-list',
    'search-form',
    'comment-form',
    'gallery',
    'caption'
));

// Add RSS Links generation
add_theme_support('automatic-feed-links');
// Hide comments feed link
add_filter('feed_links_show_comments_feed', '__return_false');

// Add excerpt to pages
add_post_type_support('page', 'excerpt');

// Register Navigation Menu
register_nav_menus(array(
    'header-menu' => 'Header Menu',
    'footer-menu' => 'Footer Menu'
));

// Create pagination
function foundation_pagination($query = '')
{
    if (empty($query)) {
        global $wp_query;
        $query = $wp_query;
    }

    $big = 999999999;

    $links = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'prev_next' => true,
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
        'current' => max(1, get_query_var('paged')),
        'total' => $query->max_num_pages,
        'type' => 'list'
    ));

    $pagination = str_replace('page-numbers', 'pagination', $links);

    echo $pagination;
}

// Register Sidebars
function foundation_widgets_init()
{
    /* Sidebar Right */
    register_sidebar(array(
        'id' => 'foundation_sidebar_right',
        'name' => __('Sidebar Right'),
        'description' => __('This sidebar is located on the right-hand side of each page.'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="widget__title">',
        'after_title' => '</h5>',
    ));

}

add_action('widgets_init', 'foundation_widgets_init');

// Remove #more anchor from posts
function remove_more_jump_link($link)
{
    $offset = strpos($link, '#more-');
    if ($offset) {
        $end = strpos($link, '"', $offset);
    }
    if ($end) {
        $link = substr_replace($link, '', $offset, $end - $offset);
    }

    return $link;
}

add_filter('the_content_more_link', 'remove_more_jump_link');

// Remove more tag <span> anchor
function remove_more_anchor($content)
{
    return str_replace('<p><span id="more-' . get_the_ID() . '"></span></p>', '', $content);
}

add_filter('the_content', 'remove_more_anchor');


/******************************************************************************************************************************
 * Enqueue Scripts and Styles for Front-End
 *******************************************************************************************************************************/

function foundation_scripts_and_styles()
{
    if (!is_admin()) {

        // Disable gutenberg built-in styles
        wp_dequeue_style('wp-block-library');

        // Load Stylesheets
        //core
        wp_enqueue_style('foundation', get_template_directory_uri() . '/css/foundation.css', null, '6.5.3');

        //system
        wp_enqueue_style('custom', get_template_directory_uri() . '/css/custom.css', null, null);/*2rd priority*/
        wp_enqueue_style('style', get_template_directory_uri() . '/style.css', null, null);/*1st priority*/

        // Load JavaScripts
        //core

        wp_enqueue_script('jquery');
        wp_enqueue_script('foundation.min', get_template_directory_uri() . '/js/foundation.min.js', ['jquery'], '6.5.3', true);
        wp_add_inline_script('foundation.min', 'jQuery(document).foundation();');

        //plugins
        wp_enqueue_script('slick', get_template_directory_uri() . '/js/plugins/slick.min.js', ['jquery'], '1.8.1', true);
        wp_enqueue_script('lazyload', get_template_directory_uri() . '/js/plugins/lazyload.min.js', ['jquery'], '11.0.6', true);
        wp_enqueue_script('matchHeight', get_template_directory_uri() . '/js/plugins/jquery.matchHeight-min.js', ['jquery'], '0.7.2', true);
//		wp_enqueue_script( 'fancybox.v2', get_template_directory_uri() . '/js/plugins/jquery.fancybox.v2.js', null, '2.1.5', true );
        wp_enqueue_script('fancybox.v3', get_template_directory_uri() . '/js/plugins/jquery.fancybox.v3.js', ['jquery'], '3.5.2', true);
//		wp_enqueue_script( 'jarallax', get_template_directory_uri() . '/js/plugins/jarallax.min.js', null, '1.10.7', true );
//		wp_enqueue_script( 'google.maps.api', 'https://maps.googleapis.com/maps/api/js?key=' . (get_theme_mod( 'google_maps_api' ) ?: 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840') . '&v=3.exp', null, null, true );

        //custom javascript
        wp_enqueue_script('global', get_template_directory_uri() . '/js/global.js', null, null, true); /* This should go first */

    }
}

add_action('wp_enqueue_scripts', 'foundation_scripts_and_styles');

/******************************************************************************
 * Additional Functions
 *******************************************************************************/

// Enable revisions for all custom post types
add_filter('cptui_user_supports_params', function () {
    return array('revisions');
});

if (function_exists('cptui_get_post_type_data')) {
    add_filter('wp_revisions_to_keep', 'limit_revisions_number', 10, 2);

    function limit_revisions_number($num, $post)
    {
        $custom_post_types = cptui_get_post_type_data();

        if (!$custom_post_types) {
            return $num;
        }

        foreach ($custom_post_types as $custom_post_type) {
            $cpt_names[] = $custom_post_type['name'];
        }
        if (isset($cpt_names) && in_array($post->post_type, $cpt_names)) {
            $num = 15;
        }

        return $num;
    }
}

// Add ability ro reply to comments
add_filter('wpseo_remove_reply_to_com', '__return_false');

// Register Post Type Slider
function post_type_slider()
{
    $post_type_slider_labels = array(
        'name' => _x('Slider', 'post type general name'),
        'singular_name' => _x('Slide', 'post type singular name'),
        'add_new' => _x('Add New', 'slide'),
        'add_new_item' => __('Add New'),
        'edit_item' => __('Edit'),
        'new_item' => __('New '),
        'all_items' => __('All'),
        'view_item' => __('View'),
        'search_items' => __('Search for a slide'),
        'not_found' => __('No slides found'),
        'not_found_in_trash' => __('No slides found in the Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Slider'
    );
    $post_type_slider_args = array(
        'labels' => $post_type_slider_labels,
        'description' => 'Display Slider',
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'menu_position' => 5,
        'supports' => array(
            'title',
            'thumbnail',
            'page-attributes',
            'editor',
            'post-formats'
        ),
        'has_archive' => false,
        'hierarchical' => true
    );
    register_post_type('slider', $post_type_slider_args);
    add_theme_support('post-formats', array('video'));
    remove_post_type_support('post', 'post-formats');
}

add_action('init', 'post_type_slider');

add_action('add_meta_boxes', 'slide_background_metabox');

function slide_background_metabox()
{
    $screens = array('slider');
    add_meta_box('slide_background', 'Slide background', 'slider_background_callback', $screens);
}

function slider_background_callback($post, $meta)
{
    wp_nonce_field('save_video_bg', 'foundation_nonce');
    ?>
    <style>
        .fields-list {
            margin-left: -12px;
            margin-right: -12px;
        }

        .fields-list::after {
            content: '';
            display: table;
            clear: both;
        }

        .field-wrap {
            float: left;
            padding-left: 12px;
            padding-right: 12px;
            box-sizing: border-box;
        }
    </style>
    <div class="fields-list">
        <div class="field-wrap" style="width: 70%">
            <p class="label-wrapper"><label for="slide_video" style="display: block;"><b>Video
                        background</b></label><em>Enter here link to video from Media Library or YouTube</em></p>
            <input type="text" id="slide_video" name="slide_video_bg"
                   value="<?php echo get_post_meta($post->ID, 'slide_video_bg', true); ?>" style="width: 100%;"/>
        </div>
        <div class="field-wrap" style="width: 30%">
            <p class="label-wrapper"><label for="video_aspect_ratio" style="display: block;"><b>Video aspect
                        ratio</b></label></p>
            <?php
            $aspect_ratio = get_post_meta($post->ID, 'video_aspect_ratio', true) ?: '16:9';
            $ratio_list = array('16:9', '4:3', '2.39:1');
            ?>
            <select name="video_aspect_ratio" id="video_aspect_ratio" style="width: 100%;">
                <?php foreach ($ratio_list as $item): ?>
                    <option value="<?php echo $item; ?>" <?php selected($aspect_ratio, $item); ?>><?php echo $item; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="clearfix" style="clear:both"></div>
    </div>
    <?php
}

/**
 * Update slide background on slide save
 */

add_action('save_post', 'save_slide_background');

function save_slide_background($post_id)
{

    if (!isset($_POST['slide_video_bg']) && !isset($_POST['video_aspect_ratio'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['foundation_nonce'], 'save_video_bg')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, 'video_aspect_ratio', $_POST['video_aspect_ratio']);
    update_post_meta($post_id, 'slide_video_bg', $_POST['slide_video_bg']);

}

/**
 * Print script to hande appearance of metabox
 */
//add_action('admin_enqueue_scripts','display_metaboxes');
add_action('admin_footer', 'display_metaboxes');

function display_metaboxes()
{

    if (get_post_type() == "slider") :
        ?>
        <script type="text/javascript">// <![CDATA[
            $ = jQuery;

            function displayMetaboxes() {
                $('#slide_background').hide();
                var selectedFormat = $('input[name=\'post_format\']:checked').val();
                if (selectedFormat == 'video') {
                    $('#slide_background').show();
                }
            }

            $(function () {
                displayMetaboxes();
                $('input[name=\'post_format\']').change(function () {
                    displayMetaboxes();
                });
            });
            // ]]></script>
    <?php
    endif;
}

// Enable control over YouTube iframe through API + add unique ID

function add_youtube_iframe_args($html, $url, $args)
{

    /* Modify video parameters. */
    if (strstr($html, 'youtube.com/embed/') && !empty($args['location'])) {
        preg_match_all('|embed/(.*)\?|', $html, $matches);
        $html = str_replace('?feature=oembed', '?feature=oembed&enablejsapi=1&autoplay=1&mute=1&controls=0&loop=1&showinfo=0&rel=0&playlist=' . $matches[1][0], $html);
        $html = str_replace('<iframe', '<iframe rel="0" enablejsapi="1" id=slide-' . get_the_ID(), $html);
    }

    return $html;
}

add_filter('oembed_result', 'add_youtube_iframe_args', 10, 3);

/**
 * Remove author archive pages
 */
function remove_author_archive_page()
{
    global $wp_query;

    if (is_author()) {
        $wp_query->set_404();
        status_header(404);
        // Redirect to homepage
        // wp_redirect(get_option('home'));
    }
}

add_action('template_redirect', 'remove_author_archive_page');

/**
 * Remove comments feed links
 */
add_filter('post_comments_feed_link', '__return_null');

// Stick Admin Bar To The Top
if (!is_admin()) {
    add_action('get_header', 'remove_topbar_bump');

    function remove_topbar_bump()
    {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }

    function stick_admin_bar()
    {
        echo "
			<style type='text/css'>
				body.admin-bar {margin-top:32px !important}
				@media screen and (max-width: 782px) {
					body.admin-bar { margin-top:46px !important }
				}
			</style>
			";
    }

    add_action('admin_head', 'stick_admin_bar');
    add_action('wp_head', 'stick_admin_bar');
}

// Customize Login Screen
function wordpress_login_styling()
{
    if ($custom_logo_id = get_theme_mod('custom_logo')) {
        $custom_logo_img = wp_get_attachment_image_src($custom_logo_id, 'medium');
        $custom_logo_src = $custom_logo_img[0];
    } else {
        $custom_logo_src = 'wp-admin/images/wordpress-logo.svg?ver=20131107';
    }
    ?>
    <style type="text/css">
        .login #login h1 a {
            background-image: url('<?php echo $custom_logo_src; ?>');
            background-size: contain;
            background-position: 50% 50%;
            width: auto;
            height: 120px;
        }

        body.login {
            background-color: #f1f1f1;
        <?php if ($bg_image = get_background_image()) {?> background-image: url('<?php echo $bg_image; ?>') !important;
        <?php } ?> background-repeat: repeat;
            background-position: center center;
        }
    </style>
<?php }

add_action('login_enqueue_scripts', 'wordpress_login_styling');

function admin_logo_custom_url()
{
    $site_url = get_bloginfo('url');

    return ($site_url);
}

add_filter('login_headerurl', 'admin_logo_custom_url');

/**
 * Display GravityForms fields label if it set to Hidden
 */

function display_gf_fields_label()
{
    echo '<style>.hidden_label label.gfield_label{visibility:visible;line-height:inherit;}.theme-overlay .theme-version{display: none;}</style>';
}

add_action('admin_head', 'display_gf_fields_label');

// ACF Pro Options Page

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

}

// Set Google Map API key

function set_custom_google_api_key()
{
    acf_update_setting('google_api_key', get_theme_mod('google_maps_api') ?: 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840');
}

add_action('acf/init', 'set_custom_google_api_key');

// Disable Emoji

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
add_filter('tiny_mce_plugins', 'disable_wp_emojis_in_tinymce');
function disable_wp_emojis_in_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

// Wrap any iframe and emved tag into div for responsive view

function iframe_wrapper($content)
{
    // match any iframes
    $pattern = '~<iframe.*?<\/iframe>|<embed.*?<\/embed>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        // Check if it is a video player iframe
        if (strpos($match, 'youtu') || strpos($match, 'vimeo')) {
            // wrap matched iframe with div
            $wrappedframe = '<div class="responsive-embed widescreen">' . $match . '</div>';
            //replace original iframe with new in content
            $content = str_replace($match, $wrappedframe, $content);
        }
    }

    return $content;
}

add_filter('the_content', 'iframe_wrapper');


// Dynamic Admin
if (is_admin()) {
    // $dynamic_admin = new DynamicAdmin();
    //	$dynamic_admin->addField( 'page', 'template', 'Page Template', 'template_detail_field_for_page' );

    // $dynamic_admin->run();
}

// Register Google Maps API key settings in customizer

function register_google_maps_settings($wp_customize)
{
    $wp_customize->add_section('google_maps', array(
        'title' => __('Google Maps', 'foundation'),
        'priority' => 30,
    ));
    $wp_customize->add_setting('google_maps_api', array(
        'default' => 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840',
    ));

    $wp_customize->add_control('google_maps_api', array(
        'label' => __('Google Maps API key', 'foundation'),
        'section' => 'google_maps',
        'settings' => 'google_maps_api',
        'type' => 'text',
    ));
}

add_action('customize_register', 'register_google_maps_settings');

/**
 * Enable GF Honeypot for all forms
 *
 * @param $form
 * @param $is_new
 */

function enable_honeypot_on_new_form_creation($form, $is_new)
{
    if ($is_new) {
        $form['enableHoneypot'] = true;
        $form['is_active'] = 1;
        GFAPI::update_form($form);
    }
}

add_action('gform_after_save_form', 'enable_honeypot_on_new_form_creation', 10, 2);

/**
 * Disable date field autocomplete popup
 *
 * @param string $input field HTML markup
 * @param object $field GForm field object
 *
 * @return string
 */

function gform_remove_date_autocomplete($input, $field)
{
    if (is_admin()) {
        return $input;
    }
    if (GFFormsModel::is_html5_enabled() && $field->type == 'date') {
        $input = str_replace('<input', '<input autocomplete="off" ', $input);
    }

    return $input;
}

add_filter('gform_field_content', 'gform_remove_date_autocomplete', 11, 2);

/**
 * Copyright field functionality
 *
 * @param array $field ACF Field settings
 *
 * @return array
 */

function populate_copyright_instructions($field)
{
    $field['instructions'] = 'Input <code>@year</code> to replace static year with dynamic, so it will always shows current year.';

    return $field;
}

add_action('acf/load_field/name=copyright', 'populate_copyright_instructions');

if (!is_admin()) {
    // Replace @year with current year
    add_filter('acf/load_value/name=copyright', function ($value) {
        return str_replace('@year', date('Y'), $value);
    });
}

/**
 * Apply lazyload to whole page content
 */

function lazyload()
{
    ob_start('lazyloadBuffer');
}

add_action('template_redirect', 'lazyload');

/**
 * @param string $html HTML content.
 *
 * @return string
 */
function lazyloadBuffer($html)
{
    $lazy = new CreateLazyImg;
    $buffer = $lazy->ignoreScripts($html);
    $buffer = $lazy->ignoreNoscripts($buffer);

    $html = $lazy->lazyloadImages($html, $buffer);
    $html = $lazy->lazyloadPictures($html, $buffer);
    $html = $lazy->lazyloadBackgroundImages($html, $buffer);

    return $html;
}

/**
 * Custom styles in TinyMCE
 *
 * @param array $buttons
 *
 * @return array
 */

function custom_style_selector($buttons)
{
    array_unshift($buttons, 'styleselect');

    return $buttons;
}

add_filter('mce_buttons_2', 'custom_style_selector', 10);

function insert_custom_formats($init_array)
{
    // Define the style_formats array
    $style_formats = array(
        array(
            'title' => 'Heading 1',
            'classes' => 'h1',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 2',
            'classes' => 'h2',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 3',
            'classes' => 'h3',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 4',
            'classes' => 'h4',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 5',
            'classes' => 'h5',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 6',
            'classes' => 'h6',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Button',
            'classes' => 'button',
            'selector' => 'a',
            'wrapper' => false,
        ),

        array(
            'title' => 'Small text',
            'inline' => 'small',
        ),
        array(
            'title' => 'Two columns',
            'classes' => 'two-columns',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,ul',
        ),
        array(
            'title' => 'Three columns',
            'classes' => 'three-columns',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,ul',
        ),

        array(
            'title' => 'Underline',
            'classes' => 'underline',
            'inline' => 'span',
            'selector' => 'a,p, h1, h2, h3, h4, h5',
            'wrapper' => false,
        ),

        array(
            'title' => 'Primary button',
            'classes' => 'primary-button button',
            'selector' => 'a',
            'inline' => 'a',
            'wrapper' => false,
        ),

        array(
            'title' => 'Secondary button',
            'classes' => 'button',
            'selector' => 'a',
            'inline' => 'a',
            'wrapper' => false,
        ),
    );
    $init_array['style_formats'] = json_encode($style_formats);

    return $init_array;

}

add_filter('tiny_mce_before_init', 'insert_custom_formats');

add_editor_style();

/**
 * Add custom color to TinyMCE editor text color selector
 *
 * @param $init array
 *
 * @return mixed array
 */

function expand_default_editor_colors($init)
{
    $default_colours = '"000000", "Black","993300", "Burnt orange","333300", "Dark olive","003300", "Dark green","003366", "Dark azure","000080", "Navy Blue","333399", "Indigo","333333", "Very dark gray","800000", "Maroon","FF6600", "Orange","808000", "Olive","008000", "Green","008080", "Teal","0000FF", "Blue","666699", "Grayish blue","808080", "Gray","FF0000", "Red","FF9900", "Amber","99CC00", "Yellow green","339966", "Sea green","33CCCC", "Turquoise","3366FF", "Royal blue","800080", "Purple","999999", "Medium gray","FF00FF", "Magenta","FFCC00", "Gold","FFFF00", "Yellow","00FF00", "Lime","00FFFF", "Aqua","00CCFF", "Sky blue","993366", "Brown","C0C0C0", "Silver","FF99CC", "Pink","FFCC99", "Peach","FFFF99", "Light yellow","CCFFCC", "Pale green","CCFFFF", "Pale cyan","99CCFF", "Light sky blue","CC99FF", "Plum","FFFFFF", "White"';

    $custom_colours = '
		"123154", "Navy",
		"173a62", "Light Navy",
		"e21c54", "Red",
		"1d1d1d", "Black",
		"737373", "Gray",';

    $init['textcolor_map'] = '[' . $default_colours . ',' . $custom_colours . ']';
    $init['textcolor_rows'] = 6; // expand colour grid to 6 rows

    return $init;
}

add_filter('tiny_mce_before_init', 'expand_default_editor_colors');


/*********************** PUT YOU FUNCTIONS BELOW ********************************/

add_image_size('full_hd', 1920, 0, array('center', 'center'));
add_image_size('large_high', 1024, 0, false);
// add_image_size( 'name', width, height, array('center','center'));

// Prevent page jumping on form submit
add_filter('gform_confirmation_anchor', '__return_false');

// Show Gravity Form field label appearance dropdown
add_filter('gform_enable_field_label_visibility_settings', '__return_true');

// Replace standard form input with button
function form_submit_button($button, $form)
{
    return str_replace(array('input', '/>'), array('button', '>'), $button) . "{$form['button']['text']}</button>";
}

add_filter("gform_submit_button", "form_submit_button", 10, 2);

// Disable gutenberg
add_filter('use_block_editor_for_post_type', '__return_false');

/**
 * Replace Wordpress email Sender name
 *
 * @return string
 */

function replace_email_sender_name()
{
    return get_bloginfo();
}

add_filter('wp_mail_from_name', 'replace_email_sender_name');


add_image_size('gallery', 581, 338, true);

add_image_size('dentist', 155, 247, false);

function register_procedures_menu()
{
    register_nav_menu('procedures', __('Procedures'));
}

add_action('init', 'register_procedures_menu');
add_action('wp_footer', 'change_label_button');

function change_label_button()
{
    ?>
    <script type="text/javascript">
        document.addEventListener('wpcf7mailsent', function (event) {
            if ('195' == event.detail.contactFormId) {
                jQuery('.wpcf7-submit.form-message').addClass('icon');
                jQuery('.wpcf7-submit.form-message').text("Message sent");
            }
            if ('6' == event.detail.contactFormId) {
                jQuery('.wpcf7-submit.form-patient').addClass('icon');
                jQuery('.wpcf7-submit.form-patient').text("Message sent");
            }
        }, false);
    </script>
    <?php
}


function button_shortcode($atts)
{
    $a = shortcode_atts(array(
        'class' => 'something',
        'title' => 'something else',
        'href' => 'something else',
    ), $atts);

    return "<a class='{$a['class']} line' href='{$a['href']}'>{$a['title']}</a>";
}

add_shortcode('button', 'button_shortcode');

add_filter('wp_nav_menu_footer-menu_items', 'add_search_to_nav', 10, 2);

function add_search_to_nav($items, $args)
{

    $link = get_field('add_search_in_menu', 'options');
    if ($link) {
        $items .= '<li><button class="search-button" data-open="search"><i class="fa fa-search"></i></button></li>';
    }
    return $items;

}

/*******************************************************************************/


/******************* HIDE/SHOW WORDPRESS PLUGINS MENU ITEM *********************/

/**
 * Remove and Restore ability to Add new plugins to site
 */

function remove_plugins_menu_item($role_name)
{
    $role = get_role($role_name);
    $role->remove_cap('activate_plugins');
    $role->remove_cap('install_plugins');
    $role->remove_cap('upload_plugins');
    $role->remove_cap('update_plugins');
}

function restore_plugins_menu_item($role_name)
{
    $role = get_role($role_name);
    $role->add_cap('activate_plugins');
    $role->add_cap('install_plugins');
    $role->add_cap('upload_plugins');
    $role->add_cap('update_plugins');
}

// remove_plugins_menu_item('administrator');
// restore_plugins_menu_item('administrator');


/*******************************************************************************/
