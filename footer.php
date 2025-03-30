    <?php wp_footer(); ?>
  </body>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if( window.innerWidth > 800 ) {
        VANTA.NET({
          el: "body",
          mouseControls: false,
          gyroControls: false,
          points: 12.00,
          maxDistance: 22.00,
          spacing: 18.00
        });
        document.getElementsByClassName('vanta-canvas')[0].style.opacity = "1";
      }
    }, false);
  </script>
</html>