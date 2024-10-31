<?php

/**
 * Server-side rendering for the post template block
 *
 * @since   1.0.0
 * @package Post Layouts for Gutenberg
 */

/**
 * Renders the post block on server.
 */
function post_layouts_block_render_block_core_latest_posts($attributes) {
    $list_items_markup = $post_thumb_id = $equalheight = '';

    $template = $attributes['layoutopt'] . $attributes['layoutcount'];

    if ($attributes['layoutcount'] && $attributes['layoutopt']) {
        switch ($template) {
            case 'grid1' :
                $list_items_markup = pl_grid_layout1($attributes);
                break;
            case 'grid2' :
                $list_items_markup = pl_grid_layout2($attributes);
                break;
            case 'list1' :
                $list_items_markup = pl_list_layout1($attributes);
                break;
            case 'list2' :
                $list_items_markup = pl_list_layout2($attributes);
                break;
            case 'list3' :
                $list_items_markup = pl_list_layout3($attributes);
                break;
        }
    }

    // Build the classes
    $class = "pl-{$attributes['layoutopt']}-template{$attributes['layoutcount']} align-{$attributes['align']}";

    $block_id = 'pl_post_layouts-' . $attributes['block_id'];

    if (isset($attributes['className'])) {
        $class .= ' ' . $attributes['className'];
    }
    $grid_class = 'pl-blogpost-items';

    if (isset($attributes['layoutopt']) && 'list' === $attributes['layoutopt']) {

        //list-class
        $grid_class .= ' pl-is-list';
    } else {

        //grid-class
        $grid_class .= ' pl-is-grid';
    }

    if (isset($attributes['columns']) && 'grid' === $attributes['layoutopt']) {
        $grid_class .= ' pl_columns-' . $attributes['columns'];
    }

    if (isset($attributes['isequalheight']) && $attributes['isequalheight']) {

        //equal height class
        $equalheight .= ' pl_same-height';
    }


    // Output the post markup
    $block_content = sprintf('<div id="%1$s" class="%2$s"><div class="%3$s %4$s">%5$s</div></div>', esc_attr($block_id), esc_attr($class), esc_attr($grid_class), esc_attr($equalheight), $list_items_markup);

    return $block_content;
}

/*
 *  Get the featured image
 */

function post_layouts_get_featured_image($post_id, $attributes) {

    // Get the post thumbnail
    $fetured_image = '';
    $post_thumb_id = get_post_thumbnail_id($post_id);
    if (isset($attributes['displayPostImage']) && $attributes['displayPostImage'] && $post_thumb_id) {
        if ($attributes['imageCrop'] === 'landscape') {
            $post_thumb_size = 'pl-blogpost-landscape';
        } else {
            $post_thumb_size = 'pl-blogpost-square';
        }

        $fetured_image = sprintf('<div class="pl-image"><a href="%1$s" rel="bookmark">%2$s</a></div>', esc_url(get_permalink($post_id)), wp_get_attachment_image($post_thumb_id, $post_thumb_size));
    }
    return $fetured_image;
}

/*
 *  Get the category of post
 */

function post_layouts_get_category($post_id, $seprator) {

    $categories_list = get_the_category_list($seprator, "", $post_id);
    $category = "";

    if (!empty($categories_list))
        $category = sprintf('<div class="category-link"> %1$s </div> ', $categories_list);

    return $category;
}

/*
 *  Get the excerpt
 */

function post_layouts_get_excerpt($post_id, $post_query, $attributes) {

    if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt']) {

        $excerpt = apply_filters('the_excerpt', get_post_field('post_excerpt', $post_id, 'display'));

        if (isset($attributes['wordsExcerpt']) && $attributes['wordsExcerpt']) {

            $wordsExcerpt = $attributes['wordsExcerpt'];
        } else {
            $wordsExcerpt = 25;
        }

        if (empty($excerpt) && isset($attributes['wordsExcerpt'])) {

            $excerpt = apply_filters('the_excerpt', wp_trim_words(get_the_content(), $wordsExcerpt));
        }

        if (!$excerpt) {
            $excerpt = null;
        }

        $excerpt_data = wp_kses_post($excerpt_data ?? '');
    }
    return $excerpt_data;
}

/*
 *  Get the post author
 */

function post_layouts_get_author($post_id) {

    $list_items_markup = sprintf('<a href="%2$s">%1$s</a></span></span>', esc_html(get_the_author_meta('display_name', get_the_author_meta('ID'))), esc_html(get_author_posts_url(get_the_author_meta('ID')))
    );
    return $list_items_markup;
}

/*
 *  Get the post tags
 */

function post_layouts_get_tags($post_id, $tag_text) {
    $tags_list = get_the_tag_list("", ", ", "", $post_id);
    $list_items_markup = '';
    if (!empty($tags_list)) {
        if (!empty($tag_text))
            $list_items_markup .= sprintf('<div class="pl-post-tags"><span class="link-label">%1$s </span> %2$s </div> ', $tag_text, $tags_list);
        else
            $list_items_markup .= sprintf('<div class="pl-post-tags"> %1$s </div> ', $tags_list);
    }
    return $list_items_markup;
}

/*
 *  Get the post social share icon
 */

