<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
   <title><?php wp_title(''); if(wp_title('', false)) { echo ' | '; } bloginfo('name'); ?></title>
   <meta charset="<?php bloginfo('charset'); ?>">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="<?php bloginfo('description'); ?>">
   <?php wp_head(); ?>
   <!-- rss -->
   <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> ATOM Feed" href="<?php bloginfo('atom_url'); ?>" />
</head>

<body <?php body_class(); ?> >

   <!-- header -->
   <header class="header clear" role="banner">
      <!-- nav -->
      <nav class="container navbar navbar-light navbar-expand-md" role="navigation">

         <!-- home/collapsed menu -->
         <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <a class="navbar-brand text-uppercase" href="<?php echo home_url(); ?>"> 
            <?php bloginfo('name'); ?>
         </a>
         <!-- /home/collapsed menu -->

         <div class="collapse navbar-collapse" id="navbarNav">
            <!-- left main menu -->
            <?php wp_nav_menu( array(
                  'menu'              => 'menu-1',
                  'theme_location'    => 'menu-1',
                  'depth'             => 2,
                  'container'         => false,
                  'menu_id'           => false,
                  'menu_class'        => 'navbar-nav mr-auto',
                  'fallback_cb'       => 'bs4navwalker::fallback',
                  'walker'            => new bs4navwalker())
               );
            ?>
            <!-- /left main menu -->
            <!-- right main menu -->
            <?php wp_nav_menu( array(
                  'menu'              => 'menu-2',
                  'theme_location'    => 'menu-2',
                  'depth'             => 2,
                  'container'         => false,
                  'menu_class'        => 'navbar-nav',
                  'walker'            => new bs4navwalker())
               );
            ?>
            <!-- /right main menu -->
            <!-- link to admin page if logged in -->
            <?php if (is_user_logged_in()) : ?>
               <ul class="navbar-nav">
                  <li class="menu-item nav-item">
                     <a class="nav-link" href="<?php echo admin_url(); ?>"><i class="fa fa-wordpress"></i> <?php _e( 'Admin Area', 'hvitur' ); ?></a>
                  </li>
               </ul>
            <?php endif; ?>
            <!-- /link to admin page if logged in -->
         </div>

      </nav>
      <!-- /nav -->
   </header>
   <!-- /header -->
