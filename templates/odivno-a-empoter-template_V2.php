<?php

/**
 * Template Name: Odivino A Emporter Page Template V2
 * Description: A custom page template for the Odivino page.
 * Author: gui2one
 */

get_header(); ?>
<?php

function get_a_emporter_category($cat_slug)
{
    $posts = get_posts([
        'post_type'      => 'a_emporter',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'tax_query'      => [
            [
                'taxonomy' => 'a_emporter-category',
                'field'    => 'slug',
                'terms'    => $cat_slug,
            ],
        ],
    ]);

    return $posts;
}


function get_pizzas_category($category_slug)
{
    $posts = get_posts([
        'post_type'      => 'a_emporter',
        'posts_per_page' => -1,
        'tax_query'      => [
            [
                'taxonomy' => 'a_emporter-category',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ],
        ],
    ]);

    return $posts;
}
function get_base_tomate()
{
    $posts = get_pizzas_category("base-tomate");

    return $posts;
}

function get_base_mozzarella()
{
    $posts = get_pizzas_category("base-mozzarella-fior-di-latte");

    return $posts;
}

function get_speciales()
{
    $posts = get_pizzas_category("speciales");

    return $posts;
}

function display_items($posts, $title = "title")
{

    echo "<div class=\"odivino-plat-category-container\">";
    echo "<h4 class=\"italian-title\">$title</h4>";
    foreach ($posts as $post) {
        echo "<div class=\"odivino-plat-container\">";
        echo "<h4>$post->post_title</h4>";
        echo $post->post_content;
        echo "</div>";
    }
    echo "</div>";
}
?>

<main class="odivino">
    <div style="height:150px;"></div>
    <h1>A Emporter</h1>
    <h3>Les Pizzas</h3>


    <?php display_items(get_base_tomate(), "Base Tomate"); ?>
    <?php display_items(get_base_mozzarella(), "Base Mozzarella"); ?>
    <?php display_items(get_speciales(), "Les Spéciales"); ?>
    <div class="odivino-separator"></div>
    <h3>Gourmandises (6€)</h3>
    <?php

    $plats_emporter = get_a_emporter_category("desserts");
    display_items($plats_emporter, "Desserts");
    ?>
</main>
<?php get_footer(); ?>