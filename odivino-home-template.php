<?php
    /**
     * Template Name: Odivino Home Page Template
     * Description: A custom page template for the Odivino Home page.
     * Author: gui2one
     */

get_header(); ?>

<div id="odivino_home_header">
  <div class="image-container">
    <?php
        $image = get_the_post_thumbnail_url(get_the_ID(), "full");
        if ($image) {
            echo "<img src=" . esc_url($image) . ">";
        }
    ?>
  </div> <!-- END image-container -->
  <div class="content">
    <h1 class="odivino-animated-title">O'Divino</h1>
    <span class="odivino-sub-title"></span>
  </div>
    </div> <!-- END header -->
<main class="odivino">
 <div style="height:150px;"></div>
    <?php the_content(); ?>
 </main>
 <?php get_footer(); ?>