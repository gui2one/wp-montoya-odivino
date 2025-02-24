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

$entrees = get_plats_category("menu-de-la-semaine", "entrees");
?>
<main class="odivino">
 <div style="height:150px;"></div>

   <h1>Menu de la Semaine</h1>
   <?php
      foreach ($entrees as $post) {
         echo "<div class=\"odivino-plat-container\">";
         echo "<h4>$post->post_title</h4>";
         echo $post->post_content;
         echo "</div>";
      }

   ?>

 </main>
 <?php get_footer(); ?>