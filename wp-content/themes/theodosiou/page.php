<?php get_header(); ?>

<?php

?>
<div id="navbar">
    <div class="menubar">
        <ul class="menubar__wrapper">
            <li class="menubar__burger menu-item-has-children menu-item-has-children--no-add">
                <a id="a" href="#" class="burger">
                    <div class="burger__slash burger__slash--one"></div>
                    <div class="burger__slash burger__slash--two"></div>
                    <div class="burger__slash  burger__slash--three"></div>
                </a>
                <?php wp_nav_menu(); ?>
            </li>
        </ul>
    </div>
</div>

<main role="main">
    <section>
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php the_content(); ?>
                <br class="clear">
            </article>
        <?php endwhile; ?>
        <?php else: ?>
            <article>
                <h2><?php _e('Sorry, nothing to display.', 'html5blank'); ?></h2>
            </article>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