function post_layouts_get_social_share_icons($post_id) {
    $object['ID'] = '';
    $social_share_info = sprintf('<a data-share="facebook" href="https://www.facebook.com/sharer.php?u=%1$s" class="pl-facebook-share social-share-default pl-social-share" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>', get_the_permalink($post_id));
    $social_share_info .= sprintf('<a data-share="twitter" href="https://twitter.com/share?url=%1$s" class="pl-twitter-share social-share-default pl-social-share" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a>', get_the_permalink($post_id));
    $social_share_info .= sprintf('<a data-share="linkedin" href="https://www.linkedin.com/shareArticle?url=%1$s" class="pl-linkedin-share social-share-default pl-social-share" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>', get_the_permalink($post_id));
    return $social_share_info;
}

/*
 *  Grid template 1
 */

function pl_grid_layout1($attributes) {

    $args = array(
        'posts_per_page' => $attributes['postsToShow'],
        'post_status' => 'publish',
        'order' => $attributes['order'],
        'orderby' => $attributes['orderBy'],
        'cat' => !empty($attributes['categories']) ? $attributes['categories'] : '',
    );

    $post_query = new WP_Query($args);

    $list_items_markup = $post_thumb_id = '';

    //loop the query
    if ($post_query->have_posts()) {

        //loop the query
        while ($post_query->have_posts()) {

            $post_query->the_post();

            // Get the post ID
            $post_id = get_the_ID();

            $post_thumb_id = get_post_thumbnail_id($post_id);

            if ($post_thumb_id && isset($attributes['displayPostImage']) && $attributes['displayPostImage']) {
                $post_thumb_class = 'has-thumb';
            } else {
                $post_thumb_class = 'no-thumb';
            }

            // Start the markup for the post
            $list_items_markup .= sprintf('<article class="pl-post-grid">');
            $list_items_markup .= sprintf('<div class="%1$s pl-blog-template pl-items">', esc_attr($post_thumb_class));
            $list_items_markup .= post_layouts_get_featured_image($post_id, $attributes);

            // Wrap the text content
            $list_items_markup .= sprintf('<div class="pl-text">');
            if (isset($attributes['displayPostCategory']) && $attributes['displayPostCategory']) {
                $list_items_markup .= post_layouts_get_category($post_id, ", ");
            }

            // Get the post title
            $title = get_the_title($post_id);

            if (!$title) {
                $title = __('Untitled', 'post-layouts');
            }

            //Get title tag
            $title_tag = $attributes['titleTag'];
            if ($title_tag == 'h1' || $title_tag == 'h2' || $title_tag == 'h3' || $title_tag == 'h4' || $title_tag == 'h5' || $title_tag == 'h6') {
                $post_title_tag = tag_escape($title_tag);
            } else {
                $post_title_tag = 'h2';
            }

            $list_items_markup .= sprintf('<div class="pl-blogpost-title"><%3$s class="pl-title"><a href="%1$s" rel="bookmark">%2$s</a></%3$s></div>', esc_url(get_permalink($post_id)), esc_html($title), esc_html($post_title_tag));

            // Wrap the byline content
            $list_items_markup .= sprintf('<div class="pl-blogpost-byline"> <div class=" metadatabox">');
            if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor']) {
                $list_items_markup .= sprintf('<div class="post-author">');
                $list_items_markup .= __('By ', 'post-layouts');
                $list_items_markup .= sprintf('<span class="pl-blogpost-author">');
                $list_items_markup .= post_layouts_get_author($post_id, $post_query);
                $list_items_markup .= sprintf('</div>');
            }

            // Get the post date
            if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
                $list_items_markup .= sprintf('<div class="mdate ">');
                $list_items_markup .= __('On ', 'post-layouts');
                $list_items_markup .= sprintf('%1$s </div>', get_the_date('F,  Y', $post_id));
            }

            //Get comments
            $comments = get_comments_number($post_id);
            if ($comments > 0) {
                // translators: %s: Number of comments.
                $number_comment = _n('%s Comment', '%s Comments', $comments, 'post-layouts');
            } else {
                $number_comment = __('No Comments', 'post-layouts');
            }
            if (isset($attributes['displayPostComments']) && $attributes['displayPostComments']) {
                $list_items_markup .= sprintf('<div class="post-comments "> %1$s </div>', $number_comment);
            }
            $list_items_markup .=sprintf('</div>');

            // Wrap the excerpt content
            $list_items_markup .= sprintf('<div class="pl-blogpost-excerpt">');
            if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt']) {
                $list_items_markup .= post_layouts_get_excerpt($post_id, $post_query, $attributes);
            }

            //Display Readmore  
            if (isset($attributes['displayPostLink']) && $attributes['displayPostLink']) {

                if ($attributes['readmoreView'] == 'text-only') {

                    $list_items_markup .= sprintf('<div class="pl-text-only"><a class="pl-blogpost-link pl-link" href="%1$s" rel="bookmark">%2$s</a></div>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                } else if ($attributes['readmoreView'] == 'pl-button') {

                    $list_items_markup .= sprintf('<a class="pl-button pl-link gb-text-link" href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                }
            }

            // Close the excerpt content
            $list_items_markup .= sprintf('</div><div class="pl-blogpost-bototm-wrap">');
            if (isset($attributes['displayPostTag']) && $attributes['displayPostTag']) {
                $list_items_markup .= post_layouts_get_tags($post_id, "");
            }
            $list_items_markup .= sprintf('<div class="pl-social-wrap">');
            if (isset($attributes['displayPostSocialshare']) && $attributes['displayPostSocialshare']) {
                $list_items_markup .= post_layouts_get_social_share_icons($post_id);
            }
            $list_items_markup .= sprintf('</div></div>');

            // Close the byline content
            $list_items_markup .= sprintf('</div>');

            // Close the text content
            $list_items_markup .= sprintf('</div>');

            // Close the markup for the post
            $list_items_markup .= "</div></article>\n";
        }
    }
    return $list_items_markup;
}

