<?php
/** 
 * list file view orders in com_virtuemart for Template
 * @package    Getshopped
 * @subpackage Template
 * @author Das Infomedia.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 // no direct access
defined('_JEXEC') or die('Restricted access');
?>

<div class="order_list vm-content">
  
  <?php
if (count($this->orderlist) == 0) {
	 echo shopFunctionsF::getLoginForm(false,true);
} else {
 ?>
  <div id="editcell">
    <table id="my-orders-table" class="adminlist data-table" width="80%">
      <thead>
        <tr class="for-desktop first">
          <th> <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_ORDER_NUMBER'); ?> </th>
          <th> <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_CDATE'); ?> </th>
          <th> <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_STATUS'); ?> </th>
          <th> <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_TOTAL'); ?> </th>
         </tr> 
         <tr class="for-mobile"><th colspan="4" class="last">My Orders</th></tr>
      </thead>
      <?php
		$k = 0;
		foreach ($this->orderlist as $row) {
			$editlink = JRoute::_('index.php?option=com_virtuemart&view=orders&layout=details&order_number=' . $row->order_number);
			?>
         <tr class="for-mobile odd">
           <td class="last" colspan="4">
            <p>
             <span><?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_ORDER_NUMBER'); ?>: </span>
             <span><a href="<?php echo $editlink; ?>"><?php echo $row->order_number; ?></a></span>
            </p>
            <p>
              <span><?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_CDATE'); ?>: </span>
              <span><?php echo vmJsApi::date($row->created_on,'LC4',true); ?></span>
            </p>
             <p>
              <span><?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_STATUS'); ?>: </span>
              <span><?php echo ShopFunctions::getOrderStatusName($row->order_status); ?></span>
            </p>
             <p>
              <span><?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_TOTAL'); ?>: </span>
              <span><span class="price"><?php echo $this->currency->priceDisplay($row->order_total, $row->currency); ?></span></span>
            </p>
           </td>
         </tr>   
      <tr class="<?php echo "row$k"; ?> for-desktop even">
        <td align="left"><a href="<?php echo $editlink; ?>"><?php echo $row->order_number; ?></a></td>
        <td align="left"><?php echo vmJsApi::date($row->created_on,'LC4',true); ?></td>
        <td align="left"><?php echo ShopFunctions::getOrderStatusName($row->order_status); ?></td>
        <td class="a-right"><span class="price"><?php echo $this->currency->priceDisplay($row->order_total, $row->currency); ?></span></td>
      </tr>
      <?php
			$k = 1 - $k;
		}
	?>
    </table>
  </div>
  <?php } ?>
</div>
