<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6556 2012-10-17 18:15:30Z kkmediaproduction $
 */

//vmdebug('$this->category',$this->category);
//vmdebug ('$this->category ' . $this->category->category_name);
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
JHTML::_ ('behavior.modal');
/* javascript for list Slide
  Only here for the order list
  can be changed by the template maker
*/
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
";

$document = JFactory::getDocument ();
$document->addScriptDeclaration ($js);

$list=0;
$grid=1;
$get = JRequest::get('get');
if(isset($get['display']) && $get['display']=='grid'){
	$grid=1;
	$list=0;
}else if(isset($get['display']) && $get['display']=='list')
{
	$grid=0;
	$list=1;	
}else { $grid=1; $list=0;}
?>

<script type="text/javascript">
function AddToWishlist(pid,catid)
{
	

	var qty = 1;
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
		//alert(xmlhttp.readyState+"  "+xmlhttp.status);
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			//alert(xmlhttp.responseText);
			
			if(xmlhttp.responseText)
			{ 
				
				var aa=xmlhttp.responseText;
                //alert(aa);
				var ab = aa.split('<div id="msg_output">');
				var abc = ab[1].split('</div>');
				var abcd = abc[0];	
				
				if(abcd == 'success'){
					document.getElementById('rslt_success').style.display="block";
					document.getElementById('rslt_already').style.display="none";
					document.getElementById('rslt_fail').style.display="none";
					
				}else if(abcd == 'already'){
					document.getElementById('rslt_success').style.display="none";
					document.getElementById('rslt_already').style.display="block";
					document.getElementById('rslt_fail').style.display="none";
					
				}else if(abcd == 'fail'){
					document.getElementById('rslt_success').style.display="none";
					document.getElementById('rslt_already').style.display="none";
					document.getElementById('rslt_fail').style.display="block";
				}
			}
		}
	}
	xmlhttp.open("GET","<?php echo JURI::base(); ?>components/com_virtuemart/views/productdetails/tmpl/addtowishlist.php?pid="+pid+"&catid="+catid+"&qty="+qty,true);
	xmlhttp.send();	
}
function hidewindow(id)
{
	document.getElementById(id).style.display="none";	
}
</script>

<script type="text/javascript">
function AddToCompare(pid,catid)
{
	var qty = 1;
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
		//alert(xmlhttp.readyState+"  "+xmlhttp.status);
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			 //alert(xmlhttp.status);
			
			if(xmlhttp.responseText)
			{ 
				
				var aa=xmlhttp.responseText;
				//alert(aa);
				var ab = aa.split('<div id="msg_output">');
				var abc = ab[1].split('</div>');
				var abcd = abc[0];	
				
				if(abcd == 'success'){
				
					document.getElementById('rslt_success_comp').style.display="block";
					document.getElementById('rslt_already_comp').style.display="none";
					
					
				}else if(abcd == 'already'){
					document.getElementById('rslt_success_comp').style.display="none";
					document.getElementById('rslt_already_comp').style.display="block";
					
					
				}
			}
		}
	}
	xmlhttp.open("GET","<?php echo JURI::base(); ?>components/com_virtuemart/views/productdetails/tmpl/addtocompare.php?pid="+pid+"&catid="+catid+"&qty="+qty,true);
	xmlhttp.send();	
}
function hidewindow_comp(id)
{
	document.getElementById(id).style.display="none";	
}
</script>

<!-- Wishlist-->
<div id="rslt_success" class="success" style="display:none" onclick="hidewindow('rslt_success')">
  <div class="message-box-wrap"> This product <strong>sucessfully</strong> added in wishlist. </div>
</div>
<div id="rslt_already" class="info" style="display:none" onclick="hidewindow('rslt_already')">
 <div class="message-box-wrap">This product is <strong>already</strong> in your wishlist. </div>
</div> 
<div id="rslt_fail" class="error" style="display:none" onclick="hidewindow('rslt_fail')">
  <div class="message-box-wrap"> You have not <strong>logged</strong> in,please login.</div>
</div>
<!--End Wishlist-->

<!--Compare-->
<div id="rslt_success_comp" class="success" style="display:none" onclick="hidewindow_comp('rslt_success_comp')">
	<div class="message-box-wrap"> This product <strong>sucessfully</strong> added for Compare.</div>
