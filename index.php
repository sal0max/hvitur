<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header();
get_template_part('partials/container'); ?>

   <main>
      <!-- category or tag: set title -->
      <?php if(is_category() || is_tag()) : ?>
         <h1 class="page-title display-6"><?php printf(__('Everything about %s', 'hvitur'), '<strong>' . wp_title('', false) . '</strong>'); ?></h1>
         <hr>
      <?php endif; ?>
      <!-- /category or tag: set title -->
      <?php get_template_part('partials/loop'); ?>
      <?php get_template_part('partials/pagination'); ?>
   </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
