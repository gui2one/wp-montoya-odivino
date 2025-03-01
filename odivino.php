<?php

require_once('inc/plats_post_type.php');
require_once('inc/pizzas_post_type.php');

add_theme_support('post-thumbnails');



function enqueue_odivino_scripts() {
    wp_register_script( 'odivino-script', get_stylesheet_directory_uri() . '/odivino-script.js', array('jquery'), false, true );
	wp_enqueue_script( 'odivino-script' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_odivino_scripts' );


/* adding settings for cutsom google map module */
function my_child_theme_customize_register($wp_customize) {
    // Add section for Google Maps settings
    $wp_customize->add_section('odivino_google_maps_settings', array(
        'title'    => __('Google Maps Settings', 'my-child-theme'),
        'priority' => 0,
    ));

    // Add setting for Google Maps API key
    $wp_customize->add_setting('odivino_google_maps_api_key', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('odivino_google_maps_api_key', array(
        'label'      => __('API key', 'montoya'),
        'section'    => 'odivino_google_maps_settings',
        'settings'   => 'odivino_google_maps_api_key',
    ));

    // Add setting for Google Maps mapId
    $wp_customize->add_setting('odivino_google_maps_map_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('odivino_google_maps_map_id', array(
        'label'      => __('map ID', 'montoya'),
        'section'    => 'odivino_google_maps_settings',
        'settings'   => 'odivino_google_maps_map_id',
    ));

    // Add setting for Google Maps Latitude
    $wp_customize->add_setting('odivino_google_maps_coords', array(
        'default'           => "45.0, -2.2",
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('odivino_google_maps_coords', array(
        'label'      => __('GPS Coords', 'montoya'),
        'section'    => 'odivino_google_maps_settings',
        'settings'   => 'odivino_google_maps_coords',
    ));    
        
}
add_action('customize_register', 'my_child_theme_customize_register');