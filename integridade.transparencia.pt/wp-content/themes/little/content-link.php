<?php $link = get_post_meta( $post->ID, '_junkie_link_url', true ); ?>

<?php if( is_single() ) { ?>

	<h1 class="entry-title"><?php the_title(); ?></h1>

<?php } else { ?>

	<h2 class="entry-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h2>

	<div class="entry-content">

		<?php 
		the_content( __( 'Continue Reading', 'junkie') ); 
		wp_link_pages(array('before' => '<p class="post-paging"><strong>'.__('Pages:', 'junkie').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
		?>
		
	</div><!-- .entry-content -->

<?php } ?>

<p class="link-source">
	<a href="<?php echo $link; ?>"><?php echo $link; ?></a> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'junkie'), get_the_title()); ?>">#</a>
</p><!-- .link-source -->

<?php if( is_single() ) { ?>

	<?php get_template_part( 'content', 'meta-header' ); ?>

	<div class="entry-content">

		<?php 
		the_content( __( 'Continue Reading', 'junkie') ); 
		wp_link_pages(array('before' => '<p class="post-paging"><strong>'.__('Pages:', 'junkie').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
		?>
		
	</div><!-- .entry-content -->

	<?php get_template_part( 'content', 'meta-footer' ); ?>

<?php } ?>