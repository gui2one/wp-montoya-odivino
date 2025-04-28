<?php

require_once 'inc/plats_post_type.php';
require_once 'inc/pizzas_post_type.php';
require_once 'inc/utils.php';

add_theme_support('post-thumbnails');


// A emporter
create_custom_post_type_and_taxonomy([
    'post_type'        => 'a_emporter',
    'post_type_labels' => [
        'name'     => 'A emporter',
        'singular' => 'A emporter',
    ],
    'taxonomy'         => [
        'slug'         => 'a_emporter-category',
        'label'        => 'Categories',
        'hierarchical' => true,
        'show_in_rest' => true,
        'query_var'    => true,
    ],
    'supports'         => ['title', 'editor', 'thumbnail', 'custom-fields'],
    'template'         => [
        ['core/paragraph', ['placeholder' => __('List ingredients here...')]],
    ],
]);
add_category_column_and_filter('a_emporter');

// La Carte
create_custom_post_type_and_taxonomy([
    'post_type'        => 'la_carte',
    'post_type_labels' => [
        'name'     => 'La Carte',
        'singular' => 'La Carte',
    ],
    'taxonomy'         => [
        'slug'         => 'la_carte-category',
        'label'        => 'Categories',
        'hierarchical' => true,
        'show_in_rest' => true,
        'query_var'    => true,
    ],
    'supports'         => ['title', 'editor', 'thumbnail', 'custom-fields'],
    'template'         => [
        ['core/paragraph', ['placeholder' => __('List ingredients here...')]],
    ],
]);
add_category_column_and_filter('la_carte');

// Menu de la semaine
create_custom_post_type_and_taxonomy([
    'post_type'        => 'menu_semaine',
    'post_type_labels' => [
        'name'     => 'Menu de la Semaine',
        'singular' => 'Menu de la Semaine',
    ],
    'taxonomy'         => [
        'slug'         => 'menu_semaine-category',
        'label'        => 'Categories',
        'hierarchical' => true,
        'show_in_rest' => true,
        'query_var'    => true,
    ],
    'supports'         => ['title', 'editor', 'thumbnail', 'custom-fields'],
    'template'         => [
        ['core/paragraph', ['placeholder' => __('List ingredients here...')]],
    ],
]);
add_category_column_and_filter('menu_semaine');

function enqueue_odivino_scripts()
{
    wp_register_script('odivino-script', get_stylesheet_directory_uri() . '/odivino-script.js', ['jquery'], false, true);
    wp_enqueue_script('odivino-script');
}

add_action('wp_enqueue_scripts', 'enqueue_odivino_scripts');

/* adding settings for cutsom google map module */
function my_child_theme_customize_register($wp_customize)
{
    // Add section for Google Maps settings
    $wp_customize->add_section('odivino_google_maps_settings', [
        'title'    => __('Google Maps Settings', 'my-child-theme'),
        'priority' => 0,
    ]);

    // Add setting for Google Maps API key
    $wp_customize->add_setting('odivino_google_maps_api_key', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('odivino_google_maps_api_key', [
        'label'    => __('API key', 'montoya'),
        'section'  => 'odivino_google_maps_settings',
        'settings' => 'odivino_google_maps_api_key',
    ]);

    // Add setting for Google Maps mapId
    $wp_customize->add_setting('odivino_google_maps_map_id', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('odivino_google_maps_map_id', [
        'label'    => __('map ID', 'montoya'),
        'section'  => 'odivino_google_maps_settings',
        'settings' => 'odivino_google_maps_map_id',
    ]);

    // Add setting for Google Maps Latitude
    $wp_customize->add_setting('odivino_google_maps_coords', [
        'default'           => "45.0, -2.2",
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('odivino_google_maps_coords', [
        'label'    => __('GPS Coords', 'montoya'),
        'section'  => 'odivino_google_maps_settings',
        'settings' => 'odivino_google_maps_coords',
    ]);
}
add_action('customize_register', 'my_child_theme_customize_register');
