<?php get_header(); ?>


<?php 


function get_pizzas_category($category_slug) {
    $posts = get_posts( array(
        'post_type' => 'pizzas',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'pizzas-category',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        ),
    ) );

    return $posts;
}
function get_base_tomate() {
    $posts = get_pizzas_category("base-tomate");

    return $posts;
}

function get_base_mozzarella() {
    $posts = get_pizzas_category("base-mozzarella-fior-di-latte");

    return $posts;
}


function get_speciales() {
    $posts = get_pizzas_category("speciales");

    return $posts;
}

function display_items($posts, $title = "title") {

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
    <h1>Nos Pizzas</h1>

    <!-- Recipe Loop -->
    <?php if (have_posts()) : ?>

            <?php 

            display_items(get_base_tomate(), "Base Tomate");
            display_items(get_base_mozzarella(), "Base Mozzarella");
            display_items(get_speciales(), "Les Spéciales");

            
            ?>

    <?php else : ?>
        <p>No recipes found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>