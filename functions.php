<?php

/*
 *  Author: Maximilian Salomon
 *  URL:    salomax.de
 */

/*------------------------------------*\
  External modules/files
\*------------------------------------*/

require_once (__DIR__ . '/functions/bs4navwalker.php');
require_once (__DIR__ . '/functions/carousel.php');
require_once (__DIR__ . '/functions/excerpts.php');
require_once (__DIR__ . '/functions/inlinelistwalker.php');
require_once (__DIR__ . '/functions/shortcodes.php');

/*------------------------------------*\
  Make localizable
\*------------------------------------*/

load_theme_textdomain('hvitur', TEMPLATEPATH . '/languages');
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if (is_readable($locale_file)) {
   require_once ($locale_file);
}

/*------------------------------------*\
  Theme support
\*------------------------------------*/

if (!isset($content_width)) {
   $content_width = 900;
}

if (function_exists('add_theme_support')) {
   // add thumbnail support
   add_theme_support('post-thumbnails');
   add_image_size('small',  150, '', true); // small thumbnail
   add_image_size('medium', 300, '', true); // medium thumbnail
   add_image_size('large',  600, '', true); // large thumbnail

   // enable post and comment RSS feed links to head
   add_theme_support('automatic-feed-links');

   // enable HTML5 support
   add_theme_support('html5', array(
      'comment-list',
      'comment-form',
      'search-form',
      'gallery',
      'caption'
   ));
}

/*------------------------------------*\
  Functions
\*------------------------------------*/

/**
 * Load hvitur scripts (header.php)
 */
