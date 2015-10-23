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
class VirtueMartViewCompare extends VmView {

	public function display($tpl = null) {
		$user =& JFactory::getUser();
		$db =& JFactory::getDBO();
		
		
		$session = JFactory::getSession();
		$cmp = $session->get('compare','');
		
		$listpid = explode(",",$cmp);
		if(empty($cmp)){
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
		
		/*** rating ***/
		$ratingModel = VmModel::getModel('ratings');
		
		$showRating = $ratingModel->showRating($product->virtuemart_product_id);
		$this->assignRef('showRating', $showRating);

		if ($showRating) {
			$vote = $ratingModel->getVoteByProduct($product->virtuemart_product_id);
			$this->assignRef('vote', $vote);
		
			$rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
			$this->assignRef('rating', $rating);
			}

	

      }
		
		parent::display($tpl);

	}
}
# pure php no closing tag