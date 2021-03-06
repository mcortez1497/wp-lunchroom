<?php
/**
 * Template Name: Subscribers Page
 *
 * @package HashOne
 */

get_header(); ?>

<header class="hs-main-header">
  <div class="hs-container">
    <?php the_title( '<h1 class="hs-main-title">', '</h1>' ); ?>
  </div>
</header><!-- .entry-header -->

<div class="hs-container">
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'template-parts/content', 'single' ); ?>

    <?php endwhile; // End of the loop. ?>

    <div class="lr-sub-container">
    <?php 
      $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'templates/member-template.php',
        'sort_column' => 'post_date'
      ));

      foreach($pages as $page) {
        $channel = new Twitch_Channel( $page->post_name );

        if (!isset($channel->channel_data->error)) {
    ?>
      <div class="lr-sub-item">
        <img src="<?php echo esc_url($channel->channel_data->logo); ?>" alt="Profile Logo" width="96" height="96" />
        <div class="lr-sub-item-title">
          <a href="<?php echo get_permalink( $page ) ?>"><?php echo $page->post_name; ?></a>
        </div>
      </div>
    <?php 
        } 
      } 
    ?>
    </div>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
