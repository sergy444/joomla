<?php /*
* @package Mj Menu
* @copyright (C) 2012 by Dasinfomedia - All rights reserved!
* @license GNU/GPL, see LICENSE.php
*/
defined('_JEXEC') or die('Restricted access');
?>
<?php

require_once (dirname(__FILE__).DS.'helper.php');
$params->def('module_id',$module->id);
$mjmenu = new modMJMenuHelper();
require(JModuleHelper::getLayoutPath('mod_mjmenu'));

?>



