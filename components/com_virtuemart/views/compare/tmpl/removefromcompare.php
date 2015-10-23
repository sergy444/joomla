<?php
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
define( 'DS', DIRECTORY_SEPARATOR );
require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');
$mainframe = JFactory::getApplication('site');

	//echo $_GET['wid'];
	//$user=JFactory::getUser();
	
	$session = JFactory::getSession();
	$cmp = $session->get('compare');
	
if(isset($_GET['wid']) )
{
	
	$temp =explode(",",$cmp);
	$newCmp=array();
	if(in_array($_GET['wid'],$temp)){
		$idx = array_search($_GET['wid']);
		
		for($i=0;$i<count($temp);$i++){
			if($temp[$i]!=$_GET['wid']){
				$newCmp[]=$temp[$i];
			}
		}
		$temp2=implode(",",$newCmp); 
		$session->set('compare',$temp2);
	}
	
	if(count($newCmp)<=0){
		$session->set('compare','');
	}
	
		
?>
	<div id="msg_output">success</div>
	<span>Product remove from Comapre.</span><?php 
}

?>
