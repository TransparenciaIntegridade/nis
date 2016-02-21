<div id="post-<?php the_ID(); ?>"<?php post_class(); ?>>

	<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	
	<div class="entry-meta">
		<?php the_time('M jS, Y') ?> &middot; <?php comments_popup_link( __( '0 Comment', 'junkie' ), __( '1 Comment', 'junkie' ), __( '% Comments', 'junkie' ) ); ?>
	</div><!-- .entry-meta -->

	<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('entry-thumb', array('class' => 'entry-thumb')); ?></a>

	<div class="entry-excerpt">
		<?php tj_content_limit('400'); ?>    	
	</div><!-- .entry-excerpt -->
				
	<div class="clear"></div>
	
</div><!-- #post-<?php the_ID(); ?> -->	