<?php

/**
 * Template Name: Odivino A Emporter Page Template V2
 * Description: A custom page template for the Odivino page.
 * Author: gui2one
 */
include get_stylesheet_directory() . '/functions_odivino.php';
get_header(); ?>
<?php


function get_base_tomate()
{
    $posts = get_odivino_category("a_emporter", "base-tomate");

    return $posts;
}

function get_base_mozzarella()
{
    $posts = get_odivino_category("a_emporter", "base-mozzarella-fior-di-latte");

    return $posts;
}

function get_speciales()
{
    $posts = get_odivino_category("a_emporter", "speciales");

    return $posts;
}

function display_items($posts, $title = "title")
{

    echo "<div class=\"odivino-plat-category-container\">";
    echo "<h4 class=\"italian-title\">$title</h4>";
    foreach ($posts as $post) {
        echo "<div class=\"odivino-plat-container\">";
        echo "<h5>$post->post_title</h5>";
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

    $plats_emporter = get_odivino_category("a_emporter", "desserts");
    display_items($plats_emporter, "Desserts");
    ?>
</main>
<?php get_footer(); ?>