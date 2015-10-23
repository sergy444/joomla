<?php
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
define( 'DS', DIRECTORY_SEPARATOR );
require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');
$mainframe = JFactory::getApplication('site');

//$session = JFactory::getSession();
//$session->set('mymessage', 'ma');

	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	
   	$session = JFactory::getSession();
	$cmp = $session->get('compare','');
	$flg=0;
	if(!empty($cmp)){
		$tmp = explode(',',$cmp);
		if(!in_array($_REQUEST['pid'],$tmp)){
			$cmp=$cmp.",".$_REQUEST['pid'];
			$session->set('compare', $cmp);
			$flg=1;
		}else{ $flg=2;}	
	}else{
		$session->set('compare', $_REQUEST['pid']);
		$flg=1;
		}
	
		
		
	if($flg==1){ ?>
		<div id="msg_output">success</div>
		<span>Item Added in Compare List </span>	
	<?php }else if($flg==2){?>
		<div id="msg_output">already</div>
		<span>Item Already exist in Compare List </span>	
	<?php }else{ ?>
		<div id="msg_output">fail</div>
		<span>Item not Added in Compare List </span>	
		<?php } ?>
