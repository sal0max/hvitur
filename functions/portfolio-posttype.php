<?php

function custom_post_type() {
   $labels = array(
      'name'                  => 'Portfolio',
      'archives'              => 'Portfolio',
      'menu_name'             => 'Portfolio',

      'singular_name'         => 'Bild',
      'add_new'               => 'Bild hinzufügen',
      'add_new_item'          => 'Neues Bild zum Portfolio hinzufügen',
      'not_found'             => 'Nichts gefunden',
      'not_found_in_trash'    => 'Nichts im Papierkorb gefunden',
      'all_items'             => 'Alle Bilder',
      'insert_into_item'      => 'Einfügen',

      'edit_item'             => 'Bild bearbeiten',
      'view_item'             => 'Zum Bild',
      'view_items'            => 'Zum Portfolio',
      'search_items'          => 'Nach Bild suchen',

      'featured_image'        => 'Portfolio-Bild',
      'set_featured_image'    => 'Portfolio-Bild festlegen',
      'remove_featured_image' => 'Portfolio-Bild entfernen',
      'use_featured_image'    => 'Portfolio-Bild verwenden',

      'uploaded_to_this_item' => 'Medien für Veranstaltungen',
      'attributes'            => 'Veranstaltungsattribute',
      'new_item'              => 'Neue Veranstaltung',
      'filter_items_list'     => 'Veranstaltungen',
      'items_list_navigation' => 'Veranstaltungen',
      'name_admin_bar'        => 'Portfolio',
      'items_list'            => 'Weitere Veranstaltungen',
   );
   $args = array(
      'labels'              => $labels,
      'supports'            => array( 'title', 'thumbnail', 'comments' ),
      'taxonomies'          => array( 'category', 'post_tag' ),
      'hierarchical'        => false,
      'public'              => true,
      'show_in_rest'        => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'can_export'          => false,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'rewrite'             => array('slug' => 'portfolio'),
      'capability_type'     => 'post',
   );
   register_post_type( 'portfolio', $args );
}
