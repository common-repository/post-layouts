<?php

/**
 * PL Config.
 *
 * @package PL
 */
if (!class_exists('PL_Config')) {

    /**
     * Class PL_Config.
     */
    class PL_Config {

        /**
         * Block Attributes
         *
         * @var block_attributes
         */
        public static $block_attributes = null;

        /**
         * Get Widget List.
         *
         * @since 0.0.1
         *
         * @return array The Widget List.
         */
        public static function get_block_attributes() {

            if (null === self::$block_attributes) {
                self::$block_attributes = array(
                    'post-layouts/pl-blog-templates' => array(
                        'slug' => '',
                        'title' => __('Post Layouts', 'post-layouts'),
                        'description' => __('This block fetches the blog posts you may have on your website and displays them in a grid layout.', 'post-layouts'),
                        'default' => true,
                        'attributes' => array(
                            'boxbgColor' => '',
                            'titleColor' => '',
                            'postmetaColor' => '',
                            'postexcerptColor' => '',
                            'primaryColor' => '',
                            'listlayouttwobgColor' => '',
                            'secondaryColor' => '',
                            'postctaColor' => '',
                            'socialShareColor' => '',
                            'titlefontSize' => '',
                            'postmetafontSize' => '',
                            'postexcerptfontSize' => '',
                            'postctafontSize' => '',
                            'readmoreBgColor' => '',
                            'designtwoboxbgColor' => '',
                            'socialSharefontSize' => '',
                            'rowSpace' => '20',
                            'columnSpace' => '20',
                            'belowTitleSpace' => '',
                            'belowImageSpace' => '10',
                            'belowexerptSpace' => '10',
                            'belowctaSpace' => '10',
                            'innerSpace' => '20',
                            'titleFontFamily' => '',
                            'titleFontWeight' => '',
                            'titleFontSubset' => '',
                            'excerptFontFamily' => '',
                            'excerptFontWeight' => '',
                            'excerptFontSubset' => '',
                            'metaFontFamily' => '',
                            'metaFontSubset' => '',
                            'metafontWeight' => '',
                            'ctaFontFamily' => '',
                            'ctaFontSubset' => '',
                            'ctafontWeight' => '',
                        ),
                    ),
                );
            }
            return self::$block_attributes;
        }

    }

}
