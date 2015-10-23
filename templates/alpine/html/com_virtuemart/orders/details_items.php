<?php
/** 
 * details_items file view orders in com_virtuemart for Template
 * @package    Getshopped
 * @subpackage Template
 * @author Das Infomedia.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 // no direct access
defined('_JEXEC') or die('Restricted access');

if($this->format == 'pdf'){
	$widthTable = '100';
	$widtTitle = '27';
} else {
	$widthTable = '100';
	$widtTitle = '49';
}
?>
<div class="order-items order-details">
	<h3 class="table-caption">Items Ordered</h3>

<table id="my-orders-table" class="data-table" summary="Items Ordered" width="<?php echo $widthTable ?>%" cellspacing="0" cellpadding="0" border="0">
 <thead>
   <tr class="for-mobile first">
      <th class="last" colspan="9">Product</th>
   </tr>
  <tr align="left" class="for-desktop last">
   
    <th align="left" colspan="2" width="<?php echo $widtTitle ?>%" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_NAME_TITLE') ?></th>
     <th align="left" width="5%"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SKU') ?></th>
   <?php /*?> <th align="center" width="10%"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_STATUS') ?></th><?php */?>
    <th align="right" width="10%" ><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRICE') ?></th>
    <th align="left" width="5%"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_QTY') ?></th>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <th align="right" width="10%" ><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_TAX') ?></th>
    <?php } ?>
    <th align="right" width="11%"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SUBTOTAL_DISCOUNT_AMOUNT') ?></th>
    <th align="right" width="15%"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL') ?></th>
  </tr>
 </thead> 
  <?php
	foreach($this->orderdetails['items'] as $item) {
		$qtt = $item->product_quantity ;
		$_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_category_id=' . $item->virtuemart_category_id . '&virtuemart_product_id=' . $item->virtuemart_product_id);
?>
   <tbody class="odd">
  <tr valign="top" class="border for-desktop first">
   
    <td align="left" colspan="2" ><a class="order_tab_name product-name" href="<?php echo $_link; ?>"><?php echo $item->order_item_name; ?></a>
      <?php
					if (!empty($item->product_attribute)) {
							if(!class_exists('VirtueMartModelCustomfields'))require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'customfields.php');
							$product_attribute = VirtueMartModelCustomfields::CustomsFieldOrderDisplay($item,'FE');
						echo $product_attribute;
					}
				?></td>
      <td align="left"><?php echo $item->order_item_sku; ?></td>           
   <?php /*?> <td align="center"><?php echo $this->orderstatuses[$item->order_status]; ?></td><?php */?>
    <td align="right" class="priceCol a-right" ><?php echo '<span >'.$this->currency->priceDisplay($item->product_item_price,$this->currency) .'</span><br />'; ?></td>
    <td class="a-right"><?php echo $qtt; ?></td>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <td class="a-right"><?php echo $this->currency->priceDisplay($item->product_tax ,$this->currency, $qtt)?></td>
    <?php } ?>
    <td class="a-right"><?php echo  $this->currency->priceDisplay( $item->product_subtotal_discount ,$this->currency);  //No quantity is already stored with it ?></td>
    <td class="a-right last"><?php
				$item->product_basePriceWithTax = (float) $item->product_basePriceWithTax;
				$class = '';
				if(!empty($item->product_basePriceWithTax) && $item->product_basePriceWithTax != $item->product_final_price ) {
					echo '<span class="line-through price" >'.$this->currency->priceDisplay($item->product_basePriceWithTax,$this->currency,$qtt) .'</span><br />' ;
				}

				echo '<span class="price" >'.$this->currency->priceDisplay(  $item->product_subtotal_with_tax ,$this->currency).'</span>'; //No quantity or you must use product_final_price ?></td>
  </tr>
  
  <tr class="border for-mobile last"> 
    <td class="last" colspan="9">
     <div>
       <a class="order_tab_name product-name" href="<?php echo $_link; ?>"><?php echo $item->order_item_name; ?></a>
      <?php
					if (!empty($item->product_attribute)) {
							if(!class_exists('VirtueMartModelCustomfields'))require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'customfields.php');
							$product_attribute = VirtueMartModelCustomfields::CustomsFieldOrderDisplay($item,'FE');
						echo $product_attribute;
					}
				?>
     </div>
     <div>
     <span class="label"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SKU') ?>: </span>
     <?php echo $item->order_item_sku; ?>
     </div>
     
     <div>
         <span class="label"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRICE') ?>: </span>
        <?php echo '<span >'.$this->currency->priceDisplay($item->product_item_price,$this->currency) .'</span><br />'; ?>
     </div>
     
     <div>
     <span class="label"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_QTY') ?>: </span>
       <?php echo $qtt; ?>
     </div>
     <?php if ( VmConfig::get('show_tax')) { ?>
    <div>
     <span class="label"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_TAX') ?>: </span>
		<?php echo $this->currency->priceDisplay($item->product_tax ,$this->currency, $qtt)?>
    </div>
    <?php } ?>
    
    <div>
    <span class="label"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SUBTOTAL_DISCOUNT_AMOUNT') ?>: </span>
		<?php echo  $this->currency->priceDisplay( $item->product_subtotal_discount ,$this->currency);  //No quantity is already stored with it ?>
    </div>
    
    <div>
     <span class="label"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL') ?>: </span>
	<?php
				$item->product_basePriceWithTax = (float) $item->product_basePriceWithTax;
				$class = '';
				if(!empty($item->product_basePriceWithTax) && $item->product_basePriceWithTax != $item->product_final_price ) {
					echo '<span class="line-through price" >'.$this->currency->priceDisplay($item->product_basePriceWithTax,$this->currency,$qtt) .'</span><br />' ;
				}

				echo '<span class="price" >'.$this->currency->priceDisplay(  $item->product_subtotal_with_tax ,$this->currency).'</span>'; //No quantity or you must use product_final_price ?>
                </div>
    </td>
  </tr>
  </tbody>
  <?php
	}
