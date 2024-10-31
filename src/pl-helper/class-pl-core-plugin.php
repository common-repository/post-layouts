<?php

/**
 * PL Core Plugin.
 *
 * @package PL
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * PL_Core_Plugin.
 *
 * @package PL
 */
class PL_Core_Plugin {

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

        $this->includes();
    }

    /**
     * Includes.
     *
     * @since 1.0.0
     */
    private function includes() {

        // require( PL_DIR . 'lib/notices/class-astra-notices.php' );
        require( PL_DIR . 'src/pl-helper/class-pl-admin.php' );
        require( PL_DIR . 'src/pl-helper/class-pl-init-blocks.php' );
    }

}

/**
 *  Prepare if class 'PL_Core_Plugin' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
PL_Core_Plugin::get_instance();
