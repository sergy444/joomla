<?php
/*------------------------------------------------------------------------
 # Sot extension logo  - Version 1.0
 # Copyright (C) 2010-2011 Sky Of Tech. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: Sky Of Tech
 # Websites: http://skyoftech.com
 -------------------------------------------------------------------------*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
/**
* Renders the TC logo
*
* @package Joomla.Framework
* @subpackage Parameter
* @since 1.5
*/
jimport('joomla.html.html');
jimport('joomla.form.formfield');
class JFormFieldLogo extends JFormField
{
	protected $type = 'logo'; //the form field type
  
protected function getInput()
{
	if ($this->value) {
	return JText::_($this->value);
	} else {
	$db = &JFactory::getDBO();
	$module_id = isset($_REQUEST['cid'][0])?$_REQUEST['cid'][0]:(isset($_REQUEST['cid'])?$_REQUEST['cid']:0);
	if(!$module_id) $module_id = (isset($_REQUEST['id']))?$_REQUEST['id']:0;
	$q = "SELECT module FROM `#__modules` WHERE id=".$module_id;
	$db->setQuery($q);
	$module_name = "";
	if($result = $db->loadObjectList()){
		$module_name = $result[0]->module;
	}

	return '<a href="http://skyoftech.com" target="_blank"><img border="0" src="../modules/'.$module_name.'/elements/logo.gif"  title="skyoftech.com" alt="skyoftech.com" ></a>';
}
}
}