/*
 *  Grid template 2
 */

function pl_grid_layout2($attributes) {
    $args = array(
        'posts_per_page' => $attributes['postsToShow'],
        'post_status' => 'publish',
        'order' => $attributes['order'],
        'orderby' => $attributes['orderBy'],
        'cat' => !empty($attributes['categories']) ? $attributes['categories'] : '',
    );

    $post_query = new WP_Query($args);

    $list_items_markup = $post_thumb_id = '';

    if ($post_query->have_posts()) {

        //loop the query
        while ($post_query->have_posts()) {

            $post_query->the_post();

            // Get the post ID
            $post_id = get_the_ID();

            $post_thumb_id = get_post_thumbnail_id($post_id);

            if ($post_thumb_id && isset($attributes['displayPostImage']) && $attributes['displayPostImage']) {
                $post_thumb_class = 'has-thumb';
            } else {
                $post_thumb_class = 'no-thumb';
            }
            // Start the markup for the post
            $list_items_markup .= sprintf('<article class="pl-post-grid">');
            $list_items_markup .= sprintf('<div class="%1$s pl-blog-template pl-grid-2">', esc_attr($post_thumb_class));
            $list_items_markup .= post_layouts_get_featured_image($post_id, $attributes);

            // Wrap the text content
            $list_items_markup .= sprintf('<div class="pl-blogpost-2-text"><div class="pl-category-link-wraper">');
            if (isset($attributes['displayPostCategory']) && $attributes['displayPostCategory']) {
                $list_items_markup .= post_layouts_get_category($post_id, "& ");
            }
            $list_items_markup .= sprintf('</div>');
            // Get the post title
            $title = get_the_title($post_id);

            if (!$title) {
                $title = __('Untitled', 'post-layouts');
            }

            //Get title tag
            $title_tag = $attributes['titleTag'];
            if ($title_tag == 'h1' || $title_tag == 'h2' || $title_tag == 'h3' || $title_tag == 'h4' || $title_tag == 'h5' || $title_tag == 'h6') {
                $post_title_tag = tag_escape($title_tag);
            } else {
                $post_title_tag = 'h2';
            }

            $list_items_markup .= sprintf('<div class="pl-blogpost-title"><%3$s class="pl-title"><a href="%1$s" rel="bookmark">%2$s</a></%3$s></div>', esc_url(get_permalink($post_id)), esc_html($title), esc_html($post_title_tag));

            // Wrap the byline content
            $list_items_markup .= sprintf('<div class="pl-blogpost-byline"> <div class=" metadatabox">');

            // Get the post date
            if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
                $list_items_markup .= sprintf('<div class="mdate ">');
                $list_items_markup .= __('On', 'post-layouts');
                $list_items_markup .= sprintf(' %1$s</div>', get_the_date('F,  Y', $post_id));
            }
            if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor']) {
                $list_items_markup .= sprintf('<div class="post-author">');
                $list_items_markup .= __('By ', 'post-layouts');
                $list_items_markup .= sprintf('<span class="pl-blogpost-author">');
                $list_items_markup .= post_layouts_get_author($post_id, $post_query);
                $list_items_markup .= sprintf('</div>');
            }

            //Get comments
            $comments = get_comments_number($post_id);

            if ($comments > 0) {
                $number_comment = $comments . " Comments";
            } else {
                $number_comment = "No Comments";
            }
            if (isset($attributes['displayPostComments']) && $attributes['displayPostComments']) {
                $list_items_markup .= sprintf('<div class="post-comments "> %1$s </div>', $number_comment);
            }
            $list_items_markup .=sprintf('</div>');

            // Wrap the excerpt content
            $list_items_markup .= sprintf('<div class="pl-blogpost-excerpt">');
            if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt']) {
                $list_items_markup .= post_layouts_get_excerpt($post_id, $post_query, $attributes);
            }


            //Display Readmore  
            if (isset($attributes['displayPostLink']) && $attributes['displayPostLink']) {

                if ($attributes['readmoreView'] == 'text-only') {

                    $list_items_markup .= sprintf('<p class="pl-text-only"><a class="pl-blogpost-link" href="%1$s" rel="bookmark">%2$s</a></p>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                } else if ($attributes['readmoreView'] == 'pl-button') {

                    $list_items_markup .= sprintf('<a class="pl-button pl-link gb-text-link" href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                }
            }

            $list_items_markup .= sprintf('</div><div class="pl-blogpost-bototm-wrap">');
            if (isset($attributes['displayPostTag']) && $attributes['displayPostTag']) {
                $list_items_markup .= post_layouts_get_tags($post_id, '<i class="fas fa-tags"></i>');
            }
            if (isset($attributes['displayPostSocialshare']) && $attributes['displayPostSocialshare']) {
                $list_items_markup .= sprintf('<div class="pl-social-wrap"><i class="fas fa-share-alt"></i><div class="social-share-data">');
                $list_items_markup .= post_layouts_get_social_share_icons($post_id);
                $list_items_markup .= sprintf('</div></div>');
            }
            $list_items_markup .= sprintf('</div>');

            // Close the byline content
            $list_items_markup .= sprintf('</div>');

            // Wrap the text content
            $list_items_markup .= sprintf('</div>');

            // Close the markup for the post
            $list_items_markup .= "</div></article>";
        }
    }
    return $list_items_markup;
}

