<?php get_header();  ?>

	<section id="content" class="clearfix">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

					<?php get_template_part( 'content', get_post_format() ); ?>

				</article>

				<div class="clearfix"></div>

			<?php endwhile; ?>

			<?php if (function_exists('junkie_pagination')) { ?>

				<div class="junkie-pagination">

					<?php junkie_pagination(); ?>

				</div><!-- .pagination --> 

			<?php } ?>

		<?php else: ?>
		
			<article id="post-0" class="post no-results not-found">
		
				<h3><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for...', 'junkie' ); ?></h3>

			</article>

		<?php endif; ?>

	</section><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>