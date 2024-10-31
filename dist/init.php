<?php

/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package Post Layouts for Gutenberg
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


//PHP version compare
if (!version_compare(PHP_VERSION, '5.6', '>=')) {
    add_action('admin_notices', 'pl_fail_php_version');
} else {
    require_once ( PL_DIR . 'src/pl-helper/class-pl-loader.php');
}

/**
 * PHP version fail error
 *
 * @since 1.0.0
 * @package Post Layouts for Gutenberg
 */
function pl_fail_php_version() {
    /* translators: %s: PHP version */
    $message = sprintf(esc_html__('Post Layouts for Gutenberg requires PHP version %s+, plugin is currently NOT RUNNING.', 'post-layouts'), '5.6');
    $html_message = sprintf('<div class="error">%s</div>', wpautop($message));
    echo wp_kses_post($html_message);
}

/**
 * Enqueue assets for frontend and backend
 *
 * @since 1.0.0
 * @package Post Layouts for Gutenberg
 */
function post_layouts_block_assets() {

    // Load the compiled styles
    wp_enqueue_style('pl-block-style-css', plugins_url('dist/blocks.style.build.css', dirname(__FILE__)), array(), filemtime(plugin_dir_path(__FILE__) . 'blocks.style.build.css'));

    // Load the FontAwesome icon library
    wp_enqueue_style('pl-block-fontawesome', plugins_url('dist/assets/fontawesome/css/all.css', dirname(__FILE__)), array(), filemtime(plugin_dir_path(__FILE__) . 'assets/fontawesome/css/all.css'));
}

add_action('enqueue_block_assets', 'post_layouts_block_assets');

/**
 * Enqueue assets for backend editor
 *
 * @since 1.0.0
 * @package Post Layouts for Gutenberg
 */
function post_layouts_block_editor_assets() {

    // Load the compiled blocks into the editor
    wp_enqueue_script('pl-block-js', plugins_url('/dist/blocks.build.js', dirname(__FILE__)), array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-api'), filemtime(plugin_dir_path(__FILE__) . 'blocks.build.js'));

    // Load the compiled styles into the editor
    wp_enqueue_style('pl-block-editor-css', plugins_url('dist/blocks.editor.build.css', dirname(__FILE__)), array('wp-edit-blocks'), filemtime(plugin_dir_path(__FILE__) . 'blocks.editor.build.css'));
}

add_action('enqueue_block_editor_assets', 'post_layouts_block_editor_assets');

/**
 * Load the plugin textdomain
 */
function post_layouts_blocks_init() {

    load_plugin_textdomain('post-layouts', false, basename(dirname(__FILE__)) . '/src/languages');
}

add_action('init', 'post_layouts_blocks_init');

// Add custom block category
add_filter('block_categories_all', function( $categories, $post ) {
    return array_merge(
            $categories, array(
        array(
            'slug' => 'post-layouts',
            'title' => __('Post Layouts By Techeshta', 'post-layouts'),
        ),
            )
    );
}, 10, 2);
