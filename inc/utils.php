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
function __register_custom_post_type_and_taxonomy($args)
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
        'supports'           => $args['supports'] ?? ['title', 'editor', 'thumbnail', 'custom-fields'],
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

function create_custom_post_type_and_taxonomy($args)
{
    add_action('init', function () use ($args) {
        __register_custom_post_type_and_taxonomy($args);
    });
}

function add_category_column($columns, $slug)
{
    $columns[$slug . '_category'] = 'Category';
    return $columns;
}
function show_category_column($column, $post_id, $slug)
{

    if ($column === $slug . "_category") {
        $terms = get_the_terms($post_id, $slug . '-category');
        if ($terms && ! is_wp_error($terms)) {
            $categories = [];
            foreach ($terms as $term) {
                $categories[] = sprintf('<a href="%s">%s</a>', esc_url(get_edit_term_link($term->term_id, $slug . '-category')), esc_html($term->name));
            }
            echo implode(', ', $categories);
        } else {
            echo '—';
        }
    }
}

function filter_by_category($post_type, $which, $slug)
{
    if ($post_type !== $slug) {
        return;
    }

    $taxonomy = $slug . '-category';
    $terms    = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => true]);

    if ($terms) {
        echo '<select name="' . esc_attr($taxonomy) . '" id="' . esc_attr($taxonomy) . '" class="postform">';
        echo '<option value="">All Categories</option>';
        foreach ($terms as $term) {
            $selected = (isset($_GET[$taxonomy]) && $_GET[$taxonomy] == $term->slug) ? ' selected="selected"' : '';
            echo '<option value="' . esc_attr($term->slug) . '"' . $selected . '>' . esc_html($term->name) . '</option>';
        }
        echo '</select>';
    }
}
function add_category_column_and_filter($slug)
{
    add_filter('manage_' . $slug . '_posts_columns', function ($columns) use ($slug) {
        return add_category_column($columns, $slug);
    });
    add_action('manage_' . $slug . '_posts_custom_column', function ($column, $post_id) use ($slug) {
        show_category_column($column, $post_id, $slug);
    }, 10, 2);

    add_action('restrict_manage_posts', function ($post_type, $which) use ($slug) {
        filter_by_category($post_type, $which, $slug);
    }, 10, 2);
}
