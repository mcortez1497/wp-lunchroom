<?php
/**
 * Template Name: Member Page
 *
 * @package HashOne
 */

$channel = new Twitch_Channel( get_the_title() );

get_header();

?>

<header class="hs-main-header lr-member-header">
  <div class="hs-container">
  </div>
</header><!-- .entry-header -->

<div class="hs-container lr-member-page">

  <div class="lr-member-banner">
    <?php if ($channel->channel_data->profile_banner) { ?>
    <div class="lr-member-banner-image" style="background-image: url('<?php echo esc_url($channel->channel_data->profile_banner); ?>')"></div>
    <?php } else { ?>
    <div class="lr-member-banner-image missing"></div>
    <?php } ?>
  </div>

  <div id="primary" class="content-area">

    <div class="lr-member-logo">
      <img src="<?php echo esc_url($channel->channel_data->logo); ?>" alt="" width="128" height="128" />
      <span class="lr-member-name">
        <?php echo $channel->channel_data->name ?>
      </span>
    </div>

    <main id="main" class="site-main" role="main">

    <div class="lr-member-player">
      <iframe src="http://player.twitch.tv/?channel=<?php echo $channel->channel_data->name ?>" height="378" width="620" frameborder="0" scrolling="no" allowfullscreen="false"></iframe>
    </div>

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'template-parts/content', 'single' ); ?>

    <?php endwhile; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

  <div id="secondary" class="widget-area"><!-- Member Sidebar -->
    <aside class="widget widget-social-icons">
      <ul class="lsi-social-icons">

        <?php if ( get_post_meta( get_the_ID(), 'lr_social_twitch' ) ) { ?>
        <li class="lsi-social-twitch">
          <a rel="nofollow" target="_blank" title="Twitch" aria-label="Twitch"
             href="<?php echo esc_url(get_post_meta( get_the_ID(), 'lr_social_twitch', true )); ?>">
            <i class="lsicon lsicon-twitch"></i>
          </a>
        </li>
        <?php } ?>

        <?php if ( get_post_meta( get_the_ID(), 'lr_social_youtube' ) ) { ?>
        <li class="lsi-social-youtube">
          <a rel="nofollow" target="_blank" title="Youtube" aria-label="Youtube"
             href="<?php echo esc_url(get_post_meta( get_the_ID(), 'lr_social_youtube', true )); ?>">
            <i class="lsicon lsicon-youtube"></i>
          </a>
        </li>
        <?php } ?>

        <?php if ( get_post_meta( get_the_ID(), 'lr_social_twitter' ) ) { ?>
        <li class="lsi-social-twitter">
          <a rel="nofollow" target="_blank" title="Twitter" aria-label="Twitter"
             href="<?php echo esc_url(get_post_meta( get_the_ID(), 'lr_social_twitter', true )); ?>">
            <i class="lsicon lsicon-twitter"></i>
          </a>
        </li>
        <?php } ?>

        <?php if ( get_post_meta( get_the_ID(), 'lr_social_facebook' ) ) { ?>
        <li class="lsi-social-facebook">
          <a rel="nofollow" target="_blank" title="Facebook" aria-label="Facebook"
             href="<?php echo esc_url(get_post_meta( get_the_ID(), 'lr_social_facebook', true )); ?>">
            <i class="lsicon lsicon-facebook"></i>
          </a>
        </li>
        <?php } ?>

        <?php if ( get_post_meta( get_the_ID(), 'lr_social_instagram' ) ) { ?>
        <li class="lsi-social-instagram">
          <a rel="nofollow" target="_blank" title="Instagram" aria-label="Instagram"
             href="<?php echo esc_url(get_post_meta( get_the_ID(), 'lr_social_instagram', true )); ?>">
            <i class="lsicon lsicon-instagram"></i>
          </a>
        </li>
        <?php } ?>

      </ul>
    </aside>

    <?php if ( get_post_meta( get_the_ID(), 'lr_stream_schedule' ) ) { ?>
    <aside class="widget widget_text">
      <h4 class="widget-title">Schedule</h4>
      <div class="textwidget">
        <?php echo get_post_meta( get_the_ID(), 'lr_stream_schedule', true ); ?>
      </div>
    </aside>
    <?php } ?>

    <?php if ( get_post_meta( get_the_ID(), 'lr_social_twitter' ) ) { ?>
    <aside class="widget">
      <a class="twitter-timeline"
         data-width="330" data-height="500"
         href="<?php echo esc_url(get_post_meta( get_the_ID(), 'lr_social_twitter', true )); ?>">
        My Latest Tweets
      </a>
      <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </aside>
    <?php } ?>

  </div><!-- #secondary -->

</div>

<?php get_footer(); ?>
