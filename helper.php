<?php
/*
Module Joomla! 3.x Native Component
@version: 1.0.0
@author: Tadele Meshesha 
@link:http://he-il.joomla.com/jewishcalendar
@license GPL2 
*/
defined( '_JEXEC' ) or die;
include('torah_cal.php');

class modJewishCalendarHelper
{
	//private static $savelocaltz;

	public static function getAjax(){

		//jimport('joomla.application.module.helper');
		$input  = JFactory::getApplication()->input;
		$jsPath   = JURI::root(true) . '/modules/mod_jewishcalendar';
		
		$module = JModuleHelper::getModule('mod_jewishcalendar', $input->getString('title'));
		$params = new JRegistry();
		$params->loadString($module->params);
		
		$get_ajax_data = $input->get('data');
		
		$get_ajax_data_ary = explode("SPRETOR",$get_ajax_data);
		
		$localtz_data = $get_ajax_data_ary[0];
		$module_id = $get_ajax_data_ary[1];
		//and i don't use php Session becouse the data seved in web server.
		
		$chek_localtz_dash = strpos($localtz_data,"%2F");
		if ($chek_localtz_dash!=false){
			$localtz_data = str_replace("%2F","/",$localtz_data);
		}else{
			$localtz_data = str_replace("2F","/",$localtz_data);
		}
		
		/*
		$chek_localtz_pls = strpos($localtz_data,"%2B");
		if ($chek_localtz_pls!=false){
			$localtz_data = str_replace("%2B","+",$localtz_data);
		}else{
			$chek_localtz_pls2 = strpos($localtz_data,"2B");
			if ($chek_localtz_pls2!=false){
				$localtz_data = str_replace("2B","+",$localtz_data);
			}
		}
		$chek_localtz_mns = strpos($localtz_data,"%2D");
		if ($chek_localtz_mns!=false){
			$localtz_data = str_replace("%2D","-",$localtz_data);
		}else{
			$chek_localtz_mns2 = strpos($localtz_data,"2D");
			if ($chek_localtz_mns2!=false){
				$localtz_data = str_replace("2D","-",$localtz_data);
			}
		}*/	
		$mydata = new stdClass();
		//general params
		$offset    = $get_ajax_data_ary[3];//$params->get('timezoneoffset', 'UTC');
		$timeSource = $get_ajax_data_ary[2];//$params->get('clock_source', 'client');		
		$mydata->timezonesorce = $timeSource;
		if($timeSource=="client"){
			//if($localtz_data=="") $localtz_data="UTC";
			$mydata->timezone = $localtz_data;
			$choosen_tz = $localtz_data;
		}else if($timeSource=="gmt"){
			$chek_offset_dash = strpos($offset,"%2F");
			if ($chek_offset_dash!=false){
				$offset = str_replace("%2F","/",$offset);
			}else{
				$offset = str_replace("2F","/",$offset);
			}
			$mydata->timezone = $offset;
			$choosen_tz = $offset;
		}
		//Clock params
		$mydata->clockformat = $get_ajax_data_ary[4];//$params->get('clock_format', 't12');
		$mydata->clockseconds = $get_ajax_data_ary[5];//$params->get('clock_seconds', 1);
		$mydata->clockleadingZeros = $get_ajax_data_ary[6];//$params->get('leadingZeros', 1);
		$mydata->clocktime = self::getClockTime($choosen_tz);
		$mydata->clock_id = $module_id;
		$clocktime = self::getClockTime($choosen_tz);
		//Gregorian Date params
		$gregoriantranslate = $get_ajax_data_ary[7];//$params->get('gregorian_date_language', 1);
		$gregorianformat    = str_replace("PACEE"," ",$get_ajax_data_ary[8]);//$params->get('gregorian_date_format', JText::_('DATE_FORMAT_LC2'));		
		$gregoriandate = self::getGregorianDate($gregoriantranslate,$gregorianformat,$choosen_tz);
		
		//Jewish Calendar params
		$jewishlang = $get_ajax_data_ary[9];//$params->get('jewish_date_language', 1);
		$jewishviewJyear = $get_ajax_data_ary[10];//$params->get('jewish_yaer', 1);
		$jewishcalendar = self::getJewishCalendar($jewishlang,$jewishviewJyear,$choosen_tz);
		
		//Day Name params
		$daylang = $get_ajax_data_ary[11];//$params->get('day_language', 1);
		$dayformat = $get_ajax_data_ary[12];//$params->get('dayname_format', 1);				
		$dayname = self::getDayName($daylang,$dayformat,$choosen_tz);

		//Calendar table
		//calendar type,1-jewish, 0-gre.
		$cal_date = "";
		if($timeSource=="client"){
			date_default_timezone_set($choosen_tz);
			$cal_date = date("F d, Y H:i:s");	
		}else if($timeSource=="gmt"){
			//$caldate = new JDate('now', $choosen_tz);
			date_default_timezone_set($choosen_tz);
			$cal_date = date("F d, Y H:i:s");			
		}		
		$get_cal_type = $params->get('calendar_type', '0');
		if($get_cal_type=='0'){
			$cal_type="gre";
		}else if($get_cal_type=='1'){
			$cal_type="jewish";
		}

		//calendar languge,0-en 1-he.
		$get_cal_lang = $params->get('calendar_type_language', '0');
		if($get_cal_lang=='0'){
			$cal_lang = "en";
		}else if($get_cal_lang=='1'){
			$cal_lang = "he";
		}		 
		//calendar detail view type
		$get_cal_event_detail_type = $params->get('jc_events_detail_type', '3');
		switch ($get_cal_event_detail_type){
			case '0':
				$cal_event_detail_type = "none";
				break;
			case '1':
				$cal_event_detail_type = "day";
				break;
			case '2':
				$cal_event_detail_type = "week";
				break;
			case '3':
				$cal_event_detail_type = "month";
				break;				
		}
		
		$items = $params->get('items');
		$returndata="";
		foreach($items as $item)
		{
			switch ($item)
			{
				case 'clock':
					$clock_time = $mydata;
					$returndata .= '<div class="jwishdate_clock" id="jewishClock_' . $module_id . '"></div>';
					require_once JPATH_ROOT . '/modules/mod_jewishcalendar/liveclock.php';
					break;

				case 'day':
					$returndata .= '<div class="jwishdate_dayname" id="jwishdate_dayname_' . $module_id . '">' . $dayname . '</div>';
					break;
					
				case 'jregorian':
					$returndata .= '<div class="gregorian_calander" id="gregorian_calander_' . $module_id . '">' . $gregoriandate . '</div>';
					break;

				case 'jewish':
					$returndata .= '<div class="jewish_calander" id="jewish_calander_' . $module_id . '">' . $jewishcalendar . '</div>';
					break;

				case 'jewishcal':
					$returndata .= '<div class="jewish_calander_cal" id="jewish_calander_cal_' . $module_id . '">
					<div class="jewish_calander_cal_container" id="jewish_calander_cal_container_'.$module_id.'"></div>
					</div>
					<script type="text/javascript">
							jQuery("#jewish_calander_cal_container_'.$module_id.'").monthly({
								cal: "'.$cal_type.'",
								lang: "'.$cal_lang.'",
								caldate: "'.$cal_date.'",
								listViewType: "'.$cal_event_detail_type.'",
								dataType: "php",
								jsonUrl: "'.$jsPath.'/calendar/events.json"
							});
					</script>';
					break;					
			}
		}		
		//return $mydata;
		return $returndata;
	}
	public static function getClockTime($tz){
		date_default_timezone_set($tz);
		$myclock = date("F d, Y H:i:s");
		return $myclock;	
	}	
	// Gregorian Date
	public static function getGregorianDate($translate,$format,$tz){
		$date      = new JDate('now', $tz);
		$gregorian_date = $date->calendar($format, true, $translate);
		$dir = $translate ? '' : 'dir="ltr"';
		return '<span ' . $dir . '>' . $gregorian_date . '</span>';
	}
	public static function getJewishCalendar($lang,$viewJyear,$tz){
		date_default_timezone_set($tz);
		$tz_date =   date('d/m/Y'); 
		$tz_date_ary = explode("/",$tz_date);

		$today = $tz_date_ary[0];
		$now_month = $tz_date_ary[1];
		$now_year = $tz_date_ary[2];
		$jdNumber = gregoriantojd((int)$now_month, (int)$today, (int)$now_year);
		$hebjewishCalendar = jdtojewish($jdNumber, true, CAL_JEWISH_ADD_GERESHAYIM);
		$hebjewishCalendar_ary = explode(" ",$hebjewishCalendar);
		$hebjewishCalendar_ary_len = count($hebjewishCalendar_ary);
		$jewishYear_heb = $hebjewishCalendar_ary[$hebjewishCalendar_ary_len-1];
		$jewishCalendar = jdtojewish($jdNumber);
		list($jewishMonth_num, $jewishDay_num, $jewishYear_num) = explode('/', $jewishCalendar);
		$jewishMonthName = self::getJewishMonthName($jewishMonth_num, $jewishYear_num, $lang);
		$jewishDay_heb_ary = array( "א'", "ב'", "ג'", "ד'", "ה'", "ו'", "ז'", "ח'", "ט'", "י'", 'י"א', 'י"ב',
									'י"ג', 'י"ד', 'ט"ו', 'ט"ז', 'י"ז', 'י"ח', 'י"ט', "כ'", 'כ"א', 
									'כ"ב', 'כ"ג', 'כ"ד', 'כ"ה', 'כ"ו', 'כ"ז', 'כ"ח', 'כ"ט', "ל'" );
		$jewishDay_heb = $jewishDay_heb_ary[$jewishDay_num-1];
		$jewishYear_heb = iconv( 'WINDOWS-1255', 'UTF-8', $jewishYear_heb );
		if($lang==1){ //Heb
			if ($viewJyear==1){ //display jewish year
				return '<span dir="rtl">'.$jewishDay_heb.' '.$jewishMonthName.' '.$jewishYear_heb.'</span>';
			}else{ // don't display jewish year
				return '<span dir="rtl">'.$jewishDay_heb.' '.$jewishMonthName.'</span>';
			}
		}else{ //Eng
			if ($viewJyear==1){ //display jewish year
				return '<span dir="ltr">'.$jewishDay_num.' '.$jewishMonthName.' '.$jewishYear_num.'</span>';
			}else{  // don't display jewish year
				return '<span dir="ltr">'.$jewishDay_num.' '.$jewishMonthName.'</span>';
			}
		}
		
	}
	public static function isJewishLeapYear($year) {
		if ($year % 19 == 0 || $year % 19 == 3 || $year % 19 == 6 ||
		  $year % 19 == 8 || $year % 19 == 11 || $year % 19 == 14 ||
		  $year % 19 == 17)
		return true;
		else
		return false;
	}

