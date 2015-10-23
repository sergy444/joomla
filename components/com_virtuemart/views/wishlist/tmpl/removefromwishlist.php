<?php
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
define( 'DS', DIRECTORY_SEPARATOR );
require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');
$mainframe = JFactory::getApplication('site');
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	//print_r($db);
if(isset($user->id) && $user->id!=0 && isset($_GET['wid']) )
{
	$sql= "DELETE FROM `#__virtuemart_wishlist` WHERE `virtuemart_wishlist_id`=".$_REQUEST['wid'];
	$db->setQuery($sql);
	$db->query(); ?>
	<div id="msg_output">success</div>
	<span>Product remove from wishlist.</span><?php 
}
else
{?>
	<div id="msg_output">fail</div>
	<span>For Creating Wishlist you need to Login. </span>
    <?php
}
?>
