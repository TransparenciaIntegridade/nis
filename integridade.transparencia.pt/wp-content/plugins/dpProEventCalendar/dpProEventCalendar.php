<?php
/*
Plugin Name: DP Pro Event Calendar
Description: The Pro Event Calendar plugin adds a professional and sleek calendar to your posts or pages. 100% Responsive, also you can use it inside a widget.
Version: 1.2.8	
Author: Diego Pereyra
Author URI: http://www.dpereyra.com/
Wordpress version supported: 3.0 and above
*/

//on activation
//defined global variables and constants here
global $dpProEventCalendar, $table_prefix, $wpdb;
$dpProEventCalendar = get_option('dpProEventCalendar_options');
define('DP_PRO_EVENT_CALENDAR_TABLE_EVENTS','dpProEventCalendar_events'); //events TABLE NAME
define('DP_PRO_EVENT_CALENDAR_TABLE_CALENDARS','dpProEventCalendar_calendars'); //calendar TABLE NAME
define('DP_PRO_EVENT_CALENDAR_TABLE_SPECIAL_DATES','dpProEventCalendar_special_dates'); //special dates TABLE NAME
define('DP_PRO_EVENT_CALENDAR_TABLE_SPECIAL_DATES_CALENDAR','dpProEventCalendar_special_dates_calendar'); //special dates TABLE NAME
define("DP_PRO_EVENT_CALENDAR_VER","1.2.8",false);//Current Version of this plugin
if ( ! defined( 'DP_PRO_EVENT_CALENDAR_PLUGIN_BASENAME' ) )
	define( 'DP_PRO_EVENT_CALENDAR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'DP_PRO_EVENT_CALENDAR_CSS_DIR' ) ){
	define( 'DP_PRO_EVENT_CALENDAR_CSS_DIR', WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/css/' );
}
// Create Text Domain For Translations
include'settings/calendar.php';
load_plugin_textdomain('dpProEventCalendar', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');

function checkMU_install_dpProEventCalendar($network_wide) {
	global $wpdb;
	if ( $network_wide ) {
		$blog_list = get_blog_list( 0, 'all' );
		foreach ($blog_list as $blog) {
			switch_to_blog($blog['blog_id']);
			install_dpProEventCalendar();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		install_dpProEventCalendar();
	}
}

function install_dpProEventCalendar() {
	global $wpdb, $table_prefix;
	$table_name_events = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_EVENTS;
	$table_name_calendars = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_CALENDARS;
	$table_name_special_dates = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_SPECIAL_DATES;
	$table_name_special_dates_calendar = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_SPECIAL_DATES_CALENDAR;
	
	if($wpdb->get_var("show tables like '$table_name_events'") != $table_name_events) {
		$sql = "CREATE TABLE $table_name_events (
					id int(11) NOT NULL AUTO_INCREMENT,
					id_calendar int(11) NOT NULL,
					date datetime NOT NULL,
					title varchar(80) NOT NULL,
					description text NOT NULL,
					link varchar(255) NULL,
					share varchar(140) NULL,
					all_day TINYINT(1) NOT NULL DEFAULT 0,
					recurring_frecuency TINYINT(1) NOT NULL DEFAULT 0,
					end_date date NULL,
					UNIQUE KEY id(id)
				);";
		$rs = $wpdb->query($sql);
	}
	
	if($wpdb->get_var("show tables like '$table_name_calendars'") != $table_name_calendars) {
		$sql = "CREATE TABLE $table_name_calendars (
					id int(11) NOT NULL AUTO_INCREMENT,
					active tinyint(1) NOT NULL,
					title varchar(80) NOT NULL,
					description varchar(255) NOT NULL,
					width char(5) NOT NULL,
					width_unity char(2) NOT NULL DEFAULT 'px',
					default_date date NULL,
					date_range_start date NULL,
					date_range_end date NULL,
					format_ampm TINYINT(1) NOT NULL DEFAULT 0,
					show_time TINYINT(1) NOT NULL DEFAULT 1,
					show_search TINYINT(1) NOT NULL DEFAULT 1,
					first_day tinyint(1) NOT NULL DEFAULT '0',
					lang_txt_no_events_found varchar(80) NOT NULL,
					lang_txt_all_day varchar(80) NOT NULL,
					lang_txt_references varchar(80) NOT NULL,
					lang_txt_search varchar(80) NOT NULL,
					lang_txt_results_for varchar(80) NOT NULL,
					lang_prev_month varchar(80) NOT NULL,
					lang_next_month varchar(80) NOT NULL,
					lang_day_sunday varchar(80) NOT NULL,
					lang_day_monday varchar(80) NOT NULL,
					lang_day_tuesday varchar(80) NOT NULL,
					lang_day_wednesday varchar(80) NOT NULL,
					lang_day_thursday varchar(80) NOT NULL,
					lang_day_friday varchar(80) NOT NULL,
					lang_day_saturday varchar(80) NOT NULL,
					lang_month_january varchar(80) NOT NULL,
					lang_month_february varchar(80) NOT NULL,
					lang_month_march varchar(80) NOT NULL,
					lang_month_april varchar(80) NOT NULL,
					lang_month_may varchar(80) NOT NULL,
					lang_month_june varchar(80) NOT NULL,
					lang_month_july varchar(80) NOT NULL,
					lang_month_august varchar(80) NOT NULL,
					lang_month_september varchar(80) NOT NULL,
					lang_month_october varchar(80) NOT NULL,
					lang_month_november varchar(80) NOT NULL,
					lang_month_december varchar(80) NOT NULL,
					current_date_color VARCHAR(10) NOT NULL DEFAULT '#C4C5D1',
					lang_txt_current_date VARCHAR(80) NOT NULL,
					UNIQUE KEY id(id)
				);";
		$rs = $wpdb->query($sql);
	}
	
	if($wpdb->get_var("show tables like '$table_name_special_dates'") != $table_name_special_dates) {
		$sql = "CREATE TABLE $table_name_special_dates (
					id int(11) NOT NULL AUTO_INCREMENT,
					title varchar(80) NOT NULL,
					color varchar(10) NOT NULL,
					UNIQUE KEY id(id)
				);";
		$rs = $wpdb->query($sql);
	}
	
	if($wpdb->get_var("show tables like '$table_name_special_dates_calendar'") != $table_name_special_dates) {
		$sql = "CREATE TABLE $table_name_special_dates_calendar (
					special_date int(11) NOT NULL,
					calendar int(11) NOT NULL,
					date date NOT NULL,
					PRIMARY KEY (special_date,calendar,date)
				);";
		$rs = $wpdb->query($sql);
	}

   $default_events = array();
   $default_events = array(
   						   'version' 	=> 		DP_PRO_EVENT_CALENDAR_VER,
						   'first_day' 	=>		true,
						   'current_date_color' => true
			              );
   
	$dpProEventCalendar = get_option('dpProEventCalendar_options');
	
	if(!$dpProEventCalendar) {
	 $dpProEventCalendar = array();
	}
	
	foreach($default_events as $key=>$value) {
	  if(!isset($dpProEventCalendar[$key])) {
		 $dpProEventCalendar[$key] = $value;
	  }
	}
	
	delete_option('dpProEventCalendar_options');	  
	update_option('dpProEventCalendar_options',$dpProEventCalendar);
}
register_activation_hook( __FILE__, 'checkMU_install_dpProEventCalendar' );

