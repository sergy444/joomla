<style>
   h1.pagetitle
   {
      display:none;
	}
	applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td
{
	vertical-align:text-top!important;
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
function RemoveFromCompare(wid)
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
		//alert(xmlhttp.readyState+" "+xmlhttp.status);
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			//alert(xmlhttp.responseText);
			if(xmlhttp.responseText)
			{
				var aa=xmlhttp.responseText;
				
				var ab = aa.split('<div id="msg_output">');
				var abc = ab[1].split('</div>');
				var abcd = abc[0];	
				
				if(abcd == 'success'){
					/*var elem = document.getElementById('child_'+wid);
    				elem.parentNode.removeChild(elem);*/
					
					<?php   
						$app =& JFactory::getApplication(); 
						$sef=$app->getCfg('sef'); 
					 ?>
					 
					 <?php if($sef == '1'){ ?>
					  window.location="<?PHP echo JURI::base(); ?>index.php/component/virtuemart?view=compare";
					 <?php } ?>   
					  
					 <?php if($sef == '0'){ ?>
					  window.location="<?PHP echo JURI::base(); ?>index.php/component/virtuemart&view=compare";
					 <?php } ?>   
					
				}else if(abcd == 'fail'){
					
				}
			}
		}
	}
	
	xmlhttp.open("GET","<?PHP echo JURI::base(); ?>components/com_virtuemart/views/compare/tmpl/removefromcompare.php?wid="+wid,true);
	xmlhttp.send();	
}
function hidewindow_comp(id)
{
	document.getElementById(id).style.display="none";	
}
</script>

<div class="compare_pge">
 
<?php if($this->valid!=0){ ?>
	 
       <!-- For desktop -->   
       <table id="product_comparison" class="data-table compare-table for-desktop">
       <colgroup>
       <col width="23%">
       <?php
	   $countcol=0;
	   foreach ($this->products as $product) { 
       $countcol++;
       }
	   $colgwidth=77/$countcol;
       
         foreach ($this->products as $product) { ?>
        	<col width="<?php echo $colgwidth; ?>%">
        	 <?php  } // end of foreach ( $this->products as $product )?>
       </colgroup>

<?php // Show child categories
if (!empty($this->products)) { 
	?>


     
        
<!--<div class="horizontal-separator"></div>-->	
<?php
	// Category and Columns Counter
	//$iBrowseCol = 1;
	//$iBrowseProduct = 1;

	$app = JFactory::getApplication();
	$template = $app->getTemplate(true);
	$params = $template->params;
   //$no_of_row = $params->get('screen_layout');
   
	// Calculating Products Per Row
	 ?>
	
    <?php
	
	//echo "Value of List".$list;
	 
	 $windex=0;
	
	?>
    
	<tbody>
     <tr class="product-img-row first odd">
      <th>Product</th>
     
		<?php
        // Start the Output
        foreach ($this->products as $product) { //echo "<pre>";print_r($product);exit;?>
        	
                    <td class="wish_img" id="child_<?php echo $this->wids[$windex]; ?>">
                       <a class="btn-remove btn-remove2" title="Remove from Compare" onclick="RemoveFromCompare('<?php echo $product->virtuemart_product_id; ?>')"/></a>
                       
                        <a class="product-image" title="<?php echo $product->link ?>" rel="vm-additional-images" href="<?php echo $product->link; ?>">
                            <?php
                                echo $product->images[0]->displayMediaFull('class="browseProductImage"', false);
                            ?>
                         </a>
                         <h5 class="product-name">
                           <?php echo JHTML::link ($product->link, $product->product_name); ?>
                         </h5>
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
              
     </tr>
     <!-- Price -->
     <tr class="product-price-row even">
         <th>Price</th>
         <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
                    <td>
                        <div class="price-box">
						<?php
						if ($this->show_prices == '1') {
							if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
								echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
							}
							
							echo $this->currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
							
						} ?>
						</div>
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
     </tr>
     
     <!-- Availability -->
     <tr class="product-availability-row odd">
         <th>Availability</th>
         <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
         <td>
          <?php
	    	$prd_stcock= $product->product_in_stock;
		
				//echo $prd_stcock;
				if ($prd_stcock != 0)
				{?>
					
					 <p class="availability in-stock"><span>In Stock</span></p>
				<?php
				}
				else
				{?>
					
					 <p class="availability out-of-stock"><span>Out of Stock</span></p>
				<?php
				}
	          ?> 
          </td>
                    
    <?php  } // end of foreach ( $this->products as $product )?>
     </tr>
     
      
      
    </tbody>
    
    <tbody>
      <!-- Description -->
      <tr class="odd">
         <th><span class="nobr">Short Description</span></th>
           <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
                    <td>
                        <div class="std">
							<?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 400, '...') ?>
						</div>
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
      </tr>
      <!-- Sku -->
      <tr class="even">
         <th><span class="nobr">SKU</span></th>
           <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
                    <td>
                       <div class="std">
                       	<?php echo $product->product_sku;?>
                       </div> 
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
      </tr>
    </tbody>
    
    <tbody>
      <tr class="add-to-row last odd">
        <th> </th>
           
            <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
                    <td class="cmp_btn">
                     
                    
                      
						<?php // Product Details Button
						echo JHTML::link ($product->link, JText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $product->product_name, 'class' => 'button_a btn-compare'));
						?>
			
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
           
      </tr>
    </tbody>
  </table>
 
 

	<?php
} 
?>    
<!-- End Desktop -->
       
