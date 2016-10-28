<?php
/*
Module Joomla! 3.x Native Component
;@version: 1.0.0
;@author: Tadele Meshesha 
;@license GPL2 
;@link:http://he-il.joomla.com/jewishcalendar
*/
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
$document = JFactory::getDocument();

if($params->get('css'))
{
	$document->addStyleDeclaration($params->get('css'));
}

?>

<div class="mod_jewishcalendar_<?php echo $module->id; ?>" id="jewishcalendar_<?php echo $module->id; ?>">
<div class="mylocaltz" id="mylocalTimezone_<?php echo $module->id; ?>" name="mylocalTimezone_<?php echo $module->id; ?>"></div>
</div>