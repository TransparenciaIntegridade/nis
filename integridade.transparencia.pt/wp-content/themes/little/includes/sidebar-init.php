<?php

// Register Widgets
function tj_widgets_init() {

	// Footer Widgets Area 1
	register_sidebar( array (
		'name' => __( 'Footer Widgets Area 1', 'themejunkie' ),
		'id' => 'footer-widget-area-1',
		'description' => __( 'Footer Widgets Area #1', 'themejunkie' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget clearfix %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Footer Widgets Area 2
	register_sidebar( array (
		'name' => __( 'Footer Widgets Area 2', 'themejunkie' ),
		'id' => 'footer-widget-area-2',
		'description' => __( 'Footer Widgets Area #2', 'themejunkie' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget clearfix %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
}
add_action( 'init', 'tj_widgets_init' );

?>