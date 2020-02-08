<?php
/**
 * Template Name: Archive Portfolio Template
 */

// wp_enqueue_style('jg_js', 'https://unpkg.com/justifiedGallery/dist/css/justifiedGallery.min.css');
// wp_enqueue_script('jg_css', 'https://unpkg.com/justifiedGallery/dist/js/jquery.justifiedGallery.min.js');

get_header();
get_template_part('partials/container');

// query_posts(array('post_type'=>'portfolio'));
$args = array( 'post_type' => 'portfolio', 'orderby' => 'post_date', 'posts_per_page' => '30' );
$loop = new WP_Query( $args ); ?>

<?php if($loop->have_posts()): ?>

   <!-- title -->
   <h1 class="page-title display-6"><?php printf('<strong>' . wp_title('', false) . '</strong>'); ?></h1>
   <hr>
   <!-- /title -->

   <!-- gallery -->
   <?php $sc = '[gallery ids="' ?>

   <?php while($loop->have_posts()): $loop->the_post(); ?>
      <?php $sc .= get_post_thumbnail_id() . ', ' ?>
   <?php endwhile; ?>

   <?php $sc .= '"]' ?>
   <?php echo do_shortcode($sc); ?>
   <!-- /gallery -->

<?php endif; ?>

<!--
<script type="text/javascript">
(function($) {
   $("#mygallery").justifiedGallery({
      rowHeight : 250,
      lastRow : 'nojustify',
      margins : 12,
      border : 0,
      captions : true,
      captions : false
   });
}(jQuery))
</script>
-->


<?php
get_sidebar();
get_footer(); ?>