	public static function getJewishMonthName($jewishMonth, $jewishYear, $lang) {
		$en_jewishMonthNamesLeap = array("Tishri", "Heshvan", "Kislev", "Tevet",
									"Shevat", "Adar I", "Adar II", "Nisan",
									"Iyar", "Sivan", "Tammuz", "Av", "Elul");
		$en_jewishMonthNamesNonLeap = array("Tishri", "Heshvan", "Kislev", "Tevet",
									   "Shevat", "", "Adar", "Nisan",
									   "Iyar", "Sivan", "Tammuz", "Av", "Elul");
		$he_jewishMonthNamesLeap = array("בתשרי", "במרחשוון", "בכסלו", "בטבת",
									"בשבט", "באדר א'", "באדר ב'", "בניסן",
									"באייר", "בסיוון", "בתמוז", "באב", "באלול");
		$he_jewishMonthNamesNonLeap = array("בתשרי", "במרחשוון", "בכסלו", "בטבת",
									"בשבט", "", "באדר", "בניסן",
									"באייר", "בסיוון", "בתמוז", "באב", "באלול");
		if($lang==0){	//Eng						
			if (self::isJewishLeapYear($jewishYear)){
				return $en_jewishMonthNamesLeap[$jewishMonth-1];
			}else{
				return $en_jewishMonthNamesNonLeap[$jewishMonth-1];
			}
		}else{ //$lang=='1' > Heb
			if (self::isJewishLeapYear($jewishYear)){
				return $he_jewishMonthNamesLeap[$jewishMonth-1];
			}else{
				return $he_jewishMonthNamesNonLeap[$jewishMonth-1];
			}			
		}
	}
	public static function getDayName($lang,$dayformat,$tz){
		
		$heb_day_ary = array('ראשון','שני','שלישי','רביעי','חמישי','שיש','שבת');
		$heb_day_ary_short = array("א'","ב'","ג'","ד'","ה'","ו'","ש'");
		$eng_day_ary = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$eng_day_ary_short = array('Sun.','Mon.','Tue.','Wed.','Thu.','Fri.','Sat.');
		$eng_day_ary_very_short = array('Su.','Mo.','Tu.','We.','Th.','Fr.','Sa.');//not in use in this time
		
		$today      = new JDate('now', $tz);
		
		$day_num = $today->calendar('w',true);	
		if($lang==1){ //Heb
			if($dayformat==1){ //full name
				$day_name =  '<span dir="rtl">'.$heb_day_ary[$day_num].'</span>';
			}else{ //short name
				$day_name =  '<span dir="rtl">'.$heb_day_ary_short[$day_num].'</span>';
			}	
		}else{ //Eng
			if($dayformat==1){  //full name
				$day_name = '<span dir="ltr">'.$eng_day_ary[$day_num].'</span>';
			}else{ //short name
				$day_name = '<span dir="ltr">'.$eng_day_ary_short[$day_num].'</span>';
			}			
		}
		return 	$day_name;
	}
	public static function getCreateJsonAjax(){
		//get module data
		//$jsPath   = JURI::root(true) . '/modules/mod_jewishcalendar';
		$module = JModuleHelper::getModule('mod_jewishcalendar');
		$params = new JRegistry();
		$params->loadString($module->params);
		$get_cal_type = $params->get('calendar_type');//1-jewish, 0-gregorian
		$event_type = $params->get('jc_events_type');
		$holdy_lang = $params->get('holidays_language');
		$tora_lang = $params->get('torah_language');
		$il_daspora = $params->get('israeldiaspora');
		$shushanpurim = $params->get('postponeshushanpurim');
		
		//get ajax data
		$input  = JFactory::getApplication()->input;
		$get_data = $input->get('data');
		$get_data_ary = explode("AND",$get_data);
		
		if ($get_cal_type== "0"){
			$cal_type = "gregorian";
			$month = $get_data_ary[0];
			$year=$get_data_ary[1];			
		}else if ($get_cal_type== "1"){
			$cal_type = "jewish";
			$month = $get_data_ary[0];
			$year=$get_data_ary[1];			
		}

		if ($il_daspora== "1"){
			$isDiaspora = true;
		}else{
			$isDiaspora = false;
		}
		if ($shushanpurim == "1"){
			$postponeShushanPurimOnSaturday = true; 
		}else{
			$postponeShushanPurimOnSaturday = false; 
		}
		if($holdy_lang == "1"){
			$hldy_lang = "he";
		}else if($holdy_lang == "0"){
			$hldy_lang = "en";
		}
		if($tora_lang == "1"){
			$torah_lang = "he";
		}else if($tora_lang == "0"){
			$torah_lang = "en";
		}	
		//event_type:
		$hldy_flg = false;
		$tora_flg = false;
		switch($event_type){
			case "0":
				$hldy_flg = true;
				break;
			case "1":
				$tora_flg = true;
				break;
			case "2":
				$hldy_flg = true;
				$tora_flg = true;
				break;				
		}
		$event_id = 1;
		$year = (int)$year;
		$xml_str =  '{';
		$xml_str .= '"monthly": [';				
		if((int)$month<10){
			$month = "0".$month;
		}	  
		
		if ($get_cal_type== "0"){ //gregorian
			$lastDay = cal_days_in_month(CAL_GREGORIAN, (int)$month, $year);
		}else if ($get_cal_type== "1"){ //jewish
			
			$lastDay = cal_days_in_month(CAL_JEWISH, (int)$month, $year);
		}
		
		for ($gday = 1; $gday <= $lastDay; $gday++) {
			if((int)$gday<10){
				$gday = "0".$gday;
			}				

			if ($get_cal_type== "0"){ //gregorian
				$jdCurrent = gregoriantojd((int)$month, (int)$gday, $year);//Convert gregorian to Julian Day Count
			}else if ($get_cal_type== "1"){ //jewish
				$jdCurrent = jewishtojd((int)$month, (int)$gday, $year);//Convert jewish to Julian Day Count
			}
					
			$holidays = self::getJewishHoliday($jdCurrent, $isDiaspora, $postponeShushanPurimOnSaturday, $hldy_lang);
			if (count($holidays) > 0 && $hldy_flg) {	
				$holiday ="";
				for ($i = 0; $i < count($holidays); $i++) {
					if($i<count($holidays)-1){
						$holiday .= $holidays[$i].",";							
					}else{
						$holiday .= $holidays[$i];
					}
				}
				if($event_id==1){
					$xml_str .= '{';
				}else{
					$xml_str .= '},{';
				}
				$xml_str .= '"id":"'.$event_id.'",';
				$xml_str .= '"name":"'.$holiday.'",';
				$xml_str .= '"type":"holiday",';
				$xml_str .= '"startdate":"'.$year.'-'.$month.'-'.$gday.'",';
				$xml_str .= '"enddate":"",';
				$xml_str .= '"starttime":"",';
				$xml_str .= '"endtime":"",';
				$xml_str .= '"color":"",';
				$xml_str .= '"url":""';
				$event_id++;
			}
			//get Torah
			
			if($tora_flg){
				if ($get_cal_type== "0"){ //gregorian
					$jewishCalendar = jdtojewish($jdCurrent);
					list($jMonth, $jDay, $jYear) = explode('/', $jewishCalendar); //Convert gregorian to jewish date
				}else if ($get_cal_type== "1"){ //jewish
					$jMonth = (int)$month;
					$jDay = (int)$gday; 
					$jYear = (int)$year;
				}
				$dte = jddayofweek($jdCurrent, 0);
				if($dte==6){
					$torah = getTorah::getTorahSections($jMonth, $jDay, $jYear, $isDiaspora, $torah_lang);
					//$xml_str .=$torah.'\n';
					if($torah!=""){
						if($event_id==1){
							$xml_str .= '{';
						}else{
						$xml_str .= '},{';
						}
						$xml_str .= '"id":"'.$event_id.'",';
						$xml_str .= '"name":"'.$torah.'",';
						$xml_str .= '"type":"torah",';
						$xml_str .= '"startdate":"'.$year.'-'.$month.'-'.$gday.'",';
						$xml_str .= '"enddate":"",';
						$xml_str .= '"starttime":"",';
						$xml_str .= '"endtime":"",';
						$xml_str .= '"color":"",';
						$xml_str .= '"url":""';
						$event_id++;							
					}						
				}
			}
		}
		if($event_id==1){
			$xml_str .= '{';
			$xml_str .= '"id":"",';
			$xml_str .= '"name":"",';
			$xml_str .= '"type":"",';
			$xml_str .= '"startdate":"",';
			$xml_str .= '"enddate":"",';
			$xml_str .= '"starttime":"",';
			$xml_str .= '"endtime":"",';
			$xml_str .= '"color":"",';
			$xml_str .= '"url":""';			
		}
		$xml_str .= '}]}';

		return $xml_str;
		
	}
	function getJewishHoliday($jdCurrent, $isDiaspora, $postponeShushanPurimOnSaturday, $h_lang) {
		$result = array();
		$TISHRI = 1;
		$HESHVAN = 2;
		$KISLEV = 3;
		$TEVET = 4;
		$SHEVAT = 5;
		$ADAR_I = 6;
		$ADAR_II = 7;
		$ADAR = 7;
		$NISAN = 8;
		$IYAR = 9;
		$SIVAN = 10;
		$TAMMUZ = 11;
		$AV = 12;
		$ELUL = 13;

		$SUNDAY = 0;
		$MONDAY = 1;
		$TUESDAY = 2;
		$WEDNESDAY = 3;
		$THURSDAY = 4;
		$FRIDAY = 5;
		$SATURDAY = 6;
		// holidays names
		// Holidays in Elul
		if($h_lang=="he"){
			$ErevRoshHashanah = "ערב ראש השנה";
			$RoshHashanahI = "ראש השנה א";
			$RoshHashanahII = "ראש השנה ב";
			$TzomGedaliah = "צום גדליה";
			$ErevYomKippur = "ערב יום כיפור";
			$YomKippur = "יום כיפור";
			$ErevSukkot = "ערב סוכות";
			$SukkotI = "סוכות א";
			$SukkotII = "סוכות ב";
			$HolHamoedSukkot = "חול המועד סוכות";
			$HoshanaRabbah = "הושענא רבה";
			$SheminiAzeret = "שמיני עצרת";
			$SimchatTorah = "שמחת תורה";
			$IsruChag = "אסרו חג";
			$SheminiAzeretSimchatTorah = "שמיני עצרת/שמחת תורה";
			$HanukkahI = "חנוכה א";
			$HanukkahII = "חנוכה ב";
			$HanukkahIII = "חנוכה ג";
			$HanukkahIV = "חנוכה ד";
			$HanukkahV = "חנוכה ה";
			$HanukkahVI = "חנוכה ו";
			$HanukkahVII = "חנוכה ז";
			$HanukkahVIII = "חנוכה ח";
			$TzomTevet = "צום עשרה בטבת";
			$TuBShevat = "טו בשבט";
			$PurimKatan = "פורים קטן";
			$ShushanPurimKatan = "שושן פורים קטן";
			$TaanithEsther = "תענית אסתר";
			$Purim = "פורים";
			$ShushanPurimPurimMeshulash = "שושן פורים (פורים משולש)";
			$ShushanPurim = "שושן פורים";
			$ShabbatHagadol = "שבת הגדול";
			$ErevPesach = "ערב פסח";
			$PesachI = "פסח א";
			$PesachII = "פסח ב";
			$HolHamoedPesach = "חול המועד פסח";
			$PesachVII = "שביעי של פסח";
			$PesachVIII = "שמיני של פסח";
			$YomHashoah = "יום השואה";
			$YomHazikaron = "יום הזיכרון";
			$YomHaAtzmaut = "יום העצמאות";
			$PesachSheini = "פסח שני";
			$LagBOmer = "לג בעומר";
			$YomYerushalayim = "יום ירושלים";
			$ErevShavuot = "ערב שבועות";
			$ShavuotI = "שבועות א";
			$ShavuotII = "שבועות ב";
			$TzomTammuz = "צום שבעה עשר בתמוז";
			$TishaBAv = "תשעה באב";
			$TuBAv = "טו באב";		  
		}else if($h_lang=="en"){
			$ErevRoshHashanah = "Erev Rosh Hashanah";
			$RoshHashanahI = "Rosh Hashanah I";
			$RoshHashanahII = "Rosh Hashanah II";
			$TzomGedaliah = "Tzom Gedaliah";
			$ErevYomKippur = "Erev Yom Kippur";
			$YomKippur = "Yom Kippur";
			$ErevSukkot = "Erev Sukkot";
			$SukkotI = "Sukkot I";
			$SukkotII = "Sukkot II";
			$HolHamoedSukkot = "Hol Hamoed Sukkot";
			$HoshanaRabbah = "Hoshana Rabbah";
			$SheminiAzeret = "Shemini Azeret";
			$SimchatTorah = "Simchat Torah";
			$IsruChag = "Isru Chag";
			$SheminiAzeretSimchatTorah = "Shemini Azeret/Simchat Torah";
			$HanukkahI = "Hanukkah I";
			$HanukkahII = "Hanukkah II";
			$HanukkahIII = "Hanukkah III";
			$HanukkahIV = "Hanukkah IV";
			$HanukkahV = "Hanukkah V";
			$HanukkahVI = "Hanukkah VI";
			$HanukkahVII = "Hanukkah VII";
			$HanukkahVIII = "Hanukkah VIII";
			$TzomTevet = "Tzom Tevet";
			$TuBShevat = "Tu B'Shevat";
			$PurimKatan = "Purim Katan";
			$ShushanPurimKatan = "Shushan Purim Katan";
			$TaanithEsther = "Ta'anith Esther";
			$Purim = "Purim";
			$ShushanPurimPurimMeshulash = "Shushan Purim (Purim Meshulash)";
			$ShushanPurim = "Shushan Purim";
			$ShabbatHagadol = "Shabbat Hagadol";
			$ErevPesach = "Erev Pesach";
			$PesachI = "Pesach I";
			$PesachII = "Pesach II";
			$HolHamoedPesach = "Hol Hamoed Pesach";
			$PesachVII = "Pesach VII";
			$PesachVIII = "Pesach VIII";
			$YomHashoah = "Yom Hashoah";
			$YomHazikaron = "Yom Hazikaron";
			$YomHaAtzmaut = "Yom Ha'Atzmaut";
			$PesachSheini = "Pesach Sheini";
			$LagBOmer = "Lag B'Omer";
			$YomYerushalayim = "Yom Yerushalayim";
			$ErevShavuot = "Erev Shavuot";
			$ShavuotI = "Shavuot I";
			$ShavuotII = "Shavuot II";
			$TzomTammuz = "Tzom Tammuz";
			$TishaBAv = "Tisha B'Av";
			$TuBAv = "Tu B'Av";	
		}
		$jewishDate = jdtojewish($jdCurrent);
		list($jewishMonth, $jewishDay, $jewishYear) = explode('/', $jewishDate);

		// Holidays in Elul
		if ($jewishDay == 29 && $jewishMonth == $ELUL){
			$result[] = $ErevRoshHashanah;
		}

		// Holidays in Tishri
		if ($jewishDay == 1 && $jewishMonth == $TISHRI)
			$result[] = $RoshHashanahI;
		if ($jewishDay == 2 && $jewishMonth == $TISHRI)
			$result[] = $RoshHashanahII;
		$jd = jewishtojd($TISHRI, 3, $jewishYear);
		$weekdayNo = jddayofweek($jd, 0);
		if ($weekdayNo == $SATURDAY) { // If the 3 Tishri would fall on Saturday ...
			// ... postpone Tzom Gedaliah to Sunday
			if ($jewishDay == 4 && $jewishMonth == $TISHRI)
				$result[] = $TzomGedaliah;
		} else {
			if ($jewishDay == 3 && $jewishMonth == $TISHRI)
				$result[] = $TzomGedaliah;
		}
		if ($jewishDay == 9 && $jewishMonth == $TISHRI)
			$result[] = $ErevYomKippur;
		if ($jewishDay == 10 && $jewishMonth == $TISHRI)
			$result[] = $YomKippur;
		if ($jewishDay == 14 && $jewishMonth == $TISHRI)
			$result[] = $ErevSukkot;
		if ($jewishDay == 15 && $jewishMonth == $TISHRI)
			$result[] = $SukkotI;
		if ($jewishDay == 16 && $jewishMonth == $TISHRI && $isDiaspora)
			$result[] = $SukkotII;
		if ($isDiaspora) {
			if ($jewishDay >= 17 && $jewishDay <= 20 && $jewishMonth == $TISHRI)
				$result[] = $HolHamoedSukkot;
		} else {
			if ($jewishDay >= 16 && $jewishDay <= 20 && $jewishMonth == $TISHRI)
				$result[] = $HolHamoedSukkot;
		}
		if ($jewishDay == 21 && $jewishMonth == $TISHRI)
			$result[] = $HoshanaRabbah;
		if ($isDiaspora) {
			if ($jewishDay == 22 && $jewishMonth == $TISHRI)
			  $result[] = $SheminiAzeret;
			if ($jewishDay == 23 && $jewishMonth == $TISHRI)
			  $result[] = $SimchatTorah;
			if ($jewishDay == 24 && $jewishMonth == $TISHRI)
			  $result[] = $IsruChag;
		} else {
			if ($jewishDay == 22 && $jewishMonth == $TISHRI)
				$result[] = $SheminiAzeretSimchatTorah;
			if ($jewishDay == 23 && $jewishMonth == $TISHRI)
				$result[] = $IsruChag;
		}

		// Holidays in Kislev/Tevet
		$hanukkahStart = jewishtojd($KISLEV, 25, $jewishYear);
		$hanukkahNo = (int) ($jdCurrent-$hanukkahStart+1);
		if ($hanukkahNo == 1) $result[] = $HanukkahI;
		if ($hanukkahNo == 2) $result[] = $HanukkahII;
		if ($hanukkahNo == 3) $result[] = $HanukkahIII;
		if ($hanukkahNo == 4) $result[] = $HanukkahIV;
		if ($hanukkahNo == 5) $result[] = $HanukkahV;
		if ($hanukkahNo == 6) $result[] = $HanukkahVI;
		if ($hanukkahNo == 7) $result[] = $HanukkahVII;
		if ($hanukkahNo == 8) $result[] = $HanukkahVIII;

		// Holidays in Tevet
		$jd = jewishtojd($TEVET, 10, $jewishYear);
		$weekdayNo = jddayofweek($jd, 0);
		if ($weekdayNo == $SATURDAY) { // If the 10 Tevet would fall on Saturday ...
		// ... postpone Tzom Tevet to Sunday
			if ($jewishDay == 11 && $jewishMonth == $TEVET)
				$result[] = $TzomTevet;
		} else {
			if ($jewishDay == 10 && $jewishMonth == $TEVET)
			$result[] = $TzomTevet;
		}

		// Holidays in Shevat
		if ($jewishDay == 15 && $jewishMonth == $SHEVAT)
			$result[] = $TuBShevat;

		// Holidays in Adar I
		$is_leap_year = self::isJewishLeapYear($jewishYear);
		if ($is_leap_year && $jewishDay == 14 && $jewishMonth == $ADAR_I)
			$result[] = $PurimKatan;
		if ($is_leap_year && $jewishDay == 15 && $jewishMonth == $ADAR_I)
			$result[] = $ShushanPurimKatan;

		// Holidays in Adar or Adar II
		if ($is_leap_year)
			$purimMonth = $ADAR_II;
		else
			$purimMonth = $ADAR;
		$jd = jewishtojd($purimMonth, 13, $jewishYear);
		$weekdayNo = jddayofweek($jd, 0);
		if ($weekdayNo == $SATURDAY) { // If the 13 Adar or Adar II would fall on Saturday ...
		// ... move Ta'anit Esther to the preceding Thursday
			if ($jewishDay == 11 && $jewishMonth == $purimMonth)
				$result[] = $TaanithEsther;
		} else {
			if ($jewishDay == 13 && $jewishMonth == $purimMonth)
				$result[] = $TaanithEsther;
		}
		if ($jewishDay == 14 && $jewishMonth == $purimMonth)
			$result[] = $Purim;
		//if ($postponeShushanPurimOnSaturday) {
		$jd = jewishtojd($purimMonth, 15, $jewishYear);
		$weekdayNo = jddayofweek($jd, 0);
		if ($weekdayNo == $SATURDAY) { // If the 15 Adar or Adar II would fall on Saturday ...
		  // ... postpone Shushan Purim to Sunday
			if ($jewishDay == 16 && $jewishMonth == $purimMonth)
				$result[] = $ShushanPurimPurimMeshulash;
		//} else {
			if ($jewishDay == 15 && $jewishMonth == $purimMonth)
				$result[] = $ShushanPurim;
		// }
		} else {
			if ($jewishDay == 15 && $jewishMonth == $purimMonth)
				$result[] = $ShushanPurim;
		}

		// Holidays in Nisan
		$shabbatHagadolDay = 14;
		$jd = jewishtojd($NISAN, $shabbatHagadolDay, $jewishYear);
		while (jddayofweek($jd, 0) != $SATURDAY) {
			$jd--;
			$shabbatHagadolDay--;
		}
		if ($jewishDay == $shabbatHagadolDay && $jewishMonth == $NISAN)
		$result[] = $ShabbatHagadol;
		if ($jewishDay == 14 && $jewishMonth == $NISAN)
		$result[] = $ErevPesach;
		if ($jewishDay == 15 && $jewishMonth == $NISAN)
		$result[] = $PesachI;
		if ($jewishDay == 16 && $jewishMonth == $NISAN && $isDiaspora)
		$result[] = $PesachII;
		if ($isDiaspora) {
		if ($jewishDay >= 17 && $jewishDay <= 20 && $jewishMonth == $NISAN)
		  $result[] = $HolHamoedPesach;
		} else {
		if ($jewishDay >= 16 && $jewishDay <= 20 && $jewishMonth == $NISAN)
		  $result[] = $HolHamoedPesach;
		}
		if ($jewishDay == 21 && $jewishMonth == $NISAN)
		$result[] = $PesachVII;
		if ($jewishDay == 22 && $jewishMonth == $NISAN && $isDiaspora)
		$result[] = $PesachVIII;
		if ($isDiaspora) {
		if ($jewishDay == 23 && $jewishMonth == $NISAN)
		  $result[] = $IsruChag;
		} else {
		if ($jewishDay == 22 && $jewishMonth == $NISAN)
		  $result[] = $IsruChag;
		}

		$jd = jewishtojd($NISAN, 27, $jewishYear);
		$weekdayNo = jddayofweek($jd, 0);
		if ($weekdayNo == $FRIDAY) { // If the 27 Nisan would fall on Friday ...
			// ... then Yom Hashoah falls on Thursday
			if ($jewishDay == 26 && $jewishMonth == $NISAN)
				$result[] = $YomHashoah;
		} else {
			if ($jewishYear >= 5757) { // Since 1997 (5757) ...
				if ($weekdayNo == $SUNDAY) { // If the 27 Nisan would fall on Friday ...
					// ... then Yom Hashoah falls on Thursday
					if ($jewishDay == 28 && $jewishMonth == $NISAN)
					$result[] = $YomHashoah;
				} else {
					if ($jewishDay == 27 && $jewishMonth == $NISAN)
						$result[] = $YomHashoah;
				}
			} else {
				if ($jewishDay == 27 && $jewishMonth == $NISAN)
					$result[] = $YomHashoah;
			}
		}

		// Holidays in Iyar

		$jd = jewishtojd($IYAR, 4, $jewishYear);
		$weekdayNo = jddayofweek($jd, 0);

		// If the 4 Iyar would fall on Friday or Thursday ...
		// ... then Yom Hazikaron falls on Wednesday and Yom Ha'Atzmaut on Thursday
		if ($weekdayNo == $FRIDAY) {
		if ($jewishDay == 2 && $jewishMonth == $IYAR)
		  $result[] = $YomHazikaron;
		if ($jewishDay == 3 && $jewishMonth == $IYAR)
		  $result[] = $YomHaAtzmaut;
		} else {
		if ($weekdayNo == $THURSDAY) {
		  if ($jewishDay == 3 && $jewishMonth == $IYAR)
			$result[] = $YomHazikaron;
		  if ($jewishDay == 4 && $jewishMonth == $IYAR)
			$result[] = $YomHaAtzmaut;
		} else {
		  if ($jewishYear >= 5764) { // Since 2004 (5764) ...
			if ($weekdayNo == $SUNDAY) { // If the 4 Iyar would fall on Sunday ...
			  // ... then Yom Hazicaron falls on Monday
			  if ($jewishDay == 5 && $jewishMonth == $IYAR)
				$result[] = $YomHazikaron;
			  if ($jewishDay == 6 && $jewishMonth == $IYAR)
				$result[] = $YomHaAtzmaut;
			} else {
			  if ($jewishDay == 4 && $jewishMonth == $IYAR)
				$result[] = $YomHazikaron;
			  if ($jewishDay == 5 && $jewishMonth == $IYAR)
				$result[] = $YomHaAtzmaut;
			}
		  } else {
			if ($jewishDay == 4 && $jewishMonth == $IYAR)
			  $result[] = $YomHazikaron;
			if ($jewishDay == 5 && $jewishMonth == $IYAR)
			  $result[] = $YomHaAtzmaut;
		  }
		}
		}

		if ($jewishDay == 14 && $jewishMonth == $IYAR)
		$result[] = $PesachSheini;
		if ($jewishDay == 18 && $jewishMonth == $IYAR)
		$result[] = $LagBOmer;
		if ($jewishDay == 28 && $jewishMonth == $IYAR)
		$result[] = $YomYerushalayim;

		// Holidays in Sivan
		if ($jewishDay == 5 && $jewishMonth == $SIVAN)
		$result[] = $ErevShavuot;
		if ($jewishDay == 6 && $jewishMonth == $SIVAN)
		$result[] = $ShavuotI;
		if ($jewishDay == 7 && $jewishMonth == $SIVAN && $isDiaspora)
		$result[] = $ShavuotII;
		if ($isDiaspora) {
		if ($jewishDay == 8 && $jewishMonth == $SIVAN)
		  $result[] = $IsruChag;
		} else {
		if ($jewishDay == 7 && $jewishMonth == $SIVAN)
		  $result[] = $IsruChag;
		}

		// Holidays in Tammuz
		$jd = jewishtojd($TAMMUZ, 17, $jewishYear);
		$weekdayNo = jddayofweek($jd, 0);
		if ($weekdayNo == $SATURDAY) { // If the 17 Tammuz would fall on Saturday ...
		// ... postpone Tzom Tammuz to Sunday
		if ($jewishDay == 18 && $jewishMonth == $TAMMUZ)
		  $result[] = $TzomTammuz;
		} else {
		if ($jewishDay == 17 && $jewishMonth == $TAMMUZ)
			$result[] = $TzomTammuz;
		}

		// Holidays in Av
		$jd = jewishtojd($AV, 9, $jewishYear);
		$weekdayNo = jddayofweek($jd, 0);
		if ($weekdayNo == $SATURDAY) { // If the 9 Av would fall on Saturday ...
			// ... postpone Tisha B'Av to Sunday
			if ($jewishDay == 10 && $jewishMonth == $AV)
				$result[] = $TishaBAv;
		} else {
			if ($jewishDay == 9 && $jewishMonth == $AV)
				$result[] = $TishaBAv;
		}
		if ($jewishDay == 15 && $jewishMonth == $AV)
			$result[] = $TuBAv;

		return $result;
	}
	//public static function getCalander($cal_type,$cal_lang){
	//	$cal = "";
	//	return $cal;
	//}
}
