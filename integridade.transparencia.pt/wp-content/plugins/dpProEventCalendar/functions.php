<?php
function dpProEventCalendar_admin_url( $query = array() ) {
	global $plugin_page;

	if ( ! isset( $query['page'] ) )
		$query['page'] = $plugin_page;

	$path = 'admin.php';

	if ( $query = build_query( $query ) )
		$path .= '?' . $query;

	$url = admin_url( $path );

	return esc_url_raw( $url );
}

function dpProEventCalendar_plugin_url( $path = '' ) {
	global $wp_version;
	if ( version_compare( $wp_version, '2.8', '<' ) ) { // Using WordPress 2.7
		$folder = dirname( plugin_basename( __FILE__ ) );
		if ( '.' != $folder )
			$path = path_join( ltrim( $folder, '/' ), $path );

		return plugins_url( $path );
	}
	return plugins_url( $path, __FILE__ );
}

function dpProEventCalendar_parse_date( $date ) {
	
	$date = substr($date,0,10);
	if($date == "0000-00-00" || $date == "")
		return '';
	$date_arr = explode("-", $date);
	$date = $date_arr[1]."/".$date_arr[2]."/".$date_arr[0];
	
	return $date ;
}

function dpProEventCalendar_parse_date_widget( $date, $date_format ) {
	if($date == "0000-00-00" || $date == "")
		return '';
		
	$date_arr = explode("-", substr($date, 0, 10));
	$time_arr = explode(":", substr($date, 11, 5));
	
	switch($date_format) {
		case 0: 
			$date = $date_arr[1]."/".$date_arr[2]."/".$date_arr[0]." ".$time_arr[0].":".$time_arr[1];
			break;
		case 1: 
			$date = $date_arr[2]."/".$date_arr[1]."/".$date_arr[0]." ".$time_arr[0].":".$time_arr[1];
			break;
		case 2: 
			$date = $date_arr[1]."/".$date_arr[2]."/".$date_arr[0];
			break;
		case 3: 
			$date = $date_arr[2]."/".$date_arr[1]."/".$date_arr[0];
			break;
		case 4: 
			$date = substr(dpProEventCalendar_translate_month($date_arr[1]), 0, 3)." ".$date_arr[2].", ".$date_arr[0];
			break;
		case 5: 
			$date = substr(dpProEventCalendar_translate_month($date_arr[1]), 0, 3)." ".$date_arr[2];
			break;
		default: 
			$date = $date_arr[1]."/".$date_arr[2]."/".$date_arr[0]." ".$time_arr[0].":".$time_arr[1];
			break;	
	}
	
	return $date ;
}

function dpProEventCalendar_translate_month($month) {
	global $dpProEventCalendar;
	
	switch($month) {
		case "01":
			$month_name = $dpProEventCalendar['lang_january'];
			break;
		case "02":
			$month_name = $dpProEventCalendar['lang_february'];
			break;
		case "03":
			$month_name = $dpProEventCalendar['lang_march'];
			break;
		case "04":
			$month_name = $dpProEventCalendar['lang_april'];
			break;
		case "05":
			$month_name = $dpProEventCalendar['lang_may'];
			break;
		case "06":
			$month_name = $dpProEventCalendar['lang_june'];
			break;
		case "07":
			$month_name = $dpProEventCalendar['lang_july'];
			break;
		case "08":
			$month_name = $dpProEventCalendar['lang_august'];
			break;
		case "09":
			$month_name = $dpProEventCalendar['lang_september'];
			break;
		case "10":
			$month_name = $dpProEventCalendar['lang_october'];
			break;
		case "11":
			$month_name = $dpProEventCalendar['lang_november'];
			break;
		case "12":
			$month_name = $dpProEventCalendar['lang_december'];
			break;
		default:
			$month_name = $dpProEventCalendar['lang_january'];
			break;
	}
	
	return $month_name;
}

function dpProEventCalendar_reslash_multi(&$val,$key) 
{
   if (is_array($val)) array_walk($val,'dpProEventCalendar_reslash_multi',$new);
   else {
      $val = dpProEventCalendar_reslash($val);
   }
}


function dpProEventCalendar_reslash($string)
{
   if (!get_magic_quotes_gpc())$string = addslashes($string);
   return $string;
}

