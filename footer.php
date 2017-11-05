<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package klr
 */

// $footer_copy	= get_field('footer_copy');
// $footer_signoff	= get_field('footer_signoff');


?>
<?php if (!is_front_page()) {
    get_newsletter();
} ?>
<div class="w-section footer">
    <div class="w-container footer-container">
      <div class="w-row footer-columns">
          <div class="footer-widget w-col w-col-3 w-col-small-12">
              <?php dynamic_sidebar( 'footer-area-1' ); ?>
          </div>
          <div class="footer-widget w-col w-col-3 w-col-small-12">
              <?php dynamic_sidebar( 'footer-area-2' ); ?>
          </div>
          <div class="footer-widget w-col w-col-3 w-col-small-12">
              <?php dynamic_sidebar( 'footer-area-3' ); ?>
          </div>
          <div class="w-col w-col-3 w-col-small-12">
              <h2 class="footer-h2">Get in touch</h2>
              <a href="tel:4847975790" target="_blank">
                  <div class="phone"><span class="phone-number">484.797.5790</span></div>
              </a>
              <a href="mailto:perfectaimbowling@gmail.com" target="_blank">
                  <div class="email"><span class="phone-number">perfectaimbowling@gmail.com</span></div>
              </a>
              <a href="https://www.facebook.com/perfectaimbowling/" target="_blank">
                <div class="icon facebook"></div>
              </a>
              <a href="https://www.youtube.com/user/TamerBowling">
                <div class="icon youtube-link"></div>
              </a>
              <a href="https://www.instagram.com/perfect_aim_pro_shop/">
                  <div class="icon instagram-link"></div>
              </a>
              <hr />
              <p class="footer-copyright">Copyright © <?php echo date("Y") ?> Perfect Aim Bowling. All rights reserved.</p>
          </div>
      </div>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>