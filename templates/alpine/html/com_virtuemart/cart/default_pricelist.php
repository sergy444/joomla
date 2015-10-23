<style>
table, caption, tbody, tfoot, thead, tr, th, td
{
	vertical-align:top!important;
}
</style>

<?php defined ('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */

?>
<div class="review_box">
<div class="cart-view cart-view1">
<h3>Bill To &amp; Shipment Information</h3>
<div class="billto-shipto floatleft width100">
	<div class="col-md-5">

		<i class="fa fa-home fa-2x"></i>
			<span class="virtu_cart_fntawsm"><?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?></span>
		<?php // Output Bill To Address ?>
		<div class="output-billto">
			<?php

			foreach ($this->cart->BTaddress['fields'] as $item) {
				if (!empty($item['value'])) {
					if ($item['name'] === 'agreed') {
						$item['value'] = ($item['value'] === 0) ? JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO') : JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES');
					}
					?><!-- span class="titles"><?php echo $item['title'] ?></span -->
					<span class="values vm2<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
					<?php if ($item['name'] != 'title' and $item['name'] != 'first_name' and $item['name'] != 'middle_name' and $item['name'] != 'zip') { ?>
						<br class="clear"/>
						<?php
					}
				}
			} ?>
			<div class="clear"></div>
		</div>

		<a class="details" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=BT', $this->useXHTML, $this->useSSL) ?>" rel="nofollow">
			<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_LBL'); ?>
		</a>

		<input type="hidden" name="billto" value="<?php echo $this->cart->lists['billTo']; ?>"/>
	</div>

	<div class="col-md-7 last">

		<i class="fa fa-truck fa-2x"></i>
			<span class="virtu_cart_fntawsm"><?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?></span>
		<?php // Output Bill To Address ?>
		<div class="output-shipto">
			<?php
			if (empty($this->cart->STaddress['fields'])) {
				echo JText::sprintf ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_EXPLAIN', JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'));
			} else {
				if (!class_exists ('VmHtml')) {
					require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');
				}
				echo JText::_ ('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
				echo VmHtml::checkbox ('STsameAsBTjs', $this->cart->STsameAsBT) . '<br />';
				?>
				<div id="output-shipto-display">
					<?php
					foreach ($this->cart->STaddress['fields'] as $item) {
						if (!empty($item['value'])) {
							?>
							<!-- <span class="titles"><?php echo $item['title'] ?></span> -->
							<?php
							if ($item['name'] == 'first_name' || $item['name'] == 'middle_name' || $item['name'] == 'zip') {
								?>
								<span class="values<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
								<?php } else { ?>
								<span class="values"><?php echo $this->escape ($item['value']) ?></span>
								<br class="clear"/>
								<?php
							}
						}
					}
					?>
				</div>
				<?php
			}
			?>
			<div class="clear"></div>
		</div>
		<?php if (!isset($this->cart->lists['current_id'])) {
		$this->cart->lists['current_id'] = 0;
	} ?>
		<a class="details" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=ST&virtuemart_user_id[]=' . $this->cart->lists['current_id'], $this->useXHTML, $this->useSSL) ?>" rel="nofollow">

			<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'); ?>
		</a>

	</div>

	<div class="clear"></div>
</div>
</div>
</div>


<div class="review_box">

<div class="cart-view">
	<h3>Shopping Cart</h3>
<div class="billing-box1">
<fieldset>
<table class="data-table cart-table cart-summary">
     <thead>
		<tr class="first last">
            <th rowspan="1" class="no-border-right">&nbsp;</th>
			<th rowspan="1"><span class="nobr"><?php echo JText::_('COM_VIRTUEMART_CART_NAME') ?></span></th>
			<th rowspan="1"><span class="nobr"><?php echo JText::_('COM_VIRTUEMART_CART_SKU') ?></span></th>
			<th colspan="1"><span class="nobr"><?php echo JText::_('COM_VIRTUEMART_CART_PRICE') ?></span></th>
            <?php if (VmConfig::get ('show_tax')) { ?>
	<th colspan="1"><span class="nobr"><?php echo JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?></span></th>
	<?php } ?>
			<th rowspan="1"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY') ?></th>
			<th colspan="1"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?></th>
            <th rowspan="1" class="last">&nbsp;</th>  
			</tr>

      </thead>
 <tbody>
<?php
$i = 1;
// 		vmdebug('$this->cart->products',$this->cart->products);
foreach ($this->cart->products as $pkey => $prow) {
 ?>
				<tr valign="top" class="sectiontableentry<?php echo $i ?> cart-p-list">
				<td align="left" class="no-border-right pr-img-td" >
                 <div class="pos-area">
					<?php if ( $prow->virtuemart_media_id) {  ?>
						 <span class="cart-images">
            <?php
			if (!empty($prow->image)) {
				echo $prow->image->displayMediaThumb ('', FALSE);
			}
			?>
            </span>
					<?php } ?>
                   </div>
                </td>
                
               <td class="a-right product-name-td">
					<?php echo JHTML::link($prow->url, $prow->product_name).$prow->customfields; ?>

				</td>
				<td class="a-right product-sku"  ><?php  echo $prow->product_sku ?></td>
				<td class="a-right unit-price"  >
				<?php
// 					vmdebug('$this->cart->pricesUnformatted[$pkey]',$this->cart->pricesUnformatted[$pkey]['priceBeforeTax']);
					echo $this->currencyDisplay->createPriceDiv('basePrice','', $this->cart->pricesUnformatted[$pkey],false);
// 					echo $prow->salesPrice ;
					echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $this->cart->pricesUnformatted[$pkey], FALSE);

					?>
				</td>
                <?php if (VmConfig::get ('show_tax')) { ?>
	<td class="a-right"><?php echo $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) ?></td>
	<?php } ?>
	
				<td align="right a-right qty-td">
                
                
				<input type="hidden" name="option" value="com_virtuemart" />
                <div class="qty-holder">
				<input type="text" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="inputbox input-text qty" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" />
                 <div class="qty-changer">
                 </div>
            </div>
				<input type="hidden" name="view" value="cart" />
				<input type="hidden" name="task" value="update" />
				<input type="hidden" name="cart_virtuemart_product_id" value="<?php echo $prow->cart_item_id  ?>" />
				
	
				
				</td>

				<td class="col-total a-right" colspan="1" align="right">
				<?php
				if (VmConfig::get('checkout_show_origprice',1) && !empty($this->cart->pricesUnformatted[$pkey]['basePriceWithTax']) && $this->cart->pricesUnformatted[$pkey]['basePriceWithTax'] != $this->cart->pricesUnformatted[$pkey]['salesPrice'] ) {
					echo '<span class="line-through">'.$this->currencyDisplay->createPriceDiv('basePriceWithTax','', $this->cart->pricesUnformatted[$pkey],true,false,$prow->quantity) .'</span>' ;
				}
				echo $this->currencyDisplay->createPriceDiv('salesPrice','', $this->cart->pricesUnformatted[$pkey],false,false,$prow->quantity) ?></td>
                <td class="a-center rm-td for-desktop last">
                <input type="submit" class="vmicon vm2-add_quantity_cart" name="update" title="<?php echo  JText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>" align="middle" value=" "/>
                		  </form>
                <a class="btn-remove btn-remove2" title="<?php echo JText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id=' . $prow->cart_item_id) ?>" > Remove item</a>	
               </td>
			</tr>
		<?php
			$i = 1 ? 2 : 1;
		


} ?>
<!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
                  <?php if ( VmConfig::get('show_tax')) { $colspan=3; } else { $colspan=2; } ?>
                  