/*
 *  List template 1
 */

function pl_list_layout1($attributes) {

    $args = array(
        'posts_per_page' => $attributes['postsToShow'],
        'post_status' => 'publish',
        'order' => $attributes['order'],
        'orderby' => $attributes['orderBy'],
        'cat' => !empty($attributes['categories']) ? $attributes['categories'] : '',
    );

    $post_query = new WP_Query($args);

    $list_items_markup = $post_thumb_id = '';

    if ($post_query->have_posts()) {

        //loop the query
        while ($post_query->have_posts()) {

            $post_query->the_post();

            // Get the post ID
            $post_id = get_the_ID();

            $post_thumb_id = get_post_thumbnail_id($post_id);

            if ($post_thumb_id && isset($attributes['displayPostImage']) && $attributes['displayPostImage']) {
                $post_thumb_class = 'has-thumb';
            } else {
                $post_thumb_class = 'no-thumb';
            }

            // Start the markup for the post
            $list_items_markup .= sprintf('<article class="%1$s pl-blog-template pl-list-one"><div class="pl-first-inner-wrap">', esc_attr($post_thumb_class));
            $list_items_markup .= post_layouts_get_featured_image($post_id, $attributes);

            // Wrap the text content
            $list_items_markup .= sprintf('<div class="pl-category-link-wraper">');
            if (isset($attributes['displayPostCategory']) && $attributes['displayPostCategory']) {
                $list_items_markup .= post_layouts_get_category($post_id, ", ");
            }
            $list_items_markup .= sprintf('</div></div>');
            $list_items_markup .= sprintf('<div class="pl-second-inner-wrap" >');

            // Wrap the byline content
            $list_items_markup .= sprintf('<div class="pl-blogpost-byline"> <div class=" metadatabox">');
            if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor']) {
                $list_items_markup .= sprintf('<div class="post-author">');
                $list_items_markup .= __('By ', 'post-layouts');
                $list_items_markup .= sprintf('<span class="pl-blogpost-author">');
                $list_items_markup .= post_layouts_get_author($post_id, $post_query);

                $list_items_markup .= sprintf('</div>');
            }

            // Get the post date
            if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
                $list_items_markup .= sprintf('<div class="mdate ">');
                $list_items_markup .= __('On', 'post-layouts');
                $list_items_markup .= sprintf(' %1$s</div>', get_the_date('F,  Y', $post_id));
            }

            //Get comments
            $comments = get_comments_number($post_id);

            if ($comments > 0) {
                $number_comment = $comments . " Comments";
            } else {
                $number_comment = "No Comments";
            }
            if (isset($attributes['displayPostComments']) && $attributes['displayPostComments']) {
                $list_items_markup .= sprintf('<div class="post-comments "> %1$s </div>', $number_comment);
            }
            $list_items_markup .= sprintf('</div>');

            // Get the post title
            $title = get_the_title($post_id);
            if (!$title) {
                $title = __('Untitled');
            }

            //Get title tag
            $title_tag = $attributes['titleTag'];
            if ($title_tag == 'h1' || $title_tag == 'h2' || $title_tag == 'h3' || $title_tag == 'h4' || $title_tag == 'h5' || $title_tag == 'h6') {
                $post_title_tag = tag_escape($title_tag);
            } else {
                $post_title_tag = 'h2';
            }

            $list_items_markup .= sprintf('<div class="pl-blogpost-title"><%3$s class="pl-title"><a href="%1$s" rel="bookmark">%2$s</a></%3$s></div>', esc_url(get_permalink($post_id)), esc_html($title), esc_html($post_title_tag));

            // Wrap the excerpt content
            $list_items_markup .= sprintf('<div class="pl-blogpost-excerpt">');
            if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt']) {
                $list_items_markup .= post_layouts_get_excerpt($post_id, $post_query, $attributes);
            }

            //Display Readmore  
            if (isset($attributes['displayPostLink']) && $attributes['displayPostLink']) {

                if ($attributes['readmoreView'] == 'text-only') {

                    $list_items_markup .= sprintf('<p class="pl-text-only"><a class="pl-blogpost-link" href="%1$s" rel="bookmark">%2$s</a></p>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                } else if ($attributes['readmoreView'] == 'pl-button') {

                    $list_items_markup .= sprintf('<a class="pl-button pl-link gb-text-link" href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                }
            }

            // Close the excerpt content
            $list_items_markup .= sprintf('</div></div><div class="pl-blogpost-bototm-wrap">');
            if (isset($attributes['displayPostTag']) && $attributes['displayPostTag']) {
                $list_items_markup .= post_layouts_get_tags($post_id, '');
            }
            if (isset($attributes['displayPostSocialshare']) && $attributes['displayPostSocialshare']) {
                $list_items_markup .= sprintf('<div class="pl-social-wrap"><div class="social-share-data">');
                $list_items_markup .= post_layouts_get_social_share_icons($post_id);
            }

            $list_items_markup .= sprintf('</div></div></div>');
            $list_items_markup .= "</article>\n";
        }
    }
    return $list_items_markup;
}

