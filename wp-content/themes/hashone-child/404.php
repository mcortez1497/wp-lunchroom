<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package HashOne
 */

get_header(); ?>

<header class="hs-main-header">
  <div class="hs-container">
    <h1 class="hs-main-title"><?php esc_html_e( 'Page not found', 'hashone' ); ?></h1>
  </div>
</header><!-- .entry-header -->


<div class="hs-container">
  <div class="response-error-title"><?php esc_html_e( 'Uh-oh, looks like we lost our lunch!', 'hashone' ); ?></div>
  <div class="response-error-subtitle"><?php esc_html_e( 'Contact an admin if you believe this page should be here.', 'hashone' ); ?></div>
  <span class="response-error-code">404</span>
</div>

<?php get_footer(); ?>
