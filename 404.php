<?php get_header(); ?>
<?php get_template_part('partials/container'); ?>

   <main role="main">
      <section>
         <!-- space -->
         <div style="height:200px;">
            &nbsp;
         </div>
         <!-- /space -->
         <!-- error -->
         <div class="row text-center">
            <div class="col-sm-12 h1">
               <?php _e( 'Page not found', 'hvitur' ); ?> &ndash; 404
            </div>
            <div class="col-sm-12">
               <a href="<?php echo get_home_url(); ?>">&#8592; <?php _e( 'Go home', 'hvitur' ); ?></a>
            </div>
         </div>
         <!-- /error -->
      </section>
   </main>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
