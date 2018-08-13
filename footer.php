   </div>
   <!-- /container -->

   <!-- footer -->
   <footer class="footer text-center ">
      <div class="container">
         <hr>
         <?php
         wp_nav_menu( array(
            'menu'              => 'menu-3',
            'theme_location'    => 'menu-3',
            'menu_class'        => 'list-inline small',
            'walker'            => new inlinelistwalker()
            )
         );
         ?>
      </div>
   </footer>
   <!-- /footer -->

   <?php wp_footer(); ?>

   <!-- analytics -->
   <!-- <script>
   (function(f, i, r, e, s, h, l) {
      i['GoogleAnalyticsObject'] = s;
      f[s] = f[s] || function() {
         (f[s].q = f[s].q || []).push(arguments)
      }, f[s].l = 1 * new Date();
      h = i.createElement(r),
         l = i.getElementsByTagName(r)[0];
      h.async = 1;
      h.src = e;
      l.parentNode.insertBefore(h, l)
   })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
   ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
   ga('send', 'pageview');
   </script> -->
   <!-- /analytics -->

   </body>
</html>
