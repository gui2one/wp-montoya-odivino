<?php

function odivino_taxonomy() {
    register_taxonomy(
        'plats-category', // Taxonomy slug
        'carte_odivino', // Custom post type it applies to
        array(
            'label' => __('Plats Categories'),
            'rewrite' => array('slug' => 'plats-category'),
            'hierarchical' => true, // Makes it behave like categories (not tags)
            'show_in_rest' => true, // Enables Gutenberg support
            'query_var' => true
        )
    );
}
add_action('init', 'odivino_taxonomy');

add_theme_support('post-thumbnails');
function register_odivino_post_type() {
    register_post_type('plats', [
        'labels' => [
            'name' => __('Plats'),
            'singular_name' => __('Plat'),
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_nav_menus'  => true,
        'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'taxonomies' => ['plats-category'],
        'capability_type' => 'page',
		'template'    => array(
                array('core/columns', array(), array( // Create a 2-column layout
                    array('core/column', array(), array( // First column (Image)
                        array('core/image', array()),
                    )),
                    array('core/column', array(), array( // Second column (Description + Ingredients)
                        array('core/post-title', array(
                            'placeholder' => 'Write a short description...',
                        )),
                        array('core/list', array(
                            'placeholder' => 'List ingredients here...'
                        )),
                    )),
                )),
            ),
		'template_lock' => 'insert'
    ]);
}
add_action('init', 'register_odivino_post_type');


// Add the Recipe Category column to the admin list view
function add_plats_category_column($columns) {
    $columns['plats_category'] = __('Plats Category');
    return $columns;
}
add_filter('manage_plats_posts_columns', 'add_plats_category_column');

// Fill the Recipe Category column with data
function show_plats_category_column($column, $post_id) {
    if ($column === 'plats_category') {
        $terms = get_the_terms($post_id, 'plats-category');
        if ($terms && !is_wp_error($terms)) {
            $categories = array();
            foreach ($terms as $term) {
                $categories[] = sprintf('<a href="%s">%s</a>', esc_url(get_edit_term_link($term->term_id, 'plats-category')), esc_html($term->name));
            }
            echo implode(', ', $categories);
        } else {
            echo '—';
        }
    }
}
add_action('manage_plats_posts_custom_column', 'show_plats_category_column', 10, 2);


// Add a dropdown filter for Recipe Categories in the admin post list
function filter_plats_by_category($post_type, $which) {
    if ($post_type !== 'plats') return;

    $taxonomy = 'plats_category';
    $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false));

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
add_action('restrict_manage_posts', 'filter_plats_by_category', 10, 2);

// Modify the query to filter by the selected category
function filter_plats_admin_query($query) {
    global $pagenow;
    if ($pagenow === 'edit.php' && isset($_GET['plats_category']) && !empty($_GET['plats_category'])) {
        $query->query_vars['tax_query'] = array(
            array(
                'taxonomy' => 'plats_category',
                'field'    => 'slug',
                'terms'    => $_GET['plats_category'],
            ),
        );
    }
}
add_filter('pre_get_posts', 'filter_plats_admin_query');
