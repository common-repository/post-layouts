<?php

/**
 * PL Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package PL
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * PL_Init_Blocks.
 *
 * @package PL
 */
class PL_Init_Blocks {

    /**
     * Member Variable
     *
     * @var instance
     */
    private static $instance;

    /**
     *  Initiator
     */
    public static function get_instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    /**
     * Enqueue Gutenberg block assets for both frontend + backend.
     *
     * @since 1.0.0
     */
    function block_assets() {
        
    }

// End function editor_assets().

    /**
     * Enqueue Gutenberg block assets for backend editor.
     *
     * @since 1.0.0
     */
    function editor_assets() {

        wp_localize_script(
                'pl-block-editor-js', 'pl_blocks_info', array(
            'blocks' => PL_Config::get_block_attributes(),
            'category' => 'post-layouts',
            'ajax_url' => admin_url('admin-ajax.php'),
            'image_sizes' => PL_Helper::get_image_sizes(),
            'post_types' => PL_Helper::get_post_types(),
            'all_taxonomy' => PL_Helper::get_related_taxonomy(),
                )
        );
    }

// End function editor_assets().
}

/**
 *  Prepare if class 'PL_Init_Blocks' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
PL_Init_Blocks::get_instance();
