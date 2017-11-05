<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package perfectaimbowling
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <meta property="og:title" content="Perfect Aim Bowling" />
    <meta property="og:description" content="<?php echo $excerpt; ?>" />
    <meta property="og:url" content="www.perfectaimbowling.com" />
    <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>" />
    <meta property="og:image" content="http://perfectaimbowling.com/wp-content/themes/perfectaimbowling/assets/images/perfectaimbowlingLogo.png" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
  
<?php wp_head(); ?>

<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<div class="w-section w-hidden-medium w-hidden-small w-hidden-tiny weather-info">
   <div class="w-container w-hidden-small w-hidden-tiny weather-container">
    <div class="w-row">
      <div class="w-col w-col-4 cart-menu">
        <div><a class="cart-customlocation" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
        </div>
      </div>
      <div class="w-col w-col-8 w-clearfix menu-utility-menu-container">
           <?php wp_nav_menu( array( 'theme_location' => 'utility', 'menu_id' => 'header-nav-link' ) ); ?>
      </div>
    </div> 
  </div>
</div>
<div class="w-section nav-block">
    <div class="w-container header-container">
        <div class="w-nav navbar" data-collapse="medium" data-animation="default" data-duration="400" data-contain="1" data-doc-height="1">
        <div class="w-container navbar-container">
          <?php echo do_shortcode('[yith_woocommerce_ajax_search]');?>
          <a class="w-nav-brand logo-block w--current" href="<?php echo site_url() ?> ">
            <img class="logo" src="<?php bloginfo (stylesheet_directory); ?>/assets/images/PABLogoRevised.jpg">
          </a>
          <div class="w-nav-button menu-button">
            <div class="w-icon-nav-menu"></div>
          </div>
            <div class="w-nav-button">
                <a href="<?php echo wc_get_endpoint_url('cart'); ?>"><div class="w-icon-nav-menu cart-icon"></div></a>
            </div>

        </div>
        <div class="w-nav-overlay" data-wf-ignore="" style="display: none;"></div>
      </div>
        <div class="w-row header-row">
            <nav class="w-nav-menu nav-menu" role="navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
            </nav>
        </div>
    </div>
    <!--Mobile Menu -->
    <div class="nav-window mobile-menu" style="display:none">
        <nav class="w-nav-menu nav-menu" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'mobile', 'menu_id' => 'mobile' ) ); ?>
        </nav>
    </div>
</div>