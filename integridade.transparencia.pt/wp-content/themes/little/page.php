<?php get_header(); ?>

	<section id="content" class="clearfix">
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
			<article <?php post_class(); ?>>
		
				<h1 class="page-title"><?php the_title(); ?></h1>
				
				<div class="entry-content">
					<?php the_content(''); ?>
					<?php edit_post_link( __('Edit', 'junkie'), '<span class="edit-post">', '</span>' ); ?>
				</div><!-- .entry-content -->
			
			</article>
				
			<?php if(get_option('little_show_page_comments') == 'on') { ?>
				<?php comments_template('', true);  ?> 	
		  	<?php } ?>  
	
		<?php endwhile; ?>
		
		<?php else : ?>
		
		<?php endif; ?>
	
	</section><!-- #content -->
    
<?php get_sidebar(); ?>
<?php get_footer(); ?>