</div><!-- .container -->

	<?php if ( is_active_sidebar( 'footer-widget-area-1' ) || is_active_sidebar( 'footer-widget-area-2' )) { ?>
	
		<div class="footer-widgets container clearfix">
		
				<div class="footer-widget-1">
					<?php if ( is_active_sidebar( 'footer-widget-area-1' ) ) :  dynamic_sidebar( 'footer-widget-area-1'); endif; ?>
				</div><!-- .footer-widget-1 -->
				
				<div class="footer-widget-2">
					<?php if ( is_active_sidebar( 'footer-widget-area-2' ) ) :  dynamic_sidebar( 'footer-widget-area-2'); endif; ?>
				</div><!-- .footer-widget-2 -->
							
				<div class="clearfix"></div>
				
		</div><!-- .footer-widgets -->
	
	<?php } ?>
			
	
	
<?php wp_footer(); ?>

</body>
</html>