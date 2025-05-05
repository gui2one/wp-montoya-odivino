<?php

/**
 * Template Name: Odivino La Carte V2
 * Description: A custom page template for the Odivino page.
 * Author: gui2one
 */

get_header(); ?>


<?php
include get_stylesheet_directory() . '/../functions_odivino.php';


function display_items($posts, $title = "title")
{
    if (count($posts) == 0) {
        return;
    }
    echo "<div class=\"odivino-plat-category-container\">";
    echo "<h4 class=\"category-title italian-title \">$title</h4>";
    foreach ($posts as $post) {
        echo "<div class=\"odivino-plat-container\">";
        echo "<h5>$post->post_title</h5>";
        echo $post->post_content;
        echo "</div>";
    }
    echo "</div>";
}
function display_pizzas($title = "title")
{
    $pizzas_mozza     = get_odivino_category("la_carte", "Base Mozzarella fior di latte");
    $pizzas_tomate    = get_odivino_category("la_carte", "Base Tomate");
    $pizzas_speciales = get_odivino_category("la_carte", "Speciales");

    if (count($pizzas_mozza) == 0 && count($pizzas_tomate) == 0 && count($pizzas_speciales) == 0) {
        return;
    }
    echo "<div class=\"odivino-plat-category-container\">";
    echo "<h4 class=\"category-title italian-title \">$title</h4>";
    echo "<div class=\"odivino-pizza-category-container\">";
    echo "<h5>Base Mozzarella</h5>";
    foreach ($pizzas_mozza as $post) {
        echo "<div class=\"odivino-plat-container\">";
        echo "<h6>$post->post_title</h6>";
        echo $post->post_content;
        echo "</div>";
    }
    echo "</div>";

    echo "<div class=\"odivino-pizza-category-container\">";
    echo "<h5>Base Tomate</h5>";
    foreach ($pizzas_tomate as $post) {
        echo "<div class=\"odivino-plat-container\">";
        echo "<h6>$post->post_title</h6>";
        echo $post->post_content;
        echo "</div>";
    }
    echo "</div>";

    echo "<div class=\"odivino-pizza-category-container\">";
    echo "<h5>Les Spéciales</h5>";
    foreach ($pizzas_speciales as $post) {
        echo "<div class=\"odivino-plat-container\">";
        echo "<h6>$post->post_title</h6>";
        echo $post->post_content;
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
}

$entrees  = get_odivino_category("la_carte", "entrees");
$salades  = get_odivino_category("la_carte", "salades");
$plats    = get_odivino_category("la_carte", "plats");
$desserts = get_odivino_category("la_carte", "desserts");

$pizzas_mozza     = get_odivino_category("la_carte", "Base Mozzarella fior di latte");
$pizzas_tomate    = get_odivino_category("la_carte", "Base Tomate");
$pizzas_speciales = get_odivino_category("la_carte", "Speciales");
?>
<main class="odivino">
    <div style="height:150px;"></div>
    <h1>Notre Carte</h1>
    <div class="odivino-separator"></div>
    <?php the_content(); ?>
    <?php display_items($entrees, "Entrées"); ?>
    <?php display_items($salades, "Salades"); ?>

    <?php display_items($plats, "Plats"); ?>
    <?php display_pizzas("Les Pizzas"); ?>
    <?php display_items($desserts, "Desserts"); ?>


</main>
<?php get_footer(); ?>