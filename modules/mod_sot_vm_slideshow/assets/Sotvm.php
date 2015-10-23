<?php
/*------------------------------------------------------------------------
 # Sot Virtuemart Slideshow - Version 1.0
 # Copyright (C) 2010-2011 Sky Of Tech. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: Sky Of Tech
 # Websites: http://skyoftech.com
 -------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');
if( file_exists(JPATH_SITE .DS.'components/com_virtuemart/virtuemart_parser.php' )) {
	require_once( JPATH_SITE .DS.'components/com_virtuemart/virtuemart_parser.php' );
} else {
	require_once( JPATH_SITE .DS.'components/com_virtuemart/virtuemart_parser.php' );
}
require_once(CLASSPATH.'ps_product_category.php');
require_once( CLASSPATH."ps_product.php" );
require_once (JPATH_SITE .DS.'modules'.DS.$module->module.DS.'libs'.DS.'SimpleImage'.DS.'SimpleImage.php');

if (! class_exists("Sotvm") ) {
	class Sotvm {	
		var $thumb_width = '40';
		var $thumb_height = '40';
		var $web_url = '';	
		var $cropresizeimage = 0;
		var $max_title = 0;
		var $max_description = 0;
		var $max_short_desc = 0;
		var $resize_folder = '';
		var $crop_folder = '';
		var $url_to_resize = '';
		var $url_to_crop = '';
		var $source = 'filter';
		var $catfilter = 0;
		var $vmcategories = array();
		var $specific_product_ids = "";
		var $NumberOfProducts = 5;
		var $featuredProducts = false;		
		var $SortMethod = 'random';
		var $params = null;
		
		function getItems(&$params) {
				
			global $CURRENCY_DISPLAY, $sess, $mm_action_url, $VM_LANG;
			$db = new ps_DB;
			
			if($rows = $this->getProductSKU( $this->NumberOfProducts, $this->SortMethod, $this->vmcategories, $this->featuredProducts, $this->specific_product_ids, $this->source, $this->catfilter ))
			{
				$ps_product = new ps_product;
				$ps_product_category = new ps_product_category;
				$pro_skus = implode("','", $rows);	
				$limit = $this->NumberOfProducts;
				if($limit>0) {
					$limit = "LIMIT $limit";
				} else {
					$limit = "";
				}
				$q = "SELECT product_id, product_name, product_parent_id, product_thumb_image, product_desc, product_full_image FROM #__{vm}_product AS p WHERE product_sku in ('$pro_skus')";
				switch( $this->SortMethod ) {
					case 'random':
						$q .= "\n ORDER BY RAND() $limit";
						break;
					case 'newest':
						$q .= "\n ORDER BY p.cdate DESC $limit";
						break;
					case 'oldest':
						$q .= "\n ORDER BY p.cdate ASC $limit";
						break;
					default:
						$q .= "\n ORDER BY p.cdate DESC $limit";
						break;
				}
				$db->setQuery( $q );
				$items = $db->loadObjectList(); 
				//var_dump($items);die;
				foreach($items as &$item) {
					$product_id = $item->product_id;

					$cid = $ps_product_category->get_cid( $product_id );

					$product_name = $item->product_name;
					$item->title = $product_name;
					if ($item->product_parent_id) {
						$url = "?page=shop.product_details&category_id=$cid&flypage=".$ps_product->get_flypage($item->product_parent_id);
						$url .= "&product_id=" . $item->product_parent_id;
					} else {
						$url = "?page=shop.product_details&category_id=$cid&flypage=".$ps_product->get_flypage($item->product_id);
						$url .= "&product_id=" . $item->product_id;
					}
					$product_link = $sess->url($mm_action_url. "index.php" . $url);
					$item->link = $product_link;
					$product_thumb_image = $item->product_full_image;
					
					//$img = $this->image_url( $product_thumb_image, "alt=\"".$product_name."\"");
					$item->image = IMAGEPATH.'product/'.$product_thumb_image;
					$item->fulltext = $item->product_desc;
					$item->introtext = $item->product_desc;
																			
					$price_base = $this->get_price($ps_product,  $item->product_id);
					$price_ps = $ps_product->get_price($item->product_id, true);
					if (_SHOW_PRICES == '1' && $this->show_price) {
						// Show price, but without "including X% tax"
						$item->price = $CURRENCY_DISPLAY->getFullValue($price_base[1]);
						
					}
					
					if (USE_AS_CATALOGUE != 1 && $this->show_addtocart
							&& isset($price_ps) && $price_ps['product_price'] // Product must have a price to add it to cart
							/*&& !$ps_product->product_has_attributes($item->product_id, true)  // Parent Products and Products with attributes can't be added to cart this way*/
							) {
						$url = "?page=shop.cart&func=cartAdd&product_id=" .  $item->product_id;
						$addtocart_link = $sess->url($mm_action_url. "index.php" . $url);
						$item->addtocart_link = $addtocart_link;

					}
					
				}

				return $this->update($params, $items);
			} else return array();
	
			
	
		}		
		
		function update($params, $items ) {	
			$tmp = array();
			
			foreach ($items as $key => $item) {//var_dump($item->product_id);die;
				$item_final = array();
				$item->title = JFilterOutput::ampReplace($item->title);
				//Images
					
				$item->introtext = $this->removeImage($item->introtext);
				//Read more link
				
				$item_final['link'] = $item->link;
				$item_final['fulltext'] = $item->fulltext;
				$item_final['title'] = $item->title;
				$item_final['id'] = $item->product_id;
				if (!isset($item_final['sub_title'])) {
					$item_final['sub_title'] = $this->truncate($item->title, $this->max_title, '...', true, true);
				}
				
				if (!isset($item_final['sub_content'])) {
					$content = $this->truncate($item->introtext, $this->max_description, '...', true, true);
					$item_final['sub_content'] = $content;
				}
				
				if (!isset($item_final['sub_short_content'])) {
					$content = $this->substrwords($item->introtext, $this->max_short_desc, '...');
					$item_final['sub_short_content'] = $content;
				}
				
				if (!isset($item_final['thumb']) && $item->image != '') {
					$item_final['thumb'] = $this->processImage($item->image, $this->thumb_width, $this->thumb_height);
				} else {
					$item_final['thumb'] = '';
				}		
				
				if (!isset($item_final['small_thumb']) && $item->image != '') {
					$item_final['small_thumb'] = $this->processImage($item->image, $this->small_thumb_width, $this->small_thumb_height);
				} else {
					$item_final['small_thumb'] = '';
				}
				
				if(isset($item->addtocart_link))
				{
					$item_final['addtocart_link'] = $item->addtocart_link;
				}
				if(isset($item->price))
				{
					$item_final['price'] = $item->price;
				}
				//var_dump($item_final);die;
				if ($item_final['thumb'] != '') {			
					$tmp[] = $item_final;
				}
			}
			
			return $tmp;				
		}
		
		function removeImage($str) {
			$regex1 = "/\<img[^\>]*>/";
			$str = preg_replace ( $regex1, '', $str );
			$regex1 = "/<div class=\"mosimage\".*<\/div>/";
			$str = preg_replace ( $regex1, '', $str );
			$str = trim ( $str );
			
			return $str;
		}
		function processImage($img, $width, $height) {
					
			if ($this->cropresizeimage == 0) {
				return $this->resizeImage($img, $width, $height);
			} else {
				return $this->cropImage($img, $width, $height);
			}
		}
			
		function resizeImage($imagePath, $width, $height) {
			global $module;
					
			$folderPath = $this->resize_folder;
			 
			 if(!JFolder::exists($folderPath)){
					JFolder::create($folderPath);	 
			 }
			  
			 $nameImg = str_replace('/','',strrchr($imagePath,"/"));		
			 $ext = substr($nameImg, strrpos($nameImg, '.'));
			 $file_name = substr($nameImg, 0,  strrpos($nameImg, '.'));
			 $nameImg = str_replace(" ","",$file_name . "_" . $width . "_" . $height .  $ext);
					 
			 if(!JFile::exists($folderPath.DS.$nameImg)){
				 $image = new SimpleImage();
				 $image->load($imagePath);
				 $image->resize($width,$height);
				 $image->save($folderPath.DS.$nameImg);
			 }else{
					 list($info_width, $info_height) = @getimagesize($folderPath.DS.$nameImg);
					 if($width!=$info_width||$height!=$info_height){
						 $image = new SimpleImage();
						 $image->load($imagePath);
						 $image->resize($width,$height);
						 $image->save($folderPath.DS.$nameImg);
					 }
			 }
			 return $this->url_to_resize . $nameImg;
		}
		
		function cropImage($imagePath, $width, $height) {
			global $module;
			
			$folderPath = $this->crop_folder;
	
			if(!JFolder::exists($folderPath)){
					JFolder::create($folderPath);	 
			}
			$nameImg = str_replace('/','',strrchr($imagePath,"/")); 
			$ext = substr($nameImg, strrpos($nameImg, '.'));
			$file_name = substr($nameImg, 0,  strrpos($nameImg, '.'));
			$nameImg = str_replace(" ","",$file_name . "_" . $width . "_" . $height .  $ext);	 
			 
			 if(!JFile::exists($folderPath.DS.$nameImg)){
				 $image = new SimpleImage();
				 $image->load($imagePath);
				 $image->crop($width,$height);
				 $image->save($folderPath.DS.$nameImg);
			 }else{
					 list($info_width, $info_height) = @getimagesize($folderPath.DS.$nameImg);
					 if($width!=$info_width||$height!=$info_height){
						 $image = new SimpleImage();
						 $image->load($imagePath);
						 $image->crop($width,$height);
						 $image->save($folderPath.DS.$nameImg);
					 }
			 }
			 
			 return $this->url_to_crop . $nameImg;
		}
		
		/**
		 * Truncates text.
		 *
		 * Cuts a string to the length of $length and replaces the last characters
		 * with the ending if the text is longer than length.
		 *
		 * @param string  $text String to truncate.
		 * @param integer $length Length of returned string, including ellipsis.
		 * @param string  $ending Ending to be appended to the trimmed string.
		 * @param boolean $exact If false, $text will not be cut mid-word
		 * @param boolean $considerHtml If true, HTML tags would be handled correctly
		 * @return string Trimmed string.
		 */
		function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
			if ($considerHtml) {
				// if the plain text is shorter than the maximum length, return the whole text
				if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
					return $text;
				}
				// splits all html-tags to scanable lines
				preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
				$total_length = strlen($ending);
				$open_tags = array();
				$truncate = '';
				foreach ($lines as $line_matchings) {
					// if there is any html-tag in this line, handle it and add it (uncounted) to the output
					if (!empty($line_matchings[1])) {
						// if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
						if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
							// do nothing
						// if tag is a closing tag (f.e. </b>)
						} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
							// delete tag from $open_tags list
							$pos = array_search($tag_matchings[1], $open_tags);
							if ($pos !== false) {
								unset($open_tags[$pos]);
							}
						// if tag is an opening tag (f.e. <b>)
						} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
							// add tag to the beginning of $open_tags list
							array_unshift($open_tags, strtolower($tag_matchings[1]));
						}
						// add html-tag to $truncate'd text
						$truncate .= $line_matchings[1];
					}
					// calculate the length of the plain text part of the line; handle entities as one character
					$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
					if ($total_length+$content_length> $length) {
						// the number of characters which are left
						$left = $length - $total_length;
						$entities_length = 0;
						// search for html entities
						if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
							// calculate the real length of all entities in the legal range
							foreach ($entities[0] as $entity) {
								if ($entity[1]+1-$entities_length <= $left) {
									$left--;
									$entities_length += strlen($entity[0]);
								} else {
									// no more characters left
									break;
								}
							}
						}
						$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
						// maximum lenght is reached, so get off the loop
						break;
					} else {
						$truncate .= $line_matchings[2];
						$total_length += $content_length;
					}
					// if the maximum length is reached, get off the loop
					if($total_length>= $length) {
						break;
					}
				}
			} else {
				if (strlen($text) <= $length) {
					return $text;
				} else {
					$truncate = substr($text, 0, $length - strlen($ending));
				}
			}
			// if the words shouldn't be cut in the middle...
			if (!$exact) {
				// ...search the last occurance of a space...
				$spacepos = strrpos($truncate, ' ');
				if (isset($spacepos)) {
					// ...and cut the text in this position
					$truncate = substr($truncate, 0, $spacepos);
				}
			}
			// add the defined ending to the text
			$truncate .= $ending;
			if($considerHtml) {
				// close all unclosed html-tags
				foreach ($open_tags as $tag) {
					$truncate .= '</' . $tag . '>';
				}
			}
			return $truncate;
		}
	
		function substrwords($text,$maxchar,$end='...'){
			$text = strip_tags($text);
			if(strlen($text)>$maxchar){
				$words=explode(" ",$text);
				$output = '';
				$i=0;
				while(1){
				$length = (strlen($output)+strlen($words[$i]));
					if($length>$maxchar){
						break;
					}else{
						$output = $output." ".$words[$i];
						++$i;
					};
				};
			}else{
				$output = $text;
			}
			return $output.$end;
		}
		
		function buildConditionSql($source, $catfilter, $category_ids, $specific_product_ids){
			$where = "";
			switch($source){
			
				case "filter":
					switch($catfilter){
						case 0:
							return "";
						break;
						case 1:
							if($category_ids)
							{
								if(is_array($category_ids))
								{
									$str_cate_ids = implode(",", $category_ids);
									$where = " AND c.category_id in (".$str_cate_ids.") ";
								}
								else
								{
									$where = " AND c.category_id = ". intval($category_ids);
								}	
							}
							
							return $where;
						break;
					
					}	
				break;
				case "specific":
					$where = " AND p.product_id in (".$specific_product_ids.")";
					return $where; 
				break;		
			}
			
			return "";
		}		
		
		function getProductSKU( $limit=0, $how=null, $category_ids=array(), $featuredProducts='no' , $specific_product_ids='', $source='filter', $catfilter='') {
			global $my, $mosConfig_offset;
			$database = new ps_DB();
	
			$where = $this->buildConditionSql($source, $catfilter, $category_ids, $specific_product_ids);
	
			if($limit>0) {
				$limit = "LIMIT $limit";
			} else {
				$limit = "";
			}
	
			$query = "SELECT distinct(p.product_sku) FROM #__{vm}_product AS p";
	
			$query .= "\nJOIN #__{vm}_product_category_xref as pc ON p.product_id=pc.product_id";
			
			$query .= "\nJOIN #__{vm}_category as c ON pc.category_id=c.category_id";
			
			$query .= "\n WHERE p.product_publish = 'Y' AND c.category_publish = 'Y' AND product_parent_id=0 ";
			if( CHECK_STOCK && PSHOP_SHOW_OUT_OF_STOCK_PRODUCTS != "1") {
				$query .= " AND product_in_stock > 0 ";
			}
			
			if( $featuredProducts=='yes' ) {
				$query .= "\n AND product_special = 'Y' ";
			}
			
			$query .= $where;
			
			switch( $how ) {
				case 'random':
					$query .= "\n ORDER BY RAND() $limit";
					break;
				case 'newest':
					$query .= "\n ORDER BY p.cdate DESC $limit";
					break;
				case 'oldest':
					$query .= "\n ORDER BY p.cdate ASC $limit";
					break;
				default:
					$query .= "\n ORDER BY p.cdate DESC $limit";
					break;
			}
			$database->setQuery( $query );
	
			$rows = $database->loadResultArray();//var_dump($rows);die;
			return $rows;
		}
		
		
		function get_price($ps_product,  $product_id){
			$auth = $_SESSION['auth'];
			$discount_info = $ps_product->get_discount( $product_id );
			if( !$discount_info["is_percent"] && $discount_info["amount"] != 0 ) {
				$discount_info["amount"] = $GLOBALS['CURRENCY']->convert($discount_info["amount"]);
			}
			// Get the Price according to the quantity in the Cart
			$price_info = $ps_product->get_price( $product_id );

			
			// Get the Base Price of the Product
			$base_price_info = $ps_product->get_price($product_id, true );

			if( $price_info === false ) {
				$price_info = $base_price_info;
			}

			$undiscounted_price = 0;
			if (isset($price_info["product_price_id"])) {
				if( $base_price_info["product_price"]== $price_info["product_price"] ) {
					$price = $base_price = $GLOBALS['CURRENCY']->convert( $base_price_info["product_price"], $price_info['product_currency'] );
				} else {
					$base_price = $GLOBALS['CURRENCY']->convert( $base_price_info["product_price"], $price_info['product_currency'] );
					$price = $GLOBALS['CURRENCY']->convert( $price_info["product_price"], $price_info['product_currency'] );	
				}

				if ($auth["show_price_including_tax"] == 1) {
					$my_taxrate = $ps_product->get_product_taxrate($product_id);
					$base_price += ($my_taxrate * $base_price);
				}
				else {
					$my_taxrate = 0;
				}
				// Calculate discount
				if( !empty($discount_info["amount"])) {
					$undiscounted_price = $base_price;
					switch( $discount_info["is_percent"] ) {
						case 0:
							// If we subtract discounts BEFORE tax
							if( PAYMENT_DISCOUNT_BEFORE == '1' ) {
								// and if our prices are shown with tax
								if( $auth["show_price_including_tax"] == 1) {
									// then we add tax to the (untaxed) discount
									$discount_info['amount'] += ($my_taxrate*$discount_info['amount']);
								} 
								// but if our prices are shown without tax
									// we just leave the (untaxed) discount amount as it is
								 	
							}
							// But, if we subtract discounts AFTER tax
								// and if our prices are shown with tax
									// we just leave the (untaxed) discount amount as it is
								// but if  prices are shown without tax
									// we just leave the (untaxed) discount amount as it is
									// even though this is not really a good combination of settings

							$base_price -= $discount_info["amount"];
							break;
						case 1:
							$base_price *= (100 - $discount_info["amount"])/100;
							break;
					}
				}
			}	
				$prices = array($price, $base_price);
				return $prices;
		}
		
	}
	
		
	
}
?>