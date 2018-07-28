<!--
   Single post or single page
-->

<?php get_header(); ?>
<?php get_template_part('partials/container'); ?>

   <main role="main">
      <!-- section -->
      <section>

         <?php if (have_posts()): while (have_posts()) : the_post(); ?>
         <!-- article -->
         <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- title -->
            <h1 class="page-title display-6"><?php the_title(); ?></h1>
            <hr>
            <!-- / title -->

            <!-- thumbnail -->
            <?php if (has_post_thumbnail()) : ?>
            <p>
               <?php the_post_thumbnail('', array('class' => 'img-fluid')); ?>
            </p>
            <?php endif; ?>
            <!-- /thumbnail -->

            <!-- details (ONLY ON POST) -->
            <?php if (get_post_type(get_the_ID()) == 'post') : ?>
            <p class="text-muted text-right">
               <!-- date -->
               <small>
                  <?php the_date(); ?>
               </small>
               <!-- /date -->
               <!-- category -->
               <?php if (has_category()) : ?>
               <small>
                  &emsp;&middot;&emsp;<?php the_category(', '); ?>
               </small>
               <?php endif; ?>
               <!-- category -->
            </p>
            <?php endif; ?>
            <!-- /details (ONLY ON POST) -->

            <!-- content -->
            <?php the_content(); ?>
            <!-- /content -->

            <!-- tags -->
            <?php if (has_tag()) : ?>
            <p class="text-right text-muted">
               <small>Tags&ensp;:&ensp;</small>
               <?php the_tags('<small>', '&ensp;&middot;&ensp;', '</small>');
               ?>
            </p>
            <?php endif; ?>
            <!-- /tags -->

            <!-- always handy to have 'Edit' links available -->
            <?php edit_post_link(__('Edit this', 'hvitur'), '<p>', '</p>'); ?>
            <!-- /always handy to have 'Edit' links available -->

            <!-- show prev/next if page/post is splittet in several pages -->
            <?php wp_link_pages( array(
               'before' => '<ul class="pagination justify-content-center">',
               'after' => '</ul>',
               'next_or_number' => 'next_and_number',
               'nextpagelink' => __('Next', 'hvitur'),
               'previouspagelink' => __('Previous', 'hvitur'))); ?>
            <!-- /show prev/next if page/post is splittet in several pages -->

         </article>
         <!-- /article -->
         <?php endwhile; ?>
         <?php endif; ?>

      </section>
      <!-- /section -->
   </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
