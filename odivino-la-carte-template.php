<?php
    /**
     * Template Name: Odivino La Carte
     * Description: A custom page template for the Odivino page.
     * Author: gui2one
     */

get_header(); ?>


<?php
    function get_plats_category($cat_slug)
    {
        $posts = get_posts([
            'post_type'      => 'plats',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'tax_query'      => [
                [
                    'taxonomy' => 'plats-category',
                    'field'    => 'slug',
                    'terms'    => $cat_slug,
                ],
            ],
        ]);

        return $posts;
    }

    function get_pizzas_category($cat_slug)
    {
        $posts = get_posts([
            'post_type'      => 'pizzas',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'tax_query'      => [
                [
                    'taxonomy' => 'pizzas-category',
                    'field'    => 'slug',
                    'terms'    => $cat_slug,
                ],
            ],
        ]);

        return $posts;
    }
    function display_items($posts, $title = "title")
    {

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
        $pizzas_mozza     = get_pizzas_category("Base Mozzarella fior di latte");
        $pizzas_tomate    = get_pizzas_category("Base Tomate");
        $pizzas_speciales = get_pizzas_category("Speciales");
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

    $entrees  = get_plats_category("entrees");
    $plats    = get_plats_category("plats");
    $desserts = get_plats_category("desserts");

    $pizzas_mozza     = get_pizzas_category("Base Mozzarella fior di latte");
    $pizzas_tomate    = get_pizzas_category("Base Tomate");
    $pizzas_speciales = get_pizzas_category("Speciales");
?>
<main class="odivino">
 <div style="height:150px;"></div>
 <h1>Notre Carte</h1>
 <div class="odivino-separator"></div>
 <?php the_content(); ?>
<?php display_items($entrees, "Entrées"); ?>

<?php display_items($plats, "Plats"); ?>
<?php display_pizzas("Les Pizzas"); ?>
<?php display_items($desserts, "Desserts"); ?>


 </main>
 <?php get_footer(); ?>