<?php

    require_once 'inc/plats_post_type.php';
    require_once 'inc/pizzas_post_type.php';

    add_theme_support('post-thumbnails');

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

    wp_enqueue_script('wp-api');

    function custom_admin_menu()
    {
        add_menu_page(
            'Odivino Admin',              // Page title
            'Odivino Admin',              // Menu title
            'manage_options',             // Capability
            'odivino-admin',              // Menu slug (custom URL)
            'custom_admin_page_callback', // Callback function to render the page
            'dashicons-admin-tools',      // Icon
            2                             // Position
        );
    }
    add_action('admin_menu', 'custom_admin_menu');

    function custom_admin_page_callback()
    {
    ?>
    <div class="wrap">
        <h1>Odivino Admin ( Inutile pour l'instant)</h1>
        <p>This page allows you to edit posts using the REST API.</p>
        <div id="custom-app">



        </div>
        <script>

            function build_plat_container(plat_data){
                const plat_container = document.createElement('div');
                plat_container.className = 'plat-container';
                plat_container.style.opacity = "1.0";
                plat_container.style.transform = "unset";
                plat_container.innerHTML = `<h4>${plat_data.title}</h4><p>${plat_data.content}</p>`;
                plat_container.innerHTML += `<button>Edit plat (${plat_data.id})</button>`;
                return plat_container;
            }
            document.addEventListener('DOMContentLoaded', function () {
                fetch('/wp-json/wp/v2/plats')
                    .then(response => response.json())
                    .then((posts) => {
                        console.log(posts);
                        for(let post of posts){
                            const plat_container = build_plat_container({id : post.id, title: post.title.rendered, content: post.content.rendered});
                            document.getElementById('custom-app').appendChild(plat_container);
                        }
                    });
            });
        </script>
    </div>
    <?php
        }
