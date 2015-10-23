<?php
/** 
 * detail file view of order in com_virtuemart for Template
 * @package    Getshopped
 * @subpackage template
 * @author Das Infomedia.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 // no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/');
?>
<div class="order_info">
<?php
if($this->print){
	?>
<body onLoad="javascript:print();">
<div><img alt="" src="<?php  echo JURI::root() . $this-> vendor->images[0]->file_url ?>"></div>
<h3>
  <?php  echo $this->vendor->vendor_store_name; ?>
</h3>
<?php  echo $this->vendor->vendor_name .' - '.$this->vendor->vendor_phone ?>
<h3><?php echo JText::_('COM_VIRTUEMART_ACC_ORDER_INFO'); ?></h3>
<div class='spaceStyle1'>
  <?php
		echo $this->loadTemplate('order');
		?>
</div>
<div class='spaceStyle1'>
  <?php
		echo $this->loadTemplate('items');
		?>
</div>
<?php	echo $this->vendor->vendor_legal_info; ?>
</body>
<?php
} else {
	?>


<div class='spaceStyle1'>
  <?php
	echo $this->loadTemplate('order');
	?>
</div>
<div class='spaceStyle1'>
  <?php
	$tabarray = array();
	$tabarray['items'] = 'COM_VIRTUEMART_ORDER_ITEM';
	$tabarray['history'] = 'COM_VIRTUEMART_ORDER_HISTORY';
	shopFunctionsF::buildTabs ( $this, $tabarray); ?>
</div>
<?php if($this->order_list_link){ ?>
<div class='buttons-set'>
  <p class="back-link">
  <a class="list_order" href="<?php echo $this->order_list_link ?>">
   <small>« </small><?php echo JText::_('COM_VIRTUEMART_ORDERS_VIEW_DEFAULT_TITLE'); ?>
  </a>
 </p>
  <div class="clear"></div>
</div>
<?php }?>
<br clear="all"/>
<br/>
<?php
}
?>
</div>
