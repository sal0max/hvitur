<?php
/**
 * The template for displaying all single posts and pages
 *
 * If posts and pages use the same template, singular.php can be used.
 * This template is ignored if single.php and/or page.php is present.
 */

get_header();
get_template_part('partials/container'); ?>

   <?php if (have_posts()): ?>
      <?php while (have_posts()): the_post(); ?>
         <!-- main -->
         <main id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- title -->
            <h1 class="page-title display-6"><?php the_title(); ?></h1>
            <hr>
            <!-- / title -->

            <!-- thumbnail -->
            <?php if (has_post_thumbnail()): ?>
            <p>
               <?php the_post_thumbnail('', array('class' => 'img-fluid d-block mx-auto')); ?>
            </p>
            <?php endif; ?>
            <!-- /thumbnail -->

            <!-- details (ONLY ON POST) -->
            <?php if (get_post_type(get_the_ID()) == 'post'): ?>
            <p class="text-muted text-right">
               <!-- date -->
               <small>
                  <?php the_date(); ?>
               </small>
               <!-- /date -->
               <!-- category -->
               <?php if (has_category()): ?>
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
            <?php if (has_tag()): ?>
            <p class="text-right text-muted">
               <small>Tags&ensp;:&ensp;</small>
               <?php the_tags('<small>', '&ensp;&middot;&ensp;', '</small>');
               ?>
            </p>
            <?php endif; ?>
            <!-- /tags -->

            <!-- edit -->
            <?php if (get_edit_post_link()): ?>
            <p><?php edit_post_link(); ?></p>
            <?php endif; ?>
            <!-- /edit -->

            <!-- show prev/next if page/post is splittet in several pages -->
            <?php wp_link_pages( array(
               'before' => '<ul class="pagination justify-content-center">',
               'after' => '</ul>',
               'next_or_number' => 'next_and_number',
               'nextpagelink' => __('Next', 'hvitur'),
               'previouspagelink' => __('Previous', 'hvitur'))); ?>
            <!-- /show prev/next if page/post is splittet in several pages -->

         </main>
         <!-- /main -->
       <?php endwhile; ?>
   <?php endif; ?>

<?php
get_sidebar();
get_footer(); ?>