/*
 *  List template 2
 */

function pl_list_layout2($attributes) {

    $args = array(
        'posts_per_page' => $attributes['postsToShow'],
        'post_status' => 'publish',
        'order' => $attributes['order'],
        'orderby' => $attributes['orderBy'],
        'cat' => !empty($attributes['categories']) ? $attributes['categories'] : '',
    );

    $post_query = new WP_Query($args);

    $list_items_markup = $post_thumb_id = '';

    if ($post_query->have_posts()) {

        //loop the query
        while ($post_query->have_posts()) {

            $post_query->the_post();

            // Get the post ID
            $post_id = get_the_ID();

            $post_thumb_id = get_post_thumbnail_id($post_id);

            if ($post_thumb_id && isset($attributes['displayPostImage']) && $attributes['displayPostImage']) {
                $post_thumb_class = 'has-thumb';
            } else {
                $post_thumb_class = 'no-thumb';
            }

            // Start the markup for the post
            $list_items_markup .= sprintf('<article class="%1$s pl-blog-template pl-items-2"><div class="pl-first-inner-wrap">', esc_attr($post_thumb_class));
            $list_items_markup .= post_layouts_get_featured_image($post_id, $attributes);

            // Wrap the text content
            $list_items_markup .= sprintf('<div class="pl-category-link-wraper tmp-2">');
            if (isset($attributes['displayPostCategory']) && $attributes['displayPostCategory']) {
                $list_items_markup .= post_layouts_get_category($post_id, "  ");
            }
            $list_items_markup .= sprintf(
                    '</div></div>'
            );
            $list_items_markup .= sprintf('<div class="pl-second-inner-wrap" >');

            // Wrap the byline content
            $list_items_markup .= sprintf('<div class="pl-blogpost-byline"> <div class=" metadatabox">');
            if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor']) {
                $list_items_markup .= sprintf('<div class="post-author"><i class="fas fa-pencil-alt"></i><span class="pl-blogpost-author">');
                $list_items_markup .= post_layouts_get_author($post_id, $post_query);
                $list_items_markup .= sprintf('</div>');
            }

            // Get the post date
            if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
                $list_items_markup .= sprintf('<div class="mdate "><i class="fas fa-calendar-alt"></i> %1$s </div>', get_the_date('F, Y', $post_id));
            }

            //Get comments
            $comments = get_comments_number($post_id);
            if ($comments > 0) {
                $number_commnet = '<i class="far fa-comment"></i>' . $comments;
            } else {
                $number_commnet = '<i class="far fa-comment"></i> 0';
            }
            if (isset($attributes['displayPostComments']) && $attributes['displayPostComments']) {
                $list_items_markup .= sprintf('<div class="post-comments "> %1$s </div>', $number_commnet);
            }
            $list_items_markup .= sprintf('</div>');

            // Get the post title
            $title = get_the_title($post_id);
            if (!$title) {
                $title = __('Untitled');
            }

            $title_tag = $attributes['titleTag'];
            if ($title_tag == 'h1' || $title_tag == 'h2' || $title_tag == 'h3' || $title_tag == 'h4' || $title_tag == 'h5' || $title_tag == 'h6') {
                $post_title_tag = tag_escape($title_tag);
            } else {
                $post_title_tag = 'h2';
            }

            $list_items_markup .= sprintf('<div class="pl-blogpost-title"><%3$s class="pl-title"><a href="%1$s" rel="bookmark">%2$s</a></%3$s></div>', esc_url(get_permalink($post_id)), esc_html($title), esc_html($post_title_tag));

            // Wrap the excerpt content
            $list_items_markup .= sprintf('<div class="pl-blogpost-excerpt">');
            if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt']) {
                $list_items_markup .= post_layouts_get_excerpt($post_id, $post_query, $attributes);
            }

            //Display Readmore  
            if (isset($attributes['displayPostLink']) && $attributes['displayPostLink']) {

                if ($attributes['readmoreView'] == 'text-only') {

                    $list_items_markup .= sprintf('<p class="pl-text-only"><a class="pl-blogpost-link" href="%1$s" rel="bookmark">%2$s</a></p>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                } else if ($attributes['readmoreView'] == 'pl-button') {

                    $list_items_markup .= sprintf('<a class="pl-button pl-link gb-text-link" href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                }
            }

            // Close the excerpt content
            $list_items_markup .= sprintf('</div></div><div class="pl-blogpost-bototm-wrap">');
            if (isset($attributes['displayPostTag']) && $attributes['displayPostTag']) {
                $list_items_markup .= post_layouts_get_tags($post_id, '');
            }
            $list_items_markup .= sprintf('<div class="pl-social-wrap"><div class="social-share-data">');
            if (isset($attributes['displayPostSocialshare']) && $attributes['displayPostSocialshare']) {
                $list_items_markup .= post_layouts_get_social_share_icons($post_id);
            }
            $list_items_markup .= sprintf('</div></div></div>');
            $list_items_markup .= "</article>\n";
        }
    }
    return $list_items_markup;
}

/*
 *  List template 3
 */

