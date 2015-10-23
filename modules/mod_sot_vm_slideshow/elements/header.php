<?php
/*------------------------------------------------------------------------
 # Sot extension header  - Version 1.0
 # Copyright (C) 2010-2011 Sky Of Tech. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: Sky Of Tech
 # Websites: http://skyoftech.com
 -------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
class JFormFieldHeader extends JFormField {

	var	$type = 'header';

	function getInput(){
		return JElementHeader::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
	}

	function getLabel(){
		return '';
	}

}


jimport('joomla.html.parameter.element');

class JElementHeader extends JElement {

	var	$_name = 'header';

	function fetchElement($name, $value, &$node, $control_name){
		$db = &JFactory::getDBO();
		$module_id = isset($_REQUEST['cid'][0])?$_REQUEST['cid'][0]:(isset($_REQUEST['cid'])?$_REQUEST['cid']:0);
		if(!$module_id) $module_id = (isset($_REQUEST['id']))?$_REQUEST['id']:0;
		$q = "SELECT module FROM `#__modules` WHERE id=".$module_id;
		$db->setQuery($q);
		$module_name = "";
		if($result = $db->loadObjectList()){
			$module_name = $result[0]->module;
		}
		
		$document = & JFactory::getDocument();
		$document->addStyleSheet(JURI::root(true).'/modules/'.$module_name.'/elements/header.css');
		return '<div class="paramHeader">'.JText::_($value).'</div>';
	}

	function fetchTooltip($label, $description, &$node, $control_name, $name){
		return '&nbsp;';
	}
}
