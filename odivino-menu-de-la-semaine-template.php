<?php
/**
 * Template Name: Odivino Menu de la Semaine Template
 * Description: A custom page template for the Odivino page.
 * Author: gui2one
 */

get_header(); ?>


<?php
function get_plats_category($category_slug1, $category_slug2) {
   $posts = get_posts( array(
       'post_type' => 'plats',
       'posts_per_page' => -1,
       'tax_query' => array(
           'relation' => 'AND',
           array(
               'taxonomy' => 'plats-category',
               'field' => 'slug',
               'terms' => $category_slug1,
           ),
           array(
               'taxonomy' => 'plats-category',
               'field' => 'slug',
               'terms' => $category_slug2,
           ),
       ),
   ) );

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

$entrees = get_plats_category("menu-de-la-semaine", "entrees");
$plats = get_plats_category("menu-de-la-semaine", "plats");
$desserts = get_plats_category("menu-de-la-semaine", "desserts");
?>
<main class="odivino">
 <div style="height:150px;"></div>

   <h1>Menu de la Semaine</h1>
   <?php
      display_items($entrees, "Entrées");
      display_items($plats, "Plats");
      display_items($desserts, "Desserts");

   ?>

 </main>
 <?php get_footer(); ?>