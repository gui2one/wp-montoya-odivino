<?php

require_once("odivino.php");

// enqueue parent theme styles
function my_theme_enqueue_styles() {

	$content_style = 'montoya-content';
	$showcase_style = 'montoya-showcase';
	$portfolio_style = 'montoya-portfolio';
	$blog_style = 'montoya-blog';
	$shortcodes_style = 'montoya-shortcodes';
	$assets_style = 'montoya-assets';
	$shop_style = 'montoya-shop';
	$wp_style = 'montoya-style-wp';
	$page_builders_style = 'montoya-page-builders';
	$parent_style = 'parent-style';
		
	wp_enqueue_style( $content_style, get_template_directory_uri() . '/css/content.css' );
	wp_enqueue_style( $showcase_style, get_template_directory_uri() . '/css/showcase.css' );
	wp_enqueue_style( $portfolio_style, get_template_directory_uri() . '/css/portfolio.css' );
	wp_enqueue_style( $blog_style, get_template_directory_uri() . '/css/blog.css' );
	wp_enqueue_style( $shortcodes_style, get_template_directory_uri() . '/css/shortcodes.css' );
	wp_enqueue_style( $assets_style, get_template_directory_uri() . '/css/assets.css' );
	wp_enqueue_style( $shop_style, get_template_directory_uri() . '/css/shop.css' );
	wp_enqueue_style( $wp_style, get_template_directory_uri() . '/css/style-wp.css' );
	wp_enqueue_style( $page_builders_style, get_template_directory_uri() . '/css/page-builders.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	
	// if WpBakery is installed, make sure we enqueue js composer syles and library 
	if ( function_exists( 'vc_set_as_theme' ) ) {
		
		// the child script childscript.js will call vc_js() on ajax success event
		wp_enqueue_script( 'wpb_composer_front_js' );

		wp_enqueue_style( 'js_composer_front' );
		wp_enqueue_style( 'js_composer_custom_css' );
		
		if( !function_exists( 'filter_the_content_vc_custom_styles' ) ){
			
			// retrieve vc custom CSS styles added for each row
			function filter_the_content_vc_custom_styles( $content ) {
		
				if ( isset( $_GET['preview'] ) && 'true' === $_GET['preview'] ) {
					 
					 return $content;
				}
				
				/* AJAX check  */
				if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
					
					$this_post_id = null;
				
					// Check if we're inside the main loop in a single post page.
					if ( ( is_single() || is_page() ) && in_the_loop() &&  is_main_query() ) {
						
						if ( is_front_page() || is_home() ) {
							$this_post_id = get_queried_object_id();
						} else if ( is_singular() ) {
							if ( !$this_post_id ) {
								$this_post_id = get_the_ID();
							}
						}

						$post_custom_css = get_metadata( 'post', $this_post_id, '_wpb_shortcodes_custom_css', true );
						if ( ! empty( $post_custom_css ) ) {
							
							$post_custom_css = strip_tags( $post_custom_css );
							return $content . '<style type="text/css" data-type="vc_custom-css">' . $post_custom_css . '</style>';
						}
						
					}
				}
				
				return $content;
			}
		}
		add_filter( 'the_content', 'filter_the_content_vc_custom_styles' );
	}
	
	// register your child script
	wp_register_script( 'childscript', get_stylesheet_directory_uri() . '/childscript.js', array('jquery'), false, true );
	wp_enqueue_script( 'childscript' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// allowable HTML tags in theme options - add here more than the ones already accepted by the theme
if( !function_exists('serano_child_kses_allowed_html') ){

	function serano_child_kses_allowed_html($tags, $context) {
		
		switch($context) {
			case 'serano_allowed_html':
				$tags = array(
					'a' => array(
								'id' => array(),
								'href' => array(),
								'title' => array(),
								'rel' => array(),
								'target' => array(),
								'class' => array(),
								'data-type' => array(),
								'data-filter' => array()
							),
					'div' => array(
								'id' => array(),
								'class' => array()
								),
					'span' => array(
								'id' => array(),
								'class' => array(),
								'data-hover' => array()
								),
					'img' => array(
								'src' => array(),
								'alt' => array(),
								'width' => array(),
								'height' => array(),
								'class' => array()
								),
					'h1' => array(),
					'h2' => array(),
					'h3' => array(),
					'h4' => array(),
					'h5' => array(),
					'h6' => array(),
					'ul' => array(
							'id' => array(),
							'class' => array()
							),
					'li' => array(
							'class' => array()
							),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
					'b' => array(),
					'i' => array(
							'id' => array(),
							'class' => array()
							),
					'u' => array(),
					'p' => array(
							'id' => array(),
							'class' => array()
							),
					'hr' => array(),
					'figure' => array(
							'id' => array(),
							'class' => array()
							)
				);
				return $tags;
			default: 
				return $tags;
		}

	}

	add_filter( 'wp_kses_allowed_html', 'serano_child_kses_allowed_html', 9, 2 );

}


?>