?>
  <tfoot>
  <tr class="sectiontableentry1 subtotal first">
    <td colspan="5" align="right" class="a-right"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></td>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <td align="right" class="a-right"><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_tax,$this->currency)."</span>" ?></td>
    <?php } ?>
    <td align="right" class="a-right"><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_discountAmount,$this->currency)."</span>" ?></td>
    <td align="right" class="a-right"><?php echo '<span class="price" >'.$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_salesPrice,$this->currency).'</span>'; ?></td>
  </tr>
  <?php
if ($this->orderdetails['details']['BT']->coupon_discount <> 0.00) {
    $coupon_code=$this->orderdetails['details']['BT']->coupon_code?' ('.$this->orderdetails['details']['BT']->coupon_code.')':'';
	?>
  <tr>
    <td align="right" class="pricePad" colspan="5"><?php echo JText::_('COM_VIRTUEMART_COUPON_DISCOUNT').$coupon_code ?></td>
    <td align="right" class="a-right">&nbsp;</td>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <td align="right" class="a-right">&nbsp;</td>
    <?php } ?>
    <td align="right" class="a-right"><?php echo '- '.$this->currency->priceDisplay($this->orderdetails['details']['BT']->coupon_discount,$this->currency); ?></td>
    <td align="right" class="a-right">&nbsp;</td>
  </tr>
  <?php  } ?>
  <?php
		foreach($this->orderdetails['calc_rules'] as $rule){
			if ($rule->calc_kind== 'DBTaxRulesBill') { ?>
  <tr >
    <td colspan="5"  align="right" class="pricePad"><?php echo $rule->calc_rule_name ?></td>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <td align="right" class="a-right"></td>
    <?php } ?>
    <td align="right" class="a-right"><?php echo  $this->currency->priceDisplay($rule->calc_amount,$this->currency);  ?></td>
    <td align="right" class="a-right"><?php echo  $this->currency->priceDisplay($rule->calc_amount,$this->currency);  ?></td>
  </tr>
  <?php
			} elseif ($rule->calc_kind == 'taxRulesBill') { ?>
  <tr >
    <td colspan="5"  align="right" class="pricePad"><?php echo $rule->calc_rule_name ?></td>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <td align="right" class="a-right"><?php echo $this->currency->priceDisplay($rule->calc_amount,$this->currency); ?></td>
    <?php } ?>
    <td align="right" class="a-right"><?php    ?></td>
    <td align="right" class="a-right"><?php echo $this->currency->priceDisplay($rule->calc_amount,$this->currency);   ?></td>
  </tr>
  <?php
			 } elseif ($rule->calc_kind == 'DATaxRulesBill') { ?>
  <tr >
    <td colspan="5"   align="right" class="pricePad"><?php echo $rule->calc_rule_name ?></td>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <td align="right" class="a-right"></td>
    <?php } ?>
    <td align="right" class="a-right"><?php  echo   $this->currency->priceDisplay($rule->calc_amount,$this->currency);  ?></td>
    <td align="right" class="a-right"><?php echo $this->currency->priceDisplay($rule->calc_amount,$this->currency);  ?></td>
  </tr>
  <?php
			 }

		}
		?>
  <tr>
    <td align="right" class="pricePad a-right" colspan="5"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPPING') ?></td>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <td align="right" class="a-right"><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_shipment_tax, $this->currency)."</span>" ?></td>
    <?php } ?>
    <td align="right" class="a-right">&nbsp;</td>
    <td align="right" class="a-right"><?php echo '<span class="price" >'.$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_shipment+ $this->orderdetails['details']['BT']->order_shipment_tax, $this->currency).'</span>'; ?></td>
  </tr>
  <tr>
    <td align="right" class="pricePad a-right" colspan="5"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PAYMENT') ?></td>
    <?php if ( VmConfig::get('show_tax')) { ?>
    <td align="right" class="a-right"><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_payment_tax, $this->currency)."</span>" ?></td>
    <?php } ?>
    <td align="right" class="a-right">&nbsp;</td>
    <td align="right" class="a-right"><?php echo '<span class="price" >'. $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_payment+ $this->orderdetails['details']['BT']->order_payment_tax, $this->currency).'</span>'; ?></td>
  </tr>
  <tr>
    <td align="right" class="pricePad a-right" colspan="5"><strong><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL') ?></strong></td>
    <?php if ( VmConfig::get('show_tax')) {  ?>
    <td align="right" class="a-right"><span  class='priceColor2'><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_billTaxAmount, $this->currency); ?></span></td>
    <?php } ?>
    <td align="right" class="a-right"><span  class='priceColor2'><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_billDiscountAmount, $this->currency); ?></span></td>
    <td align="right" class="a-right"><strong><?php echo'<span class="price" >'. $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_total, $this->currency).'</span>'; ?></strong></td>
  </tr>
  </tfoot>
</table>
</div>