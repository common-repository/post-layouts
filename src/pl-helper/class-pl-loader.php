<?php

/**
 * PL Loader.
 *
 * @package PL
 */
if (!class_exists('PL_Loader')) {

    /**
     * Class PL_Loader.
     */
    final class PL_Loader {

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

            $this->loader();

            add_action('plugins_loaded', array($this, 'load_plugin'));
        }

        /**
         * Loads Other files.
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function loader() {
            require( PL_DIR . 'src/pl-helper/class-pl-helper.php' );
            require( PL_DIR . 'src/pl-helper/class-pl-core-plugin.php' );
        }

    }

    /**
     *  Prepare if class 'PL_Loader' exist.
     *  Kicking this off by calling 'get_instance()' method
     */
    PL_Loader::get_instance();
}
