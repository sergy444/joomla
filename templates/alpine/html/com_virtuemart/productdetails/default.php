<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6530 2012-10-12 09:40:36Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/* Let's see if we found the product */
if (empty($this->product)) {
	echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

if(JRequest::getInt('print',false)){
?>
<body onLoad="javascript:print();">
<?php }

// addon for joomla modal Box
JHTML::_('behavior.modal');

$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

$boxFuncReco = '';
$boxFuncAsk = '';
if(VmConfig::get('usefancy',0)){
	vmJsApi::js( 'fancybox/jquery.fancybox-1.3.4.pack');
	vmJsApi::css('jquery.fancybox-1.3.4');
	if(VmConfig::get('show_emailfriend',0)){
		$boxReco = "jQuery.fancybox({
				href: '" . $MailLink . "',
				type: 'iframe',
				height: '550'
			});";
	}
	if(VmConfig::get('ask_question', 0)){
		$boxAsk = "jQuery.fancybox({
				href: '" . $this->askquestion_url . "',
				type: 'iframe',
				height: '550'
			});";
	}

} else {
	vmJsApi::js( 'facebox' );
	vmJsApi::css( 'facebox' );
	if(VmConfig::get('show_emailfriend',0)){
		$boxReco = "jQuery.facebox({
				iframe: '" . $MailLink . "',
				rev: 'iframe|550|550'
			});";
	}
	if(VmConfig::get('ask_question', 0)){
		$boxAsk = "jQuery.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|550|550'
			});";
	}
}
if(VmConfig::get('show_emailfriend',0) ){
	$boxFuncReco = "jQuery('a.recommened-to-friend').click( function(){
					".$boxReco."
			return false ;
		});";
}
if(VmConfig::get('ask_question', 0)){
	$boxFuncAsk = "jQuery('a.ask-a-question').click( function(){
					".$boxAsk."
			return false ;
		});";
}

