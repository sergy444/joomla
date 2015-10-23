<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule">
<?php
if ($show_product_list) {
	?>
	<div id="hiddencontainer" style=" display: none; ">
		<div class="container1">
			<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
			  <div class="prices" style="float: right;"></div>
			<?php } ?>
			<div class="product_row">
				<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>
			</div>

			<div class="product_attributes"></div>
		</div>
	</div>
	<div class="vm_cart_products">
		<div class="container1">
        
        <div class="total_products"><?php  ?>


	<?php if ($data->totalProduct == 0) 
	{
		echo '<div class="cart_emt"><div class="fnt_awsm"><i class="fa fa-shopping-cart fa-3x"></i></div><div> Total :<strong class="empty_price_cart">$0.00</strong> </div>';		
		echo '<div class="cart_txt">'. $data->totalProductTxt.'</div></div>';
	}
	
	
	
	else
	{
		
		echo  $data->totalProductTxt;
		
	}

 ?>
 </div>

		<?php
			foreach ($data->products as $product)
		{ ?>
			<div class="product_row">
            	
				<span class="product_name"><?php echo  $product['product_name'] ?><span class="p_q">&nbsp;x&nbsp;<?php echo  $product['quantity']?></span></span>
			</div>
            <?php
			if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
				 <span class="prices"><?php echo  $product['prices'] ?></span>
				<?php } ?>
			
			
		<?php 
		}
		?>
		</div>
	</div>
<?php } ?>
<?php if ($data->totalProduct and $show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
	<div class="total_product_custom" style="float: right;">
		<?php echo $data->billTotal; ?>
	</div>
   <div class="show_cart_custom" rel="nofollow">
	<?php	
		echo $data->cart_show
	?>
    </div>
<?php }?>


<div style="clear:both;"></div>
</div>
<noscript>
<?php echo JText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
</noscript>


