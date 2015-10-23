<style>
.add-to-cart-alt.cmp_btn {
    margin-top: 10px;
   }
.for-mobile .button_a.btn-compare {
    float: none;
}
.for-desktop .button_a.btn-compare {
    float: left;
}
</style>
<?php


// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
JHTML::_ ('behavior.modal');

if (isset($product->step_order_level))
	$step=$product->step_order_level;
else
	$step=1;
if($step==0)
	$step=1;


/** Product setting ***/

$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
";
/******/
$document = JFactory::getDocument ();
$document->addScriptDeclaration ($js);
?>
<script type="text/javascript">
function RemoveFromWishlist(wid)
{
	
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			
			if(xmlhttp.responseText)
			{
				var aa=xmlhttp.responseText;
				
				var ab = aa.split('<div id="msg_output">');
				var abc = ab[1].split('</div>');
				var abcd = abc[0];	
				//alert("Response:"+abcd);
				if(abcd == 'success'){
					var elem = document.getElementById('child_'+wid);
    				elem.parentNode.removeChild(elem);
				}else if(abcd == 'fail'){
					
				}
			}
		}
	}
	
	xmlhttp.open("GET","<?php echo JURI::base(); ?>components/com_virtuemart/views/wishlist/tmpl/removefromwishlist.php?wid="+wid,true);
	xmlhttp.send();	
}
function hidewindow(id)
{
	document.getElementById(id).style.display="none";	
}
</script>

<div class="my-account">
	<div class="my-wishlist">
    <?php //echo "<span class='incart' id='incart'>(".count($this->products).")</span>"; ?>
     
 
