<?php 

/************************************************************************/
/*** DISPLAY START
/************************************************************************/
class dpProEventCalendar_wpress_display {
	
	static $js_flag;
	static $js_declaration = array();
	static $id_calendar;
	static $type;
	static $limit;
	public $events_html;

	function dpProEventCalendar_wpress_display($id, $type, $limit) {
		self::$id_calendar = $id;
		self::$type = $type;
		self::$limit = $limit;
		self::return_dpProEventCalendar();
		add_action('wp_footer', array(__CLASS__, 'add_scripts'));
		
	}
	
	function add_scripts() {
		if(self::$js_flag) {
			foreach( self::$js_declaration as $key) { echo $key; }
		}
	}
	
	function return_dpProEventCalendar() {
		global $dpProEventCalendar, $wpdb, $table_prefix;
		
		$id = self::$id_calendar;
		$type = self::$type;
		$limit = self::$limit;
		
		require_once (dirname (__FILE__) . '/../classes/base.class.php');
		$dpProEventCalendar_class = new DpProEventCalendar( false, $id );
		
		if($type != "") { $dpProEventCalendar_class->switchCalendarTo($type, $limit); }
		
		array_walk($dpProEventCalendar, 'dpProEventCalendar_reslash_multi');
		$rand_num = rand();

		//if(!$calendar->active) { return ''; }
		
		$events_script= $dpProEventCalendar_class->addScripts();
		self::$js_declaration[] = $events_script;
		
		self::$js_flag = true;
		
		$events_html = $dpProEventCalendar_class->output();
					
		$this->events_html = $events_html;
	}
}

function dpProEventCalendar_simple_shortcode($atts) {
	extract(shortcode_atts(array(
		'id' => '',
		'type' => '',
		'limit' => ''
	), $atts));
	
	$dpProEventCalendar_wpress_display = new dpProEventCalendar_wpress_display($id, $type, $limit);
	return $dpProEventCalendar_wpress_display->events_html;
}
add_shortcode('dpProEventCalendar', 'dpProEventCalendar_simple_shortcode');

/************************************************************************/
/*** DISPLAY END
/************************************************************************/

/************************************************************************/
/*** WIDGET START
/************************************************************************/

class DpProEventCalendar_Widget extends WP_Widget {
	function __construct() {
		$params = array(
			'description' => 'Use the calendar as a widget',
			'name' => 'DP Pro Event Calendar'
		);
		
		parent::__construct('EventsCalendar', '', $params);
	}
	
	public function form($instance) {
		global $wpdb, $table_prefix;
		$table_name_calendars = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_CALENDARS;
		
		extract($instance);
		?>
        	<p>
            	<label for="<?php echo $this->get_field_id('title');?>">Title: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php if(isset($title)) echo esc_attr($title); ?>" />
            </p>
            
            <p>
            	<label for="<?php echo $this->get_field_id('description');?>">Description: </label>
                <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('description');?>" name="<?php echo $this->get_field_name('description');?>"><?php if(isset($description)) echo esc_attr($description); ?></textarea>
            </p>
            
            <p>
            	<label for="<?php echo $this->get_field_id('calendar');?>">Calendar: </label>
            	<select name="<?php echo $this->get_field_name('calendar');?>" id="<?php echo $this->get_field_id('calendar');?>">
                    <?php
                    $querystr = "
                    SELECT *
                    FROM $table_name_calendars
                    ORDER BY title ASC
                    ";
                    $calendars_obj = $wpdb->get_results($querystr, OBJECT);
                    foreach($calendars_obj as $calendar_key) {
                    ?>
                        <option value="<?php echo $calendar_key->id?>" <?php if($calendar == $calendar_key->id) {?> selected="selected" <?php } ?>><?php echo $calendar_key->title?></option>
                    <?php }?>
                </select>
            </p>
        <?php
	}
	
	public function widget($args, $instance) {
		global $wpdb, $table_prefix;
		$table_name = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_EVENTS;
		
		extract($args);
		extract($instance);
		
		$title = apply_filters('widget_title', $title);
		$description = apply_filters('widget_description', $description);
		
		if(empty($title)) $title = 'DP Pro Event Calendar';
		
		echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<p>'. $description. '</p>';
			echo do_shortcode('[dpProEventCalendar id='.$calendar.']');
		echo $after_widget;
		
	}
}

