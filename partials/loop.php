<!--
   ...
   ...
-->
<?php if (have_posts()): ?>

   <?php while (have_posts()) : the_post(); ?>
      <article class="mb-5" id="post-<?php the_ID(); ?>">

         <div>
            <!-- date -->
            <span class="small font-weight-light text-muted">
               <?php echo get_the_date(); ?>
            </span>
            <!-- /date -->

            <!-- title -->
            <div class="text-left">
               <a class="h3" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </div>
            <!-- /title -->

            <!-- excerpt -->
            <?php the_excerpt(); ?>
            <!-- /excerpt -->
         </div>

      </article>
   <?php endwhile; ?>

<?php else: ?>
   <!-- error message -->
   <article>
      <h2><?php _e('Sorry, nothing to display.', 'hvitur'); ?></h2>
   </article>
   <!-- /error message -->
<?php endif; ?>
