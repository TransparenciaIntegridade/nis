<?php $quote = get_post_meta( $post->ID, '_junkie_quote_quote', true ); ?>

<?php if( is_single() ) { ?>

	<p class="entry-quote"><i class="icon-quote-left"></i><blockquote><?php echo $quote; ?></blockquote></p>

<?php } else { ?>

	<p class="entry-quote"><i class="icon-quote-left"></i><blockquote><?php echo $quote; ?></blockquote></p>

<?php } ?>

<p class="quote-source"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'junkie'), get_the_title()); ?>"><?php the_title(); ?></a></p>

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