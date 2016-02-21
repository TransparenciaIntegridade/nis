<?php 
// This function displays the admin page content
function dpProEventCalendar_events_page() {
	global $dpProEventCalendar, $wpdb, $table_prefix;
	$table_name = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_EVENTS;
	$table_name_calendars = $table_prefix.DP_PRO_EVENT_CALENDAR_TABLE_CALENDARS;
	
	if ($_POST['submit']) {
		
	   foreach($_POST as $key=>$value) { $$key = $value; }
	   
	   if($all_day != 1) { $all_day = 0; }
	   
	   $date = $date . " " . $time_hours . ":" . $time_minutes . ":00";
	   
	   if (is_numeric($_POST['event_id']) && $_POST['event_id'] > 0) {
	   
	   	   $sql = "UPDATE $table_name SET ";
		   $sql .= "title = '$title', ";
		   $sql .= "description = '$description', ";
		   $sql .= "link = '$link', ";
		   $sql .= "share = '$share', ";
		   $sql .= "date = '$date', ";
		   $sql .= "end_date = '$end_date', ";
		   $sql .= "all_day = $all_day, ";
		   $sql .= "recurring_frecuency = $recurring_frecuency, ";
		   $sql .= "id_calendar = $id_calendar ";
		   $sql .= "WHERE id = $event_id ";
		   $result = $wpdb->query($sql);
		   
	   } else {
		   
		   $sql = "INSERT INTO $table_name ";
		   $sql .= "(title, description, link, share, id_calendar, date, all_day, recurring_frecuency, end_date) ";
		   $sql .= "VALUES ";
		   $sql .= "('$title', '$description', '$link', '$share', $id_calendar, '$date', $all_day, $recurring_frecuency, '$end_date');";
		   $result = $wpdb->query($sql);

	   }
	   
	   wp_redirect( admin_url('admin.php?page=dpProEventCalendar-events&settings-updated=1') );
	   exit;
	}
	
	if ($_GET['delete_event']) {
	   $event_id = $_GET['delete_event'];
	   
	   $sql = "DELETE FROM $table_name WHERE id = $event_id;";
	   $result = $wpdb->query($sql);
	   	   
	   wp_redirect( admin_url('admin.php?page=dpProEventCalendar-events&settings-updated=1') );
	   exit;
	}
	
	if($_POST['bulk-action'] == 1) {
		$action = $_POST['action_b'];
		$events = $_POST['events'];
		
		switch($action)
		{
			case "delete":
				foreach($events as $key => $value) {
					$sql = "DELETE FROM $table_name WHERE id = $value;";
	   				$wpdb->query($sql);
				}
				break;
			case "clone":
				foreach($events as $key => $value) {
					$sql = "INSERT INTO $table_name (title, description, id_calendar, date, all_day, recurring_frecuency, end_date, link, share) SELECT title, description, id_calendar, date, all_day, recurring_frecuency, end_date, link, share FROM $table_name WHERE id = $value";
	   				$wpdb->query($sql);
				}
				break;	
		}
		
		wp_redirect( admin_url('admin.php?page=dpProEventCalendar-events&settings-updated=1') );
	    exit;
	}
	
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
                <li><a href="admin.php?page=dpProEventCalendar-admin" title=""><span><?php _e('Calendars','dpProEventCalendar'); ?></span></a></li>
                <li><a href="javascript:void(0);" class="active" title=""><span><?php _e('Events','dpProEventCalendar'); ?></span></a></li>
                <li><a href="admin.php?page=dpProEventCalendar-special" title=""><span><?php _e('Special Dates','dpProEventCalendar'); ?></span></a></li>
            </ul>
            
            <div class="clear"></div>
		</div>     
	
		<?php if(!is_numeric($_GET['add']) && !is_numeric($_GET['edit'])) {?>
        
        <div id="rightSide">
        	<div id="menu_general_settings">
                <div class="titleArea">
                    <div class="wrapper">
                        <div class="pageTitle">
                            <h2><?php _e('Events List','dpProEventCalendar'); ?></h2>
                            <span></span>
                        </div>
                        
                        <div class="clear"></div>
                    </div>
                </div>
                
                <div class="wrapper">
            
			<div class="tablenav top">
			
            <div class="alignleft actions">
            <form action="" method="get">
            	<input type="hidden" name="page" value="dpProEventCalendar-events" />
                
                <select name="search_id_calendar">
                    <option value=""><?php _e('Show all Events','dpProEventCalendar'); ?></option>
					<?php
                    $querystr = "
                    SELECT *
                    FROM $table_name_calendars
                    ORDER BY title ASC
                    ";
                    $calendars_obj = $wpdb->get_results($querystr, OBJECT);
                    foreach($calendars_obj as $calendar) {
                    ?>
                        <option value="<?php echo $calendar->id?>" <?php if($calendar->id == $_GET['search_id_calendar']) {?> selected="selected" <?php }?>><?php echo $calendar->title?></option>
                    <?php }?>
                </select>
                <input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Filter','dpProEventCalendar'); ?>">
            </form>
            </div>
            
            <form action="<?php echo admin_url('admin.php?page=dpProEventCalendar-events&noheader=true'); ?>" method="post" onsubmit="if(confirm('<?php _e('Are you sure?','dpProEventCalendar'); ?>')) { return true; } else { return false;}">
            <div class="alignleft actions">
            
            	<input type="hidden" name="page" value="dpProEventCalendar-events" />
                <input type="hidden" name="bulk-action" value="1" />
                <select name="action_b">
                    <option value="-1" selected="selected"><?php _e('Bulk Actions','dpProEventCalendar'); ?></option>
                    <option value="clone"><?php _e('Clone','dpProEventCalendar'); ?></option>
                    <option value="delete"><?php _e('Delete','dpProEventCalendar'); ?></option>
                </select>
                <input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply','dpProEventCalendar'); ?>">
            </div>
            </div>
					<?php settings_fields('dpProEventCalendar-group'); ?>
                    
                    <input type="hidden" name="remove_posts_event" value="1" />
                        <div class="submit">
                        
                        <input type="button" value="<?php echo __( 'Add new event', 'dpProEventCalendar' )?>" name="add_event" onclick="location.href='<?php echo dpProEventCalendar_admin_url( array( 'add' => '1' ) )?>';" />
                        
                        </div>
                        
                        <table class="widefat" cellpadding="0" cellspacing="0" id="sort-table">
                        	<thead>
                        		<tr style="cursor:default !important;">
                                	<th width="5%" scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
                                    <th width="20%"><?php _e('Title','dpProEventCalendar'); ?></th>
                                    <th width="45%"><?php _e('Description','dpProEventCalendar'); ?></th>
                                    <th width="10%"><?php _e('Date','dpProEventCalendar'); ?></th>
                                    <th width="20%"><?php _e('Actions','dpProEventCalendar'); ?></th>
                                 </tr>
                            </thead>
                            <tbody>
                        <?php 
						$Conditions = "";
						
						if(is_numeric($_GET['search_id_calendar'])) {
							$Conditions = "WHERE events_table.id_calendar = ".$_GET['search_id_calendar']." ";
						}
						
						$counter = 0;
                        $querystr = "
                        SELECT events_table.*
                        FROM $table_name events_table
						$Conditions
                        ORDER BY events_table.date DESC
                        ";
                        $events_obj = $wpdb->get_results($querystr, OBJECT);
                        foreach($events_obj as $event) {
                            echo '<tr id="'.$event->id.'"><td scope="row" class="check-column"><input type="checkbox" name="events[]" value="'.$event->id.'" style="margin: 8px;" /></td><td>'.$event->title.'</td><td>'.dpProEventCalendar_CutString(strip_tags($event->description), 100).'</td><td>'.dpProEventCalendar_parse_date($event->date).' '.substr($event->date, 11,5).' hs</td><td><input type="button" value="'.__( 'Edit', 'dpProEventCalendar' ).'" class="button-secondary" name="edit_event" onclick="location.href=\''.admin_url('admin.php?page=dpProEventCalendar-events&edit='.$event->id).'\';" /><input type="button" value="'.__( 'Delete', 'dpProEventCalendar' ).'" class="button-secondary" name="delete_event" onclick="if(confirmEventDelete()) { location.href=\''.admin_url('admin.php?page=dpProEventCalendar-events&delete_event='.$event->id.'&noheader=true').'\'; }" /></td></tr>'; 
							$counter++;
                        }
                        ?>
                        
                    		</tbody>
                            <tfoot>
                            	<tr style="cursor:default !important;">
                                	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
                                	<th><?php _e('Title','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Description','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Date','dpProEventCalendar'); ?></th>
                                    <th><?php _e('Actions','dpProEventCalendar'); ?></th>
                                 </tr>
                            </tfoot>
                        </table>
                        
                        <div class="submit">
                        
                        <input type="button" value="<?php echo __( 'Add new event', 'dpProEventCalendar' )?>" name="add_event" onclick="location.href='<?php echo dpProEventCalendar_admin_url( array( 'add' => '1' ) )?>';" />
                        
                        </div>
                        <div class="clear"></div>
                 </form>
             	</div>
            </div> 
        </div>
        <?php } elseif(is_numeric($_GET['add']) || is_numeric($_GET['edit'])) {
		require_once (dirname (__FILE__) . '/../classes/base.class.php');
		
		if(is_numeric($_GET['edit'])){
			$event_id = $_GET['edit'];
			$querystr = "
			SELECT *
			FROM $table_name 
			WHERE id = $event_id
			";
			$result = $wpdb->get_results($querystr, OBJECT);
			$result = $result[0];
			foreach($result as $key=>$value) { $$key = $value; }
		}	
		
		$dpProEventCalendar_class = new DpProEventCalendar( true, (is_numeric($id_calendar) ? $id_calendar : null) );
		
		$dpProEventCalendar_class->addScripts(true);
		?>
        
        <div id="rightSide">
        	<div id="menu_general_settings">
                <div class="titleArea">
                    <div class="wrapper">
                        <div class="pageTitle">
                            <h5><?php _e('Event','dpProEventCalendar'); ?></h5>
                            <span></span>
                        </div>
                        
                        <div class="clear"></div>
                    </div>
                </div>
                
                <div class="wrapper">
        
        <form method="post" action="<?php echo admin_url('admin.php?page=dpProEventCalendar-events&noheader=true'); ?>" onsubmit="return event_checkform();">
            <input type="hidden" name="submit" value="1" />
            <?php if(is_numeric($id) && $id > 0) {?>
            	<input type="hidden" name="event_id" value="<?php echo $id?>" />
            <?php }?>
            <?php settings_fields('dpProEventCalendar-group'); ?>
            <div style="clear:both;"></div>
             <!--end of poststuff --> 
                <div class="option option-select">
                    <div class="option-inner">
                        <label class="titledesc"><?php _e('Calendar','dpProEventCalendar'); ?></label>
                        <div class="formcontainer">
                            <div class="forminp">
                                <select name="id_calendar" id="dpProEventCalendar_id_calendar">
                                	<option value=""><?php _e('Select a calendar','dpProEventCalendar'); ?></option>
                                    <?php
                                    $querystr = "
                                    SELECT *
                                    FROM $table_name_calendars
                                    ORDER BY title ASC
                                    ";
                                    $calendars_obj = $wpdb->get_results($querystr, OBJECT);
                                    foreach($calendars_obj as $calendar) {
                                    ?>
	                                    <option value="<?php echo $calendar->id?>" <?php if($calendar->id == $id_calendar) { ?> selected="selected"<?php }?>><?php echo $calendar->title?></option>
                                    <?php }?>
                                </select>
                                <br>
                            </div>
                            <div class="desc"><?php _e('Select a calendar','dpProEventCalendar'); ?></div>
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
                                <textarea name="description" rows="5" cols="20" id="dpProEventCalendar_description" class="dpProEventCalendar_description"><?php echo $description?></textarea>
                                <br>
                            </div>
                            <div class="desc"><?php _e('Introduce the description','dpProEventCalendar'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="option option-select">
                    <div class="option-inner">
                        <label class="titledesc"><?php _e('Link','dpProEventCalendar'); ?></label>
                        <div class="formcontainer">
                            <div class="forminp">
                                <input type="text" name="link" maxlength="255" id="dpProEventCalendar_link" class="large-text" value="<?php echo $link?>" />
                                <br>
                            </div>
                            <div class="desc"><?php _e('Introduce a URL (optional)','dpProEventCalendar'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="option option-select">
                    <div class="option-inner">
                        <label class="titledesc"><?php _e('Share Text','dpProEventCalendar'); ?></label>
                        <div class="formcontainer">
                            <div class="forminp">
                                <input type="text" name="share" id="dpProEventCalendar_share" maxlength="140" class="large-text" value="<?php echo $share?>" />
                                <br>
                            </div>
                            <div class="desc"><?php _e('Introduce a text to be shared through social networks. (optional)<br />i.e: "Event 123 on 14 May, 14:30."','dpProEventCalendar'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="option option-select">
                    <div class="option-inner">
                        <label class="titledesc"><?php _e('Date','dpProEventCalendar'); ?></label>
                        <div class="formcontainer">
                            <div class="forminp">
                                <input type="text" readonly="readonly" name="date" maxlength="10" id="dpProEventCalendar_date" class="large-text" value="<?php echo $date != '' ? date("Y-m-d", strtotime($date)) : ''?>" style="width:100px;" />
                                <button type="button" class="dpProEventCalendar_btn_getEventDate">
                                	<img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                </button>
                                <br>
                            </div>
                            <div class="desc"><?php _e('Select the date','dpProEventCalendar'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="option option-select">
                    <div class="option-inner">
                        <label class="titledesc"><?php _e('Time','dpProEventCalendar'); ?></label>
                        <div class="formcontainer">
                            <div class="forminp">
                                <select name="time_hours" id="dpProEventCalendar_time_hours" style="width:50px;">
                                	<?php for($i = 0; $i <= 23; $i++) {?>
                                    	<option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT)?>" <?php if(date("h", strtotime($date)) == str_pad($i, 2, "0", STR_PAD_LEFT)) {?> selected="selected" <?php }?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                                    <?php }?>
                                </select>
                                <span>:</span>
                                <select name="time_minutes" id="dpProEventCalendar_time_minutes" style="width:50px;">
                                	<?php for($i = 0; $i <= 59; $i++) {?>
                                    	<option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT)?>" <?php if(date("i", strtotime($date)) == str_pad($i, 2, "0", STR_PAD_LEFT)) {?> selected="selected" <?php }?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                                    <?php }?>
                                </select>
                                <br>
                            </div>
                            <div class="desc"><?php _e('Select the time','dpProEventCalendar'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="option option-checkbox">
                    <div class="option-inner">
                        <label class="titledesc"><?php _e('All Day','dpProEventCalendar'); ?></label>
                        <div class="formcontainer">
                            <div class="forminp">
                                <input type="checkbox" name="all_day" class="checkbox" id="dpProEventCalendar_all_day" value="1" <?php if($all_day) {?> checked="checked" <?php }?> />
                                <br>
                            </div>
                            <div class="desc"><?php _e('Set if the event is all the day.','dpProEventCalendar'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="option option-select">
                    <div class="option-inner">
                        <label class="titledesc"><?php _e('Frecuency','dpProEventCalendar'); ?></label>
                        <div class="formcontainer">
                            <div class="forminp">
                                <select name="recurring_frecuency" id="dpProEventCalendar_recurring_frecuency">
                                	<option value="0" <?php if($recurring_frecuency == 0) {?> selected="selected" <?php }?>><?php _e('None','dpProEventCalendar'); ?></option>
                                    <option value="1" <?php if($recurring_frecuency == 1) {?> selected="selected" <?php }?>><?php _e('Daily','dpProEventCalendar'); ?></option>
                                    <option value="2" <?php if($recurring_frecuency == 2) {?> selected="selected" <?php }?>><?php _e('Weekly','dpProEventCalendar'); ?></option>
                                    <option value="3" <?php if($recurring_frecuency == 3) {?> selected="selected" <?php }?>><?php _e('Monthly','dpProEventCalendar'); ?></option>
                                    <option value="4" <?php if($recurring_frecuency == 4) {?> selected="selected" <?php }?>><?php _e('Yearly','dpProEventCalendar'); ?></option>
                                </select>
                                <br>
                            </div>
                            <div class="desc"><?php _e('Select a frecuency','dpProEventCalendar'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="option option-select">
                    <div class="option-inner">
                        <label class="titledesc"><?php _e('End Date','dpProEventCalendar'); ?></label>
                        <div class="formcontainer">
                            <div class="forminp">
                                <input type="text" readonly="readonly" maxlength="10" name="end_date" id="dpProEventCalendar_end_date" class="large-text" value="<?php echo $end_date != '0000-00-00' ? $end_date : ''?>" style="width:100px;" />
                                <button type="button" class="dpProEventCalendar_btn_getEventEndDate">
                                	<img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/calendar.png' ); ?>" alt="Calendar" title="Calendar">
                                </button>
                                <button type="button" onclick="jQuery('#dpProEventCalendar_end_date').val('');">
                                	<img src="<?php echo dpProEventCalendar_plugin_url( 'images/admin/clear.png' ); ?>" alt="Clear" title="Clear">
                                </button>
                                <br>
                            </div>
                            <div class="desc"><?php _e('Select the end date. A frecuency value must be selected.','dpProEventCalendar'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
                <input type="button" class="button" value="<?php _e('Back') ?>" onclick="history.back();" />
            </p>
        </form>
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