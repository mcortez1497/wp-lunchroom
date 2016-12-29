<?php
/**
 * Front Page
 *
 * @package HashOne
 */

if ( 'page' == get_option( 'show_on_front' ) ) {
    include( get_page_template() );
}else{
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

            <div class="lr-twitch-wrapper">

  					<?php
  						// $url = 'https://api.twitch.tv/kraken/streams/followed';
              $url = 'https://api.twitch.tv/kraken/search/streams?query=Magic:%20The%20Gathering';

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

<?php if( get_theme_mod('hashone_disable_about_sec') != 'on' ){ ?>
<section id="hs-about-us-section" class="hs-section">
	<div class="hs-container">
		<div class="hs-about-sec wow zoomIn" data-wow-duration="1s" data-wow-delay="0.5s">
		<?php 
			$args = array(
				'page_id' => absint( get_theme_mod('hashone_about_page' , $hashone_page ) )
				);
			$query = new WP_Query($args);
			if($query->have_posts()):
				while($query->have_posts()) : $query->the_post();
			?>
			<h2 class="hs-section-title"><?php the_title(); ?></h2>
			<div class="hs-content"><?php the_content(); ?></div>
			<?php
			endwhile;
			endif;	
			wp_reset_postdata();
			?>
		</div>

		<div class="hs-progress-bar-sec">
		<?php 
			$hashone_about_widget = get_theme_mod('hashone_about_widget');
			if($hashone_about_widget){
				dynamic_sidebar($hashone_about_widget);
			}else{
				for ($i=1; $i < 6; $i++) { 
					$hashone_about_progressbar_title = get_theme_mod('hashone_about_progressbar_title'.$i , __( 'Progress Bar Title', 'hashone' ).$i);
					$hashone_about_progressbar_percentage = get_theme_mod('hashone_about_progressbar_percentage'.$i, rand( 80, 100 ));
					$hashone_about_progressbar_disable = get_theme_mod('hashone_about_progressbar_disable'.$i);
					if(!$hashone_about_progressbar_disable){
				?>
					<div class="hs-progress hs-progress-count<?php echo esc_attr($i); ?>">
						<h6><?php echo esc_html($hashone_about_progressbar_title); ?></h6>
						<div class="hs-progress-bar">
							<div class="hs-progress-bar-length" data-width="<?php echo absint($hashone_about_progressbar_percentage); ?>">
								<?php echo absint($hashone_about_progressbar_percentage)."%"; ?>
							</div>
						</div>
					</div>
				<?php
					}
				}
			}
		?>
		</div>
	</div>
</section>
<?php } ?>


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
				$hashone_featured_page_icon = get_theme_mod('hashone_featured_page_icon'.$i, 'fa-bell');
			
			if($hashone_featured_page_id){
				$args = array( 'page_id' => $hashone_featured_page_id );
				$query = new WP_Query($args);
				if($query->have_posts()):
					while($query->have_posts()) : $query->the_post();
					$hashone_wow_delay = ($i/2)-1+0.5;
				?>
					<div class="hs-featured-post hs-featured-post<?php echo $i; ?> wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="<?php echo $hashone_wow_delay; ?>s">
						<div class="hs-featured-icon"><i class="fa <?php echo esc_attr($hashone_featured_page_icon); ?>"></i></div>
						<h3>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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

<?php if( get_theme_mod('hashone_disable_portfolio_sec') != 'on' ){ ?>
<section id="hs-portfolio-section" class="hs-section">
	<?php
	$hashone_portfolio_title = get_theme_mod('hashone_portfolio_title', __('What we do it love', 'hashone'));
	$hashone_portfolio_sub_title = get_theme_mod('hashone_portfolio_sub_title', __('Check our beautiful works we do', 'hashone'));
	?>

	<?php if($hashone_portfolio_title){ ?>
	<h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_portfolio_title); ?></h2>
	<?php } ?>

	<?php if($hashone_portfolio_sub_title){ ?>
	<div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_portfolio_sub_title); ?></div>
	<?php } ?>

	<?php 
	$hashone_portfolio_cat = get_theme_mod('hashone_portfolio_cat');
	if($hashone_portfolio_cat){ 
		$hashone_portfolio_cat_array = explode(',', $hashone_portfolio_cat);
	?>	
	<div class="hs-portfolio-cat-name-list hs-container wow zoomIn" data-wow-duration="0.5s" data-wow-delay="1s">
		<?php 
			$category_slug = ""; 
			foreach ($hashone_portfolio_cat_array as $hashone_portfolio_cat_single) {
				$category_slug = get_category($hashone_portfolio_cat_single);
				$category_slug = $category_slug->slug;
				?>
				<div class="hs-portfolio-cat-name" data-filter=".<?php echo esc_attr($category_slug); ?>">
					<?php echo esc_html(get_cat_name($hashone_portfolio_cat_single)); ?>
				</div>
				<?php
			}
		?>
	</div>
	<?php } ?>

	<div class="hs-portfolio-post-wrap wow zoomIn" data-wow-duration="0.5s" data-wow-delay="1.5s">
		<div class="hs-portfolio-posts hs-clearfix">
			<?php 
			if($hashone_portfolio_cat){ 
				$args = array( 'cat' => $hashone_portfolio_cat, 'posts_per_page' => -1 );
				$query = new WP_Query($args);
				if($query->have_posts()):
					while($query->have_posts()) : $query->the_post();
					$hashone_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'hashone-portfolio-thumb');	
					$hashone_image_large = wp_get_attachment_image_src(get_post_thumbnail_id(),'large');	
					$categories = get_the_category();
			 		$category_slug = "";
			 		$cat_slug = array();

			 		foreach ($categories as $category) {
			 			$cat_slug[] = $category->slug;
			 		}

			 		$category_slug = implode(" ", $cat_slug);
				?>
					<div class="hs-portfolio <?php echo esc_attr($category_slug); ?>">
						<div class="hs-portfolio-inner">
						<?php
							if(has_post_thumbnail()){
								?>
								<img src="<?php echo esc_url($hashone_image[0]) ?>" alt="<?php esc_attr(get_the_title()); ?>">
								<?php
							}
						?>
						<div class="hs-portfolio-caption">
							<h4><?php the_title(); ?></h4>
							<a class="hs-portfolio-link" href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>
							<a class="hs-portfolio-image" data-lightbox-gallery="gallery1" href="<?php echo esc_url($hashone_image_large[0]) ?>"><i class="fa fa-search"></i></a>
						</div>
						</div>
					</div>
				<?php
				endwhile;
				endif;	
				wp_reset_postdata();
			}
			?>
		</div>
		<?php
		?>
	</div>
