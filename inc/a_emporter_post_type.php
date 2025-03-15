<?php

function odivino_pizzas_taxonomy() {
    register_taxonomy(
        'pizzas-category', // Taxonomy slug
        'carte_odivino', // Custom post type it applies to
        array(
            'label' => __('Pizzas Categories'),
            'rewrite' => array('slug' => 'pizzas-category'),
            'hierarchical' => true, // Makes it behave like categories (not tags)
            'show_in_rest' => true, // Enables Gutenberg support
            'query_var' => true
        )
    );
}
add_action('init', 'odivino_pizzas_taxonomy');

function register_odivino_pizza_type() {
    register_post_type('pizzas', [
        'labels' => [
            'name' => __('Pizzas'),
            'singular_name' => __('Pizza'),
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_nav_menus'  => true,
        'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'taxonomies' => ['pizzas-category'],
        'capability_type' => 'page',
		'template'    => array(
            array('core/paragraph', array(
                'placeholder' => __('List ingredients here...')
            )),
            ),
		'template_lock' => 'insert'
    ]);
}
add_action('init', 'register_odivino_pizza_type');


// Add the Recipe Category column to the admin list view
function add_pizzas_category_column($columns) {
    $columns['pizzas_category'] = __('Pizzas Category');
    return $columns;
}
add_filter('manage_pizzas_posts_columns', 'add_pizzas_category_column');

// Fill the Recipe Category column with data
function show_pizzas_category_column($column, $post_id) {
    if ($column === 'pizzas_category') {
        $terms = get_the_terms($post_id, 'pizzas-category');
        if ($terms && !is_wp_error($terms)) {
            $categories = array();
            foreach ($terms as $term) {
                $categories[] = sprintf('<a href="%s">%s</a>', esc_url(get_edit_term_link($term->term_id, 'pizzas-category')), esc_html($term->name));
            }
            echo implode(', ', $categories);
        } else {
            echo '—';
        }
    }
}
add_action('manage_pizzas_posts_custom_column', 'show_pizzas_category_column', 10, 2);


// Add a dropdown filter for Recipe Categories in the admin post list
function filter_pizzas_by_category($post_type, $which) {
    if ($post_type !== 'pizzas') return;

    $taxonomy = 'pizzas-category';
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
add_action('restrict_manage_posts', 'filter_pizzas_by_category', 10, 2);

// Modify the query to filter by the selected category
function filter_pizzas_admin_query($query) {
    global $pagenow;
    if ($pagenow === 'edit.php' && isset($_GET['pizzas_category']) && !empty($_GET['pizzas_category'])) {
        $query->query_vars['tax_query'] = array(
            array(
                'taxonomy' => 'pizzas-category',
                'field'    => 'slug',
                'terms'    => $_GET['pizzas_category'],
            ),
        );
    }
}
add_filter('pre_get_posts', 'filter_pizzas_admin_query');
