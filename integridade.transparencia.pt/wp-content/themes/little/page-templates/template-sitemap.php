<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header(); ?>

<section id="content" class="clearfix">

	<?php if (have_posts()) : the_post(); ?>

		<article <?php post_class(); ?>>

		    <h1 class="page-title"><?php the_title(); ?></h1>    
		
		    <div class="entry-content">
		
		        <?php the_content(); ?>
		
		      	<div class="alignleft" style="width:48%">  
			        <h3><?php _e( 'Pages', 'junkie' ); ?>:</h3>
			        <ul>
			            <?php wp_list_pages( 'depth=0&sort_column=menu_order&title_li=' ); ?>
			        </ul>
		        </div><!-- END #pages -->
		
		        <div class="alignleft" style="width:45%">  
			        <h3><?php _e('Categories', 'junkie'); ?>:</h3>
			        <ul>
			            <?php wp_list_categories('title_li=&show_count=true'); ?>
			        </ul>
		        </div><!-- END #categories -->
		        
		        <div class="clearfix"></div>

		        <div style="width:100%">
			        <h3><?php _e( 'Posts per category', 'junkie' ); ?>:</h3>
			        <?php
			        $cats = get_categories();
			      	foreach ( $cats as $cat ) {
			        	query_posts( 'cat=' . $cat->cat_ID );
			    	?>
			        	<h3><?php echo $cat->cat_name; ?></h3>
			            <ul>
							<?php while ( have_posts() ) { the_post(); ?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> / <?php _e( 'Comments', 'junkie' ); ?> (<?php echo $post->comment_count; ?>)</li>
							<?php }  ?>
			            </ul>
			        <?php } ?>
		    	</div><!-- END #post-per-categories -->
		            
		    </div><!-- END .entry-content -->

		</article><!-- END article -->
	
	<?php else : ?>
	
	<?php endif; ?>		

</section><!-- END #content -->    

<?php get_sidebar(); ?>
<?php get_footer(); ?>