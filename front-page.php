<?php
get_header();
// need opening div because not using
//    get_template_part('partials/container');
echo '<div>';
   hvitur_galleries_to_carousel(); // functions.php
get_footer(); ?>
