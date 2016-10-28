<?php
/*
Module Joomla! 3.x Native Component
;@version: 1.0.0
;@author: Tadele Meshesha 
;@license GPL2 
;@link:http://he-il.joomla.com/jewishcalendar
*/

defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

//
//JHtml::_('jquery.ui', array('core'));
$document = JFactory::getDocument();
$jsPath   = JURI::root(true) . '/modules/mod_jewishcalendar';
$joomlaVersion = new JVersion();

$document->addScript($jsPath . '/js/jquery-ui.min.js');
$document->addStyleSheet($jsPath . '/css/jquery-ui.min.css');

//general params
$module_id = $module->id;
$module_title = $module->title;
$getoffset    = $params->get('timezoneoffset', 'UTC');
$timeSource = $params->get('clock_source', 'client');
//Clock params
$clockformat = $params->get('clock_format', 't12');
$clockseconds = $params->get('clock_seconds', 1);
$clockleadingZeros = $params->get('leadingZeros', 1);
//Gregorian Date params
$gregolang = $params->get('gregorian_date_language', 1);
$gregoformat    = $params->get('gregorian_date_format', JText::_('DATE_FORMAT_LC2'));
$gregoformat = str_replace(" ","PACEE",$gregoformat);
//Jewish Calendar params
$jewishcalendarlang = $params->get('jewish_date_language', 1);
$jewishcalendarviewJyear = $params->get('jewish_yaer', 1);
//Day Name params
$daynamelang = $params->get('day_language', 1);
$daynameformat = $params->get('dayname_format', 1);	

$document->addScript($jsPath . '/js/jstz.min.js');
$document->addScript($jsPath . '/calendar/js/monthly_jewish_gre.js');
$document->addScript($jsPath . '/calendar/js/hcal.js');
$document->addStyleSheet($jsPath . '/calendar/css/monthly.css');
//$document->addStyleSheet($jsPath . '/calendar/jewish_calnder_cal.css');
$style = '.jewish_calander_cal_container{position: relative;}';
$document->addStyleDeclaration($style);
//calendar colors
$cal_title_bgcolor = $params->get('calendar_title_bgcolor', '#dbecfc');
$cal_month_title_bgcolor = $params->get('calendar_month_year_title_bgcolor', '#3588fc');
$cal_month_title_txtcolor = $params->get('calendar_month_year_title_txtcolor', '#ffffff');
$cal_current_month_btn_bgcolor = $params->get('calendar_current_month_btn_bgcolor', '#3588fc');

$cal_weekdays_bgcolor = $params->get('calendar_weekdays_bgcolor', '#3588fc');
$cal_weekdays_txtcolor = $params->get('calendar_weekdays_txtcolor', '#ffffff');
$cal_days_bgcolor = $params->get('calendar_days_bgcolor', '#ffffff');
$cal_days_txtcolor = $params->get('calendar_days_txtcolor', '#3588fc');
$cal_shabat_days_bgcolor = $params->get('calendar_shabt_days_bgcolor', '#e3edff');
$cal_shabat_days_txtcolor = $params->get('calendar_shabat_days_txtcolor', '#0828fc');
$cal_nlank_days_bgcolor = $params->get('calendar_blank_days_bgcolor', '#dbdbdb');
//events
//holidays
$cal_holidays_bgcolor = $params->get('holidays_bgcolor', '#5466a8');
$cal_holidays_txtcolor = $params->get('holidays_txtcolor', '#ffffff');
//torah
$cal_torah_bgcolor = $params->get('torah_bgcolor', '#44b07a');
$cal_torah_txtcolor = $params->get('torah_txtcolor', '#ffffff');
//.monthly-header-title a:link - > "set to day" button
//.monthly-header-title a:visited - > "set to day" button on click
//.monthly-header-title a:hover - > "set to day" button on hover
$bgcolor_style = '#monthly-header_'.$module_id.'{background: '.$cal_title_bgcolor.';}';
$bgcolor_style .= '#monthly-header-title-date_'.$module_id.',#monthly-header-title-date_'.$module_id.':hover{
						background: '.$cal_month_title_bgcolor.'!important;
						color:'.$cal_month_title_txtcolor.'!important;
					}';
$bgcolor_style .= '#monthly-reset_'.$module_id.'{background: '.$cal_current_month_btn_bgcolor.'!important;}';
$bgcolor_style .= '#monthly-day-title-wrap_'.$module_id.'{
						background: '.$cal_weekdays_bgcolor.';
						color:'.$cal_weekdays_txtcolor.';
					}';
$bgcolor_style .= '#monthly-day_'.$module_id.'{
						background: '.$cal_days_bgcolor.';
						color:'.$cal_days_txtcolor.';
					}';
$bgcolor_style .= '#monthly-day_'.$module_id.'_isShabat{
						background: '.$cal_shabat_days_bgcolor.';
						color:'.$cal_shabat_days_txtcolor.';
					}';
$bgcolor_style .= '#monthly-day-blank_'.$module_id.'{background: '.$cal_nlank_days_bgcolor.';}';
$bgcolor_style .= '#monthly-day_'.$module_id.' #monthly-event-indicator-holiday,
					#monthly-day_'.$module_id.'_isShabat #monthly-event-indicator-holiday,
					#monthly-event-list_'.$module_id.' #listed-event-holiday{
						background: '.$cal_holidays_bgcolor.'!important;
						color:'.$cal_holidays_txtcolor.'!important;
					}';
$bgcolor_style .= '#monthly-day_'.$module_id.' #monthly-event-indicator-torah,
					#monthly-day_'.$module_id.'_isShabat #monthly-event-indicator-torah,
					#monthly-event-list_'.$module_id.' #listed-event-torah{
						background: '.$cal_torah_bgcolor.'!important;
						color:'.$cal_torah_txtcolor.'!important;
					}';					
$document->addStyleDeclaration($bgcolor_style);

$document->addScriptDeclaration("
jQuery(document).ready(function(){
	var tz = jstz.determine();// Determines the time zone of the browser client
	var timezone = tz.name(); //'Asia/Kolhata' for Indian Time.
	var alldata = timezone+'SPRETOR$module_id'+'SPRETOR$timeSource'+'SPRETOR$getoffset';
	alldata +='SPRETOR$clockformat'+'SPRETOR$clockseconds'+'SPRETOR$clockleadingZeros';
	alldata +='SPRETOR$gregolang'+'SPRETOR$gregoformat';
	alldata +='SPRETOR$jewishcalendarlang'+'SPRETOR$jewishcalendarviewJyear';
	alldata +='SPRETOR$daynamelang'+'SPRETOR$daynameformat';
	var request = {
				'option' : 'com_ajax',
				'module' : 'jewishcalendar',
				'title'	 : '$module_title',
				'data'   : encodeURIComponent(alldata), 
				'format' : 'raw'
			};
	jQuery.ajax({
		type   : 'POST',
		data   : request,
		success: function (response) {
			jQuery('.mod_jewishcalendar_$module_id').html(response);
		}
	});
});
");


//Returns the path of the layout file
require JModuleHelper::getLayoutPath('mod_jewishcalendar', $params->get('layout', 'default'));