</section>
<?php } ?>

<?php if( get_theme_mod('hashone_disable_service_sec') != 'on' ){ ?>
<section id="hs-service-post-section" class="hs-section">
	<div class="hs-service-left-bg"></div>
	<div class="hs-container">
		<div class="hs-service-posts">
			<?php
			$hashone_service_title = get_theme_mod('hashone_service_title',__('Why Choose Us', 'hashone'));
			$hashone_service_sub_title = get_theme_mod('hashone_service_sub_title', __('Let us do all things for you', 'hashone'));
			?>

			<?php if($hashone_service_title){ ?>
			<h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_service_title); ?></h2>
			<?php } ?>

			<?php if($hashone_service_sub_title){ ?>
			<div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_service_sub_title); ?></div>
			<?php } ?>

			<div class="hs-service-post-wrap">
				<?php 
				for( $i = 1; $i < 7; $i++ ){
					$hashone_service_page_id = get_theme_mod('hashone_service_page'.$i, $hashone_page); 
					$hashone_service_page_icon = get_theme_mod('hashone_service_page_icon'.$i, 'fa-globe');
				
					if($hashone_service_page_id){
						$args = array( 'page_id' => $hashone_service_page_id );
						$query = new WP_Query($args);
						if($query->have_posts()):
							while($query->have_posts()) : $query->the_post();
							$hashone_wow_delay = ($i*300)+300;
						?>
							<div class="hs-clearfix hs-service-post hs-service-post<?php echo $i; ?> wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="<?php echo $hashone_wow_delay; ?>ms">
								<div class="hs-service-icon">
								<i class="fa <?php echo esc_attr($hashone_service_page_icon); ?>"></i>
								</div>

								<div class="hs-service-excerpt">
									<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
									<?php 
										if(has_excerpt()){
											echo get_the_excerpt();
										}else{
											echo hashone_excerpt( get_the_content(), 100);
										}
									 ?>
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
	</div>
</section>
<?php } ?>

<?php if( get_theme_mod('hashone_disable_team_sec') != 'on' ){ ?>
<section id="hs-team-section" class="hs-section">
	<div class="hs-container">
		<?php
		$hashone_team_title = get_theme_mod('hashone_team_title', __('Meet Our Team', 'hashone'));
		$hashone_team_sub_title = get_theme_mod('hashone_team_sub_title', __( 'Experts who works for us','hashone' ));
		?>

		<?php if($hashone_team_title){ ?>
		<h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_team_title); ?></h2>
		<?php } ?>

		<?php if($hashone_team_sub_title){ ?>
		<div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_team_sub_title); ?></div>
		<?php } ?>

		<div class="hs-team-member-wrap hs-clearfix">
			<?php 
			for( $i = 1; $i < 5; $i++ ){
				$hashone_team_page_id = get_theme_mod('hashone_team_page'.$i, $hashone_page); 
			
				if($hashone_team_page_id){
					$args = array( 'page_id' => $hashone_team_page_id );
					$query = new WP_Query($args);
					if($query->have_posts()):
						while($query->have_posts()) : $query->the_post();
						$hashone_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'hashone-team-thumb');	
						$hashone_team_designation = get_theme_mod('hashone_team_designation'.$i, __('CEO', 'hashone'));
						$hashone_team_facebook = get_theme_mod('hashone_team_facebook'.$i, '#');
						$hashone_team_twitter = get_theme_mod('hashone_team_twitter'.$i, '#');
						$hashone_team_google_plus = get_theme_mod('hashone_team_google_plus'.$i, '#');
						$hashone_team_linkedin = get_theme_mod('hashone_team_linkedin'.$i, '#');
						$hashone_wow_delay = ($i/2)-1+0.5;
					?>
						<div class="hs-team-member wow pulse" data-wow-duration="0.5s" data-wow-delay="<?php echo $hashone_wow_delay; ?>s">
							<?php if( has_post_thumbnail() ){ ?>
							<div class="hs-team-member-image">
								<img src="<?php echo esc_url($hashone_image[0]);?>" alt="<?php esc_attr(get_the_title()); ?>" />
								
								<a href="<?php the_permalink(); ?>" class="hs-team-member-excerpt">
									<div class="hs-team-member-excerpt-wrap">
									<span>
									<?php 
										if(has_excerpt()){
											echo get_the_excerpt();
										}else{
											echo hashone_excerpt( get_the_content() , 100 );
										}
									?>
									</span>
									</div>
								</a>

								<?php if( $hashone_team_facebook || $hashone_team_twitter || $hashone_team_google_plus ){ ?>
									<div class="hs-team-social-id">
										<?php if($hashone_team_facebook){ ?>
										<a target="_blank" href="<?php echo esc_url($hashone_team_facebook) ?>"><i class="fa fa-facebook"></i></a>
										<?php } ?>

										<?php if($hashone_team_twitter){ ?>
										<a target="_blank" href="<?php echo esc_url($hashone_team_twitter) ?>"><i class="fa fa-twitter"></i></a>
										<?php } ?>

										<?php if($hashone_team_google_plus){ ?>
										<a target="_blank" href="<?php echo esc_url($hashone_team_google_plus) ?>"><i class="fa fa-google-plus"></i></a>
										<?php } ?>

										<?php if($hashone_team_linkedin){ ?>
										<a target="_blank" href="<?php echo esc_url($hashone_team_linkedin) ?>"><i class="fa fa-linkedin"></i></a>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
							<?php } ?>

							<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
							
							<?php if($hashone_team_designation){ ?>
								<div class="hs-team-designation"><?php echo esc_html($hashone_team_designation); ?></div>
							<?php } ?>

							
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

<?php if( get_theme_mod('hashone_disable_counter_sec') != 'on' ){ ?>
<section id="hs-counter-section" data-stellar-background-ratio="0.4">
<div class="hs-counter-section hs-section">
<div class="hs-counter-overlay"></div>
	<div class="hs-container">
		<?php
		$hashone_counter_title = get_theme_mod('hashone_counter_title', __( 'OUR FACTS', 'hashone' ));
		$hashone_counter_sub_title = get_theme_mod('hashone_counter_sub_title', __( 'Some Numbers that Speaks', 'hashone' ));
		?>

		<?php if($hashone_counter_title){ ?>
		<h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_counter_title); ?></h2>
		<?php } ?>

		<?php if($hashone_counter_sub_title){ ?>
		<div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_counter_sub_title); ?></div>
		<?php } ?>

		<div class="hs-counter-wrap hs-clearfix">
			<?php 
			for( $i = 1; $i < 5; $i++ ){
				$hashone_counter_title = get_theme_mod('hashone_counter_title'.$i, __( 'Cups of Coffee', 'hashone' )); 
				$hashone_counter_count = get_theme_mod('hashone_counter_count'.$i, rand(600,2000));
				$hashone_counter_icon = get_theme_mod('hashone_counter_icon'.$i, 'fa-coffee');
				$hashone_wow_delay = ($i/2)-1+0.5;
				if($hashone_counter_count){
					?>
					<div class="hs-counter hs-counter<?php echo $i; ?> wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="<?php echo $hashone_wow_delay; ?>s">
						<div class="hs-counter-count odometer odometer<?php echo $i; ?>" data-count="<?php echo absint($hashone_counter_count); ?>">
							99
						</div>

						<div class="hs-counter-icon">
							<i class="fa <?php echo esc_attr($hashone_counter_icon); ?>"></i>
						</div>

						<div class="hs-counter-title">
							<?php echo esc_html($hashone_counter_title); ?>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
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

<?php if( get_theme_mod('hashone_disable_testimonial_sec') != 'on' ){ ?>
<section id="hs-testimonial-section" class="hs-section">
	<div class="hs-container">
		<?php
		$hashone_testimonial_title = get_theme_mod('hashone_testimonial_title', __( 'Testimonials', 'hashone' ));
		$hashone_testimonial_sub_title = get_theme_mod('hashone_testimonial_sub_title', __( 'What our client says', 'hashone' ));
		?>

		<?php if($hashone_testimonial_title){ ?>
		<h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_testimonial_title); ?></h2>
		<?php } ?>

		<?php if($hashone_testimonial_sub_title){ ?>
		<div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_testimonial_sub_title); ?></div>
		<?php } ?>

		<div class="hs-testimonial-wrap wow fadeIn" data-wow-duration="1s" data-wow-delay="1s">
			<div class="hs-testimonial-slider">
			<?php 
			$hashone_testimonial_page = get_theme_mod('hashone_testimonial_page', array($hashone_page));
				if(is_array($hashone_testimonial_page)){
					$args = array(
							'post_type' => 'page',
							'post__in' => $hashone_testimonial_page,
							'posts_per_page' => 6
					 			);
					$query = new WP_Query($args);
					if($query->have_posts()):
						while($query->have_posts()) : $query->the_post();
						$hashone_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'hashone-thumb');
					?>
						<div class="hs-testimonial">
							<?php
								if(has_post_thumbnail()){
									?>
									<img class="animated wobble" src="<?php echo esc_url($hashone_image[0]) ?>" alt="<?php esc_attr(get_the_title()); ?>">
									<?php
								}
							?>
							<h3><?php the_title(); ?></h3>
							<div class="hs-testimonial-excerpt">
							<i class="fa fa-quote-left"></i>
							<?php 
							if(has_excerpt()){
								echo get_the_excerpt();
							}else{
								echo hashone_excerpt( get_the_content(), 300 );
							}
							?>
							<i class="fa fa-quote-right"></i>
							</div>
						</div>
					<?php
					endwhile;
					endif;	
					wp_reset_postdata();
				}
			?>
			</div>
		</div>
	</div>	
</section>
<?php } ?>

<?php if( get_theme_mod('hashone_disable_blog_sec') != 'on' ){ ?>
<section id="hs-blog-section" class="hs-section">
	<div class="hs-container">
		<?php
		$hashone_blog_title = get_theme_mod('hashone_blog_title', __('Latest blogs','hashone'));
		$hashone_blog_sub_title = get_theme_mod('hashone_blog_sub_title', __('Check out the latest post from our blog','hashone'));
		?>

		<?php if($hashone_blog_title){ ?>
		<h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_blog_title); ?></h2>
		<?php } ?>

		<?php if($hashone_blog_sub_title){ ?>
		<div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_blog_sub_title); ?></div>
		<?php } ?>

		<div class="hs-blog-wrap hs-clearfix">
		<?php 
			$hashone_blog_post_count = get_theme_mod('hashone_blog_post_count', 4);
			$hashone_blog_cat_exclude = get_theme_mod('hashone_blog_cat_exclude');

			$hashone_count = 0;
			$hashone_check = array( 3, 4, 7, 8);
			$args = array(
				'posts_per_page' => absint($hashone_blog_post_count),
				'category__not_in' => $hashone_blog_cat_exclude
				);
			$query = new WP_Query($args);
			if($query -> have_posts()):
				while($query -> have_posts()) : $query -> the_post();
				$hashone_image = wp_get_attachment_image_src(get_post_thumbnail_id() , 'hashone-portfolio-thumb');
				$hashone_count++;
				if(in_array($hashone_count, $hashone_check)){
					$hashone_class = "hs-right-img fadeInRight";
				}else{
					$hashone_class = "hs-left-img fadeInLeft";
				}

				$hashone_wow_delay = ($hashone_count*300)+300;
				?>
				<div class="hs-blog-post hs-clearfix wow <?php echo esc_attr($hashone_class); ?>" data-wow-duration="0.5s" data-wow-delay="<?php echo $hashone_wow_delay?>ms">
					<div class="hs-blog-thumbnail" style='background-image:url(<?php echo esc_url($hashone_image[0]) ?>);'>
						<a href="<?php the_permalink(); ?>">
							<img alt="<?php _e('portfolio thumb', 'hashone') ?>" src="<?php echo get_template_directory_uri() ?>/images/portfolio-thumb.png"/>
						</a>
					</div>

					<div class="hs-blog-excerpt">
					<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<div class="hs-blog-date"><i class="fa fa-calendar"></i><?php echo get_the_date(); ?></div>
						<?php 
						if(has_excerpt()){
							echo get_the_excerpt();
						}else{
							echo hashone_excerpt( get_the_content() , 160 );
						}
						?>
					</div>
				</div>
				<?php
				endwhile;
			endif;
			wp_reset_postdata();
		?>
		</div>	
	</div>