function pl_list_layout3($attributes) {

    $args = array(
        'posts_per_page' => $attributes['postsToShow'],
        'post_status' => 'publish',
        'order' => $attributes['order'],
        'orderby' => $attributes['orderBy'],
        'cat' => !empty($attributes['categories']) ? $attributes['categories'] : '',
    );

    $post_query = new WP_Query($args);

    $list_items_markup = $post_thumb_id = '';

    if ($post_query->have_posts()) {

        //loop the query
        while ($post_query->have_posts()) {

            $post_query->the_post();

            // Get the post ID
            $post_id = get_the_ID();

            $post_thumb_id = get_post_thumbnail_id($post_id);

            if ($post_thumb_id && isset($attributes['displayPostImage']) && $attributes['displayPostImage']) {
                $post_thumb_class = 'has-thumb';
            } else {
                $post_thumb_class = 'no-thumb';
            }

            // Start the markup for the post
            $list_items_markup .= sprintf(
                    '<article class="%1$s pl-blog-template-3 pl-items-3"><div class="pl-clearfix"><div class="pl-first-inner-wrap">', esc_attr($post_thumb_class)
            );
            $list_items_markup .= post_layouts_get_featured_image($post_id, $attributes);

            // Wrap the text content
            $list_items_markup .= sprintf(
                    '<div class="pl-category-link-wraper">'
            );
            if (isset($attributes['displayPostCategory']) && $attributes['displayPostCategory']) {
                $list_items_markup .= post_layouts_get_category($post_id, "   ");
            }
            $list_items_markup .= sprintf(
                    '</div></div>'
            );
            $list_items_markup .= sprintf(
                    '<div class="pl-second-inner-wrap" >'
            );

            // Get the post title
            $title = get_the_title($post_id);
            if (!$title) {
                $title = __('Untitled');
            }

            $title_tag = $attributes['titleTag'];
            if ($title_tag == 'h1' || $title_tag == 'h2' || $title_tag == 'h3' || $title_tag == 'h4' || $title_tag == 'h5' || $title_tag == 'h6') {
                $post_title_tag = tag_escape($title_tag);
            } else {
                $post_title_tag = 'h2';
            }

            $list_items_markup .= sprintf('<div class="pl-blogpost-title"><%3$s class="pl-title"><a href="%1$s" rel="bookmark">%2$s</a></%3$s></div>', esc_url(get_permalink($post_id)), esc_html($title), esc_html($post_title_tag));

            // Wrap the byline content
            $list_items_markup .= sprintf(
                    '<div class="pl-blogpost-byline"> <div class=" metadatabox">'
            );
            if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor']) {
                $list_items_markup .= sprintf(
                        '<div class="post-author"><i class="fas fa-pencil-alt"></i><span class="pl-blogpost-author">'
                );
                $list_items_markup .= post_layouts_get_author($post_id);
                $list_items_markup .= sprintf(
                        '</div>'
                );
            }

            // Get the post date
            if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
                $list_items_markup .= sprintf(
                        '<div class="mdate "><i class="fas fa-calendar-alt"></i> %1$s </div>', get_the_date('F, Y', $post_id)
                );
            }

            //Get comments
            $comments = get_comments_number($post_id);

            if ($comments > 0) {
                $number_commnet = '<i class="far fa-comment"></i>' . $comments;
            } else {
                $number_commnet = '<i class="far fa-comment"></i> 0';
            }
            if (isset($attributes['displayPostComments']) && $attributes['displayPostComments']) {
                $list_items_markup .= sprintf(
                        '<div class="post-comments "> %1$s </div>', $number_commnet
                );
            }
            $list_items_markup .= sprintf('</div>');

            // Wrap the excerpt content
            $list_items_markup .= sprintf('<div class="pl-blogpost-excerpt">');
            if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt']) {
                $list_items_markup .= post_layouts_get_excerpt($post_id, $post_query, $attributes);
            }
            $list_items_markup .= sprintf('</div>');

            // Close the excerpt content
            $list_items_markup .= sprintf('<div class="pl-blogpost-bototm-wrap-3">');

            //Display Readmore  
            if (isset($attributes['displayPostLink']) && $attributes['displayPostLink']) {

                if ($attributes['readmoreView'] == 'text-only') {

                    $list_items_markup .= sprintf('<p class="pl-text-only"><a class="pl-blogpost-link" href="%1$s" rel="bookmark">%2$s</a></p>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                } else if ($attributes['readmoreView'] == 'pl-button') {

                    $list_items_markup .= sprintf('<div class="list-3-readview is-pl-inline"><a class="pl-button pl-link gb-text-link" href="%1$s" rel="bookmark">%2$s</a></div>', esc_url(get_permalink($post_id)), esc_html($attributes['readMoreText']));
                }
            }
            if (isset($attributes['displayPostTag']) && $attributes['displayPostTag']) {
                $list_items_markup .= post_layouts_get_tags($post_id, '<i class="fas fa-tags"></i>');
            }

            $list_items_markup .= sprintf(
                    '<div class="pl-social-wrap"><div class="social-share-data">'
            );
            if (isset($attributes['displayPostSocialshare']) && $attributes['displayPostSocialshare']) {
                $list_items_markup .= post_layouts_get_social_share_icons($post_id);
            }
            $list_items_markup .= sprintf(
                    '</div></div></div></div></div>'
            );
            $list_items_markup .= "</article>\n";
        }
    }
    return $list_items_markup;
}