</div>
<div id="rslt_already_comp" class="info" style="display:none" onclick="hidewindow_comp('rslt_already_comp')">
 <div class="message-box-wrap">This product is <strong>already</strong> in your Compare List.</div> 
</div>

<!-- End Compare-->




<?php
if (empty($this->keyword) and !empty($this->category)) {
	?>
<div class="category_description">
	<h2 class="headstyle"><?php echo $this->category->category_name; ?></h2>
</div>
<?php
}
?>
<script type="text/javascript">
	
	function showListViewJS()
	{ 
		
	  window.location.href="index.php?option=com_virtuemart&view=category&virtuemart_category_id=<?php echo $_GET['virtuemart_category_id']; ?>&display=list";
	}
	function showGridViewJS()
	{
		window.location.href="index.php?option=com_virtuemart&view=category&virtuemart_category_id=<?php echo $_GET['virtuemart_category_id']; ?>&display=grid";
	}
	
</script>

<?php
/* Show child categories */


?>
<div class="browse-view">
<?php

if (!empty($this->keyword)) {
	?>
<h2 class="headstyle"><?php echo $this->keyword; ?></h2>
	<?php
} ?>
<?php if ($this->search !== NULL) {

	$category_id  = JRequest::getInt ('virtuemart_category_id', 0); ?>
<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=category&limitstart=0', FALSE); ?>" method="get">

	<!--BEGIN Search Box -->
	<div class="virtuemart_search">
		<?php echo $this->searchcustom ?>
		<br/>
		<?php echo $this->searchcustomvalues ?>
		<input name="keyword" class="inputbox srch_box" type="text" size="20" value="<?php echo $this->keyword ?>"/>
		<input type="submit" value="<?php echo JText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="button srch_btn" onclick="this.form.keyword.focus();"/>
	</div>
    
	<input type="hidden" name="search" value="true"/>
	<input type="hidden" name="view" value="category"/>
	<input type="hidden" name="option" value="com_virtuemart"/>
	<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>

</form>
<!-- End Search Box -->
	<?php } ?>