<?php if($this->valid!=0){ ?>
	   <fieldset>
          
       <table id="wishlist-table" class="data-table">
        <thead>
          <tr class="for-mobile first">
            <th colspan="4">My Wishlist</th>
          </tr>
          <tr class="for-desktop last">
                            <th>Product Image</th>
                            <th>Product Details</th>
                            <th>Details</th>
                            <th></th>
           </tr>
        </thead>

<?php // Show child categories
if (!empty($this->products)) { 
	?>


     
        
<!--<div class="horizontal-separator"></div>-->	
<?php
	// Category and Columns Counter
	$iBrowseCol = 1;
	$iBrowseProduct = 1;

	$app = JFactory::getApplication();
	$template = $app->getTemplate(true);
	$params = $template->params;
    $no_of_row = $params->get('screen_layout');
   
	// Calculating Products Per Row
	 ?>
	<script type="text/javascript">
	var tcart = jQuery.noConflict();
	tcart(document).ready(function(){
		var data = tcart( "#incart" ).hasClass( "incart" );
		var i=1;
		if(data == true)
		{
			i++;
		}
	});
	
	var i=0;
	</script>
    <?php
	 // for box layout
	 if($no_of_row == 1)
	 {
		$BrowseProducts_per_row =3;
		$Browsecellwidth = ' width' . floor (100 / $BrowseProducts_per_row);
	 }
	 else
	 {
		// for full layout 
		$BrowseProducts_per_row =4;
		$Browsecellwidth = ' width' . floor (100 / $BrowseProducts_per_row);
		 
	 }

	// Separator
	$verticalseparator = " vertical-separator";

	$BrowseTotalProducts = count($this->products);
	//echo "Value of List".$list;
	 
	 $windex=0;
	
	?>
    
	<tbody>
    <?php
	// Start the Output
	foreach ($this->products as $product) {
		  
			
            
			// Show the horizontal seperator
			if ($iBrowseCol == 1 && $iBrowseProduct > $BrowseProducts_per_row) {
				?>
			<!--<div class="horizontal-separator"></div>-->
				<?php
			}
	
	     		// this is an indicator wether a row needs to be opened or not
			if ($iBrowseCol == 1) {
				?>
		
		<?php
			}
	
			// Show the vertical seperator
			if ($iBrowseProduct == $BrowseProducts_per_row or $iBrowseProduct % $BrowseProducts_per_row == 0) {
				$show_vertical_separator = ' ';
			} else {
				$show_vertical_separator = $verticalseparator;
			}
	   
	   		// Show Products
			//echo "List:".$list." Grid:".$grid; 
			
       ?>		
         <?php $idindex=$this->wids[$windex]; ?>
			<tr class="for-desktop odd" id="child_<?php echo $idindex; ?>">
				<td class="wish_img">
               
				    <a class="product-image" title="<?php echo $product->link ?>" rel="vm-additional-images" href="<?php echo $product->link; ?>">
						<?php
							echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
						?>
					 </a>
					
				</td>

                <!-- Product description -->
                
				<td class="wishtit">

					<h5 class="product-name"><?php echo JHTML::link ($product->link, $product->product_name); ?></h5>
						
					<?php // Product Short Description
					if (!empty($product->product_s_desc)) {
						?>
						<div class="description std">
                          <div class="inner">
							<?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 100, '...') ?>
                           </div> 
						</div>
                        
						<?php } ?>
                      
                  </td>      
                     <td class="wishbtn">
					<div class="product-price cart-cell wish_prize" id="productPrice<?php echo $product->virtuemart_product_id ?>">
                      <div class="price-box">
						<?php
						if ($this->show_prices == '1') {
							if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
								echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
							}
							echo $this->currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
							
						} ?>
						</div>
					</div>
                    
				    <div class="add-to-cart-alt cmp_btn">
                    
                      
						<?php // Product Details Button
						echo JHTML::link ($product->link, JText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $product->product_name, 'class' => 'button_a btn-compare'));
						?>
						
				</div>
                
                    </td>  
                    
                    <td class="last">
                      <a class="btn-remove btn-remove2" title="Remove from Wishlist" onclick="RemoveFromWishlist(<?php echo $idindex++; ?>)"></a>
                    </td>
					
				
			
			<!-- end of spacer -->
	
          
			<?php
	
			// Do we need to close the current row now?
			if ($iBrowseCol == $BrowseProducts_per_row || $iBrowseProduct == $BrowseTotalProducts) {
				?>
				
	   </tr> <!-- end of desktop row -->
       <!-- For mobile -->
       <tr class="for-mobile last even" id="child_<?php echo $idindex; ?>">
          <td class="last" colspan="4">
           <div>
               <a class="product-image" title="<?php echo $product->link ?>" rel="vm-additional-images" href="<?php echo $product->link; ?>">
						<?php
							echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
						?>
					 </a>
           </div>
           
            <div>
              <h5 class="product-name"><?php echo JHTML::link ($product->link, $product->product_name); ?></h5>
						
					<?php // Product Short Description
					if (!empty($product->product_s_desc)) {
						?>
						<div class="description std">
                          <div class="inner">
							<?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 400, '...') ?>
                           </div> 
						</div>
                        
						<?php } ?>
                      
            </div>
             
             <div>
                	<div class="product-price cart-cell wish_prize" id="productPrice<?php echo $product->virtuemart_product_id ?>">
                      <div class="price-box">
						<?php
						if ($this->show_prices == '1') {
							if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
								echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
							}
							
							if (round($product->prices['basePriceWithTax'],$this->currency->_priceConfig['salesPrice'][1]) != $product->prices['salesPrice']) 
							{
								echo '<span class="price-crossed" >' . $this->currency->createPriceDiv ('basePriceWithTax', 'COM_VIRTUEMART_PRODUCT_BASEPRICE_WITHTAX', $product->prices) . "</span>";
							}
							
							echo $this->currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
							
						} ?>
						</div>
					</div>
                    
				    <div class="add-to-cart-alt cmp_btn">
                    
                      
						<?php // Product Details Button
						echo JHTML::link ($product->link, JText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $product->product_name, 'class' => 'button_a btn-compare'));
						?>
						
				</div>
             </div>
             
             <div>
                  <a class="btn-remove btn-remove2" title="Remove from Wishlist" onclick="RemoveFromWishlist(<?php echo $idindex++; ?>)"></a>
             </div>
          </td>
       </tr>
        
       </tbody>
        </table>
        
            

				<?php
				$iBrowseCol = 1;
			} else {
				$iBrowseCol++;
			}
	
			$iBrowseProduct++;
		
		
		
		
	} // end of foreach ( $this->products as $product )
	// Do we need a final closing row tag?
	if ($iBrowseCol != 1) {
		?>
	<div class="clear"></div>

		<?php
	}
	?>
     
</fieldset>
<div class="vm-pagination"><?php echo $this->vmPagination->getPagesLinks (); ?><span style="float:right"><?php echo $this->vmPagination->getPagesCounter (); ?></span></div>

	<?php
} 
?>
<?php } else {
	echo '<fieldset>
	      <div class="wish_empty">
		   <div class="notice"><div class="message-box-wrap">Your Wishlist is Empty. Please Add product in wishlist.</div></span>
		  </div> 
		 </fieldset>';	
} ?>

</div><!-- end wishlist view -->
  <div class="buttons-set">
        <p class="back-link"><a href="index.php"><small>« </small>Back</a></p>
    </div>
</div><!-- end myaccount -->