if(!empty($boxFuncAsk) or !empty($boxFuncReco)){
	$document = JFactory::getDocument();
	$document->addScriptDeclaration("
//<![CDATA[
	jQuery(document).ready(function($) {
		".$boxFuncReco."
		".$boxFuncAsk."
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
//]]>
");
}


?>
<!-- Wishlist-->
<div id="rslt_success" class="success" style="display:none" onClick="hidewindow('rslt_success')">
  <div class="message-box-wrap"> This product <strong>sucessfully</strong> added in wishlist. </div>
</div>
<div id="rslt_already" class="info" style="display:none" onClick="hidewindow('rslt_already')">
 <div class="message-box-wrap">This product is <strong>already</strong> in your wishlist. </div>
</div> 
<div id="rslt_fail" class="error" style="display:none" onClick="hidewindow('rslt_fail')">
  <div class="message-box-wrap"> You have not <strong>logged</strong> in,please login.</div>
</div>
<!--End Wishlist-->

<!--Compare-->
<div id="rslt_success_comp" class="success" style="display:none" onClick="hidewindow_comp('rslt_success_comp')">
 <div>This product <strong>sucessfully</strong> added for Compare.</div>
</div>
<div id="rslt_already_comp"  class="info" style="display:none" onClick="hidewindow_comp('rslt_already_comp')">
  <div class="message-box-wrap">This product is <strong>already</strong> in your Compare List.</div>
</div>
<!-- End Compare-->

<div class="productdetails-view productdetails prd_detail floatleft width100">

    <?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
	?>
        <div class="product-neighbours floatleft width100">
	    <?php
	    if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
		echo JHTML::_('link', $prev_link, $this->product->neighbours ['previous'][0]
			['product_name'], array('rel'=>'prev', 'class' => 'previous-page'));
	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
		echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('rel'=>'next','class' => 'next-page'));
	    }
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // Product Navigation END
    ?>

	
    
    
 

    <?php // afterDisplayTitle Event
    echo $this->product->event->afterDisplayTitle ?>

    <?php
    // Product Edit Link
    echo $this->edit_link;
    // Product Edit Link END
    ?>

    <?php
    // PDF - Print - Email Icon
    if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_icon')) {
	?>
        <div class="icons">
	    <?php
	    //$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
	    $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;

		echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_icon', false);
	    echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
	    echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend', false,true,false,'class="recommened-to-friend"');
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // PDF - Print - Email Icon END
    ?>

   

    <?php
    if (!empty($this->product->customfieldsSorted['ontop'])) {
	$this->position = 'ontop';
	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

    <div class="detail_section floatleft width100">
            <div class="col-md-6 product-img-box">
				<?php
                echo $this->loadTemplate('images');
                ?>
              <div class="product-share">
                    <span class="share-label">Share: </span>
                    <?php
                     $document = &JFactory::getDocument();
                     $renderer       = $document->loadRenderer('modules');
                     $position       = 'mj-share';
                     $options        = array('style' => 'raw');
                    echo $renderer->render($position, $options, null); 
                    ?>
        </div>
            </div>
        
            <div class="col-md-6 last other_detail">
                <div class="spacer-buy-area">
                    <div class="detail_title">
                      <?php // Product Title   ?>
                        <h1 class="product_name"><?php echo $this->product->product_name ?></h1>
                        <?php    // Product Title END   ?>
                        
                        
                        <div class="detail_rating">
                          <?php   if ($this->showRating) {
                                $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);
                    
                                if (empty($this->rating)) {
                                ?>
                                <span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                                    <?php
                                } else {
                                    $ratingwidth = $this->rating->rating * 16; //I don't use round as percetntage with works perfect, as for me
                                    ?>
                                <span class="vote">
                        
                                    <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($this->rating->rating) . '/' . $maxrating) ?>" class="ratingbox" style="display:inline-block;">
                                    <span class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>">
                                    </span>
                                    </span>
                                </span>
                                <?php
                                }
                            } ?>
                        </div>
                     </div>   
                        
						<div class="product_desc_detail">
                        <?php
						 $prd_stcock= $this->product->product_in_stock;
		
								//echo $prd_stcock;
								if ($prd_stcock != 0)
								{?>
									
									 <p class="availability in-stock"><span style="color:#4e4d49">Availability:</span><span>  In Stock</span></p>
								<?php
								}
								else
								{?>
									
									 <p class="availability out-of-stock"><span style="color:#4e4d49">Availability:</span><span>  Out of Stock</span></p>
								<?php
								}
							  ?>
							  
							<p class="product-sku"><span style="color:#4e4d49">Product Code: </span><span><?php echo $this->product->product_sku;?></span></p>	
						</div>
						
               
        
                <?php
                
                if (is_array($this->productDisplayShipments)) {
                    foreach ($this->productDisplayShipments as $productDisplayShipment) {
                    echo $productDisplayShipment . '<br />';
                    }
                }
                if (is_array($this->productDisplayPayments)) {
                    foreach ($this->productDisplayPayments as $productDisplayPayment) {
                    echo $productDisplayPayment . '<br />';
                    }
                }
                // Product Price
                    // the test is done in show_prices
                //if ($this->show_prices and (empty($this->product->images[0]) or $this->product->images[0]->file_is_downloadable == 0)) {
                    echo $this->loadTemplate('showprices');
                //}
                ?>
        
                <?php
                // Add To Cart Button
        // 			if (!empty($this->product->prices) and !empty($this->product->images[0]) and $this->product->images[0]->file_is_downloadable==0 ) {
        //		if (!VmConfig::get('use_as_catalog', 0) and !empty($this->product->prices['salesPrice'])) {
                    echo $this->loadTemplate('addtocart');
        //		}  // Add To Cart Button END
                ?>
        
                <?php
                // Availability
                $stockhandle = VmConfig::get('stockhandle', 'none');
                $product_available_date = substr($this->product->product_available_date,0,10);
                $current_date = date("Y-m-d");
                if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
                    if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
                    ?>	<div class="availability">
                            <?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') .': '. JHTML::_('date', $this->product->product_available_date, JText::_('DATE_FORMAT_LC4')); ?>
                        </div>
                    <?php
                    } else if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
                    ?>	<div class="availability">
                        <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : JText::_(VmConfig::get('rised_availability')); ?>
                    </div>
                    <?php
                    } else if (!empty($this->product->product_availability)) {
                    ?>
                    <div class="availability">
                    <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : JText::_($this->product->product_availability); ?>
                    </div>
                    <?php
                    }
                }
                else if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
                ?>	<div class="availability">
                        <?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') .': '. JHTML::_('date', $this->product->product_available_date, JText::_('DATE_FORMAT_LC4')); ?>
                    </div>
                <?php
                }
                ?>
        
        <?php
        // Ask a question about this product
        if (VmConfig::get('ask_question', 0) == 1) {
            ?>
                    <div class="ask-a-question">
                        <a class="ask-a-question" href="<?php echo $this->askquestion_url ?>" rel="nofollow" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
                        <!--<a class="ask-a-question modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php echo $this->askquestion_url ?>"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>-->
                    </div>
                <?php }
                ?>
        
                <?php
                // Manufacturer of the Product
                if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
                    echo $this->loadTemplate('manufacturer');
                }
                ?>
                  
                  <?php // Accordian Section ?>
                  <div class="bottom_section">
          
                          <!-- section 1 -->
                          <span class="acc-trigger active"><a href="#"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></a></span>
                            
                            <div class="acc-container">
                                <div class="content">
                                    <?php
                                    // Product Description
                                    if (!empty($this->product->product_desc)) {
                                        ?>
                                        <div class="product-description">
                                            <?php echo $this->product->product_desc; ?>
                                        </div>
                                    <?php
                                    } // Product Description END ?>
                                 </div>
                             </div>       
                           
                            <!-- section 2 -->
                            <span class="acc-trigger"> <?php if (!empty($this->product->customfieldsSorted['normal'])){ ?> <li><a href="#">Custome Fild</a></li> <?php } ?></span>
                             
                             <div class="acc-container">
                                <div class="content">
                                    <?php
                                    if (!empty($this->product->customfieldsSorted['normal'])) {
                                    $this->position = 'normal';
                                    echo $this->loadTemplate('customfields');
                                    } // Product custom_fields END ?>
                                 </div>
                             </div>     
                            
                           <!-- section 3 -->
                           <span class="acc-trigger"><a href="#"><?php echo JText::_('COM_VIRTUEMART_REVIEWS') ?></a></span> 
                             <div class="acc-container">
                                <div class="content">
                                    <?php
                                    echo $this->loadTemplate('reviews');
                                   ?>
                                </div>
                            </div>     
                            
       
                     </div> <?php // End Bottom Section ?>
                  
                </div>
            </div>
            
             
	<div class="clear"></div>
    </div>
    
    <div class="clearfix mar_top4"></div>
    
	<?php // event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent; ?>
    
   
    <?php
    // Product Files
    // foreach ($this->product->images as $fkey => $file) {
    // Todo add downloadable files again
    // if( $file->filesize > 0.5) $filesize_display = ' ('. number_format($file->filesize, 2,',','.')." MB)";
    // else $filesize_display = ' ('. number_format($file->filesize*1024, 2,',','.')." KB)";

    /* Show pdf in a new Window, other file types will be offered as download */
    // $target = stristr($file->file_mimetype, "pdf") ? "_blank" : "_self";
    // $link = JRoute::_('index.php?view=productdetails&task=getfile&virtuemart_media_id='.$file->virtuemart_media_id.'&virtuemart_product_id='.$this->product->virtuemart_product_id);
    // echo JHTMl::_('link', $link, $file->file_title.$filesize_display, array('target' => $target));
    // }
	?>
	<div class="clearfix mar_top5"></div>
    <?php
    if (!empty($this->product->customfieldsRelatedProducts)) {
	echo $this->loadTemplate('relatedproducts');
    } // Product customfieldsRelatedProducts END

    if (!empty($this->product->customfieldsRelatedCategories)) {
	echo $this->loadTemplate('relatedcategories');
    } // Product customfieldsRelatedCategories END
   
    ?>

<?php // onContentAfterDisplay event
echo $this->product->event->afterDisplayContent; ?>


</div>