function dpProEventCalendar_CutString ($texto, $longitud = 180) { 
	$str_len = function_exists('mb_strlen') ? mb_strlen($texto) : strlen($texto);
	if($str_len > $longitud) { 
		$strpos = function_exists('mb_strpos') ? mb_strpos($texto, ' ', $longitud) : strpos($texto, ' ', $longitud);
		$pos_espacios = $strpos - 1; 
		if($pos_espacios > 0) { 
			$substr1 = function_exists('mb_substr') ? mb_substr($texto, 0, ($pos_espacios + 1)) : substr($texto, 0, ($pos_espacios + 1));
			$caracteres = count_chars($substr1, 1); 
			if ($caracteres[ord('<')] > $caracteres[ord('>')]) { 
				$strpos2 = function_exists('mb_strpos') ? mb_strpos($texto, ">", $pos_espacios) : strpos($texto, ">", $pos_espacios);
				$pos_espacios = $strpos2 - 1; 
			} 
			$substr2 = function_exists('mb_substr') ? mb_substr($texto, 0, ($pos_espacios + 1)) : substr($texto, 0, ($pos_espacios + 1));
			$texto = $substr2.'...'; 
		} 
		if(preg_match_all("|(<([\w]+)[^>]*>)|", $texto, $buffer)) { 
			if(!empty($buffer[1])) { 
				preg_match_all("|</([a-zA-Z]+)>|", $texto, $buffer2); 
				if(count($buffer[2]) != count($buffer2[1])) { 
					$cierrotags = array_diff($buffer[2], $buffer2[1]); 
					$cierrotags = array_reverse($cierrotags); 
					foreach($cierrotags as $tag) { 
							$texto .= '</'.$tag.'>'; 
					} 
				} 
			} 
		} 
 
	} 
	return $texto; 
}

add_action( 'wp_ajax_nopriv_getDate', 'dpProEventCalendar_getDate' );
add_action( 'wp_ajax_getDate', 'dpProEventCalendar_getDate' );
 
function dpProEventCalendar_getDate() {
	
    $nonce = $_POST['postEventsNonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-get-events-nonce' ) )
        die ( 'Busted!');
		
	if(!is_numeric($_POST['date'])) { die(); }
	
	$timestamp = $_POST['date'];
	$calendar = $_POST['calendar'];
	$is_admin = $_POST['is_admin'];
	if ($is_admin && strtolower($is_admin) !== "false") {
      $is_admin = true;
   } else {
      $is_admin = false;
   }
   
	require_once('classes/base.class.php');

	$dpProEventCalendar = new DpProEventCalendar( $is_admin, $calendar, $timestamp );
	
	die($dpProEventCalendar->monthlyCalendarLayout());
}

add_action( 'wp_ajax_nopriv_getEvents', 'dpProEventCalendar_getEvents' );
add_action( 'wp_ajax_getEvents', 'dpProEventCalendar_getEvents' );
 
function dpProEventCalendar_getEvents() {
	
    $nonce = $_POST['postEventsNonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-get-events-nonce' ) )
        die ( 'Busted!');
		
	if(!isset($_POST['date'])) { die(); }
	
	$date = $_POST['date'];
	$calendar = $_POST['calendar'];
	
	require_once('classes/base.class.php');

	$dpProEventCalendar = new DpProEventCalendar( false, $calendar );
	
	die($dpProEventCalendar->eventsListLayout( $date ));
}

add_action( 'wp_ajax_nopriv_getSearchResults', 'dpProEventCalendar_getSearchResults' );
add_action( 'wp_ajax_getSearchResults', 'dpProEventCalendar_getSearchResults' );
 
function dpProEventCalendar_getSearchResults() {
	
    $nonce = $_POST['postEventsNonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-get-events-nonce' ) )
        die ( 'Busted!');
		
	if(!isset($_POST['calendar']) || !isset($_POST['key'])) { die(); }
	
	$calendar = $_POST['calendar'];
	$key = $_POST['key'];
	
	require_once('classes/base.class.php');

	$dpProEventCalendar = new DpProEventCalendar( false, $calendar );
	
	die($dpProEventCalendar->getSearchResults( $key ));
}

add_action( 'wp_ajax_setSpecialDates', 'dpProEventCalendar_setSpecialDates' );
 
function dpProEventCalendar_setSpecialDates() {

    $nonce = $_POST['postEventsNonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-get-events-nonce' ) )
        die ( 'Busted!');
		
	if(!isset($_POST['calendar']) || !isset($_POST['date'])) { die(); }
	
	$calendar = $_POST['calendar'];
	$sp = $_POST['sp'];
	$date = $_POST['date'];
	
	require_once('classes/base.class.php');

	$dpProEventCalendar = new DpProEventCalendar( true, $calendar );
	
	$dpProEventCalendar->setSpecialDates( $sp, $date );
	
	die();
}

function dpProEventCalendar_updateNotice(){
    echo '<div class="updated">
       <p>Updated Succesfully.</p>
    </div>';
}

if(@$_GET['settings-updated'] && ($_GET['page'] == 'dpProEventCalendar-admin' || $_GET['page'] == 'dpProEventCalendar-events' || $_GET['page'] == 'dpProEventCalendar-special')) {
	add_action('admin_notices', 'dpProEventCalendar_updateNotice');
}
?>