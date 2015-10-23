<?php
/*------------------------------------------------------------------------
 # Sot Virtuemart class  - Version 1.0
 # Copyright (C) 2010-2011 Sky Of Tech. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: Sky Of Tech
 # Websites: http://skyoftech.com
 -------------------------------------------------------------------------*/
 
// no direct access
defined('_JEXEC') or die('Restricted access');

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
// Load the language file of com_virtuemart.
JFactory::getLanguage()->load('com_virtuemart');
if (!class_exists( 'calculationHelper' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'calculationh.php');
if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
if (!class_exists( 'calculationHelper' )) require(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'cart.php');
if (!class_exists( 'VirtueMartModelProduct' )){
   JLoader::import( 'product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
}
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
		var $category_id = array();
		var $specific_product_ids = "";
		var $NumberOfProducts = 5;
		var $featuredProducts = false;		
		var $SortMethod = 'random';
		var $params = null;
		var $_db = null;
		var $filter_order_Dir = "ASC";
		var $ShowProductsInStock = 1;

		function getItems(&$params) {	
			$this->_db = JFactory::getDBO();										
			if($product = $this->getProducts())
			{	
				return $this->update($params, $product);
			} else return array();	
	
		}
		
		function getProducts($onlyPublished=true){		
	
			$app = &JFactory::getApplication() ;
			
			$groupBy = '';
	
			//administrative variables to organize the joining of tables
			$joinCategory 	= true ;
			$joinMf 		= true ;
			$joinPrice 		= true ;
			$joinCustom		= false ;
			$joinLang = true; // test fix Patrick
	
			$where = array();
	
			if($onlyPublished){
				$where[] = ' p.`published`="1" ';
			}
		
			if($app->isSite() && !$this->ShowProductsInStock ){
				$where[] = ' p.`product_in_stock`>"0" ';
			}				
			
			if($this->source == 'filter'){
				$virtuemart_category_id = '';
				if(is_array($this->category_id) && !empty($this->category_id))
				{
					$virtuemart_category_id = implode(",", $this->category_id);
				}
				else
				{
					$virtuemart_category_id = intval($this->category_id);
				}
				
				$joinCategory = true ;
				$where[] = ' `#__virtuemart_product_categories`.`virtuemart_category_id` in ('.$virtuemart_category_id.')';
				
			} 
			else if($this->source == 'specific')
			{
				
				if(!empty($this->specific_product_ids) && $this->specific_product_ids!='')
				{
					$where[] = ' p.`virtuemart_product_id` in ('.$this->specific_product_ids.') ';
				}
			}
	
			
			$joinShopper = false;
			if ($app->isSite()) {
				if(!class_exists('VirtueMartModelUser')) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'user.php');
				$usermodel = new VirtueMartModelUser();
				$currentVMuser = $usermodel->getUser();
				$virtuemart_shoppergroup_ids =  $currentVMuser->shopper_groups;
	
				if(is_array($virtuemart_shoppergroup_ids)){
					foreach ($virtuemart_shoppergroup_ids as $key => $virtuemart_shoppergroup_id){
						$where[] .= '(s.`virtuemart_shoppergroup_id`= "' . (int) $virtuemart_shoppergroup_id . '" OR' . ' ISNULL(s.`virtuemart_shoppergroup_id`) )';
					}
					$joinShopper = true;
				}
			}
	
			if($this->featuredProducts=='yes')
			{
				$where[] = ' p.`product_special`="1" ';
			}
			
			$limit = $this->NumberOfProducts;
			if($limit>0) {
				$limit = "LIMIT $limit";
			} else {
				$limit = "";
			}
			// special  orders case
			switch ($this->SortMethod) {
			
				case 'random':
					$orderBy = "\n ORDER BY RAND() ";
					break;
				case 'newest':
					$orderBy = "\n ORDER BY p.created_on DESC ";
					break;
				case 'oldest':
					$orderBy = "\n ORDER BY p.created_on ASC";
					break;
				case 'ordering':
					$orderBy = ' ORDER BY `#__virtuemart_product_categories`.`ordering` ';
					$joinCategory = true ;
					break;
				case 'product_price':
					//$filters[] = 'p.`virtuemart_product_id` = p.`virtuemart_product_id`';
					$orderBy = ' ORDER BY pp.`product_price` ';
					$joinPrice = true ;
					break;
				default:
					$orderBy = "\n ORDER BY p.cdate DESC ";
					break;
			}
			
			$orderBy .= $limit;
	
			
			
			if($joinLang){
				$select = ' *, p.`product_in_stock`,l.`virtuemart_product_id` as virtuemart_product_id FROM `#__virtuemart_products_'.VMLANG.'` as l';
				$joinedTables = ' JOIN `#__virtuemart_products` AS p using (`virtuemart_product_id`)';
			} else {
				$select = ' * FROM `#__virtuemart_products` as p';
				$joinedTables = '';
			}
	
			if ($joinCategory == true) {
				$joinedTables .= ' LEFT JOIN `#__virtuemart_product_categories` ON p.`virtuemart_product_id` = `#__virtuemart_product_categories`.`virtuemart_product_id`
				 LEFT JOIN `#__virtuemart_categories_'.VMLANG.'` as c ON c.`virtuemart_category_id` = `#__virtuemart_product_categories`.`virtuemart_category_id` 
				 INNER JOIN `#__virtuemart_categories` as vca ON vca.`virtuemart_category_id` = c.`virtuemart_category_id`
				 ';
				 
				 $where[] = ' vca.`published`= 1 ';
			}
			
			if ($joinMf == true) {
				$joinedTables .= ' LEFT JOIN `#__virtuemart_product_manufacturers` ON p.`virtuemart_product_id` = `#__virtuemart_product_manufacturers`.`virtuemart_product_id`
				 LEFT JOIN `#__virtuemart_manufacturers_'.VMLANG.'` as m ON m.`virtuemart_manufacturer_id` = `#__virtuemart_product_manufacturers`.`virtuemart_manufacturer_id` ';
			}
	
	
			if ($joinPrice == true) {
				$joinedTables .= ' LEFT JOIN `#__virtuemart_product_prices` as pp ON p.`virtuemart_product_id` = pp.`virtuemart_product_id` ';
			}
		
			if ($joinShopper == true) {
				$joinedTables .= ' LEFT JOIN `#__virtuemart_product_shoppergroups` ON p.`virtuemart_product_id` = `#__virtuemart_product_shoppergroups`.`virtuemart_product_id`
				 LEFT  OUTER JOIN `#__virtuemart_shoppergroups` as s ON s.`virtuemart_shoppergroup_id` = `#__virtuemart_product_shoppergroups`.`virtuemart_shoppergroup_id`';
			}
	
			if(count($where)>0){
				$whereString = ' WHERE ('.implode(' AND ', $where ).') ';
			} else {
				$whereString = '';
			}
			
			$products = $this->excuteSql($select, $joinedTables, $whereString, $groupBy, $orderBy);
	
			return $products;
	
		}
		
		/**
		 *
		 * Excute sql
		 *	
		 */
	
		public function excuteSql($select, $joinedTables, $whereString = '', $groupBy = '', $orderBy = ''){
			$joinedTables .= $whereString .$groupBy .$orderBy;	
			$q = 'SELECT '.$select.$joinedTables;
			$this->_db->setQuery($q);
			$products = $this->_db->LoadObjectList();			
			return $products;
	
		}						
		
		/**
		 * Gets the price for a variant
		 *
		 * @author Max Milbers
		 */
		public function getPrice($product,$customVariant,$quantity){
		
			
			// 		vmdebug('strange',$product);
			if(!is_object($product)){
				$product = $this->getProduct($product,true,false,true);
			}
		
			// Loads the product price details
			if(!class_exists('calculationHelper')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'calculationh.php');
			$calculator = calculationHelper::getInstance();
		
			// Calculate the modificator
			$variantPriceModification = $calculator->calculateModificators($product,$customVariant);
		
			$prices = $calculator->getProductPrices($product,$product->categories,$variantPriceModification,$quantity);
			return $prices;
		
		}
		
		function getProductImage($product_id=0){
			if($product_id)
			{
				$sql = "SELECT vm.file_url FROM #__virtuemart_medias AS vm 
						INNER JOIN #__virtuemart_product_medias AS pm ON vm.virtuemart_media_id = pm.virtuemart_media_id
						WHERE pm.virtuemart_product_id = {$product_id}
						";
				$this->_db->setQuery($sql);
				$img = $this->_db->LoadResult();
				return $img;
			}
		}

		
		function update($params, $items ) {	
			$tmp = array();
			
			foreach ($items as $key => $item) {//var_dump($item->product_id);die;
				$item_final = array();
				//$item->categories = NULL;
				
				$item->image = $this->getProductImage($item->virtuemart_product_id);

				$item->categories = $this->getProductCategories($item->virtuemart_product_id);
				
				$item->prices = $this->getPrice($item, array(), 1);
				$item->link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$item->virtuemart_product_id.'&virtuemart_category_id='.$item->virtuemart_category_id);
				
				$item->title = JFilterOutput::ampReplace($item->product_name);
				//Images
				
				$item->introtext = $this->removeImage($item->product_s_desc);
				//Read more link
				
				$item_final['link'] = $item->link;
				$item_final['fulltext'] = $item->product_desc;
				$item_final['title'] = $item->title;
				$item_final['id'] = $item->virtuemart_product_id;
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
				
				if($item->product_in_stock>0)
				{
					$item_final['product_in_stock'] = $item->product_in_stock;
					if($this->show_addtocart)
					{
						$item_final['addtocart_link'] = $this->addtocart($item);
					}
					if($this->show_price)
					{
						$currency = CurrencyDisplay::getInstance( );
						$array_price = array();	
						
						if (!empty($item->prices['basePrice'] ) ) $array_price['basePrice'] = $currency->createPriceDiv('basePrice','',$item->prices,true);
						if (!empty($item->prices['salesPrice'] ) ) $array_price['salePrice'] = $currency->createPriceDiv('salesPrice','',$item->prices,true);
				
						$item_final['price'] = $array_price;
					}
				} else {
					$item_final['product_in_stock'] = 0;
				}
				//var_dump($item_final);die;
				if ($item_final['thumb'] != '') {			
					$tmp[] = $item_final;
				}
			}
			
			return $tmp;				
		}
		
		/**
		 * Load  the product category
		 *
		 * @author Kohl Patrick,RolandD,Max Milbers
		 * @return array list of categories product is in
		 */
		private function getProductCategories($virtuemart_product_id=0) {
	
			$categories = array();
			if ($virtuemart_product_id > 0) {
				$q = 'SELECT `virtuemart_category_id` FROM `#__virtuemart_product_categories` WHERE `virtuemart_product_id` = "'.(int)$virtuemart_product_id.'"';
				$this->_db->setQuery($q);
				$categories = $this->_db->loadResultArray();
			}
	
			return $categories;
	 	}
		
		function addtocart($product) {
            if (!VmConfig::get('use_as_catalog',0)) { 
			
				ob_start();
			?>      
				<form method="post" class="product" action="index.php">								
					<?php 
					$button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
					$button_cls = ''; //$button_cls = 'addtocart_button';
					if (VmConfig::get('check_stock') == '1' && !$product->product_in_stock) {
						$button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
						$button_cls = 'notify-button';
					} ?>
					
					<input type="submit" name="addtocart"  class="sot_addtocart_button_module" value="" title="<?php echo $button_lbl ?>" />

					<input type="hidden" class="pname" value="<?php echo $product->product_name ?>">
					<input type="hidden" class="quantity-input" name="quantity[]" value="1" />
					<input type="hidden" name="option" value="com_virtuemart" />
					<input type="hidden" name="view" value="cart" />
					<input type="hidden" name="task" value="add" />
					<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>" />
					<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />
					
				</form>

			<?php $addtocart = ob_get_clean(); return $addtocart;
			}
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
			if(JFile::exists($img))	
			{	
				if ($this->cropresizeimage == 0) {
					return $this->resizeImage($img, $width, $height);
				} else {
					return $this->cropImage($img, $width, $height);
				}
			}
			else
			{
				return '';
			}	
		}
			
		function resizeImage($imagePath, $width, $height) {
			global $module;
					
			$folderPath = $this->resize_folder;
			
			$parent_path = str_replace("/images/resize","",$folderPath);
			$parent_path = str_replace("\\images\\resize","",$parent_path);
			
			if(!JFolder::exists($parent_path)){
				if(mkdir($parent_path, 0777)){
				
				} else {
					echo "Error: Can't create folder for resize image!"; exit();
				}
			}
			
			$parent_path = str_replace("/resize","",$folderPath);
			$parent_path = str_replace("\\resize","",$parent_path);
			
			if(!JFolder::exists($parent_path)){
				//if(JFolder::create($folderPath)){echo "ok";} else {echo "not ok";}	 
				if(mkdir($parent_path, 0777)){
					if(mkdir($folderPath, 0777)){
					
					} else {
						echo "Error: Can't create folder for resize image!"; 
					}	
				} else {
					echo "Error: Can't create folder for resize image!"; 
				}	 
			} else
			{
			 if(!JFolder::exists($folderPath)){
				if(mkdir($folderPath, 0777)){
					
				} else {
					echo "Error: Can't create folder for resize image!"; 
				}	
			 
			 }
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
			
			$parent_path = str_replace("/images/crop","",$folderPath);
			$parent_path = str_replace("\\images\\crop","",$parent_path);
			
			if(!JFolder::exists($parent_path)){
				if(mkdir($parent_path, 0777)){
				
				} else {
					echo "Error: Can't create folder for resize image!"; exit();
				}
			}
			
			$parent_path = str_replace("/crop","",$folderPath);
			$parent_path = str_replace("\\crop","",$parent_path);
			 if(!JFolder::exists($parent_path)){
					//if(JFolder::create($folderPath)){echo "ok";} else {echo "not ok";}	 
					if(mkdir($parent_path, 0777)){
						if(mkdir($folderPath, 0777)){
						
						} else {
							echo "Error: Can't create folder for crop image!"; 
						}	
					} else {
						echo "Error: Can't create folder for crop image!"; 
					}	 
			 } else
			 {
				 if(!JFolder::exists($folderPath)){
					if(mkdir($folderPath, 0777)){
						
					} else {
						echo "Error: Can't create folder for crop image!"; 
					}	
				 
				 }
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
		
		
		
	}
	
		
	
}
?>