/**
 * Registers the `core/latest-posts` block on server.
 */
function post_layouts_register_block_core_latest_posts() {

    // Check if the register function exists
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type('post-layouts/pl-blog-templates', array(
        'attributes' => array(
            'block_id' => array(
                'type' => 'string',
                'default' => 'not_set',
            ),
            'targetLevel' => array(
                'type' => 'string',
                'default' => '1',
            ),
            'targetLeveltwo' => array(
                'type' => 'string',
                'default' => '1',
            ),
            'categories' => array(
                'type' => 'string',
                'default' => '',
            ),
            'className' => array(
                'type' => 'string',
            ),
            'postsToShow' => array(
                'type' => 'number',
                'default' => 4,
            ),
            'displayPostDate' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayPostExcerpt' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'wordsExcerpt' => array(
                'type' => 'string',
                'default' => 25,
            ),
            'displayPostAuthor' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayPostTag' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayPostCategory' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayPostImage' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayPostLink' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayPostComments' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayPostSocialshare' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'isequalheight' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'postLayout' => array(
                'type' => 'string',
                'default' => 'grid',
            ),
            'columns' => array(
                'type' => 'number',
                'default' => 2,
            ),
            'align' => array(
                'type' => 'string',
                'default' => 'center',
            ),
            'width' => array(
                'type' => 'string',
                'default' => 'wide',
            ),
            'order' => array(
                'type' => 'string',
                'default' => 'desc',
            ),
            'orderBy' => array(
                'type' => 'string',
                'default' => 'date',
            ),
            'imageCrop' => array(
                'type' => 'string',
                'default' => 'landscape',
            ),
            'layoutcount' => array(
                'type' => 'number',
                'default' => 1,
            ),
            'layoutopt' => array(
                'type' => 'string',
                'default' => 'grid',
            ),
            'readMoreText' => array(
                'type' => 'string',
                'default' => 'Read More',
            ),
            'boxbgColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'listlayouttwobgColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'titleColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'postmetaColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'postexcerptColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'postctaColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'socialShareColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'titlefontSize' => array(
                'type' => 'number',
                'default' => '',
            ),
            'postmetafontSize' => array(
                'type' => 'number',
                'default' => '',
            ),
            'postexcerptfontSize' => array(
                'type' => 'number',
                'default' => '',
            ),
            'postctafontSize' => array(
                'type' => 'number',
                'default' => '',
            ),
            'socialSharefontSize' => array(
                'type' => 'number',
                'default' => '',
            ),
            'rowSpace' => array(
                'type' => 'number',
                'default' => 20,
            ),
            'columnSpace' => array(
                'type' => 'number',
                'default' => '20',
            ),
            'belowTitleSpace' => array(
                'type' => 'number',
                'default' => '',
            ),
            'belowImageSpace' => array(
                'type' => 'number',
                'default' => '',
            ),
            'belowexerptSpace' => array(
                'type' => 'number',
                'default' => '',
            ),
            'belowctaSpace' => array(
                'type' => 'number',
                'default' => 10,
            ),
            'innerSpace' => array(
                'type' => 'number',
                'default' => 20,
            ),
            'titleFontFamily' => array(
                'type' => 'string',
                'default' => '',
            ),
            'titleFontWeight' => array(
                'type' => 'string',
                'default' => '',
            ),
            'titleFontSubset' => array(
                'type' => 'string',
                'default' => '',
            ),
            'excerptFontFamily' => array(
                'type' => 'string',
                'default' => '',
            ),
            'excerptFontWeight' => array(
                'type' => 'string',
                'default' => '',
            ),
            'excerptFontSubset' => array(
                'type' => 'string',
                'default' => '',
            ),
            'metaFontFamily' => array(
                'type' => 'string',
                'default' => '',
            ),
            'metaFontSubset' => array(
                'type' => 'string',
                'default' => '',
            ),
            'metafontWeight' => array(
                'type' => 'string',
                'default' => '',
            ),
            'ctaFontFamily' => array(
                'type' => 'string',
                'default' => '',
            ),
            'ctaFontSubset' => array(
                'type' => 'string',
                'default' => '',
            ),
            'ctafontWeight' => array(
                'type' => 'string',
                'default' => '',
            ),
            'titleTag' => array(
                'type' => 'string',
                'default' => 'h3',
            ),
            'primaryColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'secondaryColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'readmoreView' => array(
                'type' => 'string',
                'default' => 'text-only',
            ),
            'readmoreBgColor' => array(
                'type' => 'string',
                'default' => '',
            ),
            'designtwoboxbgColor' => array(
                'type' => 'string',
                'default' => '',
            ),
        ),
        'render_callback' => 'post_layouts_block_render_block_core_latest_posts',
    ));
}

add_action('init', 'post_layouts_register_block_core_latest_posts');

/**
 * Create API fields for additional info
 */