<!-- For Mobile --> 
 
<table id="product_comparison_mobile" class="data-table compare-table for-mobile">
  <colgroup>
   <?php
       $count_col=count($this->products);
        
        if($count_col==1)
        {?>
            <col width="100%">
        
   <?php }
         else
         { ?>
           
             <col width="50%">
             <col width="50%">
             
    <?php }
      ?>
   </colgroup>
    <?php // Show child categories
if (!empty($this->products)) { 
	?>
    
   <?php
	$app = JFactory::getApplication();
	$template = $app->getTemplate(true);
	$params = $template->params;
   
    $windex=0;
	
	?>
       
     

     
      <?php if($count_col > 2)
	  {// prodcut is morethan 2?>
           
                <tbody>
                   <tr class="first odd">
                       <th colspan="2">Product</th>
                   </tr>
                
                    <?php
                    // Start the Output
					 $i=0;
					 $j=0;
                    foreach ($this->products as $product) { ?>
					  <?php if($i%2==0){?> <tr class="product-img-row <?php echo ($j%2==0)? "even":"odd"; ?>"><?php }?>
                    
                                <td class="wish_img" id="child_<?php echo $this->wids[$windex]; ?>">
                                    <a class="btn-remove btn-remove2" title="Remove from Compare" onclick="RemoveFromCompare('<?php echo $product->virtuemart_product_id; ?>')"/></a>
                                   
                                    <a class="product-image" title="<?php echo $product->link ?>" rel="vm-additional-images" href="<?php echo $product->link; ?>">
                                        <?php
                                            echo $product->images[0]->displayMediaFull('class="browseProductImage"', false);
                                        ?>
                                     </a>
                                     <h5 class="product-name">
                                       <?php echo JHTML::link ($product->link, $product->product_name); ?>
                                     </h5>
                                </td>
                                    <?php  if($i%2==1){?>      </tr><?php $j++;  }?>
                         <?php  $i++; } ?>
                          
              
                    
                    
                    
                    <tr class="even">
                       <th colspan="2">Price</th>
                    </tr> 
                    
                    
                     <?php
                    // Start the Output
					$i=0;
					 $j=0;
                    foreach ($this->products as $product) { ?>
                      <?php if($i%2==0){?> <tr class="product-price-row <?php echo ($j%2==0)? "even":"odd"; ?>"><?php }?>
                    
                                <td>
                                    <div class="price-box">
                                    <?php
                                    if ($this->show_prices == '1') {
                                        if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
                                            echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
                                        }
                                        
                                       
                                        
                                        echo $this->currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
                                        
                                    } ?>
                                    </div>
                                </td>
                               <?php  if($i%2==1){?>  </tr><?php $j++;  }?>
                   <?php $i++; } ?> 
                      
                 
                     <tr class="odd">
                        <th colspan="2">Availability</th>
                     </tr>
                     
                      <?php
                    // Start the Output
					$i=0;
					 $j=0;
                    foreach ($this->products as $product) { ?>
                     <?php if($i%2==0){?> <tr class="product-availability-row <?php echo ($j%2==0)? "even":"odd"; ?>"><?php }?>
                      <td>
                      <?php
                        $prd_stcock= $product->product_in_stock;
                    
                            //echo $prd_stcock;
                            if ($prd_stcock != 0)
                            {?>
                                
                                 <p class="availability in-stock"><span>In Stock</span></p>
                            <?php
                            }
                            else
                            {?>
                                
                                 <p class="availability out-of-stock"><span>Out of Stock</span></p>
                            <?php
                            }
                          ?> 
                      </td>
                	 <?php  if($i%2==1){?>  </tr><?php $j++;  }?>
                   <?php $i++; } ?> 
                     
                     
                       
             </tbody>
             
                <tbody>
                            <tr class="even">
                               <th colspan="2">Short Description</th>
                            </tr>
                             <?php
                            // Start the Output
							$i=0;
					       $j=0;
                            foreach ($this->products as $product) { ?>
                             <?php if($i%2==0){?><tr class="<?php echo ($j%2==0)? "even":"odd"; ?>"><?php }?>
                                  <td>
                                            <div class="std">
                                                <?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 400, '...') ?>
                                            </div>
                                        </td>
                           <?php  if($i%2==1){?>  </tr><?php $j++;  }?>
                        <?php $i++; } ?> 
                            
                             
                             
                            <tr class="odd">
                                 <th colspan="2">SKU</th>
                            </tr> 
                            
                             <?php
                            // Start the Output
							$i=0;
					       $j=0;
                            foreach ($this->products as $product) { ?>
                            <?php if($i%2==0){?><tr class="<?php echo ($j%2==0)? "even":"odd"; ?>"><?php }?>
                                <td>
                                    <div class="std">
                                        <?php echo $product->product_sku;?>
                                      </div> 
                                 </td>
                          <?php  if($i%2==1){?>  </tr><?php $j++;  }?>
                        <?php $i++; } ?> 
                            
                             
                             
                        </tbody>
                        
              	<tbody>
                   <tr class="even">
                      <th colspan="2">&nbsp;</th>
                   </tr>
                   
                   
                    <?php
                    // Start the Output
					$i=0;
					$j=0;
                    foreach ($this->products as $product) { ?>
                    <?php if($i%2==0){?><tr class="add-to-row last <?php echo ($j%2==0)? "even":"odd"; ?>"><?php }?>
                       <td>
                                  <form method="post" class="product" action="index.php" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
                                        <?php // Display the quantity box ?>
                                        <!-- <label for="quantity<?php echo $this->product->virtuemart_product_id;?>" class="quantity_box">
                                            <?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
                                        <input  type="hidden" class="input-text qty" name="quantity[]" value="1" />
                        
                                        <?php // Display the quantity box END ?>
                                        <?php // Add the button
                                        $button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
                                        $button_cls = ''; //$button_cls = 'addtocart_button';
                                        if (VmConfig::get('check_stock') == '1' && !$this->product->product_in_stock) {
                                            $button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
                                            $button_cls = 'notify-button';
                                        } ?>
                            
                                        <?php // Display the add to cart button ?>
                                <input type="submit" name="addtocart"  class="addtocart-button" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" />
                                
                                            <?php // Display the add to cart button END ?>
                                            <input type="hidden" class="pname" value="<?php echo $product->product_name ?>">
                                            <input type="hidden" name="option" value="com_virtuemart" />
                                            <input type="hidden" name="view" value="cart" />
                                            <noscript><input type="hidden" name="task" value="add" /></noscript>
                                            <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>" />
                                            <?php /** @todo Handle the manufacturer view */ ?>
                                            <input type="hidden" name="virtuemart_manufacturer_id" value="<?php echo $product->virtuemart_manufacturer_id ?>" />
                                            <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />
                            </form>
                                    
                        
                                </td>
                            <?php  if($i%2==1){?>  </tr><?php $j++;  }?>
                        <?php $i++; } ?> 
                    
                    
               </tbody>
 <?php }
       else
	   {// prodcut is 2 or 1?>
         
               <tbody>
       <tr class="first odd">
           <th colspan="2">Product</th>
       </tr>
       <tr class="product-img-row first even">
		<?php
        // Start the Output
        foreach ($this->products as $product) { //echo "<pre>";print_r($product);exit;?>
        	
                    <td class="wish_img" id="child_<?php echo $this->wids[$windex]; ?>">
                        <a class="btn-remove btn-remove2" title="Remove from Compare" onclick="RemoveFromCompare('<?php echo $product->virtuemart_product_id; ?>')"/></a>
                       
                        <a class="product-image" title="<?php echo $product->link ?>" rel="vm-additional-images" href="<?php echo $product->link; ?>">
                            <?php
                                echo $product->images[0]->displayMediaFull('class="browseProductImage"', false);
                            ?>
                         </a>
                         <h2 class="product-name">
                           <?php echo JHTML::link ($product->link, $product->product_name); ?>
                         </h2>
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
              
     </tr>
        
        <tr class="odd">
           <th colspan="2">Price</th>
        </tr> 
        
        <tr class="product-price-row even">
         <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
                    <td>
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
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
     </tr> 
     
         <tr class="odd">
            <th colspan="2">Availability</th>
         </tr>
         
         <tr class="product-availability-row even">
        
         <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
         <td>
          <?php
	    	$prd_stcock= $product->product_in_stock;
		
				//echo $prd_stcock;
				if ($prd_stcock != 0)
				{?>
					
					 <p class="availability in-stock"><span>In Stock</span></p>
				<?php
				}
				else
				{?>
					
					 <p class="availability out-of-stock"><span>Out of Stock</span></p>
				<?php
				}
	          ?> 
          </td>
                    
    <?php  } // end of foreach ( $this->products as $product )?>
     </tr>
     
         <tr class="odd">
                <th colspan="2">Rating</th>
         </tr>
         
         <tr class="product-review-row even">
         
         <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
                    <td> 
                   
                        <div class="ratings">
				   <?php
				      //echo "ShowRating".$this->showRating;
                    if ($this->showRating) {
                        $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);
                        
						//echo "Rating".$this->rating;
                        if (empty($this->rating)) {
							
                        ?>
                        <span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                            <?php
                        } else {
                            $ratingwidth = $this->rating->rating * 16; //I don't use round as percetntage with works perfect, as for me
                            ?>
                        <span class="vote">
                           <?php /*?><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . round($this->rating->rating) . '/' . $maxrating; ?><br/><?php */?>
                            <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($this->rating->rating) . '/' . $maxrating) ?>" class="ratingbox" style="display:inline-block;">
                            <span class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>">
                            </span>
                            </span>
                        </span>
                        <?php
                        }
                    }
                    ?>
                 </div>
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
     </tr> 
    </tbody>
    
               <tbody>
                    <tr class="odd">
                       <th colspan="2">Short Description</th>
                    </tr>
                    
                    <tr class="even">
                       <?php
                    // Start the Output
                    foreach ($this->products as $product) { ?>
                    
                                <td>
                                    <div class="std">
                                        <?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 400, '...') ?>
                                    </div>
                                </td>
                                
                         <?php  } // end of foreach ( $this->products as $product )?>
                  </tr>
                     
                    <tr class="odd">
                         <th colspan="2">SKU</th>
                    </tr> 
                    
                    <tr class="even">
                       <?php
                    // Start the Output
                    foreach ($this->products as $product) { ?>
                    
                                <td>
                                   <div class="std">
                                    <?php echo $product->product_sku;?>
                                   </div> 
                                </td>
                                
                         <?php  } // end of foreach ( $this->products as $product )?>
                  </tr>
                </tbody> 
    
               <tbody>
       <tr class="odd">
          <th colspan="2">&nbsp;</th>
       </tr>
       
       <tr class="add-to-row last even">
            <?php
        // Start the Output
        foreach ($this->products as $product) { ?>
        
                    <td>
                     
                    
                      <form method="post" class="product" action="index.php" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
							<?php // Display the quantity box ?>
							<!-- <label for="quantity<?php echo $this->product->virtuemart_product_id;?>" class="quantity_box">
								<?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
							<input  type="hidden" class="input-text qty" name="quantity[]" value="1" />
			
							<?php // Display the quantity box END ?>
							<?php // Add the button
                            $button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
                            $button_cls = ''; //$button_cls = 'addtocart_button';
                            if (VmConfig::get('check_stock') == '1' && !$this->product->product_in_stock) {
                                $button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
                                $button_cls = 'notify-button';
                            } ?>
                
                            <?php // Display the add to cart button ?>
					<input type="submit" name="addtocart"  class="addtocart-button" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" />
                    
								<?php // Display the add to cart button END ?>
                                <input type="hidden" class="pname" value="<?php echo $product->product_name ?>">
                                <input type="hidden" name="option" value="com_virtuemart" />
                                <input type="hidden" name="view" value="cart" />
                                <noscript><input type="hidden" name="task" value="add" /></noscript>
                                <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>" />
                                <?php /** @todo Handle the manufacturer view */ ?>
                                <input type="hidden" name="virtuemart_manufacturer_id" value="<?php echo $product->virtuemart_manufacturer_id ?>" />
                                <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />
				</form>
						
			
                    </td>
                    
             <?php  } // end of foreach ( $this->products as $product )?>
           
      </tr>
     </tbody> 
         
 <?php } ?>
       
 </table> 



	<?php
} 
?>  
   
<!-- End Mobile -->     

				
		
		
		
		
	
      


<?php } else {
	echo '<fieldset>
	      <div class="wish_empty">
		   <div class="notice"><div class="message-box-wrap">Your Compare List is <strong>Empty</strong>. Please Add product in Compare.</div></div>
		  </div> 
		 </fieldset>';	
} ?>


  
</div><!-- end col-main -->
