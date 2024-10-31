<?php

/**
 * PL Admin.
 *
 * @package PL
 */
if (!class_exists('PL_Admin')) {

    /**
     * Class PL_Admin.
     */
    final class PL_Admin {

        /**
         * Calls on initialization
         *
         * @since 0.0.1
         */
        public static function init() {

            // Activation hook.
        }

        /**
         * Filters and Returns a list of allowed tags and attributes for a given context.
         *
         * @param Array  $allowedposttags Array of allowed tags.
         * @param String $context Context type (explicit).
         * @since 1.8.0
         * @return Array
         */
        public static function add_data_attributes($allowedposttags, $context) {
            $allowedposttags['a']['data-repeat-notice-after'] = true;

            return $allowedposttags;
        }

        /**
         * Enqueues the needed CSS/JS for the builder's admin settings page.
         *
         * @since 1.0.0
         */
        public static function styles_scripts() {

            // Styles.
            wp_enqueue_style('PL-admin-settings', PL_URL . 'admin/assets/admin-menu-settings.css', array(), PL_VER);
            // Script.
            wp_enqueue_script('PL-admin-settings', PL_URL . 'admin/assets/admin-menu-settings.js', array('jquery', 'wp-util', 'updates'), PL_VER);

            $localize = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'ajax_nonce' => wp_create_nonce('pl-block-nonce'),
            );

            wp_localize_script('pl-admin-settings', 'pl', apply_filters('pl_js_localize', $localize));
        }

    }

    PL_Admin::init();
}
