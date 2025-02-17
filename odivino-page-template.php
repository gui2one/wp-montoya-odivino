<?php
/**
 * Template Name: Odivino Page Template
 * Description: A custom page template for the Odivino page.
 * Author: gui2one
 */

get_header(); ?>

<main class="odivino">
 <div style="height:150px;"></div>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
 </main>
 <?php get_footer(); ?>