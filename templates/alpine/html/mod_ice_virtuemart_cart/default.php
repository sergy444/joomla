<?php
/**
 * IceVMCart Extension for Joomla 2.5 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2012 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/icevmcart.html
 * @Support 	http://www.icetheme.com/Forums/IceVmCart/
 *
 */
// No direct access
defined('_JEXEC') or die;

 ?>
<?php $dropdown = $params->get('dropdown',1); ?>
<span class="ice_store_dropdown" style="display:none"><?php echo $dropdown; ?></span>
<div id="vm_module_cart" class="iceVmCartModule">
	<div class="lof_vm_top">
        
         <?php if( count( $data->products) == 0): ?>
         <p class="vm_cart_empy"><?php echo $vm_cart_empy ?></p>
         
         <?php else:?>
           
        <?php /*?><div class="lof_top_1">
			<span class="vm_products"><?php echo  $data->totalProductTxt ?>&nbsp;</span>
            <span class="vm_sum"><?php if ($data->totalProduct) echo  $data->billTotal; ?></span>
		</div><?php */?>
        
       
		<div class="lof_top_2">
	    	<?php if ($data->totalProduct) echo  $data->cart_show; ?>
			<?php if($dropdown){ ?>
				<?php if( count( $data->products) == 0): ?>
					<p class="vm_cart_empy"><?php echo $vm_cart_empy ?></p>
				<?php else:?>
                   <span id="cartHeader">
					<a class="vm_readmore showmore" href = "javascript:void(0)">
                     <span class="vm_sum">
						<?php if ($data->totalProduct) echo  $data->totalProduct.$data->billTotal; ?>
                     </span>
                    </a>
                   </span> 
				<?php endif; ?>
			<?php } ?>
		</div>
        
       
        <?php endif; ?>
        
	</div>
	<?php
		if($dropdown){
	?>
	<div class="lof_vm_bottom" style="display:none;">
    <div class="lof_vm_bottom_btn">
            <p class="block-subtitle">Recently added item(s)</p>
			<a class="lofclose" href = "javascript:void(0)">X</a>
		</div>
		<?php 
		foreach ($data->products as $product){
		?><div style="clear:both;"></div> 
           <?php
           //print_r($product);
		   ?>
		<div class="lof_item">
          <div class="top-cart">
                <a class="top-btn-remove" title="<?php echo JText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id=' . $product["virtuemart_product_id"]) ?>" > Remove item</a>	 
                </div>
        <?php
         // print_r($product);
		  ?>
			<a href="<?php echo $product["link"];?>"><img src="<?php echo $product["image"]; ?>" alt="<?php print htmlspecialchars($product['product_name']);?>"/></a>       
			<div class="lof_info">
               
				<a href = "<?php echo $product["link"]; ?>" title = "<?php print htmlspecialchars($product['product_name']);?>">
					<?php print htmlspecialchars($product['product_name']);?>
				</a>
				<span class="lof_quantity"> X <?php echo  $product['quantity'] ?></span>
				<span class="lof_price"> - <?php echo  $product['prices'] ?></span>
                
			</div>
		</div>
		<?php }?>
		<div class="lof_vm_bottom_btn">
			<?php if ($data->totalProduct) echo  $data->cart_show; ?>
		</div>
	</div>
	<?php } ?>
	<script language="javascript">
		jQuery(document).ready(function(){
			<?php if($dropdown){ ?>
			jQuery('.lof_vm_top .showmore').click(function(){
				if(jQuery(this).hasClass('showmore')){
					jQuery('.lof_vm_bottom').slideDown("slow");
					<?php /*?>jQuery(this).text('<?php print JText::_('SHOW_LESS')?>');<?php */?>
					
				}else{
					jQuery('.lof_vm_bottom').slideUp();
					<?php /*?>jQuery(this).text('<?php print JText::_('SHOW_MORE')?>');<?php */?>
					
				}
			});
			jQuery('.lof_vm_bottom_btn .lofclose').click(function(){
				jQuery('.lof_vm_bottom').slideUp();
				<?php /*?>jQuery('.lof_vm_top .lof_top_2 .showless').text('<?php print JText::_('SHOW_MORE')?>');<?php */?>
				
			});
			<?php } ?>
			jQuery('#main').find('.vm table.cart').addClass("cart-full");
			
		});	
	</script>
</div>
