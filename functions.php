<?php

/*
 *  Author: Maximilian Salomon
 *  URL:    salomax.de
 */

/*------------------------------------*\
  External modules/files
\*------------------------------------*/

// Load any external files you have here

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
   add_image_size('small', 150, '', true); // Small Thumbnail
   add_image_size('medium', 300, '', true); // Medium Thumbnail
   add_image_size('large', 600, '', true); // Large Thumbnail

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
      // conditionizr & modernizr
      // wp_enqueue_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.4.0.min.js', array(), '4.3.0');
      // wp_enqueue_script('modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');

      // prism.js (CDN)
      wp_enqueue_script('prism_js', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/prism.min.js');
      wp_enqueue_script('prism_js-java', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-java.min.js');
      wp_enqueue_script('prism_js-bash', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-bash.min.js');
      wp_enqueue_script('prism_js-linenumbers', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/plugins/line-numbers/prism-line-numbers.min.js');
      // wp_enqueue_script('prismJS-normalize-whitespace', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/plugins/normalize-whitespace/prism-normalize-whitespace.min.js');

      // bootstrap (CDN)
      wp_enqueue_script('jQuery_js', 'https://code.jquery.com/jquery-3.3.1.slim.min.js');
      wp_enqueue_script('pooper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js');
      wp_enqueue_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js');

      // custom scripts
      wp_enqueue_script('hvitur_scripts', get_template_directory_uri() . '/js/scripts.js', array(
         'jquery'
      ) , '1.0.0');
   }
}

/**
 * Load hvitur styles (style.css & bootstrap)
 */
function hvitur_styles() {
   wp_enqueue_style('hvitur', get_template_directory_uri() . '/style.css');

   // prism.js
   wp_enqueue_style('prism_css', get_template_directory_uri() . '/css/prism-light-gist.css');
   //wp_enqueue_style('prism_css', get_template_directory_uri() . '/css/prism-dark-darcula.css');
   wp_enqueue_style('prism_css-linenumbers', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/plugins/line-numbers/prism-line-numbers.min.css');

   // bootstrap (CDN)
   wp_enqueue_style('bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');

   // fontawesome (CDN) - imported by plugin: "Better Font Awesome"
   // wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
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
 * Remove injected classes, id's and page id's from navigation <li> items
 */
function my_css_attributes_filter($var) {
   return is_array($var) ? array() : '';
}

/**
 * Remove invalid "rel" attribute values in the category list
 */
function remove_category_rel_from_category_list($thelist) {
   return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

/**
 * Add page slug to body class, love this - Credit: Starkers Wordpress Theme
 */
function add_slug_to_body_class($classes) {
   global $post;
   if (is_home()) {
      $key = array_search('blog', $classes);
      if ($key > - 1) {
         unset($classes[$key]);
      }
   }
   elseif (is_page()) {
      $classes[] = sanitize_html_class($post->post_name);
   }
   elseif (is_singular()) {
      $classes[] = sanitize_html_class($post->post_name);
   }

   return $classes;
}

/**
 * Remove wp_head() injected recent comment styles
 */
function my_remove_recent_comments_style() {
   global $wp_widget_factory;
   remove_action('wp_head', array(
      $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
      'recent_comments_style'
   ));
}

/**
 * Pagination for paged posts, page 1, page 2, page 3, with next and previous links (no plugin!)
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
 * Changing excerpt length
 */
function overwrite_excerpt_length($length) {
   return 50;
}

/**
 * Changing excerpt "more"
 */
function overwrite_excerpt_more($more) {
   return sprintf(
      '&hellip;<br><div class="pt-2"><a href="%1$s">%2$s</a></div>',
      get_the_permalink(),
      __('Read More', 'hvitur')
   );
}

/**
 * Remove admin bar
 */
function overwrite_show_admin_bar() {
   return false;
}

/**
 * Remove 'text/css' from our enqueued stylesheet
 */
function html5_style_remove($tag) {
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
 * Custom gravatar in Settings > Discussion
 */
function hvitur_gravatar($avatar_defaults) {
   $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
   $avatar_defaults[$myavatar] = "Custom Gravatar";
   return $avatar_defaults;
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
 * Gets all images of all galleries and puts them together in one single bootstrap (v4) carousel
 */
function hvitur_galleries_to_carousel() {
   global $post;

   // only do this on singular items
   if (!is_singular()) return;
   // make sure the post has a gallery in it
   if (!has_shortcode($post->post_content, 'gallery')) return;

   // retrieve all galleries of this post and flatten them
   $galleries = get_post_galleries_images($post);
   $images = array();
   foreach ($galleries as $gallery) {
      foreach ($gallery as $image) {
         $images[] = $image;
      }
   }

   $carousel = '<div class="carousel slide carousel-fade" id="carousel" data-ride="carousel">';

   // image slides
   $carousel .= '<div class="carousel-inner" role="listbox">';
   foreach ($images as $i => $image) {
      if ($i == 0) {
         $carousel .= '<div class="carousel-item active">';
      }
      else {
         $carousel .= '<div class="carousel-item">';
      }
      $carousel .= '<div class="center-cropped"';
      $carousel .= 'style="min-height: calc(100vh - 3.5rem); background-image: url(\'' . $image . '\');">';
      $carousel .= '</div>';
      // add hidden div for preloading the next image
      if ($i < sizeof($images)) {
         $carousel .= '<div style="position:absolute; width:0; height:0; overflow:hidden; z-index:-1; content:';
         $carousel .= 'url(\'' . $images[$i + 1] . '\');"></div>';
      }

      $carousel .= '</div>';
   }
   $carousel .= '</div>';

   // indicators
   //   $carousel .= '<ol class="carousel-indicators">';
   //   for ($i = 0;$i < sizeof($images);$i++) {
   //      if ($i == 0) {
   //         $carousel .= '<li data-target="#carousel" data-slide-to="0" class="active"></li>';
   //      }
   //      else {
   //         $carousel .= '<li data-target="#carousel" data-slide-to="' . $i . '"></li>';
   //      }
   //   }
   //   $carousel .= '</ol>';

   // controlers
   $carousel .= '<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">';
   $carousel .= '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
   $carousel .= '<span class="sr-only">Previous</span>';
   $carousel .= '</a>';
   $carousel .= '<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">';
   $carousel .= '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
   $carousel .= '<span class="sr-only">Next</span>';
   $carousel .= '</a>';

   // edit button
   if (get_edit_post_link()) {
      $url = get_edit_post_link($post_id);
      $text = __('Edit this' , 'hvitur');
      $carousel .= '<a href="'. $url . '"
         target="_blank" class="btn btn-sm btn-outline-light"
         style="position: absolute; top: 12px; right: 8px; z-index=100">' . $text . '</a>';
   }

   $carousel .= '</div>';

   echo $carousel;
}

/**
 * Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address.
 */
function hide_email_shortcode($atts, $content = null) {
   if (!is_email($content)) {
      return;
   }
   return '<a href="mailto:' . antispambot($content) . '">' . antispambot($content) . '</a>';
}

/**
 * Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address.
 */
function hide_email_shortcode2($atts, $content = null) {
   if (!is_email($content)) {
      return;
   }
   return '<a href="mailto:' . antispambot($content) . '">Email</a>';
}

/**
 * Calculates the current age, given a birthdate.
 * Could also be used for anniversaries or any other recurring events.
 *
 * @param string $birthday The date, formatted as dd.MM.yyyy. e.g. 28.12.1969
 *
 * @return string The years since the given date to now as a whole number.
 */
function whats_my_age_again($birthday) {
   extract(shortcode_atts(array(
      'birthday' => 'birthday'
   ) , $birthday));
   $birthday = date("Ymd", strtotime($birthday));
   $diff = date("Ymd") - $birthday;
   return substr($diff, 0, -4);
}

/**
 * Default edit post link:
 * Open in new page and display in red. Also provides translation.
 */
function my_edit_post_link($link, $post_id, $text) {
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
add_action('get_header', 'enable_threaded_comments'); // enable threaded comments
add_action('init', 'hvitur_galleries_to_carousel');
add_action('init', 'hvitur_header_scripts'); // add custom scripts to wp_head
add_action('init', 'hvitur_pagination'); // add our hvitur pagination
add_action('init', 'register_hvitur_menu'); // add hvitur menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // remove inline "recent comment" styles from wp_head()
add_action('wp_enqueue_scripts', 'hvitur_styles'); // add (theme) stylesheet
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'feed_links', 2); // display the links to the general feeds: post and comment feed
remove_action('wp_head', 'feed_links_extra', 3); // display the links to the extra feeds such as category feeds
remove_action('wp_head', 'index_rel_link'); // index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // prev link
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'rsd_link'); // display the link to the really simple discovery service endpoint, edituri link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // start link
remove_action('wp_head', 'wlwmanifest_link'); // display the link to the windows live writer manifest file.
remove_action('wp_head', 'wp_generator'); // display the xhtml generator that is generated on the wp_head hook, wp version
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Filters
add_filter('avatar_defaults', 'hvitur_gravatar'); // custom gravatar in settings > discussion
add_filter('body_class', 'add_slug_to_body_class'); // add slug to body class (starkers build)
add_filter('edit_post_link', 'my_edit_post_link', 10, 3);
add_filter('excerpt_length', 'overwrite_excerpt_length');
add_filter('excerpt_more', 'overwrite_excerpt_more');
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // remove width and height dynamic attributes to post images
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // remove width and height dynamic attributes to thumbnails
add_filter('show_admin_bar', 'overwrite_show_admin_bar');
add_filter('style_loader_tag', 'html5_style_remove'); // remove 'text/css' from enqueued stylesheet
add_filter('the_category', 'remove_category_rel_from_category_list'); // remove invalid rel attribute
add_filter('the_excerpt', 'do_shortcode'); // allows shortcodes to be executed in excerpt (manual excerpts only)
add_filter('the_excerpt', 'shortcode_unautop'); // remove auto <p> tags in excerpt (manual excerpts only)
add_filter('widget_text', 'do_shortcode'); // allow shortcodes in dynamic sidebar
add_filter('widget_text', 'shortcode_unautop'); // remove <p> tags in dynamic sidebars (better!)
add_filter('wp_link_pages_args', 'hvitur_add_next_and_number');
add_filter('wp_link_pages_link', 'hvitur_link_pages_link', 10, 2);
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // remove surrounding <div> from wp navigation
remove_filter('the_content', 'wpautop'); // remove <p> tags from excerpt pages
remove_filter('the_excerpt', 'wpautop'); // remove <p> tags from excerpt

// Shortcodes
add_shortcode('email', 'hide_email_shortcode');
add_shortcode('email2', 'hide_email_shortcode2');
add_shortcode('yearsSince', 'whats_my_age_again');

// Register custom navigation walkers
require_once ('functions/bs4navwalker.php');
require_once ('functions/inlinelistwalker.php');

// If dynamic sidebar exists
if (function_exists('register_sidebar')) {
   // Define sidebar widget area 1
   register_sidebar(array(
      'name' => __('Widget Area 1', 'hvitur') ,
      'description' => __('Description for this widget-area...', 'hvitur') ,
      'id' => 'widget-area-1',
      'before_widget' => '<div id="%1$s" class="%2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
   ));

   // Define sidebar widget area 2
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
