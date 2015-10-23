<?php
/**
 *
 * @version $Id$
 * @package VirtueMart
 * @author Valérie Isaksen
 * @subpackage mod_vmmenu
 * @copyright Copyright (C) 2014 VirtueMart Team - All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
 *
 * http://virtuemart.net
 */

// no direct access
defined('_JEXEC') or die;

// Include the module helper classes.
if (!class_exists('ModVMMenuHelper')) {
	require dirname(__FILE__).'/helper.php';
}


// Initialise variables.
$lang		= JFactory::getLanguage();
$user		= JFactory::getUser();
$hideMainmenu	= JRequest::getInt('hidemainmenu')  ;

// Render the module layout
require JModuleHelper::getLayoutPath('mod_vmmenu', $params->get('layout', 'default'));