<?php
if (VmConfig::get ('coupons_enable')) {
	?>
<tr class="sectiontableentry2">

<td colspan="7" align="left">
	<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
	// echo JHTML::_('link', JRoute::_('index.php?view=cart&task=edit_coupon',$this->useXHTML,$this->useSSL), JText::_('COM_VIRTUEMART_CART_EDIT_COUPON'));
	echo $this->loadTemplate ('coupon');
}
	?>

	<?php if (!empty($this->cart->cartData['couponCode'])) { ?>
	<?php
	echo $this->cart->cartData['couponCode'];
	echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
	?>

				</td>

					 <?php if (VmConfig::get ('show_tax')) { ?>
		<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->pricesUnformatted['couponTax'], FALSE); ?> </td>
		<?php } ?>
	<td align="right"> </td>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->pricesUnformatted['salesPriceCoupon'], FALSE); ?> </td>
	<?php } else { ?>
	</td><td colspan="1" align="left">&nbsp;</td>
	<?php
}

	?>
    
</tr>
	<?php } ?>


<?php
foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) { ?>
			<tr class="sectiontableentry<?php $i ?>">
				<td colspan="5" class="a-right"><?php echo $rule['calc_name'] ?> </td>

                                   <?php if ( VmConfig::get('show_tax')) { ?>
				<td class="a-right"> </td>
                                <?php } ?>
				<td class="a-right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false); ?></td>
				<td class="a-right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false); ?> </td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		} ?>

<?php

foreach ($this->cart->cartData['taxRulesBill'] as $rule) { ?>
			<tr class="sectiontableentry<?php $i ?>">
				<td colspan="5" align="right"><?php echo $rule['calc_name'] ?> </td>
				<?php if ( VmConfig::get('show_tax')) { ?>
				<td class="a-right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false); ?> </td>
				 <?php } ?>
				<td class="a-right"><?php ?> </td>
				<td class="a-right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false); ?> </td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		}

foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) { ?>
			<tr class="sectiontableentry<?php $i ?>">
				<td colspan="5" align="right"><?php echo   $rule['calc_name'] ?> </td>

                                     <?php if ( VmConfig::get('show_tax')) { ?>
				<td class="a-right"> </td>

                                <?php } ?>
				<td class="a-right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false); ?>  </td>
				<td class="a-right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false); ?> </td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		}

if ($this->checkout_task) {
$taskRoute = '&task=' . $this->checkout_task;
}
else {
$taskRoute = '';
}
if (VmConfig::get('oncheckout_opc', 1)) {
?>

<form method="post" id="checkoutForm" name="checkoutForm" action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart' . $taskRoute, $this->useXHTML, $this->useSSL); ?>" > 


	<?php } ?>
    
<tr class="sectiontableentry1" valign="top" >
	<?php if (!$this->cart->automaticSelectedShipment) { ?>

	<?php /*	<td colspan="2" align="right"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPPING'); ?> </td> */ ?>
				<td colspan="7" align="left">
				<?php echo $this->cart->cartData['shipmentName']; ?>
	<br/>
	<?php
	if (!empty($this->layoutName) && $this->layoutName == 'default' && !$this->cart->automaticSelectedShipment) {
		if (VmConfig::get('oncheckout_opc', 1)) {
			$previouslayout = $this->setLayout('select');
			echo $this->loadTemplate('shipment');
			$this->setLayout($previouslayout);
		} else {
			echo JHTML::_('link', JRoute::_('index.php?view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
		}
	} else {
		echo JText::_ ('COM_VIRTUEMART_CART_SHIPPING');
	}?>
	</td>
<?php
} else {
	?>
	<td colspan="7" align="left">
		<?php echo $this->cart->cartData['shipmentName']; ?>
	</td>
	<?php } ?>

	<td class="a-right"><?php echo $this->currencyDisplay->createPriceDiv('salesPriceShipment','', $this->cart->pricesUnformatted['salesPriceShipment'],false); ?> </td>
    
</tr>
<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 ) { ?>
<tr class="sectiontableentry1" valign="top">
	<?php if (!$this->cart->automaticSelectedPayment) { ?>

	<td colspan="7" align="left">
		<?php echo $this->cart->cartData['paymentName']; ?>
		<br/>
		<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
			if (VmConfig::get('oncheckout_opc', 1)) {
				$previouslayout = $this->setLayout('select');
				echo $this->loadTemplate('payment');
				$this->setLayout($previouslayout);
			} else {
				echo JHTML::_('link', JRoute::_('index.php?view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
			}
		} else {
		echo JText::_ ('COM_VIRTUEMART_CART_PAYMENT');
	} ?> </td>

	</td>
	<?php } else { ?>
	<td colspan="7" align="left"><?php echo $this->cart->cartData['paymentName']; ?> </td>
	<?php } ?>
	<td class="a-right"><?php  echo $this->currencyDisplay->createPriceDiv('salesPricePayment','', $this->cart->pricesUnformatted['salesPricePayment'],false); ?> </td>
</tr>
<?php } ?>



</table>
</fieldset>
</div>
</div>




<div class="cart-collaterals">
  
  
  <div class="totals">
         <table>
       <tfoot>
        
       <tr>
    <td colspan="1" class="a-right" style="">
        <strong>Grand Total</strong>
    </td>
    <td class="a-right" style="">
   
        <strong><?php echo $this->currencyDisplay->createPriceDiv('billTotal','', $this->cart->pricesUnformatted['billTotal'],false); ?></strong>

    </td>
</tr>
        </tfoot>
                
    </table>
    
    <ul class="checkout-types">
           <li class="first">
                    <a class="continue" href="index.php?option=com_virtuemart&view=category" ><?php echo JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING'); ?></a>
           </li>
           
          </ul>
  </div>
</div>

</div>