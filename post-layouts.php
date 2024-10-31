<?php

/**
 * Plugin Name: Post Layouts for Gutenberg
 * Plugin URI: https://wordpress.org/plugins/post-layouts/
 * Description: A beautiful post layouts block to showcase your posts in grid and list layout with multiple templates availability.
 * Author: Techeshta
 * Author URI: https://www.techeshta.com
 * Version: 1.2.8
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Text Domain: post-layouts
 */
/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

define('PL_DOMAIN', 'post-layouts');
define('PL_DIR', plugin_dir_path(__FILE__));
define('PL_URL', plugins_url('/', __FILE__));

/**
 * Initialize the blocks
 */
function post_layouts_gutenberg_loader() {
    /**
     * Load the blocks functionality
     */
    require_once ( PL_DIR . 'dist/init.php');

    /**
     * Load Post Grid PHP
     */
    require_once ( PL_DIR . 'src/blocks/index.php');
}

add_action('plugins_loaded', 'post_layouts_gutenberg_loader');

/**
 * Load the plugin text-domain
 */
function post_layouts_gutenberg_init() {
    load_plugin_textdomain('post-layouts', false, basename(dirname(__FILE__)) . '/languages');
}

add_action('init', 'post_layouts_gutenberg_init');

/**
 * Add a check for our plugin before redirecting
 */
function post_layouts_gutenberg_activate() {
    add_option('post_layouts_gutenberg_do_activation_redirect', true);
}

register_activation_hook(__FILE__, 'post_layouts_gutenberg_activate');

/**
 * Add image sizes
 */
function post_layouts_gutenberg_image_sizes() {
    // Post Grid Block
    add_image_size('pl-blogpost-landscape', 600, 400, true);
    add_image_size('pl-blogpost-square', 600, 600, true);
}

add_action('after_setup_theme', 'post_layouts_gutenberg_image_sizes');