</section>
<?php } ?>

<?php if( get_theme_mod('hashone_disable_contact_sec') != 'on' ){ ?>
<section id="hs-contact-section" data-stellar-background-ratio="0.2">
<div class="hs-contact-section hs-section">
	<div class="hs-contact-overlay"></div>
	<div class="hs-container">
		<?php
		$hashone_contact_title = get_theme_mod('hashone_contact_title', __( 'Contact Us', 'hashone' ));
		$hashone_contact_sub_title = get_theme_mod('hashone_contact_sub_title', __( 'We would love to hear from you', 'hashone' ));
		?>

		<?php if($hashone_contact_title){ ?>
		<h2 class="hs-section-title wow fadeInUp" data-wow-duration="0.5s"><?php echo esc_html($hashone_contact_title); ?></h2>
		<?php } ?>

		<?php if($hashone_contact_sub_title){ ?>
		<div class="hs-section-tagline wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"><?php echo esc_html($hashone_contact_sub_title); ?></div>
		<?php } ?>

		<div class="hs-clearfix">
			<div class="hs-contact-form wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="1s">
				<?php 
				$hashone_contact_form = get_theme_mod( 'hashone_contact_form' );

				if($hashone_contact_form){
					echo do_shortcode(wp_kses_post($hashone_contact_form));
				}else{
					if(is_active_sidebar('hashone-contact-form')){
						dynamic_sidebar('hashone-contact-form');
					}
				}
				?>
			</div>
			
			<div class="hs-contact-address wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="1.5s">
				<?php
				$hashone_contact_detail = get_theme_mod( 'hashone_contact_detail', __( 'Contact us on the detail given below', 'hashone' ) );
				$hashone_contact_address = get_theme_mod( 'hashone_contact_address', __( 'Address: 2400 South Avenue', 'hashone' ) );
				$hashone_contact_phone = get_theme_mod( 'hashone_contact_phone', __( 'Phone: +928 336 2000', 'hashone' ) );
				$hashone_contact_email = get_theme_mod( 'hashone_contact_email', __( 'Email: support@hashthemes.com', 'hashone' ) );
				$hashone_contact_website = get_theme_mod( 'hashone_contact_website', __( 'Website: http://hashthemes.com', 'hashone' ) );
				?>
				<ul>
					<li><?php echo wp_kses_post(wpautop($hashone_contact_detail)); ?></li>
					<li><i class="fa fa-map-marker"></i><?php echo esc_html($hashone_contact_address); ?></li>
					<li><i class="fa fa-phone"></i><?php echo esc_html($hashone_contact_phone); ?></li>
					<li><i class="fa fa-envelope"></i><?php echo esc_html($hashone_contact_email); ?></li>
					<li><i class="fa fa-globe"></i><?php echo esc_html($hashone_contact_website); ?></li>
				</ul>

				<div class="hs-social">
				<?php 
					$facebook = get_theme_mod('hashone_social_facebook');
					$twitter = get_theme_mod('hashone_social_twitter');
					$google_plus = get_theme_mod('hashone_social_google_plus');
					$pinterest = get_theme_mod('hashone_social_pinterest');
					$youtube = get_theme_mod('hashone_social_youtube');
					$linkedin = get_theme_mod('hashone_social_linkedin');

					if($facebook)
						echo '<a class="sq-facebook" href="'.esc_url( $facebook ).'" target="_blank"><i class="fa fa-facebook"></i></a>';

					if($twitter)
						echo '<a class="sq-twitter" href="'.esc_url( $twitter ).'" target="_blank"><i class="fa fa-twitter"></i></a>';

					if($google_plus)
						echo '<a class="sq-googleplus" href="'.esc_url( $google_plus ).'" target="_blank"><i class="fa fa-google-plus"></i></a>';

					if($pinterest)
						echo '<a class="sq-pinterest" href="'.esc_url( $pinterest ).'" target="_blank"><i class="fa fa-pinterest"></i></a>';

					if($youtube)
						echo '<a class="sq-youtube" href="'.esc_url( $youtube ).'" target="_blank"><i class="fa fa-youtube"></i></a>';

					if($linkedin)
						echo '<a class="sq-linkedin" href="'.esc_url( $linkedin ).'" target="_blank"><i class="fa fa-linkedin"></i></a>';
				?>
				</div>
			</div>	
		</div>
	</div>
</div>
</section>
<?php }

get_footer(); 
}
