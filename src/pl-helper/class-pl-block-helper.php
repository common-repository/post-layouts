<?php

/**
 * PL Block Helper.
 *
 * @package PL
 */
if (!class_exists('PL_Block_Helper')) {

    /**
     * Class PL_Block_Helper.
     */
    class PL_Block_Helper {

        /**
         * Get Post Grid Block CSS
         *
         * @since 1.4.0
         * @param array  $attr The block attributes.
         * @param string $id The selector ID.
         * @return array The Widget List.
         */
        public static function get_post_grid_css($attr, $id) {    // @codingStandardsIgnoreStart
            $defaults = PL_Helper::$block_list['post-layouts/pl-blog-templates']['attributes'];

            $attr = array_merge($defaults, (array) $attr);

            $selectors = self::get_post_selectors($attr);

            // @codingStandardsIgnoreEnd

            $desktop = PL_Helper::generate_css($selectors, '#pl_post_layouts-' . $id);

            return $desktop;
        }

        /**
         * Get Post Block Selectors CSS
         *
         * @param array $attr The block attributes.
         * @since 1.4.0
         */
        public static function get_post_selectors($attr) {    // @codingStandardsIgnoreStart
            return array(
                " .pl-post-grid" => array(
                    "padding-right" => ($attr['columnSpace'] / 2) . "px",
                    "padding-left" => ($attr['columnSpace'] / 2) . "px",
                    "margin-bottom" => $attr['rowSpace'] . "px",
                ),
                " .pl-is-grid .pl-text, .pl-is-list .pl-second-inner-wrap" => array(
                    "padding-right" => ($attr['innerSpace']) . "px",
                    "padding-left" => ($attr['innerSpace']) . "px",
                ),
                " .pl-button, .pl-blogpost-excerpt a.pl-link" => array(
                    "background" => $attr['readmoreBgColor'],
                    "color" => $attr['postctaColor'] . "!important",
                    "font-size" => $attr['postctafontSize'] . "px !important",
                    'font-family' => $attr['ctaFontFamily'],
                    'font-weight' => $attr['ctafontWeight'],
                ),
                " .pl-blogpost-2-text" => array(
                    "background" => $attr['designtwoboxbgColor'],
                    "padding-left" => $attr['innerSpace'] . "px",
                    "padding-right" => $attr['innerSpace'] . "px"
                ),
                " .pl-list-one, .pl-items-2, .pl-items-3 .pl-second-inner-wrap" => array(
                    "background" => $attr['listlayouttwobgColor'],
                ),
                " .pl-items-2 .pl-category-link-wraper" => array(
                    "background" => $attr['secondaryColor'],
                ),
                " .pl-is-list .pl-category-link-wraper div.category-link a" => array(
                    "background" => $attr['primaryColor'],
                    "color" => $attr['secondaryColor'],
                ),
                " .pl-is-list article" => array(
                    "margin-bottom" => $attr['rowSpace'] . "px",
                ),
                " .pl-items-2 .pl-blogpost-bototm-wrap" => array(
                    "border-bottom" => "2px solid " . $attr['secondaryColor'],
                    "border-top" => "2px solid " . $attr['secondaryColor'],
                ),
                " .pl-list-template2 div.pl-category-link-wraper" => array(
                    "background" => $attr['primaryColor'],
                    "color" => $attr['secondaryColor'],
                ),
                " .pl-items" => array(
                    "background" => $attr['boxbgColor'],
                ),
                " .pl-blogpost-title" => array(
                    "padding-bottom" => $attr['belowTitleSpace'] . "px"
                ),
                " .pl-image" => array(
                    "padding-bottom" => $attr['belowImageSpace'] . "px",
                ),
                " .pl-link" => array(
                    "margin-bottom" => $attr['belowctaSpace'] . "px",
                ),
                " .pl-blogpost-excerpt p" => array(
                    "font-size" => $attr['postexcerptfontSize'] . "px",
                    'font-family' => $attr['excerptFontFamily'],
                    'font-weight' => $attr['belowexerptSpace'],
                    'color' => $attr['postexcerptColor']
                ),
                " .pl-blogpost-title a" => array(
                    "font-size" => $attr['titlefontSize'] . "px",
                    'font-family' => $attr['titleFontFamily'],
                    'font-weight' => $attr['titleFontWeight'],
                    'color' => $attr['titleColor'],
                ),
                " .pl-blogpost-author a , .pl-post-tags a" => array(
                    "font-size" => $attr['postmetafontSize'] . "px !important",
                    'font-family' => $attr['metaFontFamily'],
                    'font-weight' => $attr['metafontWeight'],
                    'color' => $attr['postmetaColor'] . " !important",
                ),
                " .pl-blogpost-byline .metadatabox > div" => array(
                    "font-size" => $attr['postmetafontSize'] . "px",
                    'font-family' => $attr['titleFontFamily'],
                    'font-weight' => $attr['metafontWeight'],
                    'color' => $attr['postmetaColor'],
                ),
                " .pl-social-wrap a" => array(
                    "font-size" => $attr['socialSharefontSize'] . "px",
                    'color' => $attr['socialShareColor']
                ),
            );
            // @codingStandardsIgnoreEnd
        }

    }

}