add_action('widgets_init', 'dpProEventCalendar_register_widget');
function dpProEventCalendar_register_widget() {
	register_widget('DpProEventCalendar_Widget');
}

/************************************************************************/
/*** WIDGET END
/************************************************************************/

/************************************************************************/
/*** WIDGET UPCOMING EVENTS START
/************************************************************************/

class DpProEventCalendar_UpcomingEventsWidget extends WP_Widget {
	function __construct() {
		$params = array(
			'description' => 'Display the upcoming events of a calendar.',
			'name' => 'DP Pro Event Calendar - Upcoming Events'
		);
		
		parent::__construct('EventsCalendarUpcomingEvents', '', $params);
	}
	
	public function form($instance) {
		global $wpdb, $table_prefix;
		$table_name_calendars = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_CALENDARS;
		
		extract($instance);
		?>
        	<p>
            	<label for="<?php echo $this->get_field_id('title');?>">Title: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php if(isset($title)) echo esc_attr($title); ?>" />
            </p>
            
            <p>
            	<label for="<?php echo $this->get_field_id('description');?>">Description: </label>
                <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('description');?>" name="<?php echo $this->get_field_name('description');?>"><?php if(isset($description)) echo esc_attr($description); ?></textarea>
            </p>
            
            <p>
            	<label for="<?php echo $this->get_field_id('calendar');?>">Calendar: </label>
            	<select name="<?php echo $this->get_field_name('calendar');?>" id="<?php echo $this->get_field_id('calendar');?>">
                    <?php
                    $querystr = "
                    SELECT *
                    FROM $table_name_calendars
                    ORDER BY title ASC
                    ";
                    $calendars_obj = $wpdb->get_results($querystr, OBJECT);
                    foreach($calendars_obj as $calendar_key) {
                    ?>
                        <option value="<?php echo $calendar_key->id?>" <?php if($calendar == $calendar_key->id) {?> selected="selected" <?php } ?>><?php echo $calendar_key->title?></option>
                    <?php }?>
                </select>
            </p>
            <p>
            	<label for="<?php echo $this->get_field_id('events_count');?>">Number of events to retrieve: </label>
                <input type="number" class="widefat" style="width:40px;" min="1" max="10" id="<?php echo $this->get_field_id('events_count');?>" name="<?php echo $this->get_field_name('events_count');?>" value="<?php echo !empty($events_count) ? $events_count : 5; ?>"s />
            </p>
        <?php
	}
	
	public function widget($args, $instance) {
		global $wpdb, $table_prefix;
		$table_name = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_EVENTS;
		
		extract($args);
		extract($instance);
		
		$title = apply_filters('widget_title', $title);
		$description = apply_filters('widget_description', $description);
		
		if(empty($title)) $title = 'DP Pro Event Calendar - Upcoming Events';
		if(!is_numeric($events_count)) { $events_count = 5; }
		
		echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<p>'. $description. '</p>';
			echo do_shortcode('[dpProEventCalendar id='.$calendar.' type="upcoming" limit="'.$events_count.'"]');
		echo $after_widget;
		
	}
}

add_action('widgets_init', 'dpProEventCalendar_register_upcomingeventswidget');
function dpProEventCalendar_register_upcomingeventswidget() {
	register_widget('DpProEventCalendar_UpcomingEventsWidget');
}

/************************************************************************/
/*** WIDGET UPCOMING EVENTS END
/************************************************************************/

function dpProEventCalendar_enqueue_scripts() {
	if ( !is_admin() ){ 
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'isotope', dpProEventCalendar_plugin_url( 'js/jquery.isotope.js' ),
			array('jquery'), DP_PRO_EVENT_CALENDAR_VER, false);
		wp_enqueue_script( 'dpProEventCalendar', dpProEventCalendar_plugin_url( 'js/jquery.dpProEventCalendar.js' ),
			array('jquery'), DP_PRO_EVENT_CALENDAR_VER, false); 
		wp_localize_script( 'dpProEventCalendar', 'ProEventCalendarAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'postEventsNonce' => wp_create_nonce( 'ajax-get-events-nonce' ) ) );
	}
}

add_action( 'init', 'dpProEventCalendar_enqueue_scripts' );

function dpProEventCalendar_enqueue_styles() {	
  global $post, $dpProEventCalendar, $wp_registered_widgets,$wp_widget_factory;
  
  wp_enqueue_style( 'dpProEventCalendar_headcss', dpProEventCalendar_plugin_url( 'css/dpProEventCalendar.css' ),
	false, DP_PRO_EVENT_CALENDAR_VER, 'all');
}
add_action( 'wp', 'dpProEventCalendar_enqueue_styles' );

