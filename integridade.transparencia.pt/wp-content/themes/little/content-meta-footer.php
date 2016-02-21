<div class="entry-meta entry-footer">

	<span class="entry-categories"><?php _e('Posted in: ', 'junkie') ?> <?php the_category(', ') ?></span>
    <span class="entry-tags"><?php the_tags( ' / ' . __('Tagged:', 'junkie') . ' ', ', ', ''); ?></span>

<div class="clearfix"></div>

<?php if( get_option('little_enable_share_buttons') == 'on' ) { ?>
	<div class="single-share">
		<span><?php _e('Share this post: ', 'junkie') ?></span>
		<div class="btn-tweet">
		    <a href="http://twitter.com/share" class="twitter-share-button"
		    data-url="<?php the_permalink(); ?>"
		    data-via=""
		    data-text="<?php the_title(); ?>"
		    data-related=""
		    data-count="horizontal">Tweet</a>
		</div><!-- .btn-tweet -->
		<div class="btn-like">
		<iframe src="http://www.facebook.com/plugins/like.php?locale=en_US&amp;href=<?php the_permalink(); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;font=arial&amp;colorscheme=light" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px;" allowTransparency="true"></iframe>
		</div><!-- .btn-like -->
		<div class="btn-plus">
			<g:plusone size="medium" href="<?php the_permalink();?>"></g:plusone>
		</div><!-- .btn-plus -->
	</div><!-- .single-share -->
	<div class="clearfix"></div>
<?php } ?>    
</div><!-- .entry-meta .entry-footer-->