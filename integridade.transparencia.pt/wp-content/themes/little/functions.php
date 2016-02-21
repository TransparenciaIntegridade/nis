<?php
    
// Translations can be filed in the /lang/ directory
load_theme_textdomain( 'junkie', get_template_directory() . '/lang' );

require_once(get_template_directory() . '/includes/sidebar-init.php');
require_once(get_template_directory() . '/includes/custom-functions.php'); 
require_once(get_template_directory() . '/includes/post-thumbnails.php');

require_once(get_template_directory() . '/includes/theme-metaboxes.php');
require_once(get_template_directory() . '/includes/post-meta.php');

require_once(get_template_directory() . '/includes/theme-options.php');
require_once(get_template_directory() . '/includes/theme-widgets.php');

require_once(get_template_directory() . '/functions/theme_functions.php'); 
require_once(get_template_directory() . '/functions/admin_functions.php');

// Uncomment this to test your localization, make sure to enter the right language code.
// function test_localization( $locale ) {
// 	return "nl_NL";
// }
// add_filter('locale','test_localization');

?>
