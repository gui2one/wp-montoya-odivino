<?php

get_header();
?>
<main class="odivino">
<div style="height:150px;"></div>
<h1><?php single_cat_title(); ?></h1>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
<?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>