/* Uninstall */
function checkMU_uninstall_dpProEventCalendar($network_wide) {
	global $wpdb;
	if ( $network_wide ) {
		$blog_list = get_blog_list( 0, 'all' );
		foreach ($blog_list as $blog) {
			switch_to_blog($blog['blog_id']);
			uninstall_dpProEventCalendar();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		uninstall_dpProEventCalendar();
	}
}

function uninstall_dpProEventCalendar() {
	global $wpdb, $table_prefix;
	delete_option('dpProEventCalendar_options'); 
	
	$events_table = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_EVENTS;
	$sql = "DROP TABLE $events_table;";
	$wpdb->query($sql);
	
	$calendars_table = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_CALENDARS;
	$sql = "DROP TABLE $calendars_table;";
	$wpdb->query($sql);
	
	$special_dates_table = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_SPECIAL_DATES;
	$sql = "DROP TABLE $special_dates_table;";
	$wpdb->query($sql);
	
	$special_dates_calendar_table = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_SPECIAL_DATES_CALENDAR;
	$sql = "DROP TABLE $special_dates_calendar_table;";
	$wpdb->query($sql);
}
register_uninstall_hook( __FILE__, 'checkMU_uninstall_dpProEventCalendar' );

/* Add new Blog */

add_action( 'wpmu_new_blog', 'newBlog_dpProEventCalendar', 10, 6); 		
 
function newBlog_dpProEventCalendar($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;
 
	if (is_plugin_active_for_network('dpProEventCalendar/dpProEventCalendar.php')) {
		$old_blog = $wpdb->blogid;
		switch_to_blog($blog_id);
		install_dpProEventCalendar();
		switch_to_blog($old_blog);
	}
}

/*******************/
/* UPDATES 
/*******************/

$table_name_calendars = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_CALENDARS;
$table_name_events = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_EVENTS;

if(!isset($dpProEventCalendar['first_day'])) {
	$dpProEventCalendar['first_day'] = true;
	
	$sql = "ALTER TABLE $table_name_calendars ADD (first_day TINYINT(1) NOT NULL DEFAULT 0);";
	$wpdb->query($sql);
	update_option('dpProEventCalendar_options',$dpProEventCalendar);
}

if(!isset($dpProEventCalendar['current_date_color'])) {
	$dpProEventCalendar['current_date_color'] = true;
	
	$sql = "ALTER TABLE $table_name_calendars ADD (current_date_color VARCHAR(10) NOT NULL DEFAULT '#C4C5D1');";
	$wpdb->query($sql);
	$sql = "ALTER TABLE $table_name_calendars ADD (lang_txt_current_date VARCHAR(80) NOT NULL DEFAULT 'Current Date');";
	$wpdb->query($sql);
	update_option('dpProEventCalendar_options',$dpProEventCalendar);
}

require_once (dirname (__FILE__) . '/functions.php');
require_once (dirname (__FILE__) . '/includes/core.php');
require_once (dirname (__FILE__) . '/settings/settings.php');
?>