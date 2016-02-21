<div class="entry-meta entry-header">
	<span class="published"><?php the_time( get_option('date_format') ); ?></span>
	<span class="meta-sep"> / </span>
	<span class="comment-count"><?php comments_popup_link(__('No Comments', 'junkie'), __('1 Comment', 'junkie'), __('% Comments', 'junkie')); ?></span>
	<?php if( !is_single() ) { ?>
		<span class="meta-sep"> / </span>
		<span class="entry-categories"><?php _e('Posted in: ', 'junkie') ?> <?php the_category(', ') ?></span>
	<?php } ?>
	<?php edit_post_link( __('Edit', 'junkie'), ' / <span class="edit-post">', '</span>' ); ?>
</div><!-- .entry-meta entry-header -->