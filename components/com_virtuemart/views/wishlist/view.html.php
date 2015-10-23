<?php
/**
 *
 * Description
 *
 * @package	VirtueMart
 * @subpackage
 * @author
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2011 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 6564 2012-10-19 11:45:27Z kkmediaproduction $
 */

# Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

# Load the view framework
if(!class_exists('VmView'))require(JPATH_VM_SITE.DS.'helpers'.DS.'vmview.php');

/**
 * Default HTML View class for the VirtueMart Component
 * @todo Find out how to use the front-end models instead of the backend models
 */
class VirtueMartViewWishlist extends VmView {

	public function display($tpl = null) {
		$user =& JFactory::getUser();
		$db =& JFactory::getDBO();
		//echo $sql="SELECT a.virtuemart_wishlist_id,a.virtuemart_product_id,a.virtuemart_product_qty FROM #__virtuemart_wishlist WHERE userid=".$user->id;
		/*$sql="SELECT 	a.virtuemart_wishlist_id,a.virtuemart_product_id,a.virtuemart_product_qty,
						b.product_s_desc,b.product_name,b.slug,
						c.virtuemart_category_id,
						d.virtuemart_media_id,
						e.file_url
				FROM 	#__virtuemart_wishlist as a,#__virtuemart_products_en_gb as b,#__virtuemart_product_categories as c,
						#__virtuemart_product_medias as d,#__virtuemart_medias as e
				WHERE 	a.userid=".$user->id." 
							AND b.virtuemart_product_id=a.virtuemart_product_id 
							AND c.virtuemart_product_id=a.virtuemart_product_id 
							AND d.virtuemart_product_id=a.virtuemart_product_id 
							AND	d.virtuemart_media_id=e.virtuemart_media_id
				GROUP BY a.virtuemart_product_id
				ORDER BY a.wishlist_date DESC";*/
		$sql="SELECT virtuemart_wishlist_id,virtuemart_product_id FROM #__virtuemart_wishlist WHERE userid=".$user->id;
		$db->setQuery($sql);
		$productids = $db->loadObjectList();
		//print_r($wishlist);
		$listpid=array();
		foreach($productids as $pid)
		{
			$listpid[]=$pid->virtuemart_product_id;
			$wids[]=$pid->virtuemart_wishlist_id;
		}
		if(count($listpid)==0){
			$valid=0;
			 $this->assignRef('valid',$valid);
			//$app =& JFactory::getApplication();
			//$app->enqueueMessage('Your Wishlist is Empty Please Add any product to Wishlist', 'error');
			//$app->redirect('index.php');		
			//exit;
		}else{
			$valid=1;
			 $this->assignRef('valid',$valid);
		$this->assignRef('wids', $wids);
		$productModel = VmModel::getModel('product');
		$products=$productModel->getProducts($listpid);
		//echo "<pre>";
		//print_r($wishlist);
		//exit;
		$productModel->addImages($products,1);

	    $this->assignRef('products', $products);
		foreach($products as $product){
              $product->stock = $productModel->getStockIndicator($product);
         }
		
		$show_prices  = VmConfig::get('show_prices',1);
		if($show_prices == '1'){
			if(!class_exists('calculationHelper')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'calculationh.php');
		}
		$this->assignRef('show_prices', $show_prices);
		if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
		$showBasePrice = Permissions::getInstance()->check('admin'); //todo add config settings
		$this->assignRef('showBasePrice', $showBasePrice);
		$currency = CurrencyDisplay::getInstance( );
		$this->assignRef('currency', $currency);
		
	    $pagination = $productModel->getPagination(3);
	    $this->assignRef('vmPagination', $pagination);
		

		}
		
		parent::display($tpl);

	}
}
# pure php no closing tag