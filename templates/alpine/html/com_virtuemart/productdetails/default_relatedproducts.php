<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_relatedproducts.php 6431 2012-09-12 12:31:31Z alatak $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
//vmJsApi::jPrice();
$document = JFactory::getDocument();
//$document->addStyleSheet(JURI::base().'modules/mod_latest_product/css/latest_prd.css'); 
//$document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
$document->addScript(JURI::base().'templates/alpine/js/bxslider.js'); 
?>


 <div class="block block-related">
    <div class="block-title"><h3><?php echo JText::_('COM_VIRTUEMART_RELATED_PRODUCTS'); ?></h3></div>
         
   		 <div class="block-content">
           <ul class="products-grid bxslider" id="block_related">
    <?php
    	foreach ($this->product->customfieldsRelatedProducts as $field) {
		
	    if(!empty($field->display)) 
		{?>
	     <li class="item">
            <div class="product-image-area product-field-type-<?php echo $field->field_type ?>">
                <?php echo $field->display; ?>
            </div>
            
        </li>
  <?php }
	  } ?>
          
         </ul> <!-- End ul --->
   
      </div>  <!-- End Block Content --->
    
 </div>
 
  <script type="text/javascript">
    jQuery(document).ready(function(){
        var _width = jQuery(window).width();
        var _slidewidth = 200;
        var _slidemargin = 20;
        var _maxslides = 4;
        if(_width > 1024 && _width <=1099){
            _slidewidth = 181;
        }
        if(_width >= 768 && _width <=1024){
            
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
        _width = jQuery('.content_left').width();
        _slidewidth = (_width-_slidemargin*(_maxslides-1))/_maxslides;
        var related_slider = jQuery('#block_related').bxSlider({
            minSlides: 1,
            maxSlides: _maxslides,
            pager: false,
            slideWidth: _slidewidth,
            slideMargin: _slidemargin,
            responsive: true
        });
        var st;
        jQuery(window).resize(function(e){
            e.preventDefault();
            var _width = jQuery(document).width();
            if(st) clearTimeout(st);
            st = setTimeout(function(){
                var _width = jQuery(window).width();
                var _slidewidth = 200;
                var _slidemargin = 20;
                var _maxslides = 4;
                 if(_width > 1024 && _width <=1099){
                    _slidewidth = 181;
                }
                if(_width >= 768 && _width <=1024){
                    
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
                _width = jQuery('.content_left').width();
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
  