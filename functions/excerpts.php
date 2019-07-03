<?php

/**
 * Changing excerpt length
 */
function overwrite_excerpt_length($length) {
   return 50;
}

/**
 * Changing text "more" of generated excerpts
 */
function overwrite_excerpt_more($more) {
   return "&hellip;";
}

/**
 * Add text "more" to all excerpts (generated and custom ones)
 */
function overwrite_the_excerpt($excerpt){
   $post = get_post();
   $excerpt .= sprintf(
      '<span class="font-weight-light"><br><a href="%1$s">%2$s &#8594;</a></span>',
      get_the_permalink(),
      __('Read More', 'hvitur')
   );
   return $excerpt;
}
