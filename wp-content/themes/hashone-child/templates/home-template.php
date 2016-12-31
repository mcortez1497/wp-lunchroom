<?php
/**
 * Template Name: Home Page
 *
 * @package HashOne
 */

get_header(); 

$hashone_page = '';
$hashone_page_array = get_pages();
if(is_array($hashone_page_array)){
  $hashone_page = $hashone_page_array[0]->ID;
}
?>

<section id="hs-home-slider-section">
  <div id="hs-bx-slider">
  <?php for ($i=1; $i < 4; $i++) {  
    $hashone_slider_page_id = get_theme_mod( 'hashone_slider_page'.$i );

    if($hashone_slider_page_id){
      $args = array( 
        'page_id' => absint($hashone_slider_page_id) 
      );
      $query = new WP_Query($args);
      if( $query->have_posts() ):
        while($query->have_posts()) : $query->the_post();
        ?>
        <div class="hs-slide">
          <div class="hs-slide-overlay"></div>

          <?php 
          if(has_post_thumbnail()){
            $hashone_slider_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');	
            echo '<img alt="'.esc_attr(get_the_title()).'" src="'.esc_url($hashone_slider_image[0]).'">';
          } ?>

          <!-- TODO: Abstract -->
          <div class="lr-twitch-wrapper">

          <?php
          $url = 'https://api.twitch.tv/kraken/streams/followed';
          // $url = 'https://api.twitch.tv/kraken/search/streams?query=Magic:%20The%20Gathering';

          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/vnd.twitchtv.v5+json',
            'Client-ID: 243x69xvxlj4lyk7juy2riu8ml30p4',
            'Authorization: OAuth gpnsx385cpzbw09jmt39ibo2arqiun'
          ));

          $data = curl_exec($ch);
          curl_close($ch);

          $json = json_decode($data);
          $streams = $json->streams;

          $html = "<div class='lr-twitch-player'>";

          if ( !wp_is_mobile() ) {
            $html .= "  <div class='lr-twitch-video'>"
                  .  "    <iframe src='http://player.twitch.tv/?channel=" . $streams[0]->channel->name . "' height='349' width='620'"
                  .  "            frameborder='0' scrolling='no' allowfullscreen='false'></iframe>"
                  .  "  </div>";
          }

          $html .= "<div class='lr-channels'>";

          foreach ($streams as $key=>$stream) {
            $html .= "<div class='lr-channel " . ($key == 0 && !wp_is_mobile() ? "active" : "") . "'>"
                  .  "  <img src=" .$stream->preview->medium . " alt='Stream' />"
                  .  "  <div class='lr-channel-description'>"
                      .  "    <div class='lr-channel-user'>" . $stream->channel->name . "</div>"
                  .  "    <div class='lr-channel-playing'>playing " . $stream->channel->game . "</div>"
                  .  "    <div class='lr-channel-status'>" . $stream->channel->status . "</div>"
                  .  "  </div>"
                  .  "</div>";
          }

          $html .= "  </div>"
                .  "</div>";

          echo $html;

          ?>

          </div>

        </div>
        <?php
        endwhile;
      endif;
    }
  } ?>
  </div>
</section>

<?php if( get_theme_mod('hashone_disable_featured_sec') != 'on' ){ ?>
<section id="hs-featured-post-section" class="hs-section">
  <div class="hs-container">
    <?php
    $hashone_featured_title = get_theme_mod('hashone_featured_title', __( 'Our Features', 'hashone'));
    $hashone_featured_desc = get_theme_mod('hashone_featured_desc', __( 'Check out cool featured of the theme', 'hashone'));
    ?>
    <?php if($hashone_featured_title){ ?>
    <h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_featured_title); ?></h2>
    <?php } ?>

    <?php if($hashone_featured_desc){ ?>
    <div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_featured_desc); ?></div>
    <?php } ?>

    <div class="hs-featured-post-wrap hs-clearfix">
      <?php 
      for( $i = 1; $i < 5; $i++ ){
        $hashone_featured_page_id = get_theme_mod('hashone_featured_page'.$i, $hashone_page); 
        $hashone_featured_page_link = get_theme_mod('hashone_featured_page_link'.$i, __( '', 'hashone')); 
        $hashone_featured_page_icon = get_theme_mod('hashone_featured_page_icon'.$i, 'fa-bell');
        $hashone_featured_page_img = get_theme_mod('hashone_featured_page_img'.$i, '' );

      if($hashone_featured_page_id){
        $args = array( 'page_id' => $hashone_featured_page_id );
        $query = new WP_Query($args);
        if($query->have_posts()):
          while($query->have_posts()) : $query->the_post();
          $hashone_wow_delay = ($i/2)-1+0.5;
        ?>
          <div class="hs-featured-post hs-featured-post<?php echo $i; ?> wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="<?php echo $hashone_wow_delay; ?>s">
            <div class="hs-featured-icon icon-color-<?php echo $i; ?>">
              <?php if($hashone_featured_page_img != '') { ?>
              <img src="<?php echo $hashone_featured_page_img ?>" alt="Community Icon" />
              <?php } else { ?>
              <i class="fa <?php echo esc_attr($hashone_featured_page_icon); ?>"></i>
              <?php } ?>
            </div>
            <h3>
            <a href="<?php echo ($hashone_featured_page_link != '' ? $hashone_featured_page_link : the_permalink()); ?>"><?php the_title(); ?></a>
            </h3>
            <div class="hs-featured-excerpt">
            <?php 
            if(has_excerpt()){
              echo get_the_excerpt();
            }else{
              echo hashone_excerpt( get_the_content(), 100); 
            }?>
            </div>
          </div>
        <?php
        endwhile;
        endif;	
        wp_reset_postdata();
        }
      }
      ?>
    </div>
  </div>
</section>
<?php } ?>

<?php if( get_theme_mod('hashone_disable_logo_sec') != 'on' ){ ?>
<section id="hs-logo-section" class="hs-section">
  <div class="hs-container">
    <?php
    $hashone_logo_title = get_theme_mod('hashone_logo_title', __( 'We are Associated with', 'hashone' ));
    $hashone_logo_sub_title = get_theme_mod('hashone_logo_sub_title', __( 'Meet our Awesome Clients', 'hashone' ));
    ?>

    <?php if($hashone_logo_title){ ?>
    <h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_logo_title); ?></h2>
    <?php } ?>

    <?php if($hashone_logo_sub_title){ ?>
    <div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_logo_sub_title); ?></div>
    <?php } ?>

    <?php 
    $hashone_client_logo_image = get_theme_mod('hashone_client_logo_image');
    $hashone_client_logo_image = explode(',', $hashone_client_logo_image);
    ?>

    <div class="wow zoomIn" data-wow-duration="0.5s" data-wow-delay="0.5s">
    <div class="hs_client_logo_slider">
    <?php
    foreach ($hashone_client_logo_image as $hashone_client_logo_image_single) {
      ?>
      <img alt="<?php _e('logo','hashone') ?>" src="<?php echo esc_url(wp_get_attachment_url($hashone_client_logo_image_single)); ?>">
      <?php
    }
    ?>
    </div>
    </div>
  </div>
</section>
<?php } ?>

<?php get_footer(); ?>
