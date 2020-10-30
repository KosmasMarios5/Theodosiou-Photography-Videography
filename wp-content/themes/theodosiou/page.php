<?php get_header(); ?>



<div id="page-header">
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

    <a href="https://new.theodosiou.gr" class="site-logo-top">
        <img title="logo-01" alt="logo-01"
             src="https://new.theodosiou.gr/wp-content/uploads/elementor/thumbs/logo-01-1-owgv4xb1tnh31on8r064felao4vryxoe50z483wgu4.png">
        <noscript><img
                    src="https://new.theodosiou.gr/wp-content/uploads/elementor/thumbs/logo-01-1-owgv4xb1tnh31on8r064felao4vryxoe50z483wgu4.png"
                    title="logo-01" alt="logo-01"/></noscript>
    </a>
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
