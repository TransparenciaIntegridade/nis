<div class="entry-thumb">

	<?php 
        $embed = get_post_meta($post->ID, '_junkie_video_embed_code', true);
        if( !empty( $embed ) ) {
            echo stripslashes(htmlspecialchars_decode($embed));
        } else {
            junkie_video($post->ID, 600); 
        }
    ?>

</div><!-- .entry-thumb -->

<?php if( is_single() ) { ?>

	<h1 class="entry-title"><?php the_title(); ?></h1>

<?php } else { ?>

	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

<?php } ?>

	<?php get_template_part( 'content' , 'meta-header' ); ?>

<div class="entry-content">
	
	<?php 
		the_content( __('Continue Reading', 'junkie') );
		wp_link_pages(array('before' => '<p class="post-paging"><strong>'.__('Pages:', 'junkie').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); 
	?>
	
</div><!-- .entry-content -->

<?php if( is_single() ) { 

	get_template_part( 'content', 'meta-footer' );

} ?>