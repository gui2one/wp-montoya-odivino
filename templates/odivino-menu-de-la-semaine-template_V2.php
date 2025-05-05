<?php

/**
 * Template Name: Odivino Menu de la Semaine Template V2
 * Description: A custom page template for the Odivino page.
 * Author: gui2one
 */
include get_stylesheet_directory() . '/../functions_odivino.php';
get_header(); ?>


<?php


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

$entrees  = get_odivino_category("menu_semaine", "entrees");
$plats    = get_odivino_category("menu_semaine", "plats");
$desserts = get_odivino_category("menu_semaine", "desserts");
?>
<main class="odivino">
    <div style="height:150px;"></div>
    <h1>Menu de la Semaine</h1>
    <?php the_content(); ?>
    <?php display_items($entrees, "Entrées"); ?>
    <div class="odivino-separator"></div>
    <?php display_items($plats, "Plats"); ?>
    <div class="odivino-separator"></div>
    <?php display_items($desserts, "Desserts"); ?>



</main>
<?php get_footer(); ?>