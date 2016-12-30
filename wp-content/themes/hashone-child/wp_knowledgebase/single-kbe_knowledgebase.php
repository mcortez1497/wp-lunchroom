<?php
    get_header('kb');
    
    // load the style and script
    wp_enqueue_style ( 'kbe_theme_style' );
    if( KBE_SEARCH_SETTING == 1 ){
        wp_enqueue_script( 'kbe_live_search' );
    }
    
    // Classes For main content div
    if(KBE_SIDEBAR_INNER == 0) {
        $kbe_content_class = 'class="kbe_content_full"';
    } elseif(KBE_SIDEBAR_INNER == 1) {
        $kbe_content_class = 'class="kbe_content_right"';
    } elseif(KBE_SIDEBAR_INNER == 2) {
        $kbe_content_class = 'class="kbe_content_left"';
    }
    
    // Classes For sidebar div
    if(KBE_SIDEBAR_INNER == 0) {
        $kbe_sidebar_class = 'kbe_aside_none';
    } elseif(KBE_SIDEBAR_INNER == 1) {
        $kbe_sidebar_class = 'kbe_aside_left';
    } elseif(KBE_SIDEBAR_INNER == 2) {
        $kbe_sidebar_class = 'kbe_aside_right';
    }
?>

<header class="hs-main-header">
  <div class="hs-container">
    <h1 class="hs-main-title">
      <a href="<?php echo home_url( "/" . KBE_PLUGIN_SLUG . "/" ) ?>">Knowledge Base</a>
    </h1>
  </div>
</header><!-- .entry-header -->

<div class="hs-container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<div id="kbe_container">
    <!--Breadcrum-->
    <?php
        if(KBE_BREADCRUMBS_SETTING == 1){
    ?>
        <div class="kbe_breadcrum">
            <?php echo kbe_breadcrumbs(); ?>
        </div>
    <?php
        }
    ?>
    <!--/Breadcrum-->
        
    <!--content-->
    <div id="kbe_content" <?php echo $kbe_content_class; ?>>
        <!--Content Body-->
        <div class="kbe_leftcol" >
        <?php
            while(have_posts()) :
                the_post();

                //  Never ever delete it !!!
                kbe_set_post_views(get_the_ID());
        ?>
                <h1><?php the_title(); ?></h1>
            <?php 
                the_content();
                if(KBE_COMMENT_SETTING == 1){
            ?>
                    <div class="kbe_reply">
            <?php
                        comments_template("wp_knowledgebase/kbe_comments.php");
            ?>
                    </div> 
        <?php
                }
            endwhile;

            //  Never ever delete it !!!
            kbe_get_post_views(get_the_ID());
        ?>
        </div>
        <!--/Content Body-->

    </div>
	
    <!--aside-->
    <div class="kbe_aside <?php echo $kbe_sidebar_class; ?>">
    <?php
        if((KBE_SIDEBAR_INNER == 2) || (KBE_SIDEBAR_INNER == 1)){
            dynamic_sidebar('kbe_cat_widget');
        }
    ?>
    </div>
    <!--/aside-->
    
</div>

		</main><!-- #main -->
	</div><!-- #primary -->
</div>

<?php get_footer('kb'); ?>
