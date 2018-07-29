<!--
   ...
   ...
-->
<?php if (have_posts()): ?>
   <div class="card-columns">

   <?php while (have_posts()) : the_post(); ?>
      <!-- card -->
      <article class="card" id="post-<?php the_ID(); ?>">

         <!-- thumbnail -->
         <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
         <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php the_post_thumbnail('medium_large', array('class' => 'card-img-top img-fluid')); ?>
         </a>
         <?php endif; ?>
         <!-- /thumbnail -->

         <div class="card-body">
            <!-- title -->
            <h3 class="card-title text-left">
               <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>
            <!-- /title -->

            <!-- excerpt -->
            <?php the_excerpt(); ?>
            <!-- /excerpt -->
         </div>

         <div class="card-footer text-right" style="background-color: #fff">
            <small>
               <!-- date -->
               <?php echo get_the_date(); ?>
               <!-- /date -->
            </small>
         </div>

      </article>
      <!-- /card -->
   <?php endwhile; ?>

   </div>
<?php else: ?>
   <!-- error message -->
   <article>
      <h2><?php _e('Sorry, nothing to display.', 'hvitur'); ?></h2>
   </article>
   <!-- /error message -->
<?php endif; ?>
