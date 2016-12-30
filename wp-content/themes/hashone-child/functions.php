<?php

// BEGIN PARENT FUNCTIONS
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
// END PARENT FUNCTIONS

// BEGIN CHILD FUNCTIONS
function lunchroom_dynamic_styles(){
	echo "<style>";

  // Twitch logo for Log In/Log Out nav button
  $twitch_icon = get_stylesheet_directory_uri() . '/images/twitch_icon_white_24.png';
  $twitch_icon_hover = get_stylesheet_directory_uri() . '/images/twitch_icon_orange_24.png';
  echo '.lr-menu-login-icon { background-image: url(' . $twitch_icon  . '); } ';
  echo '.lr-menu-login:hover .lr-menu-login-icon { background-image: url(' . $twitch_icon_hover  . '); } ';
  

  // Custom colors for Featured Images section
  for( $i = 1; $i < 5; $i++ ) {
    $hashone_featured_page_icon_color = get_theme_mod('hashone_featured_page_color'.$i, '#EE3B24' );
    echo '.hs-featured-icon.icon-color-' . $i . ':before { border-bottom: 25px solid ' . $hashone_featured_page_icon_color  . '; } ';
    echo '.hs-featured-icon.icon-color-' . $i . ' { background: ' . $hashone_featured_page_icon_color  . '; } ';
    echo '.hs-featured-icon.icon-color-' . $i . ':after { border-top: 25px solid ' . $hashone_featured_page_icon_color  . '; } ';
  }

	echo "</style>";
}

add_action( 'wp_head', 'lunchroom_dynamic_styles' );
// END CHILD FUNCTIONS


?>
