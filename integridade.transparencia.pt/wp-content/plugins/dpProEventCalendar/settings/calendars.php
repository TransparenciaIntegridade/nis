<?php 
// This function displays the admin page content
function dpProEventCalendar_calendars_page() {
	global $dpProEventCalendar, $wpdb, $table_prefix;
	$table_name = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_CALENDARS;
	$table_name_events = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_EVENTS;
	$table_name_special_dates_calendar = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_SPECIAL_DATES_CALENDAR;

	if ($_POST['submit']) {
		
	   foreach($_POST as $key=>$value) { $$key = $value; }
	   
	   if($active != 1) { $active = 0; }
	   if($format_ampm != 1) { $format_ampm = 0; }
	   if($show_time != 1) { $show_time = 0; }
	   if($show_search != 1) { $show_search = 0; }
	   
	   if (is_numeric($_POST['calendar_id']) && $_POST['calendar_id'] > 0) {
	   
	   	   $sql = "UPDATE $table_name SET ";
		   $sql .= "title = '$title', ";
		   $sql .= "description = '$description', ";
		   $sql .= "width = '$width', ";
		   $sql .= "width_unity = '$width_unity', ";
		   $sql .= "default_date = '$default_date', ";
		   $sql .= "date_range_start = '$date_range_start', ";
		   $sql .= "date_range_end = '$date_range_end', ";
		   $sql .= "current_date_color = '$current_date_color', ";
		   $sql .= "active = $active, ";
		   $sql .= "format_ampm = $format_ampm, ";
		   $sql .= "show_time = $show_time, ";
		   $sql .= "show_search = $show_search, ";
		   $sql .= "first_day = $first_day, ";
		   $sql .= "lang_txt_no_events_found = '$lang_txt_no_events_found', ";
		   $sql .= "lang_txt_all_day = '$lang_txt_all_day', ";
		   $sql .= "lang_txt_references = '$lang_txt_references', ";
		   $sql .= "lang_txt_search = '$lang_txt_search', ";
		   $sql .= "lang_txt_results_for = '$lang_txt_results_for', ";
		   $sql .= "lang_txt_current_date = '$lang_txt_current_date', ";
		   $sql .= "lang_prev_month = '$lang_prev_month', ";
		   $sql .= "lang_next_month = '$lang_next_month', ";
		   $sql .= "lang_day_sunday = '$lang_day_sunday', ";
		   $sql .= "lang_day_monday = '$lang_day_monday', ";
		   $sql .= "lang_day_tuesday = '$lang_day_tuesday', ";
		   $sql .= "lang_day_wednesday = '$lang_day_wednesday', ";
		   $sql .= "lang_day_thursday = '$lang_day_thursday', ";
		   $sql .= "lang_day_friday = '$lang_day_friday', ";
		   $sql .= "lang_day_saturday = '$lang_day_saturday', ";
		   $sql .= "lang_month_january = '$lang_month_january', ";
		   $sql .= "lang_month_february = '$lang_month_february', ";
		   $sql .= "lang_month_march = '$lang_month_march', ";
		   $sql .= "lang_month_april = '$lang_month_april', ";
		   $sql .= "lang_month_may = '$lang_month_may', ";
		   $sql .= "lang_month_june = '$lang_month_june', ";
		   $sql .= "lang_month_july = '$lang_month_july', ";
		   $sql .= "lang_month_august = '$lang_month_august', ";
		   $sql .= "lang_month_september = '$lang_month_september', ";
		   $sql .= "lang_month_october = '$lang_month_october', ";
		   $sql .= "lang_month_november = '$lang_month_november', ";
		   $sql .= "lang_month_december = '$lang_month_december' ";
		   $sql .= "WHERE id = $calendar_id ";
		   $result = $wpdb->query($sql);
		   
	   } else {
		   
		   $sql = "INSERT INTO $table_name (";
		   $sql .= "title, ";
		   $sql .= "description, ";
		   $sql .= "width, ";
		   $sql .= "width_unity, ";
		   $sql .= "default_date, ";
		   $sql .= "date_range_start, ";
		   $sql .= "date_range_end, ";
		   $sql .= "current_date_color, ";
		   $sql .= "active, ";
		   $sql .= "format_ampm, ";
		   $sql .= "show_time, ";
		   $sql .= "show_search, ";
		   $sql .= "first_day, ";
		   $sql .= "lang_txt_no_events_found, ";
		   $sql .= "lang_txt_all_day, ";
		   $sql .= "lang_txt_references, ";
		   $sql .= "lang_txt_search, ";
		   $sql .= "lang_txt_results_for, ";
		   $sql .= "lang_txt_current_date, ";
		   $sql .= "lang_prev_month, ";
		   $sql .= "lang_next_month, ";
		   $sql .= "lang_day_sunday, ";
		   $sql .= "lang_day_monday, ";
		   $sql .= "lang_day_tuesday, ";
		   $sql .= "lang_day_wednesday, ";
		   $sql .= "lang_day_thursday, ";
		   $sql .= "lang_day_friday, ";
		   $sql .= "lang_day_saturday, ";
		   $sql .= "lang_month_january, ";
		   $sql .= "lang_month_february, ";
		   $sql .= "lang_month_march, ";
		   $sql .= "lang_month_april, ";
		   $sql .= "lang_month_may, ";
		   $sql .= "lang_month_june, ";
		   $sql .= "lang_month_july, ";
		   $sql .= "lang_month_august, ";
		   $sql .= "lang_month_september, ";
		   $sql .= "lang_month_october, ";
		   $sql .= "lang_month_november, ";
		   $sql .= "lang_month_december ";
		   $sql .= ") VALUES ( ";
		   $sql .= "'$title', ";
		   $sql .= "'$description', ";
		   $sql .= "'$width', ";
		   $sql .= "'$width_unity', ";
		   $sql .= "'$default_date', ";
		   $sql .= "'$date_range_start', ";
		   $sql .= "'$date_range_end', ";
		   $sql .= "'$current_date_color', ";
		   $sql .= "$active, ";
		   $sql .= "$format_ampm, ";
		   $sql .= "$show_time, ";
		   $sql .= "$show_search, ";
		   $sql .= "$first_day, ";
		   $sql .= "'$lang_txt_no_events_found', ";
		   $sql .= "'$lang_txt_all_day', ";
		   $sql .= "'$lang_txt_references', ";
		   $sql .= "'$lang_txt_search', ";
		   $sql .= "'$lang_txt_results_for', ";
		   $sql .= "'$lang_txt_current_date', ";
		   $sql .= "'$lang_prev_month', ";
		   $sql .= "'$lang_next_month', ";
		   $sql .= "'$lang_day_sunday', ";
		   $sql .= "'$lang_day_monday', ";
		   $sql .= "'$lang_day_tuesday', ";
		   $sql .= "'$lang_day_wednesday', ";
		   $sql .= "'$lang_day_thursday', ";
		   $sql .= "'$lang_day_friday', ";
		   $sql .= "'$lang_day_saturday', ";
		   $sql .= "'$lang_month_january', ";
		   $sql .= "'$lang_month_february', ";
		   $sql .= "'$lang_month_march', ";
		   $sql .= "'$lang_month_april', ";
		   $sql .= "'$lang_month_may', ";
		   $sql .= "'$lang_month_june', ";
		   $sql .= "'$lang_month_july', ";
		   $sql .= "'$lang_month_august', ";
		   $sql .= "'$lang_month_september', ";
		   $sql .= "'$lang_month_october', ";
		   $sql .= "'$lang_month_november', ";
		   $sql .= "'$lang_month_december' ";
		   $sql .= ");";
		   $result = $wpdb->query($sql);

	   }
	   
	   wp_redirect( admin_url('admin.php?page=dpProEventCalendar-admin&settings-updated=1') );
	   exit;
	}
	
	if ($_GET['delete_calendar']) {
	   $calendar_id = $_GET['delete_calendar'];
	   
	   $sql = "DELETE FROM $table_name WHERE id = $calendar_id;";
	   $result = $wpdb->query($sql);
	   
	   $sql = "DELETE FROM $table_name_special_dates_calendar WHERE calendar = $calendar_id;";
	   $result = $wpdb->query($sql);
	   	   
	   wp_redirect( admin_url('admin.php?page=dpProEventCalendar-admin&settings-updated=1') );
	   exit;
	}
	
	
	require_once (dirname (__FILE__) . '/../classes/base.class.php');
	
	
	?>
    
	<div class="wrap" style="clear:both;" id="dp_options">
    <h2></h2>
	<div style="clear:both;"></div>
 	<!--end of poststuff --> 
 	<div id="dp_ui_content">
    	
        <div id="leftSide">
        	<div id="dp_logo"></div>
            <p>
                Version: <?php echo DP_PRO_EVENT_CALENDAR_VER?><br />
            </p>
            <ul id="menu" class="nav">
                <li><a href="javascript:void(0);" class="active" title=""><span><?php _e('Calendars','dpProEventCalendar'); ?></span></a></li>
                <li><a href="admin.php?page=dpProEventCalendar-events" title=""><span><?php _e('Events','dpProEventCalendar'); ?></span></a></li>
                <li><a href="admin.php?page=dpProEventCalendar-special" title=""><span><?php _e('Special Dates','dpProEventCalendar'); ?></span></a></li>
            </ul>
            
            <div class="clear"></div>
		</div>     
		<?php if(!is_numeric($_GET['add']) && !is_numeric($_GET['edit'])) {	?>
 
        
        <div id="rightSide">
        	<div id="menu_general_settings">
                <div class="titleArea">
                    <div class="wrapper">
                        <div class="pageTitle">
                            <h2><?php _e('Calendars List','dpProEventCalendar'); ?></h2>
                            <span><?php _e('Use the shortcode in your posts or pages.','dpProEventCalendar'); ?></span>
                        </div>
                        
                        <div class="clear"></div>
                    </div>
                </div>
                
                <div class="wrapper">

                <form action="" method="post">
					<?php settings_fields('dpProEventCalendar-group'); ?>
                    
                    <input type="hidden" name="remove_posts_calendar" value="1" />
                    
                    	<div class="submit">
                        
                        <input type="button" value="<?php echo __( 'Add new calendar', 'dpProEventCalendar' )?>" name="add_calendar" onclick="location.href='<?php echo dpProEventCalendar_admin_url( array( 'add' => '1' ) )?>';" />
                        
                        </div>
                        <table class="widefat" cellpadding="0" cellspacing="0" id="sort-table">
                        	<thead>
                        		<tr style="cursor:default !important;">
                                	<th><?php _e('ID','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Shortcode','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Title','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Description','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Events','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Actions','dpProEventCalendar'); ?></th>
                                 </tr>
                            </thead>
                            <tbody>
                        <?php 
						$counter = 0;
                        $querystr = "
                        SELECT calendars.*, (SELECT COUNT(*) FROM $table_name_events events WHERE events.id_calendar = calendars.id) as events
                        FROM $table_name calendars
                        ORDER BY calendars.title ASC
                        ";
                        $calendars_obj = $wpdb->get_results($querystr, OBJECT);
                        foreach($calendars_obj as $calendar) {
							$dpProEventCalendar_class = new DpProEventCalendar( true, (is_numeric($calendar->id) ? $calendar->id : null) );
							
							$dpProEventCalendar_class->addScripts(true);
							
							$calendar_nonce = $dpProEventCalendar_class->getNonce();
							
                            echo '<tr id="'.$calendar->id.'">
									<td width="5%">'.$calendar->id.'</td>
									<td width="20%">[dpProEventCalendar id='.$calendar->id.']</td>
									<td width="20%">'.$calendar->title.'</td>
									<td width="20%">'.$calendar->description.'</td>
									<td width="5%"><a href="'.admin_url('admin.php?page=dpProEventCalendar-events&search_id_calendar='.$calendar->id).'">'.$calendar->events.'</a></td>
									<td width="30%">
										<input type="button" value="'.__( 'Edit', 'dpProEventCalendar' ).'" name="edit_calendar" class="button-secondary" onclick="location.href=\''.admin_url('admin.php?page=dpProEventCalendar-admin&edit='.$calendar->id).'\';" />
										<input type="button" value="'.__( 'Special Dates', 'dpProEventCalendar' ).'" name="sp_calendar" data-calendar-id="'.$calendar->id.'" data-calendar-nonce="'.$calendar_nonce.'" class="btn_manage_special_dates button-secondary" />
										<input type="button" value="'.__( 'Delete', 'dpProEventCalendar' ).'" name="delete_calendar" class="button-secondary" onclick="if(confirmCalendarDelete()) { location.href=\''.admin_url('admin.php?page=dpProEventCalendar-admin&delete_calendar='.$calendar->id.'&noheader=true').'\'; }" />
									</td>
								</tr>'; 
							$counter++;
							$dpProEventCalendar_class->output(true);
                        }
                        ?>
                        
                    		</tbody>
                            <tfoot>
                            	<tr style="cursor:default !important;">
                                	<th><?php _e('ID','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Shortcode','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Title','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Description','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Events','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Actions','dpProEventCalendar'); ?></th>
                                 </tr>
                            </tfoot>
                        </table>
                        
                        <div class="submit">
                        
                        <input type="button" value="<?php echo __( 'Add new calendar', 'dpProEventCalendar' )?>" name="add_calendar" onclick="location.href='<?php echo dpProEventCalendar_admin_url( array( 'add' => '1' ) )?>';" />
                        
                        </div>
                        <div class="clear"></div>
                 </form>
             	</div>
            </div> 
        <?php } elseif(is_numeric($_GET['add']) || is_numeric($_GET['edit'])) {
		
		if(is_numeric($_GET['edit'])){
			$calendar_id = $_GET['edit'];
			$querystr = "
			SELECT *
			FROM $table_name 
			WHERE id = $calendar_id
			";
			$calendar_obj = $wpdb->get_results($querystr, OBJECT);
			$calendar_obj = $calendar_obj[0];	
			foreach($calendar_obj as $key=>$value) { $$key = $value; }
		}
		
		$dpProEventCalendar_class = new DpProEventCalendar( true, (is_numeric($calendar_id) ? $calendar_id : null) );
		
		$dpProEventCalendar_class->addScripts(true);
		?>
        <div id="rightSide">
        	<div id="menu_general_settings">
                <div class="titleArea">
                    <div class="wrapper">
                        <div class="pageTitle">
                            <h2><?php _e('Calendar','dpProEventCalendar'); ?></h2>
                            <span><?php _e('Customize the Calendar.','dpProEventCalendar'); ?></span>
                        </div>
                        
                        <div class="clear"></div>
                    </div>
                </div>
                
                <div class="wrapper">
        
       		<form method="post" action="<?php echo admin_url('admin.php?page=dpProEventCalendar-admin&noheader=true'); ?>" onsubmit="return calendar_checkform();">
            <input type="hidden" name="submit" value="1" />
            <?php if(is_numeric($id) && $id > 0) {?>
            	<input type="hidden" name="calendar_id" value="<?php echo $id?>" />
            <?php }?>
            <?php settings_fields('dpProEventCalendar-group'); ?>
            <div style="clear:both;"></div>
             <!--end of poststuff --> 
             	
                <h2 class="subtitle accordion_title" onclick="showAccordion('div_general_settings');">General Settings</h2>
                <div id="div_general_settings">
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Active','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="active" id="dpProEventCalendar_active" class="checkbox" <?php if($active) {?>checked="checked" <?php }?> value="1" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('On/Off the calendar','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
        
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Title','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="title" maxlength="80" id="dpProEventCalendar_title" class="large-text" value="<?php echo $title?>" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Introduce the title (80 chars max.)','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Description','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="description" id="dpProEventCalendar_description" class="large-text" value="<?php echo $description?>" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Introduce the description','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Preselected Date','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" readonly="readonly" maxlength="10" class="large-text"  name="default_date" id="dpProEventCalendar_default_date" value="<?php echo $default_date != '0000-00-00' ? $default_date : '' ?>" style="width:100px;" />
                                    <button type="button" class="dpProEventCalendar_btn_getDate">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                    </button>
                                    <button type="button" onclick="jQuery('#dpProEventCalendar_default_date').val('');">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/clear.png' ); ?>" alt="Clear" title="Clear">
                                    </button>
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Select the preselected date.(optional)<br />Leave blank to NOT preselect any date.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Date Range','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" readonly="readonly" maxlength="10" class="large-text"  name="date_range_start" id="dpProEventCalendar_date_range_start" value="<?php echo $date_range_start != '0000-00-00' ? $date_range_start : '' ?>" style="width:100px;" />
                                    <button type="button" class="dpProEventCalendar_btn_getDateRangeStart">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                    </button>
                                    <button type="button" onclick="jQuery('#dpProEventCalendar_date_range_start').val('');">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/clear.png' ); ?>" alt="Clear" title="Clear">
                                    </button>
                                    
                                    &nbsp;&nbsp;to&nbsp;&nbsp;
                                    
                                    <input type="text" readonly="readonly" maxlength="10" class="large-text"  name="date_range_end" id="dpProEventCalendar_date_range_end" value="<?php echo $date_range_end != '0000-00-00' ? $date_range_end : '' ?>" style="width:100px;" />
                                    <button type="button" class="dpProEventCalendar_btn_getDateRangeEnd">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                    </button>
                                    <button type="button" onclick="jQuery('#dpProEventCalendar_date_range_end').val('');">
                                        <img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/clear.png' ); ?>" alt="Clear" title="Clear">
                                    </button>
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Select the date range.(optional)','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select no_border">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('First Day','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <select name="first_day" id="dpProEventCalendar_first_day" class="large-text">
                                    	<option value="0"><?php _e('Sunday','dpProEventCalendar'); ?></option>
                                        <option value="1"><?php _e('Monday','dpProEventCalendar'); ?></option>
                                    </select>
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Select the first day to display in the calendar','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                
                <h2 class="subtitle accordion_title" onclick="showAccordion('div_display_settings');">Display Settings</h2>
                
                <div id="div_display_settings" style="display: none;">
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show Time','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_time" class="checkbox" id="dpProEventCalendar_show_time" value="1" <?php if($show_time) {?>checked="checked" <?php }?> onclick="toggleFormat();" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set if Show/Hide the events time.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox" id="div_format_ampm" style="display:none;">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Hour Format AM/PM','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="format_ampm" id="dpProEventCalendar_format_ampm" class="checkbox" <?php if($format_ampm) {?> checked="checked" <?php }?> value="1" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set the hour format to AM/PM, if disabled the format will be 24 hours','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Show Search','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="checkbox" name="show_search" class="checkbox" id="dpProEventCalendar_show_search" value="1" <?php if($show_search) {?>checked="checked" <?php }?> />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set if Show/Hide the search input.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-checkbox">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Current Date Color','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <div id="currentDate_colorSelector" class="colorSelector"><div style="background-color: <?php echo $current_date_color?>"></div></div>
                                    <input type="hidden" name="current_date_color" id="dpProEventCalendar_current_date_color" value="<?php echo $current_date_color?>" />
                                    <br>
                                </div>
                                <div class="desc"><?php _e('Set the Current date color.','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select no_border">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Width','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="width" id="dpProEventCalendar_width" maxlength="4" style="width:50px;" class="large-text" value="<?php echo $width?>" /> 
                                    <select name="width_unity" id="dpProEventCalendar_width_unity" style="width:60px;" class="large-text">
                                        <option value="px" <?php if($width_unity == 'px') {?> selected="selected" <?php }?>>px</option>
                                        <option value="%" <?php if($width_unity == '%') {?> selected="selected" <?php }?>>%</option>
                                    </select>
                                    <br>
                                </div>
                                <div class="desc" style="margin-left: 120px; width: 400px;"><?php _e('Set the width of the calendar','dpProEventCalendar'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                
                <h2 class="subtitle accordion_title" onclick="showAccordion('div_translations');">Translations</h2>
                
                <div id="div_translations" style="display: none;">
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Prev Month','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_prev_month" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['PREV_MONTH']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Next Month','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_next_month" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['NEXT_MONTH']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('No Events Found','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_txt_no_events_found" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['TXT_NO_EVENTS_FOUND']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('All Day','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_txt_all_day" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['TXT_ALL_DAY']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('References','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_txt_references" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['TXT_REFERENCES']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Search','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_txt_search" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['TXT_SEARCH']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Results','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_txt_results_for" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['TXT_RESULTS_FOR']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Current Date','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_txt_current_date" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['TXT_CURRENT_DATE']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Sunday','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_day_sunday" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['DAY_SUNDAY']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Monday','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_day_monday" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['DAY_MONDAY']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Tuesday','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_day_tuesday" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['DAY_TUESDAY']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Wednesday','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_day_wednesday" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['DAY_WEDNESDAY']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Thursday','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_day_thursday" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['DAY_THURSDAY']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Friday','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_day_friday" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['DAY_FRIDAY']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('Saturday','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_day_saturday" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['DAY_SATURDAY']?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('January','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_january" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][0]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('February','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_february" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][1]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('March','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_march" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][2]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('April','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_april" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][3]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('May','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_may" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][4]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('June','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_june" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][5]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('July','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_july" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][6]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('August','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_august" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][7]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('September','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_september" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][8]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('October','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_october" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][9]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('November','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_november" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][10]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="option option-select">
                        <div class="option-inner">
                            <label class="titledesc"><?php _e('December','dpProEventCalendar'); ?></label>
                            <div class="formcontainer">
                                <div class="forminp">
                                    <input type="text" name="lang_month_december" class="large-text" value="<?php echo $dpProEventCalendar_class->translation['MONTHS'][11]?>" />
                                    <br>
                                </div>
                                <div class="desc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
               </div>
               
                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
                        <input type="button" class="button" value="<?php _e('Back') ?>" onclick="history.back();" />
                    </p>
                </form>
                <script type="text/javascript">
					toggleFormat();
				</script>
            </div>
        </div>
        <?php $dpProEventCalendar_class->output(true);?>
        <?php }?>
	 <!--end of poststuff --> 
	
	
	</div> <!--end of float wrap -->
    <div class="clear"></div>
	

	<?php	
}
?>