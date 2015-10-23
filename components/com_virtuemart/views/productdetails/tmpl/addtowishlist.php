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
if(isset($user->id) && $user->id!=0)
{
	$sql1= "SELECT virtuemart_wishlist_id FROM  `#__virtuemart_wishlist` WHERE userid=".$user->id." AND virtuemart_product_id=".$_REQUEST['pid']." AND virtuemart_category_id=".$_REQUEST['catid'];
	$db->setQuery($sql1);
	$rows1 = $db->loadObject();
	if(isset($rows1))
	{ ?>
	<div id="msg_output">already</div>
		<span>Item already in Wishlist </span>	
    <?php 
	}else{ 
	$sql= "INSERT INTO `#__virtuemart_wishlist`(`userid`,`virtuemart_product_id`,`virtuemart_category_id`,`virtuemart_product_qty`)values(".$user->id.",".$_REQUEST['pid'].",".$_REQUEST['catid'].",".$_REQUEST['qty'].")";
	$db->setQuery($sql);
	$db->query();
	$lid=$db->insertid();
		if($lid>0)
		{?>
		<div id="msg_output">success</div>
		<span>Item is Added in Wishlist </span>	
	<?php	}
	}
}
else
{?>
	<div id="msg_output">fail</div>
	<span>For Creating Wishlist you need to Login. </span>
    <?php
}
?>
