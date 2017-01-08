<?php
/**
 * The header for our theme.
 *
 * @package HashOne
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

<script type="text/javascript" src="/wp-content/themes/hashone-child/js/twitch-player.js"></script>

</head>

<body <?php body_class(); ?>>
<div id="hs-page">
  <?php
  $hashone_header_bg = get_theme_mod('hashone_header_bg','hs-black');
  ?>
  <header id="hs-masthead" class="hs-site-header hs-clearfix <?php echo esc_attr($hashone_header_bg) ?>">
    <div class="hs-container">
      <div id="hs-site-branding">
        <?php 
        if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) :
          the_custom_logo();
        else:
          if ( is_front_page() ) : ?>
          <h1 class="hs-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
          <?php else : ?>
          <p class="hs-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
          <?php endif; ?>
        <?php endif; // End header image check. ?>
      </div><!-- .site-branding -->

      <nav id="hs-site-navigation" class="hs-main-navigation">
        <div class="hs-toggle-menu"><span></span></div>

        <div class="hs-menu">
          <ul id="menu-navigation" class="hs-clearfix">

          <?php 
          wp_nav_menu( array( 
            'theme_location' => 'primary', 
            'container' => false,
            'items_wrap' => '%3$s',
          ) ); 
          ?>

          <li class="lr-menu-divider">
            <div class="lr-divider"></div>
          </li>
          <li id="menu-item-login" class="lr-menu-login menu-item menu-item-type-custom menu-item-object-custom">
            <?php if ( is_user_logged_in() ) : ?>
            <a href="<?php echo wp_logout_url( home_url() ); ?>">Log Out <div class="lr-menu-login-icon lr-logout"></div></a>
            <?php else : ?>
            <a href="<?php echo esc_url(get_site_url()) . "/wp-login.php?action=wordpress_social_authenticate&mode=login&provider=TwitchTV&redirect_to=" . esc_url(get_site_url()); ?>">Log In <div class="lr-menu-login-icon lr-login"></div></a>
            <?php endif; ?>
          </li>

          </ul>
        </div>

      </nav><!-- #hs-site-navigation -->
    </div>
  </header><!-- #hs-masthead -->

  <div id="hs-content" class="hs-site-content hs-clearfix">
