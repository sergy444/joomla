<?php
/*------------------------------------------------------------------------
 # Sot Virtuemart Slideshow  - Version 1.0
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # @Author: Sky Of Tech
 # @Websites: http://skyoftech.com
 # @Email: contactnum1@gmail.com
 # Copyright (C) 2010-2011 Sky Of Tech. All Rights Reserved.
 -------------------------------------------------------------------------*/
 
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (dirname(__FILE__).DS.'helper.php');
global $mm_action_url, $VM_LANG;

/*-- start---*/
$description 			= $params->get("description", 0);
$thumb_width 			= $params->get("thumb_width", 500);
$thumb_height 			= $params->get("thumb_height", 300);
$auto_play				= $params->get("auto_play", 1);
$navigation_position	= $params->get("navigation_position", 'bottom');
$effect					= $params->get("effect", 'random');
$timer					= $params->get("timer", 4000);
$opacity				= $params->get("opacity", 0.7);
$show_navigation		= $params->get("show_navigation", 1);
$link_image				= $params->get("link_image", 1);
$hover					= $params->get("hover", 1);	
$show_readmore			= $params->get("show_readmore", 1);
$target					= $params->get("target", 1);
$navigation_type		= $params->get("navigation_type", "square");	

JHTML::stylesheet('style.css', JURI::base() . 'modules/'.$module->module.'/assets/');		
$modvmHelper = new modVMHelper();
$items = $modvmHelper->excute($params, $module);


/** include js file **/
?>
	<script type="text/javascript" src="<?php echo JURI::base() . '/modules/'.$module->module.'/assets/jquery-1.4.4.min.js';?>" ></script>
	<script type="text/javascript" src="<?php echo JURI::base() . '/modules/'.$module->module.'/assets/coin-slider.js';?>" ></script>
<?php
/** include js file **/

$path = JModuleHelper::getLayoutPath( 'mod_sot_vm_slideshow');
if (file_exists($path)) {
	require($path);
}
?>