<?php

/**
 * Gets all images of all galleries and puts them together in one single bootstrap (v4) carousel
 */
function hvitur_galleries_to_carousel() {
   global $post;

   // only do this on singular items
   if (!is_singular()) return;
   // make sure the post has a gallery in it
   if (!has_shortcode($post->post_content, 'gallery')) return;

   // retrieve all galleries of this post and flatten them
   $galleries = get_post_galleries_images($post);
   $images = array();
   foreach ($galleries as $gallery) {
      foreach ($gallery as $image) {
         $images[] = $image;
      }
   }

   $carousel = '<div class="carousel slide carousel-fade" id="carousel" data-ride="carousel">';

   // image slides
   $carousel .= '<div class="carousel-inner" style="z-index:-1;">';
   foreach ($images as $i => $image) {
      if ($i == 0) {
         $carousel .= '<div class="carousel-item active">';
      }
      else {
         $carousel .= '<div class="carousel-item">';
      }
      $carousel .= '<div ';
      $carousel .= ' class="center-cropped"';
      $carousel .= ' style="min-height: calc(100vh - 3.5rem); background-image: url(\'' . $image . '\');">';
      $carousel .= ' </div>';
      // add hidden div for preloading the next image
      if ($i < sizeof($images)) {
         $carousel .= '<div style="position:absolute; width:0; height:0; overflow:hidden; z-index:-1; content:';
         $carousel .= 'url(\'' . $images[$i + 1] . '\');"></div>';
      }

      $carousel .= '</div>';
   }
   $carousel .= '</div>';

   // controlers
   $carousel .= '<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">';
   $carousel .= '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
   $carousel .= '<span class="sr-only">Previous</span>';
   $carousel .= '</a>';
   $carousel .= '<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">';
   $carousel .= '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
   $carousel .= '<span class="sr-only">Next</span>';
   $carousel .= '</a>';

   // edit button
   if (get_edit_post_link()) {
      $url = get_edit_post_link($post_id);
      $text = __('Edit this' , 'hvitur');
      $carousel .= '<a href="'. $url . '"
         target="_blank" class="btn btn-sm btn-outline-light"
         style="position: absolute; top: 12px; right: 8px; z-index: 100;">' . $text . '</a>';
   }

   $carousel .= '</div>';

   echo $carousel;
}
