<?php get_header(); ?>


<?php

    function get_plats_category($category_slug)
    {
        $posts = get_posts([
            'post_type'      => 'plats',
            'posts_per_page' => -1,
            'tax_query'      => [
                [
                    'taxonomy' => 'plats-category',
                    'field'    => 'slug',
                    'terms'    => $category_slug,
                ],
            ],
        ]);

        return $posts;
    }
    function get_entrees()
    {
        $posts = get_plats_category("entrees");

        return $posts;
    }

    function get_plats()
    {
        $posts = get_plats_category("plats");

        return $posts;
    }

    function get_desserts()
    {
        $posts = get_plats_category("desserts");
        return $posts;
    }

    function display_items($posts, $title = "title")
    {

        echo "<div class=\"odivino-plat-category-container\">";
        echo "<h2 class=\"italian-title\">$title</h2>";
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
    <h1>Notre Carte</h1>

    <!-- Recipe Loop -->
    <?php if (have_posts()): ?>




<?php display_items(get_entrees(), "Les Entrées"); ?>
<div class="odivino-separator"></div>
<?php display_items(get_plats(), "Les Plats"); ?>
<div class="odivino-separator"></div>
<?php display_items(get_desserts(), "Les Desserts"); ?>



    <?php else: ?>
        <p>No recipes found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>