function hvitur_header_scripts() {
   if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
      // bootstrap
      wp_enqueue_script('jQuery_js',                    'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.js');
      wp_enqueue_script('pooper_js',                    'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js');
      wp_enqueue_script('bootstrap_js',                 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js');
      // prism.js
      wp_enqueue_script('prism_js',                     'https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/prism.min.js');
      wp_enqueue_script('prism_js-json',                'https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/components/prism-json.min.js');
      wp_enqueue_script('prism_js-bash',                'https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/components/prism-bash.min.js');
      wp_enqueue_script('prism_js-linenumbers',         'https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/plugins/line-numbers/prism-line-numbers.min.js');
      wp_enqueue_script('prism_js-autolinker',          'https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/plugins/autolinker/prism-autolinker.js');
      wp_enqueue_script('prismJS-normalize-whitespace', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/plugins/normalize-whitespace/prism-normalize-whitespace.min.js');
      // custom scripts
      wp_enqueue_script('hvitur_scripts',                get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0');
   }
}

/**
 * Load hvitur styles (style.css & bootstrap)
 */
function hvitur_styles() {
   wp_enqueue_style('hvitur',                 get_template_directory_uri() . '/style.css');
   // prism.js
   wp_enqueue_style('prism_css',              get_template_directory_uri() . '/css/hvitur-prism-dark.min.css');
   wp_enqueue_style('prism_css-linenumbers', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/plugins/line-numbers/prism-line-numbers.min.css');
   wp_enqueue_style('prism_css-autolinker',  'https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/plugins/autolinker/prism-autolinker.css');
   // bootstrap
   wp_enqueue_style('bootstrap_css',          get_template_directory_uri() . '/css/hvitur.min.css');
   // fontawesome - alredy imported by plugin: "Better Font Awesome"
   //wp_enqueue_style('fontawesome',         'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
}

/**
 * Register hvitur navigation
 */
function register_hvitur_menu() {
   register_nav_menus(array(
      'menu-1' => esc_html__('Primary-left', 'hvitur') ,
      'menu-2' => esc_html__('Primary-right', 'hvitur') ,
      'menu-3' => esc_html__('Footer', 'hvitur')
   ));
}

/**
 * Remove the <div> surrounding the dynamic navigation to cleanup markup
 */
function my_wp_nav_menu_args($args = '') {
   $args['container'] = false;
   return $args;
}

/**
 * Preserve leading underscores in file names during upload
 */
function preserve_leading_underscore($filename, $filename_raw) {
    if( "_" == substr($filename_raw, 0, 1) ) {
        $filename = "_" . $filename;
    }

    return $filename;
}

/**
 * Remove invalid "rel" attribute values in the category list
 */
function remove_category_rel_from_category_list($thelist) {
   return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

/**
 * Remove wp_head() injected recent comment styles
 */
function remove_recent_comments_css() {
   global $wp_widget_factory;
   remove_action('wp_head', array(
      $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
      'recent_comments_style'
   ));
}

/**
 * Pagination for paged posts, page 1, page 2, page 3, with next and previous links
 */
function hvitur_pagination() {
   global $wp_query;
   $big = 999999999;
   echo paginate_links(array(
      'base' => str_replace($big, '%#%', get_pagenum_link($big)) ,
      'format' => '?paged=%#%',
      'current' => max(1, get_query_var('paged')) ,
      'total' => $wp_query->max_num_pages
   ));
}

/**
 * Remove admin bar
 */
function overwrite_show_admin_bar() {
   return false;
}

/**
 * Remove type="text/css" from enqueued stylesheets -> not necessary
 */
function hvitur_remove_textcss($tag) {
   return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

/**
 * Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
 */
function remove_thumbnail_dimensions($html) {
   $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
   return $html;
}

/**
 *
 */
function hvitur_link_pages_link($link, $i) {
   //add "page-link"-class to current page
   if (strpos($link, 'a href') == false) {
      $link = '<p class="page-link">' . $link . "</p>";
   }
   else {
      // add "page-link"-class to all other pages
      $link = str_replace('a href', 'a class="page-link" href', $link);
   }
   // disable current page
   global $page;
   global $index;
   if (strip_tags($link) == $page) {
      return '<li class="page-item  active">' . $link . '</li>';
   }
   else {
      return '<li class="page-item">' . $link . '</li>';
   }
}

/**
 * Add "Next" and "Previous" in addition to page numbers
 */
function hvitur_add_next_and_number($args) {
   if ($args['next_or_number'] == 'next_and_number') {
      global $page, $numpages, $multipage, $more, $pagenow;
      $args['next_or_number'] = 'number';
      $prev = '';
      $next = '';
      if ($multipage) {
         if ($more) {
            $i = $page - 1;
            if ($i && $more) {
               $prev .= '<li class="page-item">';
               $prev .= str_replace('a href', 'a class="page-link" href', _wp_link_page($i));
               $prev .= $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a></li>';
            }
            $i = $page + 1;
            if ($i <= $numpages && $more) {
               $next .= '<li class="page-item">';
               $next .= str_replace('a href', 'a class="page-link" href', _wp_link_page($i));
               $next .= $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>';
            }
         }
      }
      $args['before'] = $args['before'] . $prev;
      $args['after'] = $next . $args['after'];
   }
   return $args;
}

/**
 * Threaded comments
 */
function enable_threaded_comments() {
   if (!is_admin()) {
      if (is_singular() and comments_open() and (get_option('thread_comments') == 1)) {
         wp_enqueue_script('comment-reply');
      }
   }
}

/**
 * Default edit post link:
 * Open in new page and display in red. Also provides translation.
 */
function hvitur_edit_post_link($link, $post_id, $text) {
   $url = get_edit_post_link($post_id);
   $text = __('Edit this' , 'hvitur');
   return '<a href="' . $url . '" target="_blank" class="text-danger">' . $text . '</a>';
}

/**
 * Custom comments callback
 */
function hvitur_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
   extract($args, EXTR_SKIP);

   if ('div' == $args['style']) {
      $tag = 'div';
      $add_below = 'comment';
   }
   else {
      $tag = 'li';
      $add_below = 'div-comment';
   }
?>
   <!-- heads up: starting < for the html tag (li or div) in the next line: -->
   <<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
   <?php if ('div' != $args['style']): ?>
   <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
   <?php
   endif; ?>
   <div class="comment-author vcard">
   <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['180']); ?>
   <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>') , get_comment_author_link()) ?>
   </div>
<?php if ($comment->comment_approved == '0'): ?>
   <em class="comment-awaiting-moderation">Your comment is awaiting moderation.</em>
   <br />
<?php
   endif; ?>

   <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">
      <?php
   printf(__('%1$s at %2$s', 'hvitur') , get_comment_date() , get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'hvitur') , '  ', '');
?>
   </div>

   <?php comment_text() ?>

   <div class="reply">
   <?php comment_reply_link(array_merge($args, array(
      'add_below' => $add_below,
      'depth' => $depth,
      'max_depth' => $args['max_depth']
   ))) ?>
   </div>
   <?php if ('div' != $args['style']): ?>
   </div>
   <?php
   endif; ?>
<?php
}

/*------------------------------------*\
  Actions + Filters + ShortCodes
\*------------------------------------*/

// actions
add_action   ('get_header',                      'enable_threaded_comments');               // enable threaded comments
add_action   ('init',                            'hvitur_galleries_to_carousel');           // functions/carousel.php
add_action   ('init',                            'hvitur_header_scripts');                  // add custom scripts to wp_head
add_action   ('init',                            'hvitur_pagination');                      // add our hvitur pagination
add_action   ('init',                            'register_hvitur_menu');                   // add hvitur menu
add_action   ('widgets_init',                    'remove_recent_comments_css');             // remove inline "recent comment" styles from wp_head()
add_action   ('wp_enqueue_scripts',              'hvitur_styles');                          // add (theme) stylesheet
remove_action('wp_head',                         'adjacent_posts_rel_link', 10, 0);         // display relational links for the posts adjacent to the current post.
remove_action('wp_head',                         'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head',                         'feed_links', 2);                          // display the links to the general feeds: post and comment feed
remove_action('wp_head',                         'feed_links_extra', 3);                    // display the links to the extra feeds such as category feeds
remove_action('wp_head',                         'index_rel_link');                         // index link
remove_action('wp_head',                         'parent_post_rel_link', 10, 0);            // prev link
remove_action('wp_head',                         'rel_canonical');
remove_action('wp_head',                         'rsd_link');                               // display the link to the really simple discovery service endpoint, edituri link
remove_action('wp_head',                         'start_post_rel_link', 10, 0);             // start link
remove_action('wp_head',                         'wlwmanifest_link');                       // display the link to the windows live writer manifest file.
remove_action('wp_head',                         'wp_generator');                           // display the xhtml generator that is generated on the wp_head hook, wp version
remove_action('wp_head',                         'wp_shortlink_wp_head', 10, 0);

// filters
add_filter   ('edit_post_link',                  'hvitur_edit_post_link', 10, 3);
add_filter   ('excerpt_length',                  'overwrite_excerpt_length');
add_filter   ('excerpt_more',                    'overwrite_excerpt_more');
add_filter   ('image_send_to_editor',            'remove_thumbnail_dimensions', 10);        // remove width and height dynamic attributes to post images
add_filter   ('post_thumbnail_html',             'remove_thumbnail_dimensions', 10);        // remove width and height dynamic attributes to thumbnails
add_filter   ('sanitize_file_name',              'preserve_leading_underscore', 10, 2);     // don't strip leading underscores of uploaded files names
add_filter   ('show_admin_bar',                  'overwrite_show_admin_bar');
add_filter   ('style_loader_tag',                'hvitur_remove_textcss');                  // remove 'text/css' from enqueued stylesheet
add_filter   ('the_category',                    'remove_category_rel_from_category_list'); // remove invalid rel attribute
add_filter   ('the_excerpt',                     'do_shortcode');                           // allows shortcodes to be executed in excerpt (manual excerpts only)
add_filter   ('the_excerpt',                     'overwrite_the_excerpt');
add_filter   ('the_excerpt',                     'shortcode_unautop');                      // disable automatic <p> tags in the excerpt (manual excerpts only)
add_filter   ('widget_text',                     'do_shortcode');                           // allow shortcodes in dynamic sidebar
add_filter   ('widget_text',                     'shortcode_unautop');                      // remove <p> tags in dynamic sidebars (better!)
add_filter   ('wp_feed_cache_transient_lifetime', create_function('', 'return 7200;'));     // 2h rss feed refresh time
add_filter   ('wp_link_pages_args',              'hvitur_add_next_and_number');
add_filter   ('wp_link_pages_link',              'hvitur_link_pages_link', 10, 2);
add_filter   ('wp_nav_menu_args',                'my_wp_nav_menu_args');                    // remove surrounding <div> from wp navigation
remove_filter('the_content',                     'wpautop');                                // disable automatic <p> tags in excerpt pages
remove_filter('the_excerpt',                     'wpautop');                                // disable automatic <p> tags in the excerpt

// shortcodes
add_shortcode('email',                           'shortcode_hide_email');                   // functions/shortcodes.php
add_shortcode('email2',                          'shortcode_hide_email2');                  // functions/shortcodes.php
add_shortcode('yearsSince',                      'shortcode_whats_my_age_again');           // functions/shortcodes.php
add_shortcode('code',                            'shortcode_codeblock');                    // functions/shortcodes.php
add_shortcode('kbd',                             'shortcode_kbd');                          // functions/shortcodes.php

// if dynamic sidebar exists
if (function_exists('register_sidebar')) {
   // define sidebar widget area 1
   register_sidebar(array(
      'name' => __('Widget Area 1', 'hvitur') ,
      'description' => __('Description for this widget-area...', 'hvitur') ,
      'id' => 'widget-area-1',
      'before_widget' => '<div id="%1$s" class="%2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
   ));

   // define sidebar widget area 2
   register_sidebar(array(
      'name' => __('Widget Area 2', 'hvitur') ,
      'description' => __('Description for this widget-area...', 'hvitur') ,
      'id' => 'widget-area-2',
      'before_widget' => '<div id="%1$s" class="%2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
   ));
}

?>
