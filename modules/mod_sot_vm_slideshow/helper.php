<?php 
/*------------------------------------------------------------------------
 # Sot K2 Slideshow Pro  - Version 1.0
 # Copyright (C) 2010-2011 Sky Of Tech. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: Sky Of Tech
 # Websites: http://skyoftech.com
 -------------------------------------------------------------------------*/
 
defined('_JEXEC') or die('Restricted access');

if (! class_exists("modVMHelper") ) { 
require_once (dirname(__FILE__) .DS. 'libs' .DS.'vm' .DS.'SotVm.php');

class modVMHelper {
	var $module_name = '';
	function excute($params, $module) {
		$enable_cache 		=   $params->get('cache',1);
		$cachetime			=   $params->get('cache_time',0);
		$this->module_name = $module->module;
		
		if($enable_cache==1) {		
		$conf =& JFactory::getConfig();
			$cache = &JFactory::getCache($module->module);
			$cache->setLifeTime( $params->get( 'cache_time', $conf->getValue( 'config.cachetime' ) * 60 ) );
			$cache->setCaching(true);
			$items =  $cache->get( array('modVMHelper', 'getProducts'), array($params, $module));
		} else {
			$items = modVMHelper::getProducts($params, $module);
		}		
		return $items;			
	}
	
	function getProducts($params, $module) {				
       	$sotvm = new Sotvm(); 
		$sotvm->show_addtocart      =  	$params->get('show_addtocart', 1);
		$sotvm->show_price          =  	$params->get('show_price', 1);
		$sotvm->category_id         =  	$params->get('virtuemart_category_id', 0 );
		$sotvm->NumberOfProducts    =  	$params->get('NumberOfProducts', $sotvm->NumberOfProducts);
		$sotvm->featuredProducts	= 	$params->get('featuredProducts', $sotvm->featuredProducts);	
		$sotvm->ShowProductsInStock	= 	$params->get('ShowProductsInStock', $sotvm->ShowProductsInStock);	
		$sotvm->SortMethod			=  	$params->get('SortMethod', $sotvm->SortMethod);
		
		$sotvm->source				=	$params->get('source', $sotvm->source);	
		$sotvm->specific_product_ids=	$params->get('specific_product_ids', $sotvm->specific_product_ids);
					
		$sotvm->thumb_height 		= $params->get('thumb_height', "700px");
        $sotvm->thumb_width 		= $params->get('thumb_width', "400px");        
        $sotvm->small_thumb_height 	= $params->get('small_thumb_height', "70px");
        $sotvm->small_thumb_width 	= $params->get('small_thumb_width', "40px");
		
        $sotvm->web_url 			= JURI::base();
        $sotvm->max_title        	= $params->get('limittitle',25);
        $sotvm->max_description     = $params->get('limit_description',200);
		$sotvm->max_short_desc      = $params->get('limit_short_description',100); 
        
        $sotvm->resize_folder 		= JPATH_CACHE.DS. $module->module .DS."images".DS."resize";
		$sotvm->crop_folder 		= JPATH_CACHE.DS. $module->module .DS."images".DS."crop";
        $sotvm->url_to_resize 		= $sotvm->web_url . "cache/". $module->module ."/images/resize/";
		$sotvm->url_to_crop 		= $sotvm->web_url . "cache/". $module->module ."/images/crop/";
        $sotvm->cropresizeimage 	= $params->get('cropresizeimage', 1);              		
		$items = $sotvm->getItems($params);				
		return $items;
	}
}
			
}
if(!class_exists('Browser')){
	class Browser
	{
		private $props    = array("Version" => "0.0.0",
									"Name" => "unknown",
									"Agent" => "unknown") ;
	
		public function __Construct()
		{
			$browsers = array("firefox", "msie", "opera", "chrome", "safari",
								"mozilla", "seamonkey",    "konqueror", "netscape",
								"gecko", "navigator", "mosaic", "lynx", "amaya",
								"omniweb", "avant", "camino", "flock", "aol");
	
			$this->Agent = strtolower($_SERVER['HTTP_USER_AGENT']);
			foreach($browsers as $browser)
			{
				if (preg_match("#($browser)[/ ]?([0-9.]*)#", $this->Agent, $match))
				{
					$this->Name = $match[1] ;
					$this->Version = $match[2] ;
					break ;
				}
			}
		}
	
		public function __Get($name)
		{
			if (!array_key_exists($name, $this->props))
			{
				die("No such property or function {$name}");
			}
			return $this->props[$name] ;
		}
	
		public function __Set($name, $val)
		{
			if (!array_key_exists($name, $this->props))
			{
				SimpleError("No such property or function.", "Failed to set $name", $this->props);
				die;
			}
			$this->props[$name] = $val ;
		}
	
	} 
}	
?>