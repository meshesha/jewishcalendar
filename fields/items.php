<?php
/**
 * @package     Joomla.Site
 *
 * @copyright   Copyright (C) 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
JFormHelper::loadFieldClass('list');
class JFormFieldItems extends JFormFieldList{
	protected $type = 'items';

	protected function getInput(){
		$document = JFactory::getDocument();
		$jsPath   = JURI::root(true) . '/modules/mod_jewishcalendar';

		$joomlaVersion = new JVersion();

		if($joomlaVersion->isCompatible('3')){
			JHtml::_('jquery.ui', array('core', 'sortable'));
		}else{
			$document->addStyleSheet($jsPath . '/css/chosen.min.css');
			$document->addScript($jsPath . '/js/jquery.min.js');
			$document->addScript($jsPath . '/js/jquery-noconflict.js');
			$document->addScript($jsPath . '/js/chosen.jquery.min.js');
			$document->addScript($jsPath . '/js/jquery-ui.min.js');
		}

		$document->addScript($jsPath . '/js/jquery-chosen-sortable.min.js');

		$script = 'jQuery(function(){jQuery(".chzn-sortable").chosen().chosenSortable();});';
		$document->addScriptDeclaration($script);

		if(!is_array($this->value)){
			$this->value = explode(',',$this->value);
		}

		$html = parent::getInput();
		
		return $html;
	}

	protected function getOptions(){
		$value = $this->value;

		$options = array();
		$options['clock']   = JHtml::_('select.option', 'clock', JText::_('JEWISHCALENDAR_CLOCK'));
		$options['day']       = JHtml::_('select.option', 'day', JText::_('JEWISHCALENDAR_DAY_NAME'));
		$options['jregorian'] = JHtml::_('select.option', 'jregorian', JText::_('JEWISHCALENDAR_GREGORIAN_DATE'));
		$options['jewish']     = JHtml::_('select.option', 'jewish', JText::_('JEWISHCALENDAR_JEWISH_DATE'));
		$options['jewishcal']     = JHtml::_('select.option', 'jewishcal', JText::_('JEWISHCALENDAR_JEWISH_CAL'));

		$options = $this->sort_array_from_array($options,$value);

		return $options;
	}

	function sort_array_from_array($array, $orderArray){
		$ordered = array();
		foreach($orderArray as $key => $value){
			if(array_key_exists($value,$array)){
				$ordered[] = $array[$value];
				unset($array[$value]);
			}
		}
		return $ordered + $array;
	}
}
