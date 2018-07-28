<?php
/*
 *  Author: Maximilian Salomon
 *  URL:    salomax.de
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
  External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
  Make localizable
\*------------------------------------*/
load_theme_textdomain( 'hvitur', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
   require_once($locale_file);

/*------------------------------------*\
  Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
   $content_width = 900;
}

if (function_exists('add_theme_support'))
{
   // Add Thumbnail Theme Support
   add_theme_support('post-thumbnails');
   add_image_size('small',  150, '', true); // Small Thumbnail
   add_image_size('medium', 300, '', true); // Medium Thumbnail
   add_image_size('large',  600, '', true); // Large Thumbnail

   // Enables post and comment RSS feed links to head
   add_theme_support('automatic-feed-links');

   // Enable HTML5 support
   add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
}

/*------------------------------------*\
  Functions
\*------------------------------------*/

// Load Hvítur scripts (header.php)
function hvitur_header_scripts()
{
   if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
      /* conditionizr */
      //wp_enqueue_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.4.0.min.js', array(), '4.3.0');

      /* modernizr */
      //wp_enqueue_script('modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');

      /* prism.js (CDN) */
      wp_enqueue_script('prism_js',             'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/prism.min.js');
      wp_enqueue_script('prism_js-java',        'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-java.min.js');
      wp_enqueue_script('prism_js-bash',        'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-bash.min.js');
      wp_enqueue_script('prism_js-linenumbers', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/plugins/line-numbers/prism-line-numbers.min.js');
      #wp_enqueue_script('prismJS-normalize-whitespace', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/plugins/normalize-whitespace/prism-normalize-whitespace.min.js');

      /* bootstrap (CDN) */
      wp_enqueue_script('jQuery_js',    'https://code.jquery.com/jquery-3.2.1.slim.min.js');
      wp_enqueue_script('pooper_js',    'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
      wp_enqueue_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js');

      /* custom scripts */
      wp_enqueue_script('hvitur_scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0');
   }
}

// Load Hvítur styles (style.css & bootstrap)
function hvitur_styles()
{
   wp_enqueue_style('hvitur', get_template_directory_uri() . '/style.css');

   /* prism.js */
   wp_enqueue_style('prism_css', get_template_directory_uri() . '/css/prism-tomorrow.css');
   wp_enqueue_style('prism_css-linenumbers', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/plugins/line-numbers/prism-line-numbers.min.css');

   /* bootstrap (CDN) */
   wp_enqueue_style('bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');

   /* fontawesome (CDN) - imported by plugin: "Better Font Awesome" */
   //wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
}

// Register hvitur Navigation
function register_hvitur_menu()
{
   register_nav_menus(array(// Using array to specify more menus if needed
      'menu-1' => esc_html__('Primary-left', 'hvitur'),
      'menu-2' => esc_html__('Primary-right', 'hvitur'),
      'menu-3' => esc_html__('Footer', 'hvitur')
 ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
   $args['container'] = false;
   return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
   return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
   return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
   global $post;
   if (is_home()) {
      $key = array_search('blog', $classes);
      if ($key > -1) {
         unset($classes[$key]);
      }
   } elseif (is_page()) {
      $classes[] = sanitize_html_class($post->post_name);
   } elseif (is_singular()) {
      $classes[] = sanitize_html_class($post->post_name);
   }

   return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
   // Define Sidebar Widget Area 1
   register_sidebar(array(
      'name' => __('Widget Area 1', 'hvitur'),
      'description' => __('Description for this widget-area...', 'hvitur'),
      'id' => 'widget-area-1',
      'before_widget' => '<div id="%1$s" class="%2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
 ));

   // Define Sidebar Widget Area 2
   register_sidebar(array(
      'name' => __('Widget Area 2', 'hvitur'),
      'description' => __('Description for this widget-area...', 'hvitur'),
      'id' => 'widget-area-2',
      'before_widget' => '<div id="%1$s" class="%2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
 ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
   global $wp_widget_factory;
   remove_action('wp_head', array(
      $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
      'recent_comments_style'
 ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function hvitur_pagination()
{
   global $wp_query;
   $big = 999999999;
   echo paginate_links(array(
      'base' => str_replace($big, '%#%', get_pagenum_link($big)),
      'format' => '?paged=%#%',
      'current' => max(1, get_query_var('paged')),
      'total' => $wp_query->max_num_pages
 ));
}

// Changing excerpt length
function new_excerpt_length($length) {
   return 25;
}

// Changing excerpt "more"
function new_excerpt_more($more) {
   return ' [&hellip;]';}

// Remove Admin bar
function remove_admin_bar()
{
   return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
   return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions($html)
{
   $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
   return $html;
}

// Custom Gravatar in Settings > Discussion
function hvitur_gravatar ($avatar_defaults)
{
   $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
   $avatar_defaults[$myavatar] = "Custom Gravatar";
   return $avatar_defaults;
}

// 
function hvitur_link_pages_link($link, $i)
{
   //add "page-link"-class to current page
   if ( strpos($link, 'a href') == false ) {
      $link = '<p class="page-link">' . $link . "</p>";
   } else {
      // add "page-link"-class to all other pages
      $link = str_replace('a href', 'a class="page-link" href', $link);
   }
   // disable current page
   global $page;
   global $index;
   if ( strip_tags($link) == $page ) {
      return '<li class="page-item  active">' . $link . '</li>';
   } else {
      return '<li class="page-item">' . $link . '</li>';
   }
}

// Add "Next" and "Previous" in addition to page numbers"
function hvitur_add_next_and_number($args)
{
   if($args['next_or_number'] == 'next_and_number')
   {
      global $page, $numpages, $multipage, $more, $pagenow;
      $args['next_or_number'] = 'number';
      $prev = '';
      $next = '';
      if ( $multipage )
      {
         if ( $more )
         {
            $i = $page - 1;
            if ( $i && $more )
            {
               $prev .= '<li class="page-item">';
               $prev .= str_replace('a href', 'a class="page-link" href', _wp_link_page($i));
               $prev .= $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a></li>';
            }
            $i = $page + 1;
            if ( $i <= $numpages && $more ) {
               $next .= '<li class="page-item">';
               $next .= str_replace('a href', 'a class="page-link" href', _wp_link_page($i));
               $next .= $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>';
            }
         }
      }
      $args['before'] = $args['before'].$prev;
      $args['after'] = $next.$args['after'];
   }
   return $args;
}

// Threaded Comments
function enable_threaded_comments()
{
   if (!is_admin()) {
      if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
         wp_enqueue_script('comment-reply');
      }
   }
}

// Custom Comments Callback
function hvitur_comments($comment, $args, $depth)
{
   $GLOBALS['comment'] = $comment;
   extract($args, EXTR_SKIP);

   if ('div' == $args['style']) {
      $tag = 'div';
      $add_below = 'comment';
   } else {
      $tag = 'li';
      $add_below = 'div-comment';
   }
?>
   <!-- heads up: starting < for the html tag (li or div) in the next line: -->
   <<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
   <?php if ('div' != $args['style']) : ?>
   <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
   <?php endif; ?>
   <div class="comment-author vcard">
   <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['180']); ?>
   <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
   </div>
<?php if ($comment->comment_approved == '0') : ?>
   <em class="comment-awaiting-moderation">Your comment is awaiting moderation.</em>
   <br />
<?php endif; ?>

   <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">
      <?php
         printf(__('%1$s at %2$s', 'hvitur'), get_comment_date(), get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'hvitur'),'  ','');
      ?>
   </div>

   <?php comment_text() ?>

   <div class="reply">
   <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
   </div>
   <?php if ('div' != $args['style']) : ?>
   </div>
   <?php endif; ?>
<?php }


// Gets all images of all galleries and puts them together in one single bootstrap (v4) carousel
function hvitur_galleries_to_carousel() {
   global $post;

   // only do this on singular items
   if (!is_singular())
      return;
   // make sure the post has a gallery in it
   if (!has_shortcode($post->post_content, 'gallery'))
      return;

   // retrieve all galleries of this post and flatten them
   $galleries = get_post_galleries_images( $post );
   $images = array();
   foreach( $galleries as $gallery ) {
      foreach( $gallery as $image ) {
         $images[] = $image;
      }
   }

   $carousel = '<div class="carousel slide carousel-fade" id="carousel" data-ride="carousel">';

   // image slides
   $carousel .= '<div class="carousel-inner" role="listbox">';
   foreach ( $images as $i => $image ) {
      if ( $i==0 ) {
         $carousel .= '<div class="carousel-item active">';
      } else {
         $carousel .= '<div class="carousel-item">';
      }
      $carousel .= '<div class="center-cropped"';
      $carousel .= 'style="min-height: calc(100vh - 3.5rem); background-image: url(\'' . $image . '\');">';
      $carousel .= '</div>';
      // add hidden div for preloading the next image
      if ( $i < sizeof($images) ) {
         $carousel .= '<div style="position:absolute; width:0; height:0; overflow:hidden; z-index:-1; content:';
         $carousel .= 'url(\'' . $images[$i+1] . '\');"></div>';
      }
      
      $carousel .= '</div>';
   }
   $carousel .= '</div>';

   // indicators
   $carousel .= '<ol class="carousel-indicators">';
   for ( $i = 0; $i < sizeof($images); $i++ ) {
      if( $i==0 ) {
         $carousel .= '<li data-target="#carousel" data-slide-to="0" class="active"></li>';
      } else {
         $carousel .= '<li data-target="#carousel" data-slide-to="' . $i . '"></li>';
      }
   }
   $carousel .= '</ol>';

   // controlers
   $carousel .= '<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">';
   $carousel .= '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
   $carousel .= '<span class="sr-only">Previous</span>';
   $carousel .= '</a>';
   $carousel .= '<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">';
   $carousel .= '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
   $carousel .= '<span class="sr-only">Next</span>';
   $carousel .= '</a>';

   $carousel .= '</div>';

   echo $carousel;
}

/*------------------------------------*\
  Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init',               'hvitur_header_scripts');           // Add Custom Scripts to wp_head
add_action('wp_print_scripts',   'hvitur_conditional_scripts');      // Add Conditional Page Scripts
add_action('get_header',         'enable_threaded_comments');        // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'hvitur_styles');                   // Add (Theme) Stylesheet
add_action('init',               'register_hvitur_menu');            // Add Hvítur Menu
add_action('widgets_init',       'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init',               'hvitur_pagination');               // Add our Hvítur Pagination
add_action('init',               'hvitur_galleries_to_carousel');

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3);                    // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2);                          // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link');                               // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link');                       // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link');                         // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0);            // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0);             // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);         // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator');                           // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults',      'hvitur_gravatar');                        // Custom Gravatar in Settings > Discussion
add_filter('body_class',           'add_slug_to_body_class');                 // Add slug to body class (Starkers build)
add_filter('widget_text',          'do_shortcode');                           // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text',          'shortcode_unautop');                      // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args',     'my_wp_nav_menu_args');                    // Remove surrounding <div> from WP Navigation
add_filter('the_category',         'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt',          'shortcode_unautop');                      // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt',          'do_shortcode');                           // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('show_admin_bar',       'remove_admin_bar');                       // Remove Admin bar
add_filter('style_loader_tag',     'html5_style_remove');                     // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html',  'remove_thumbnail_dimensions', 10);        // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);        // Remove width and height dynamic attributes to post images
add_filter('excerpt_length',       'new_excerpt_length');
add_filter('excerpt_more',         'new_excerpt_more');
add_filter('wp_link_pages_link',   'hvitur_link_pages_link', 10, 2);
add_filter('wp_link_pages_args',   'hvitur_add_next_and_number');

// Remove Filters
remove_filter('the_content', 'wpautop'); // Remove <p> tags from Excerpt pages
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt

// Shortcodes
add_shortcode('email',  'hvitur_hide_email_shortcode');
add_shortcode('email2', 'hvitur_hide_email_shortcode2');
add_shortcode('yearsSince', 'whats_my_age_again');

/*------------------------------------*\
  Hide Email from Bots
\*------------------------------------*/

/**
 * Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address. 
 */
function hvitur_hide_email_shortcode($atts , $content = null)
{
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
function hvitur_hide_email_shortcode2($atts , $content = null)
{
   if (!is_email($content)) {
      return;
   }
   return '<a href="mailto:' . antispambot($content) . '">Email</a>';
}

/**
 * 
 */
function whats_my_age_again($birthday)
{
   extract( shortcode_atts( array(
      'birthday' => 'birthday'
   ), $birthday));
   $birthday = date("Ymd", strtotime($birthday));
   $diff = date("Ymd") - $birthday;
   return substr($diff, 0, -4);
}

/**
 * Register Custom Navigation Walkers
 */
require_once('functions/bs4navwalker.php');
require_once('functions/inlinelistwalker.php');

?>
