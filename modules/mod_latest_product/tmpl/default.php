<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
if(!defined('JPATH_BASE')) define('JPATH_BASE', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'modules/mod_latest_product/css/latest_prd.css'); 	
$document->addScript(JURI::base().'modules/mod_latest_product/js/bxslider.js'); 

?>

<div class="block block-latest">
   
         
   		 <div class="block-content">
           <ul class="products-grid bxslider" id="block_latest">
    <?php
    	foreach($recent_product as $rprd)
	    {  ?>
	     <li class="item">
            <div class="bx1">
              
             <div class="product-image-area">
             <a class="product-image" href="index.php?option=com_virtuemart&amp;view=productdetails&amp;virtuemart_product_id=<?php echo $rprd->virtuemart_product_id; ?>&amp;virtuemart_category_id=<?php echo $rprd->virtuemart_category_id; ?>">
                <?php echo $rprd->images[0]->displayMediaFull('class="rp"', false); ?>
                </a>
              </div>
           
             
             <div class="other_info">
              
             <div class="product-name">
                <a href="index.php?option=com_virtuemart&amp;view=productdetails&amp;virtuemart_product_id=<?php echo $rprd->virtuemart_product_id; ?>&amp;virtuemart_category_id=<?php echo $rprd->virtuemart_category_id; ?>">
                <?php echo $rprd->product_name; ?>
                </a>
                
                <div class="price-box">
                <?php
				    // echo $show_prices;
							if ($show_prices == '1') {
								if ($rprd->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$rprd->images[0]->file_is_downloadable) {
									echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
								}
								
								echo $currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $rprd->prices);
								
								echo $currency->createPriceDiv ('taxAmount', 'inc. tax:', $rprd->prices);
								
							} ?>
              </div>
                
             </div> 
               
               
             
              
              <div class="additionnal">
                <?php 
				$data=substr($rprd->product_s_desc,0,150);
				echo $data;
				?>
                <br />
                <br />
               
                	
                
                  <!-- <a href="#">Add to cart &gt;</a>-->
                   <div class="addtoccart">
                 
                      <div class="addtocart-area">
    
                    <form method="post" class="product" action="index.php">
                       
    
                        <div class="addtocart-bar">
    
                            <?php
                            // Display the quantity box
                            ?>
                            <!-- <label for="quantity<?php echo $product->virtuemart_product_id;?>" class="quantity_box"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
               
                <input type="text" class="quantity-input fea_qua" name="quantity[]" value="1"/>
                  <span class="quantity-controls js-recalculate fea_qua_span">
					<input type="button" class="quantity-controls quantity-plus" value="&#160;" />
					<input type="button" class="quantity-controls quantity-minus" value="&#160;" />
				 </span>
    
    
                            <?php
                            // Add the button
                            $button_lbl = JText::_ ('COM_VIRTUEMART_CART_ADD_TO');
                            $button_cls = ''; //$button_cls = 'addtocart_button';
    
    
                            ?>
                            <?php // Display the add to cart button ?>
                            <span class="addtocart-button">
                                <?php //echo shopFunctionsF::getAddToCartButton($product->orderable); ?>
                </span>
                 <a class="addtocart">
                 
                        <input type="submit" name="addtocart"  class="addtocart-button category_cart_btn" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" /></a>
    
                            <div class="clear"></div>
                        </div>
    
                        <input type="hidden" class="pname" value="<?php echo $rprd->product_name ?>"/>
                        <input type="hidden" name="option" value="com_virtuemart"/>
                        <input type="hidden" name="view" value="cart"/>
                        <noscript><input type="hidden" name="task" value="add"/></noscript>
                        <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $rprd->virtuemart_product_id ?>"/>
                        <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $rprd->virtuemart_category_id ?>"/>
                    </form>
                    
                    
                    <div class="clear"></div>
                </div>
                
                  </div>
                   
                   
                   
                 
                
              </div> 
             </div> <!-- End other info -->
              
              <div class="hover"></div>
              
            </div><!-- End bx 1-->
            
        </li>
  <?php }
	   ?>
          
         </ul> <!-- End ul --->
   
      </div>  <!-- End Block Content --->
    
 </div>
 
	  
     <script type="text/javascript">
	  var noconf= jQuery.noConflict();

    noconf(document).ready(function(){
        var _width = noconf(window).width();
        var _slidewidth = 200;
        var _slidemargin = 20;
        var _maxslides = 4;
        if(_width >= 1024 && _width <=1099){
            _slidewidth = 181;
        }
        if(_width >= 768 && _width < 1024){
             _maxslides = 3;
        }
        if(_width < 768 && _width >= 700){
            _maxslides = 3;
        }
        if(_width < 700 && _width >= 520){
            _maxslides = 2;
        }
        if(_width < 520){
            _maxslides = 1;
        }
        _width = noconf('.container').width();
        _slidewidth = (_width-_slidemargin*(_maxslides-1))/_maxslides;
        var related_slider = noconf('#block_latest').bxSlider({
            minSlides: 1,
            maxSlides: _maxslides,
            pager: false,
            slideWidth: _slidewidth,
            slideMargin: _slidemargin,
            responsive: true
        });
        var st;
        noconf(window).resize(function(e){
            e.preventDefault();
            var _width = noconf(document).width();
            if(st) clearTimeout(st);
            st = setTimeout(function(){
                var _width = noconf(window).width();
                var _slidewidth = 200;
                var _slidemargin = 20;
                var _maxslides = 4;
                 if(_width >= 1024 && _width <=1099){
                    _slidewidth = 181;
                }
                if(_width >= 768 && _width < 1024){
                    _maxslides = 3;
                }
                if(_width < 768 && _width >= 700){
                    _maxslides = 3;
                }
                if(_width < 700 && _width >= 520){
                    _maxslides = 2;
                }
                if(_width < 520){
                    _maxslides = 1;
                }
                _width = noconf('.container').width();
                _slidewidth = (_width-_slidemargin*(_maxslides-1))/_maxslides;
                related_slider.reloadSlider({
                    minSlides: 1,
                    maxSlides: _maxslides,
                    pager: false,
                    slideWidth: _slidewidth,
                    slideMargin: _slidemargin,
                    responsive: true
                });
            }, 500);
        });
        
    })
</script> 