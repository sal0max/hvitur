<?php

/**
 * Class Name:  inlinelistwalker
 * Version:     0.1.0
 * Author:      Maximilian Salomon
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class inlinelistwalker extends Walker_Nav_Menu {

   /**
    * Start the element output.
    *
    * Adds main/sub-classes to the list items and links.
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param object $item   Menu item data object.
    * @param int    $depth  Depth of menu item. Used for padding.
    * @param array  $args   An array of arguments. @see wp_nav_menu()
    * @param int    $id     Current item ID.
    */
   function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
      global $wp_query;
      $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

      // Passed classes.
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
      $class_name .= 'list-inline-item';

      // Build HTML.
      $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $class_name . '">';

      // Link attributes.
      $attributes  = !empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
      $attributes .= !empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
      $attributes .= !empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
      $attributes .= !empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
      $attributes .= ' class="'
         . 'menu-link'
         . ( is_front_page() ? ' text-light' : ' text-secondary' )
         . ( $depth > 0 ? ' sub-menu-link' : ' main-menu-link' )
         . '"';

      // Build HTML output and pass through the proper filter.
      $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
         $args->before,
         $attributes,
         $args->link_before,
         apply_filters( 'the_title', $item->title, $item->ID ),
         $args->link_after,
         $args->after
      );
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
   }
}
