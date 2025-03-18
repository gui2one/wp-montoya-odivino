<?php

function js_file_make_module($file_tag)
{
    add_filter('script_loader_tag', function ($tag, $handle) use ($file_tag) {
        if ($handle !== $file_tag) {
            return $tag;
        }
        return str_replace('src=', 'type="module" src=', $tag);
    }, 10, 2);
}
function register_custom_post_type_and_taxonomy($args)
{
    // Register Taxonomy
    if (! empty($args['taxonomy'])) {
        register_taxonomy(
            $args['taxonomy']['slug'],
            $args['post_type'],
            [
                'label'        => __($args['taxonomy']['label']),
                'rewrite'      => ['slug' => $args['taxonomy']['slug']],
                'hierarchical' => $args['taxonomy']['hierarchical'] ?? true,
                'show_in_rest' => $args['taxonomy']['show_in_rest'] ?? true,
                'query_var'    => $args['taxonomy']['query_var'] ?? true,
            ]
        );

        // Add hardcoded categories
        $default_terms = ['Entrees', 'Salades', 'Pizzas', 'Plats', 'Desserts'];

        foreach ($default_terms as $term) {
            if (! term_exists($term, $args['taxonomy']['slug'])) {
                wp_insert_term($term, $args['taxonomy']['slug']);
            }
        }
    }

    // Register Custom Post Type
    register_post_type($args['post_type'], [
        'labels'             => [
            'name'          => __($args['post_type_labels']['name']),
            'singular_name' => __($args['post_type_labels']['singular']),
        ],
        'public'             => $args['public'] ?? true,
        'has_archive'        => $args['has_archive'] ?? true,
        'show_in_nav_menus'  => $args['show_in_nav_menus'] ?? true,
        'supports'           => $args['supports'] ?? ['title', 'editor', 'thumbnail'],
        'show_in_rest'       => $args['show_in_rest'] ?? true,
        'publicly_queryable' => $args['publicly_queryable'] ?? true,
        'taxonomies'         => isset($args['taxonomy']) ? [$args['taxonomy']['slug']] : [],
        'capability_type'    => $args['capability_type'] ?? 'page',
        'template'           => $args['template'] ?? [],
        'template_lock'      => $args['template_lock'] ?? 'insert',
        'menu_position'      => $args['menu_position'] ?? 1,
        'show_in_menu'       => $args['show_in_menu'] ?? true,
    ]);
}
