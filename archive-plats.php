<?php get_header(); ?>

<main>
    <div style="height:150px;"></div>
    <h1>Notre Carte</h1>

    <!-- Category List -->
    <ul class="plats-categories">
        <?php
        $categories = get_terms('plats-category'); // Get all categories
        foreach ($categories as $category) :
            echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
        endforeach;
        ?>
    </ul>

    <!-- Recipe Loop -->
    <?php if (have_posts()) : ?>
        <div class="recipes-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article class="recipe">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php the_post_thumbnail_url('small'); ?>" alt="<?php the_title(); ?>">
                        </a>
                    <?php endif; ?>

                    <!-- <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> -->

                    <p><?php echo wp_trim_words(the_content(), 20); ?></p> <!-- Short description -->

                    <!-- Display plats Categories -->
                    <p class="plats-meta">
                        Categories: <?php the_terms(get_the_ID(), 'plats_category', '', ', '); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>" class="btn">View Plat</a>
                </article>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>No recipes found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>