//admin settings
function dpProEventCalendar_admin_scripts() {
	global $dpProEventCalendar;
	if ( is_admin() ){ // admin actions
		// Settings page only
		if ( isset($_GET['page']) && ('dpProEventCalendar-admin' == $_GET['page'] or 'dpProEventCalendar-settings' == $_GET['page'] or 'dpProEventCalendar-events' == $_GET['page'] or 'dpProEventCalendar-special' == $_GET['page'] )  ) {
		wp_register_script('jquery', false, false, false, false);
		wp_enqueue_style( 'dpProEventCalendar_admin_head_css', dpProEventCalendar_plugin_url( 'css/admin-styles.css' ),
			false, DP_PRO_EVENT_CALENDAR_VER, 'all');
		
		wp_enqueue_script( 'isotope', dpProEventCalendar_plugin_url( 'js/jquery.isotope.js' ),
			array('jquery'), DP_PRO_EVENT_CALENDAR_VER, false);
		wp_enqueue_script( 'dpProEventCalendar', dpProEventCalendar_plugin_url( 'js/jquery.dpProEventCalendar.js' ),
			array('jquery'), DP_PRO_EVENT_CALENDAR_VER, false); 
		wp_localize_script( 'dpProEventCalendar', 'ProEventCalendarAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'postEventsNonce' => wp_create_nonce( 'ajax-get-events-nonce' ) ) );
		wp_enqueue_script( 'colorpicker2', dpProEventCalendar_plugin_url( 'js/colorpicker.js' ),
			array('jquery'), DP_PRO_EVENT_CALENDAR_VER, false); 
		wp_enqueue_script ( 'dpProEventCalendar_admin', dpProEventCalendar_plugin_url( 'js/admin_settings.js' ), array('jquery-ui-dialog') ); 
    	wp_enqueue_style ('wp-jquery-ui-dialog');
	
		wp_enqueue_style( 'dpProEventCalendar_headcss', dpProEventCalendar_plugin_url( 'css/dpProEventCalendar.css' ),
			false, DP_PRO_EVENT_CALENDAR_VER, 'all');
		wp_enqueue_style( 'colorpicker', dpProEventCalendar_plugin_url( 'css/colorpicker.css' ),
			false, DP_PRO_EVENT_CALENDAR_VER, 'all');
		};
  	}
}

add_action( 'admin_init', 'dpProEventCalendar_admin_scripts' );

function dpProEventCalendar_admin_head() {
	global $dpProEventCalendar;
	if ( is_admin() ){ // admin actions
	   
	  	// Special Dates page only
		if ( isset($_GET['page']) && 'dpProEventCalendar-special' == $_GET['page'] ) {
		?>
			<script type="text/javascript">
			// <![CDATA[
				function confirmSpecialDelete()
				{
					var agree=confirm("Delete this Special Date?");
					if (agree)
					return true ;
					else
					return false ;
				}
				
				function special_checkform ()
				{
					if (document.getElementById('dpProEventCalendar_title').value == "") {
						alert( "Please enter the title of the special date." );
						document.getElementById('dpProEventCalendar_title').focus();
						return false ;
					}
					return true ;
				}
				
				function special_checkform_edit ()
				{
					if (document.getElementById('dpPEC_special_title').value == "") {
						alert( "Please enter the title of the special date." );
						document.getElementById('dpPEC_special_title').focus();
						return false ;
					}
					return true ;
				}
				
				jQuery(document).ready(function() {
					jQuery('#specialDate_colorSelector').ColorPicker({
						onShow: function (colpkr) {
							jQuery(colpkr).fadeIn(500);
							return false;
						},
						onHide: function (colpkr) {
							jQuery(colpkr).fadeOut(500);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							jQuery('#specialDate_colorSelector div').css('backgroundColor', '#' + hex);
							jQuery('#dpProEventCalendar_color').val('#' + hex);
						}
					});
					
					jQuery('#specialDate_colorSelector_Edit').ColorPicker({
						onShow: function (colpkr) {
							jQuery(colpkr).fadeIn(500);
							return false;
						},
						onHide: function (colpkr) {
							jQuery(colpkr).fadeOut(500);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							jQuery('#specialDate_colorSelector_Edit div').css('backgroundColor', '#' + hex);
							jQuery('#dpPEC_special_color').val('#' + hex);
						}
					});
				});
			//]]>
			</script>
	<?php
	   } 
	   
	   // Calendars page only
		if ( isset($_GET['page']) && 'dpProEventCalendar-admin' == $_GET['page'] ) {
		?>
			<script type="text/javascript">
			// <![CDATA[
				function confirmCalendarDelete()
				{
					var agree=confirm("Delete this Calendar?");
					if (agree)
					return true ;
					else
					return false ;
				}
				
				function calendar_checkform ()
				{
					if (document.getElementById('dpProEventCalendar_title').value == "") {
						alert( "Please enter the title of the calendar." );
						document.getElementById('dpProEventCalendar_title').focus();
						return false ;
					}
					
					if (document.getElementById('dpProEventCalendar_description').value == "") {
						alert( "Please enter the description of the calendar." );
						document.getElementById('dpProEventCalendar_description').focus();
						return false ;
					}
					
					if (document.getElementById('dpProEventCalendar_width').value == "") {
						alert( "Please enter the width of the calendar." );
						document.getElementById('dpProEventCalendar_width').focus();
						return false ;
					}
					return true ;
				}
				
				function toggleFormat() {
					if(jQuery('#dpProEventCalendar_show_time').attr("checked")) {
						jQuery('#div_format_ampm').slideDown('fast');
					} else {
						jQuery('#div_format_ampm').slideUp('fast');
					}
				}
				
				function showAccordion(div) {
					if(jQuery('#'+div).css('display') == 'none') {
						jQuery('#'+div).slideDown('fast');
					} else {
						jQuery('#'+div).slideUp('fast');
					}
				}
				
				jQuery(document).ready(function() {
					jQuery('#currentDate_colorSelector').ColorPicker({
						onShow: function (colpkr) {
							jQuery(colpkr).fadeIn(500);
							return false;
						},
						onHide: function (colpkr) {
							jQuery(colpkr).fadeOut(500);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							jQuery('#currentDate_colorSelector div').css('backgroundColor', '#' + hex);
							jQuery('#dpProEventCalendar_current_date_color').val('#' + hex);
						}
					});
					
				});
			//]]>
			</script>
	<?php
	   } //Calendars page only
	   
	   // Events page only
		if ( isset($_GET['page']) && 'dpProEventCalendar-events' == $_GET['page'] ) {

		?>
			<script type="text/javascript">
			// <![CDATA[
			function confirmEventDelete()
			{
				var agree=confirm("Delete this Event?");
				if (agree)
				return true ;
				else
				return false ;
			}

			function event_checkform ()
			{
			  	if (document.getElementById('dpProEventCalendar_id_calendar').value == "") {
					alert( "Please select a calendar." );
					document.getElementById('dpProEventCalendar_id_calendar').focus();
					return false ;
			  	}
				
				if (document.getElementById('dpProEventCalendar_title').value == "") {
					alert( "Please enter the title of the event." );
					document.getElementById('dpProEventCalendar_title').focus();
					return false ;
			  	}
				
				if (document.getElementById('dpProEventCalendar_description').value == "") {
					alert( "Please enter the description of the event." );
					document.getElementById('dpProEventCalendar_description').focus();
					return false ;
			  	}
				
				if (document.getElementById('dpProEventCalendar_date').value == "") {
					alert( "Please select the date of the event." );
					document.getElementById('dpProEventCalendar_date').focus();
					return false ;
			  	}
			  	return true ;
			}
			//]]>
			</script>
	<?php
	   } //Events page only
	   
	   // Settings page only
		if ( isset($_GET['page']) && 'dpProEventCalendar-settings' == $_GET['page'] ) {
		?>
			<script type="text/javascript">
			// <![CDATA[
				jQuery(document).ready(function() {
					jQuery('#holidays_colorSelector').ColorPicker({
						onShow: function (colpkr) {
							jQuery(colpkr).fadeIn(500);
							return false;
						},
						onHide: function (colpkr) {
							jQuery(colpkr).fadeOut(500);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							jQuery('#holidays_colorSelector div').css('backgroundColor', '#' + hex);
							jQuery('#dpProEventCalendar_holidays_color').val('#' + hex);
						}
					});
				});
			//]]>
			</script>
	<?php
	   } //Settings page only
	   
	 }//only for admin
}
add_action('admin_head', 'dpProEventCalendar_admin_head');
?>