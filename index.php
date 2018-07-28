<?php get_header(); ?>
<?php get_template_part('partials/container'); ?>

   <main role="main">
      <!-- section -->
      <section>
         <?php if(is_category() || is_tag()) : ?>
            <h1 class="page-title display-6"><?php printf(__('Everything about %s', 'hvitur'), '<strong>' . wp_title('', false) . '</strong>'); ?></h1>
            <hr>
         <?php endif; ?>
         <?php get_template_part('partials/loop'); ?>
         <?php get_template_part('partials/pagination'); ?>
      </section>
      <!-- /section -->
   </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
