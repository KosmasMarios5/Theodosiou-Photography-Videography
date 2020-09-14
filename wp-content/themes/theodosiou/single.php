<?php get_header(); ?>

<main role="main">
    <section>
		<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_content(); // Dynamic Content ?>
            </article>
		<?php endwhile; ?>

		<?php else: ?>
            <article>
                <h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>
            </article>
		<?php endif; ?>
    </section>
</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
