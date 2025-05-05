<?php
function get_pizzas_category($post_type, $cat_slug)
{
    $posts = get_posts([
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'tax_query'      => [
            [
                'taxonomy' => $post_type . '-category',
                'field'    => 'slug',
                'terms'    => $cat_slug,
            ],
        ],
    ]);

    return $posts;
}


function get_odivino_category($post_type, $cat_slug)
{
    $posts = get_posts([
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'tax_query'      => [
            [
                'taxonomy' => $post_type . '-category',
                'field'    => 'slug',
                'terms'    => $cat_slug,
            ],
        ],
    ]);

    return $posts;
}
