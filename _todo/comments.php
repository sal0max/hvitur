<div id="comments" class="comments">

   <?php if ( post_password_required() ) : ?>
      <p><?php esc_html_e( 'Post is password protected. Enter the password to view any comments.', 'hvitur' ); ?></p>
   </div>
   <?php return; endif; ?>

   <?php if ( have_comments() ) : ?>
      <h2><?php comments_number(); ?></h2>
      <ul>
         <?php wp_list_comments( 'type=comment&callback=hviturcomments' ); // Custom callback in functions.php. ?>
      </ul>
   <?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
      <p><?php esc_html_e( 'Comments are closed here.', 'hvitur' ); ?></p>
   <?php endif; ?>

   <?php comment_form(); // This tag outputs a complete commenting form for use within a template.  ?>

</div>
