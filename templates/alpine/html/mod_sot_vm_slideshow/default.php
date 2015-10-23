<?php
/*------------------------------------------------------------------------
 # Sot vm Slideshow  - Version 1.0
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # @Author: Sky Of Tech
 # @Websites: http://skyoftech.com
 # @Email: contactnum1@gmail.com
 # Copyright (C) 2010-2011 Sky Of Tech. All Rights Reserved.
 -------------------------------------------------------------------------*/
 
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<script type="text/javascript">
	if(typeof(SOT<?php echo $module->id;?>)=='undefined')
		SOT<?php echo $module->id;?> = jQuery.noConflict();
</script>		
<?php
if(count($items)>0):
$document =& JFactory::getDocument();
if($navigation_type=='square'){
	$styles = '#cs-buttons-sot-slideshow-'.$module->id.' { font-size: 0px; padding: 10px; float: left; }
	#cs-buttons-sot-slideshow-'.$module->id.' a { margin-left: 5px; height: 10px; width: 10px; float: left; border: 1px solid #222222!important; color: #0098f9; text-indent: -1000px; }
	#cs-buttons-sot-slideshow-'.$module->id.' .sot-cs-active { background-color: #0098f9; color: #FFFFFF; }';
} else {
	$styles = '#cs-buttons-sot-slideshow-'.$module->id.' { padding: 10px; }
	#cs-buttons-sot-slideshow-'.$module->id.' a { border:thin solid #3399FF !important; color:#166FDF !important; font-weight:bold; margin:1px !important; padding:2px !important; }
	#cs-buttons-sot-slideshow-'.$module->id.' .sot-cs-active { background-color: #0098f9; color: #FE6602!important; }';
}	
$document->addStyleDeclaration($styles);

?>

<div style="width: <?php echo $thumb_width;?>px; height: <?php echo $thumb_height;?>px; " id="sot-slideshow-<?php echo $module->id;?>" class="sot-article-slideshow">
	<?php foreach($items as $key=>$item):?>		
			<a href="<?php echo htmlspecialchars($item['link']);?>" target="<?php echo $target;?>">
				<img style="display: none;" src="<?php echo htmlspecialchars($item['thumb']);?>" alt="<?php echo htmlspecialchars($item['title']);?>" class="thumb_large_img">
			</a>
			<span style="display: none;">					
				<div class="sot-content">
					<b><?php echo htmlspecialchars($item['sub_title']);?></b><br>
					<div class="sot-main-content"><?php echo $item['sub_content'];?></div>				
				</div>
				<div class="sot-price-addtocart">
					<div class="sot-price-slideshowpro">
						<?php if(isset($item['price'])){ ?>
							<div class="sot-price-label"><?php echo JText::_('Price');?> : </div>
							<div class="sot-price-content">
								<div class="sot-basePrice">
									<?php
										if(isset($item['price']['basePrice']))
										{
											echo $item['price']['basePrice'];
										}
									?>
								</div>
								<div class="sot-salePrice">		
									<?php	
										if(isset($item['price']['salePrice']))
										{
											echo $item['price']['salePrice'];
										}
									?>	
								</div>		
							</div>																									
						 <?php }?>
					</div>
					<?php if(isset($item['addtocart_link'])){ ?>
					<div class="sot-addtocart">
						<?php 
							echo $item['addtocart_link'];
						?>
					</div>	
					<?php }?>
				</div>
			</span>
	<?php endforeach; ?>		
</div>

<script type="text/javascript">
	SOT<?php echo $module->id;?>(document).ready(function($) {
		$('#sot-slideshow-<?php echo $module->id;?>').coinslider({ 
			width: <?php echo $thumb_width;?>, // width of slider panel
			height: <?php echo $thumb_height;?>, // height of slider panel
			delay: <?php echo $timer;?>, // delay between images in ms
			opacity: <?php echo $opacity;?>, // opacity of title and navigation
			effect: '<?php echo $effect;?>', // random, swirl, rain, straight
			navigation: <?php echo ($show_navigation)?'true':'false';?>, // prev next and buttons
			navigationPos: '<?php echo $navigation_position;?>',  // navigation position top, left, bottom, right
			links : <?php echo ($link_image)?'true':'false';?>, // show images as links 
			readmoreLink: <?php echo ($show_readmore)?'true':'false';?>, //show readmore links
			readmoreText: '<?php echo JText::_('readmore');?>', // text read more for language
			hoverPause: <?php echo ($hover)?'true':'false';?>, // pause on hover		
			auto: <?php echo ($auto_play)?'true':'false';?>, // true is auto play
			classPrefix: 'sot-'
		});
	});
</script>
<?php endif;?>