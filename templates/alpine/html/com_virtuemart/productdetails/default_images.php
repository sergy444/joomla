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
 * @version $Id: default_images.php 6188 2012-06-29 09:38:30Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
vmJsApi::js( 'fancybox/jquery.fancybox-1.3.4.pack');
vmJsApi::css('jquery.fancybox-1.3.4');
$document = JFactory::getDocument ();
$imageJS = '
jQuery(document).ready(function() {
	jQuery("a[rel=vm-additional-images]").fancybox({
		"titlePosition" 	: "inside",
		"transitionIn"	:	"elastic",
		"transitionOut"	:	"elastic"
	});
	jQuery(".additional-images .product-image").click(function() {
		jQuery(".main-image img").attr("src",this.src );
		jQuery(".main-image img").attr("alt",this.alt );
		jQuery(".main-image a").attr("href",this.src );
		jQuery(".main-image a").attr("title",this.alt );
	}); 
});
';
//$document->addScriptDeclaration ($imageJS);
//$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
//$document->addScript(JURI::base().'templates/alpine/js/etalage.js');
$document->addStylesheet(JURI::base().'templates/alpine/css/zoom_1.css');

if (!empty($this->product->images)) 
{ ?>
	<ul id="etalage">
    <?php
   $count_images = count ($this->product->images);
   
   if ($count_images > 1) {
		 for ($i = 1; $i < $count_images; $i++) {
				
                $image = $this->product->images[$i];
				?>
    <li>
    <?php echo $image->displayMediaFull("class='etalage_thumb_image'",true);?>
    <?php echo $image->displayMediaFull("class='etalage_source_image'",true);?>           
    </li>
    <?php }
	 } ?>
    
</ul>

<?php }
  // Showing The Additional Images END ?>
 <div class="etalage-control">
    <a href="javascript:void(0)" class="etalage-prev">Previous</a>
    <a href="javascript:void(0)" class="etalage-next">Next</a>
</div>

  
  
  

 <script type="text/javascript">
    jQuery(document).ready(function(){
        var width = jQuery('.detail_section .col-md-6.product-img-box').width();
        var src_img_width = 800;
        var src_img_height = 1000;
        var ratio_width = 800;
        var ratio_height = 1000;
        
        src_img_width = 1000 * ratio_width / ratio_height;
        var height = width * ratio_height / ratio_width;

        var zoom_enabled = true;
        if(jQuery(window).width()<767)
            zoom_enabled = false;
        jQuery('#etalage').etalage({
            thumb_image_width: width,
            thumb_image_height: height,
            source_image_width: src_img_width,
            source_image_height: src_img_height,
            zoom_area_width: width,
            zoom_area_height: height,
            zoom_enable: zoom_enabled,
            smallthumb_hide_single: false,
            autoplay: false
        });
        jQuery('.detail_section .col-md-6.product-img-box .etalage-control a').css('bottom',((jQuery('.etalage_small_thumbs').height()-25)/2)+"px");
        if(jQuery('.etalage_small_thumbs').height() == 0)
            jQuery('.detail_section .col-md-6.product-img-box .etalage-control a').css('bottom',((jQuery('.etalage_small_thumbs img').first().height()-25)/2)+"px");
        jQuery(window).resize(function(e){
            var width = jQuery('.detail_section .col-md-6.product-img-box').width();
            var height = width * ratio_height / ratio_width;
            zoom_enabled = true;
            if(jQuery(window).width()<767)
                zoom_enabled = false;
            jQuery('#etalage').etalage({
                thumb_image_width: width,
                thumb_image_height: height,
                source_image_width: src_img_width,
                source_image_height: src_img_height,
                zoom_area_width: width+12,
                zoom_area_height: height+12,
                zoom_enable: zoom_enabled,
                smallthumb_hide_single: false,
                autoplay: false
            });
            jQuery('.detail_section .col-md-6.product-img-box .etalage-control a').css('bottom',((jQuery('.etalage_small_thumbs').height()-25)/2)+"px");
        });
        jQuery('.etalage-prev').on('click', function(){
            etalage_previous();
        });

        jQuery('.etalage-next').on('click', function(){
            etalage_next();
        });
    });
</script>