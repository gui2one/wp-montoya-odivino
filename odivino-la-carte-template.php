<?php
    /**
     * Template Name: Odivino La Carte
     * Description: A custom page template for the Odivino page.
     * Author: gui2one
     */

get_header(); ?>


<?php
    function get_plats_category2($category_slug1, $category_slug2)
    {
        $posts = get_posts([
            'post_type'      => 'plats',
            'posts_per_page' => -1,
            'tax_query'      => [
                'relation' => 'AND',
                [
                    'taxonomy' => 'plats-category',
                    'field'    => 'slug',
                    'terms'    => $category_slug1,
                ],
                [
                    'taxonomy' => 'plats-category',
                    'field'    => 'slug',
                    'terms'    => $category_slug2,
                ],
            ],
        ]);

        return $posts;
    }

    function get_plats_category($cat_slug)
    {
        $posts = get_posts([
            'post_type'      => 'plats',
            'posts_per_page' => -1,
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
        echo "<h4 class=\"italian-title\">$title</h4>";
        foreach ($posts as $post) {
            echo "<div class=\"odivino-plat-container\">";
            echo "<h5>$post->post_title</h5>";
            echo $post->post_content;
            echo "</div>";
        }
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
 <?php the_content(); ?>
 <h2>Les Plats</h2>
    <?php display_items($entrees, "Entrées"); ?>
<?php display_items($plats, "Plats"); ?>
<?php display_items($desserts, "Desserts"); ?>

    <div class="odivino-separator"></div>

    <h2>Les Pizzas</h2>
    <?php display_items($pizzas_mozza, "Base Mozzarella"); ?>
<?php display_items($pizzas_tomate, "Base Tomate"); ?>
<?php display_items($pizzas_speciales, "Spéciales"); ?>
 </main>
 <?php get_footer(); ?>