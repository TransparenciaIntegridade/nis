<?php // Hook for adding admin menus
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'dpProEventCalendar_settings');
} 

// function for adding settings page to wp-admin
function dpProEventCalendar_settings() {
    // Add a new submenu under Options:
	add_menu_page( 'Event Calendar', 'Event Calendar', 'manage_options','dpProEventCalendar-admin', 'dpProEventCalendar_calendars_page', dpProEventCalendar_plugin_url( 'images/dpProEventCalendar_icon.gif' ) );
	add_submenu_page('dpProEventCalendar-admin', 'Calendars', 'Calendars', 'manage_options', 'dpProEventCalendar-admin', 'dpProEventCalendar_calendars_page');
	add_submenu_page('dpProEventCalendar-admin', 'Events', 'Events', 'manage_options', 'dpProEventCalendar-events', 'dpProEventCalendar_events_page');
	add_submenu_page('dpProEventCalendar-admin', 'Special Dates', 'Special Dates', 'manage_options', 'dpProEventCalendar-special', 'dpProEventCalendar_special_page');
}
include('calendars.php');
include('events.php');
include('special.php');

?>