<?php // Show child categories
if (!empty($this->products)) {
	?>
<div class="orderby-displaynumber floatleft width100">
	<div class="width70 floatleft" style="margin-top:5px;">
		<?php echo $this->orderByList['orderby']; ?>
		<?php //echo $this->orderByList['manufacturer']; ?>
        
        <div class="view_as">
    <?php if(isset($_REQUEST['display'])){ ?>
    <?php if($_REQUEST['display']=='grid'){ ?>
    <a title="GridView"><i class="fa fa-th-large fa-2x active"></i></a> <a onclick="showListViewJS()" title="ListView"><i class="fa fa-th-list fa-2x unactive"></i></a>
    <?php }else{ ?>
    <a onclick="showGridViewJS()" title="GridView"><i class="fa fa-th-large fa-2x unactive"></i></a> <a title="ListView"><i class="fa fa-th-list fa-2x active"></i></a>
    <?php } ?>
    <?php }else{ ?>
    <a title="GridView"><i class="fa fa-th-large fa-2x active"></i></a> <a onclick="showListViewJS()" title="ListView"><i class="fa fa-th-list fa-2x unactive"></i></a>
    <?php } ?>
  </div>
      
	</div>
	
	
    <div class="cmp_btn floatright">
		<?php   
            $app =& JFactory::getApplication(); 
            $sef=$app->getCfg('sef'); 
         ?>
         
         <?php if($sef == '1'){ ?>
          <a href="index.php?option=com_virtuemart?view=compare" class="button_a btn-compare"><span>Compare</span></a>
           
         <?php } ?>   
          
         <?php if($sef == '0'){ ?>
          <a href="index.php?option=com_virtuemart&view=compare" class="button_a btn-compare"><span>Compare</span></a>
            
         <?php } ?>   
     </div>
        
     
	<div class="clear"></div>
</div> <!-- end of orderby-displaynumber -->

	
<!-- Show Prodcut -->
<div class="category_prodcut">
<?php /*?><h1><?php echo $this->category->category_name; ?></h1><?php */?>

	<?php
	// Category and Columns Counter
	$iBrowseCol = 1;
	$iBrowseProduct = 1;

	// Calculating Products Per Row
	$BrowseProducts_per_row = $this->perRow;
	//$Browsecellwidth = ' width' . floor (100 / $BrowseProducts_per_row);

	// Separator
	$last = " last";

	$BrowseTotalProducts = count($this->products);

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
	<div class="row">
	<?php
		}

		// Show the vertical seperator
		if ($iBrowseProduct == $BrowseProducts_per_row or $iBrowseProduct % $BrowseProducts_per_row == 0) {
			$show_last = $last;
		} else {
			
			$show_last = ' ';
		}

		// Show Products
		?>
        <?php if($list==0 && $grid==1){ ?>
       		 <div class="grid_view">
        
             <div class="product floatleft one_third<?php echo $show_last ?>">
                <div class="spacer">
                    <div class="width100 floatleft image_section">
                       
                       <div class="grid_img">
                        	<a title="<?php echo $product->product_name ?>" rel="vm-additional-images" href="<?php echo $product->link; ?>">
								<?php
                                    echo $product->images[0]->displayMediaFull('class="browseProductImage"', false);
                                ?>
                        	 </a>
                        </div>
                        
                        <div class="options">
                          <div class="cart">
                            <form method="post" class="product category_cart" action="index.php" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
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
                                    <a class="addtocart fa fa-shopping-cart">
                            <input type="submit" name="addtocart"  class="addtocart-button category_cart_btn" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" /></a>
                
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
                           
                          </div>
                          
                          <div class="wishlist">
                          	 <a class="addtowishlist fa fa-heart-o" title="Add to Wishlist" onclick="AddToWishlist('<?php echo $product->virtuemart_product_id; ?>','<?php echo $product->virtuemart_category_id; ?>')"><span>Add to Wishlist</span></a>
                          </div>
                          
                          <div class="compare">
                             <a class="addtocompare fa fa-files-o" title="Add to Comapre" onclick="AddToCompare('<?php echo $product->virtuemart_product_id; ?>','<?php echo $product->virtuemart_category_id; ?>')"><span>Add to Comapre</span></a>
                          </div>
                          
                          <div class="readmore">
                           
                            <a class="product-details_1 fa fa-paperclip" href="<?php echo $product->link;?>" title="<?php echo JText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS');?>">
                              <span><?php echo JText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS');?></span>
                              
                            </a>
                      
                          </div>
                        </div>
                       
                    </div>
                    
                    <div class="p_name floatleft">
                      <?php echo JHTML::link ($product->link, $product->product_name); ?>
                    </div>
                        
                   <div class="grid_rating floatleft">  
                        <!-- The "Average Customer Rating" Part -->
                        <?php // Output: Average Product Rating
                        if ($this->showRating) {
                            $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);
    
                            if (empty($product->rating)) {
                                ?>
                                <span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                            <?php
                            } else {
                                $ratingwidth = $product->rating * 12; //I don't use round as percetntage with works perfect, as for me
                                ?>
                                <span class="vote">
                                   
                                    <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($product->rating) . '/' . $maxrating) ?>" class="category-ratingbox" style="display:inline-block;">
                                        <span class="stars-blue" style="width:<?php echo $ratingwidth.'px'; ?>">
                                        </span>
                                    </span>
                                </span>
                            <?php
                            }
                        }
						
                        ?>
                        </div>
                    
                       <?php // Product Short Description
                        if (!empty($product->product_s_desc)) {
                            ?>
                            <div class="product_s_desc floatleft">
                                <?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 30, '...') ?>
                            </div>
                      <?php } ?>
                    
                      <div class="product-price cat_price marginbottom12 floatleft" id="productPrice<?php echo $product->virtuemart_product_id ?>">
                            <?php
                            if ($this->show_prices == '1') {
                                if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
                                    echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
                                }
                               
                                echo $this->currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
                               
                            } ?>
    
                      </div>
                    
                   
                    
                    <div class="clear"></div>
                </div>
                <!-- end of spacer -->
            </div> <!-- end of product -->
        
        </div> <!-- End Grid view -->
        
         <?php }else if($list==1 && $grid==0){ ?>
        
       		 <div class="list_view">
        
				 <div class="product floatleft width100">
		        	<div class="spacer">
                        <div class="width20 floatleft image_section">
                           <div class="list_img">
                            <a title="<?php echo $product->product_name ?>" rel="vm-additional-images" href="<?php echo $product->link; ?>">
                                <?php
                                    echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
                                ?>
                             </a>
                            </div>
                            
                       </div> 

						<div class="floatleft content_section">
                          <div class="product-price cat_price marginbottom12" id="productPrice<?php echo $product->virtuemart_product_id ?>">
						<?php
						if ($this->show_prices == '1') {
							if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
								echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
							}
							
							echo $this->currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
							
						} ?>
                          
                        
						<form method="post" class="product category_cart" action="index.php" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
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
                                    <a class="addtocart_list">
                            <input type="submit" name="addtocart"  class="addtocart-button category_cart_btn" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" /></a>
                
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
					
 
					</div> 
					       <h3><?php echo JHTML::link ($product->link, $product->product_name); ?></h3>
                   
                     <ul class="post_meta_links_small">
                        <?php
							$prd_stcock= $product->product_in_stock;
						
								//echo $prd_stcock;
								if ($prd_stcock != 0)
								{?>
									
									 
                                     <li class="post_by"><i class="fa fa-check"></i> <a href="#">In Stock</a></li>
								<?php
								}
								else
								{?>
									
									
                                     <li class="post_by"><i class="fa fa-ban"></i> <a href="#">Out of Stock</a></li>
								<?php
								}
							  ?> 
                        
                        <li class="post_categoty"><i class="fa fa-folder-open"></i> <a href="#"><?php echo $product->product_sku; ?></a></li>
                        <li class="post_comments"><i class="fa fa-comments"></i> 
                        <a href="#">
                         
                            <!-- The "Average Customer Rating" Part -->
                            <?php // Output: Average Product Rating
                            if ($this->showRating) {
                                $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);
        
                                if (empty($product->rating)) {
                                    ?>
                                    <?php echo JText::_('COM_VIRTUEMART_UNRATED') ?>
                                <?php
                                } else {
                                    $ratingwidth = $product->rating * 12; //I don't use round as percetntage with works perfect, as for me
                                    ?>
                                    
                                       
                                        <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($product->rating) . '/' . $maxrating) ?>" class="category-ratingbox" style="display:inline-block;">
                                            <span class="stars-blue" style="width:<?php echo $ratingwidth.'px'; ?>">
                                            </span>
                                        </span>
                                   
                                <?php
                                }
                            }
                            if ( VmConfig::get ('display_stock', 1)) { ?>
                                <!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
                                <div class="paddingtop8">
                                    <span class="vmicon vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
                                    <span class="stock-level"><?php echo JText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
                                </div>
                            <?php } ?>
                         </a></li>
                    </ul>
                   
					<?php // Product Short Description
					 //echo $prd_stcock= $product->product_in_stock;
					if (!empty($product->product_s_desc)) {
						?>
						<p class="product_s_desc">
							<?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 400, '...') ?>
						</p>
						<?php } ?>

					  <a class="addtowishlist" title="Add to Wishlist" onclick="AddToWishlist('<?php echo $product->virtuemart_product_id; ?>','<?php echo $product->virtuemart_category_id; ?>')"><i class="fa fa-heart-o"></i>&nbsp;Add to Wishlist</a>
					  
                        <a class="addtocompare" title="Add to Comapre" onclick="AddToCompare('<?php echo $product->virtuemart_product_id; ?>','<?php echo $product->virtuemart_category_id; ?>')"><i class="fa fa-files-o"></i>&nbsp;Add to Comapre</a>
				</div>
                
				<div class="clear"></div>
			</div>
			<!-- end of spacer -->
		</div> <!-- end of product -->
        
             </div> <!-- End list view -->
        
         <?php } ?>
        
		<?php

		// Do we need to close the current row now?
		if ($iBrowseCol == $BrowseProducts_per_row || $iBrowseProduct == $BrowseTotalProducts) {
			?>
			<div class="clear"></div>
   </div> <!-- end of row -->
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
</div> <!-- End Category Prodcuct -->

<div class="clearfix mar_top4"></div>	

<div class="vm-pagination col-md-6">
<div class="page_result"><?php echo $this->vmPagination->getPagesCounter (); ?></div>
<?php echo $this->vmPagination->getPagesLinks (); ?>
</div>
<div class="col-md-6 last floatright display-number">
	<?php echo $this->vmPagination->getResultsCounter ();?>
    <?php echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?>
</div>

	<?php
} elseif ($this->search !== NULL) {
	echo JText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div><!-- end browse-view -->