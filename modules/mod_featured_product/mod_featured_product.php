<?php
/**
 * Hello World! Module Entry Point
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
ini_set("display_errors","1"); 
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
vmJsApi::jQuery();
vmJsApi::cssSite();
	$product_model = VmModel::getModel('product');

              
		$query = "SELECT a.virtuemart_product_id, a.product_name, b.virtuemart_media_id, c.file_url, f.virtuemart_category_id, h.currency_symbol
FROM #__virtuemart_products_en_gb AS a, #__virtuemart_product_medias AS b, #__virtuemart_medias AS c, #__virtuemart_rating_reviews AS d, #__virtuemart_product_prices AS e, #__virtuemart_product_categories AS f, #__virtuemart_product_prices AS g, #__virtuemart_currencies AS h,#__virtuemart_products as i
WHERE a.virtuemart_product_id = b.virtuemart_product_id
AND c.virtuemart_media_id = b.virtuemart_media_id
AND a.virtuemart_product_id = f.virtuemart_product_id
AND a.virtuemart_product_id = g.virtuemart_product_id
AND g.product_currency = h.virtuemart_currency_id
AND a.virtuemart_product_id = i.virtuemart_product_id
AND i.published=1 AND i.product_special='1'
GROUP BY a.virtuemart_product_id DESC";	
  
			$db = JFactory::getDbo();  
			$db->setQuery($query);
			if ($db->getErrorNum()) {
			  echo $db->getErrorMsg();
			  exit;
			}
			//$product = $db->loadObjectList();
           $rpids=array();
	$rproducts = $db->loadObjectList();
	foreach($rproducts as $rprd)
	{
		$rpids[]=$rprd->virtuemart_product_id;
	}
	
	require_once(JPATH_VM_ADMINISTRATOR . DS . 'helpers' .DS. 'image.php');
	$obj = new VmImage();
	//Load helpers
	$recent_product=$product_model->getProducts($rpids);
	$product_model->addImages($recent_product,1);
	$show_prices  = VmConfig::get('show_prices',1);
		if($show_prices == '1'){
			if(!class_exists('calculationHelper')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'calculationh.php');
			
		}
		
		vmJsApi::jPrice();
		
		if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
		$showBasePrice = Permissions::getInstance()->check('admin'); //todo add config settings
		
		
	if ($recent_product) {
		$currency = CurrencyDisplay::getInstance( );
		}
		$ratingModel = VmModel::getModel('ratings');
		$showRating = $ratingModel->showRating();
		 $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);
	$tot_prd = count($rpids);	
			
			
require( JModuleHelper::getLayoutPath( 'mod_featured_product' ) );
?>