function post_layouts_block_register_rest_fields() {

    // Add landscape featured image source
    register_rest_field(
            'post', 'featured_image_src', array(
        'get_callback' => 'post_layouts_block_get_image_src_landscape',
        'update_callback' => null,
        'schema' => null,
            )
    );

    // Add square featured image source
    register_rest_field(
            'post', 'featured_image_src_square', array(
        'get_callback' => 'post_layouts_block_get_image_src_square',
        'update_callback' => null,
        'schema' => null,
            )
    );

    // Add author info
    register_rest_field(
            'post', 'author_info', array(
        'get_callback' => 'post_layouts_block_get_author_info',
        'update_callback' => null,
        'schema' => null,
            )
    );

    // Add category info
    register_rest_field(
            'post', 'category_info', array(
        'get_callback' => 'post_layouts_block_get_catgeory_info',
        'update_callback' => null,
        'schema' => null,
            )
    );

    // Add tags info
    register_rest_field(
            'post', 'tags_info', array(
        'get_callback' => 'post_layouts_block_get_tags_info',
        'update_callback' => null,
        'schema' => null,
            )
    );

    // Add Social Share info
    register_rest_field(
            'post', 'social_share_info', array(
        'get_callback' => 'post_layouts_get_social_share_info',
        'update_callback' => null,
        'schema' => null,
            )
    );

    // Add Wordexerpt Info
    register_rest_field(
            'post', 'wordExcerpt_info', array(
        'get_callback' => 'post_layouts_grid_block_get_wordExcerpt',
        'update_callback' => null,
        'schema' => null,
            )
    );

    // Add Comment info
    register_rest_field(
            'post', 'comment_info', array(
        'get_callback' => 'post_layouts_get_comment_info',
        'update_callback' => null,
        'schema' => null,
            )
    );
}

add_action('rest_api_init', 'post_layouts_block_register_rest_fields');

/**
 * Get landscape featured image source for the rest field
 */
function post_layouts_block_get_image_src_landscape($object, $field_name, $request) {
    $feat_img_array = wp_get_attachment_image_src(
            $object['featured_media'], 'pl-blogpost-landscape', false
    );
    return $feat_img_array[0] ?? ' ';
}

/**
 * Get square featured image source for the rest field
 */
function post_layouts_block_get_image_src_square($object, $field_name, $request) {
    $feat_img_array = wp_get_attachment_image_src(
            $object['featured_media'], 'pl-blogpost-square', false
    );
    return $feat_img_array[0] ?? ' ';
}

/**
 * Get author info for the rest field
 */
function post_layouts_block_get_author_info($object, $field_name, $request) {

    // Get the author name
    $author_data['display_name'] = get_the_author_meta('display_name', $object['author']);

    // Get the author link
    $author_data['author_link'] = get_author_posts_url($object['author']);

    // Return the author data
    return $author_data;
}

/**
 * Get category info for the rest field
 */
function post_layouts_block_get_catgeory_info($object, $field_name, $request) {
    $object['ID'] = '';
    $categories_list = get_the_category_list(",", "", $object['ID']);
    $cat_class = '';

    $category_info = sprintf('%1$s', $categories_list);
    // Return the category data
    return $category_info;
}

/**
 * Get tags info for the rest field
 */
function post_layouts_block_get_tags_info($object, $field_name, $request) {
    // Get the author name
    $object['ID'] = '';
    $tags_list = get_the_tag_list("", ", ", "", $object['ID']);
    $tags_info = sprintf('%1$s', $tags_list);
    // Return the tag data
    return $tags_info;
}

/**
 * Get excerpt info for the rest field
 */
function post_layouts_grid_block_get_wordExcerpt($object, $field_name, $request) {
    $object['ID'] = '';

    $excerpt = apply_filters('the_excerpt', get_post_field('post_excerpt', $object['ID'], 'display'));

    if (empty($excerpt)) {
        $excerpt = apply_filters('the_excerpt', get_the_content($object['ID']));
    }

    if (!$excerpt) {
        $excerpt = null;
    }
    $list_items_markup = wp_kses_post($excerpt);

    return $list_items_markup;
}

/**
 * Get social share info for the rest field
 */
function post_layouts_get_social_share_info($object, $field_name, $request) {
    $object['ID'] = '';
    $social_share_info = sprintf('<a data-share="facebook" href="https://www.facebook.com/sharer.php?u=%1$s" class="pl-facebook-share social-share-default pl-social-share" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>', get_the_permalink($object['ID']));
    $social_share_info .= sprintf('<a data-share="twitter" href="https://twitter.com/share?url=%1$s" class="pl-twiiter-share social-share-default pl-social-share" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a>', get_the_permalink($object['ID']));
    $social_share_info .= sprintf('<a data-share="linkedin" href="https://www.linkedin.com/shareArticle?url=%1$s" class="pl-linkedin-share social-share-default pl-social-share" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>', get_the_permalink($object['ID']));
    return $social_share_info;
}

/**
 * Get comment count for the rest field
 */
function post_layouts_get_comment_info($object, $field_name, $request) {
    $object['ID'] = '';

    $comments = get_comments_number($object['ID']);
    if ($comments > 0) {
        return $comments . sprintf(" Comments");
    } else {
        return sprintf("No Comments");
    }
}

function remove_event_handlers($content) {
    // Regular expression to match event handler attributes (onload, onclick, etc.)   
    $pattern = '/\s*on\w+="[^"]*"/i';
    $sanitized_content = preg_replace($pattern, '', $content);
	
	$pattern = '/\s*on\w+=[^"]*/i';
    $sanitized_content = preg_replace($pattern, '', $sanitized_content);

    return $sanitized_content;    
}
