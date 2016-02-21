<?php get_header(); ?>

	<?php get_template_part( 'includes/breadcrumbs' ); ?>

	<section id="content">
			
		<?php if (have_posts()) : while ( have_posts() ) : the_post() ?>
		
			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

				<?php get_template_part( 'content', get_post_format() ); ?>

			</article><!-- #post-<?php the_ID(); ?> -->

		<?php endwhile; ?>
				
		<?php if (function_exists('junkie_pagination')) { ?>

			<div class="junkie-pagination">

				<?php junkie_pagination(); ?>

			</div><!-- .pagination --> 

		<?php } ?>
		
		<?php else : ?>
		
		<?php endif; ?>
		
	</section><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
