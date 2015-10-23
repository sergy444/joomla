<?php

/**
 *
 * @package	VirtueMart
 * @subpackage Plugins  - Elements
 * @author Valérie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2011 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: $
 */
 
 // Load the model framework

if (!class_exists('VmConfig'))
    require(JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');

jimport( 'joomla.application.component.model');

if(!class_exists('VmModel'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmmodel.php');

if (!class_exists('ShopFunctions'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'shopfunctions.php');
if (!class_exists('TableCategories'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'tables' . DS . 'categories.php');

if (!class_exists('VmElements'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'elements' . DS . 'vmelements.php');
/*
 * This element is used by the menu manager
 * Should be that way
 */
class VmElementVmCategories extends VmElements {

    var $type = 'vmcategories';

    // This line is required to keep Joomla! 1.6/1.7 from complaining
    function getInput() {		
        $key = ($this->element['key_field'] ? $this->element['key_field'] : 'value');
        $val = ($this->element['value_field'] ? $this->element['value_field'] : $this->name);//var_dump($this->value);die;
        JPlugin::loadLanguage('com_virtuemart', JPATH_ADMINISTRATOR);
		
		//VmConfig::loadConfig();
		if(!is_array($this->value) && $this->value=='') $this->value = array('0'=>"0");		
		$categorylist = self::categoryListTreeLoop($this->value);
		
        //$categorylist = ShopFunctions::categoryListTree($this->value);
        $class = '';
        $html = '<select class="inputbox"   name="' . $this->name . '[]" multiple="multiple" size="10">';
        $html .= '<option value="0">' . JText::_('COM_VIRTUEMART_CATEGORY_FORM_TOP_LEVEL') . '</option>';
        $html .= $categorylist;
        $html .="</select>";
        return $html;
    }

    function fetchElement($name, $value, &$node, $control_name) {
        JPlugin::loadLanguage('com_virtuemart', JPATH_ADMINISTRATOR);
        $categorylist = ShopFunctions::categoryListTree(array($value));

        $class = '';
        $html = '<select class="inputbox"   name="' . $control_name . '[' . $name . '][]' . '" multiple="multiple" size="10">';
        $html .= '<option value="0">' . JText::_('COM_VIRTUEMART_CATEGORY_FORM_TOP_LEVEL') . '</option>';
        $html .= $categorylist;
        $html .="</select>";
        return $html;
    }
	
	/**
	 * Creates structured option fields for all categories
	 *
	 * @todo: Connect to vendor data
	 * @author RolandD, Max Milbers, jseros
	 * @param array 	$selectedCategories All category IDs that will be pre-selected
	 * @param int 		$cid 		Internally used for recursion
	 * @param int 		$level 		Internally used for recursion
	 * @return string 	$category_tree HTML: Category tree list
	 */
	public function categoryListTreeLoop($selectedCategories = array(), $cid = 0, $level = 0, $disabledFields=array()) {

		static $categoryTree = '';

		$virtuemart_vendor_id = 1;

// 		vmSetStartTime('getCategories');
		$categoryModel = self::getModel('category');
		$level++;

		$categoryModel->_noLimit = true;
		$records = $categoryModel->getCategories(true, $cid);
// 		vmTime('getCategories','getCategories');
		$selected="";
		if(!empty($records)){
			foreach ($records as $key => $category) {

				$childId = $category->category_child_id;

				if ($childId != $cid) {
					if(in_array($childId, $selectedCategories)) $selected = 'selected="selected"'; else $selected='';

					$disabled = '';
					if( in_array( $childId, $disabledFields )) {
						$disabled = 'disabled="disabled"';
					}

					if( $disabled != '' && stristr($_SERVER['HTTP_USER_AGENT'], 'msie') ) {
						//IE7 suffers from a bug, which makes disabled option fields selectable
					}
					else{
						$categoryTree .= '<option '. $selected .' '. $disabled .' value="'. $childId .'">'."\n";
						$categoryTree .= str_repeat(' - ', ($level-1) );

						$categoryTree .= $category->category_name .'</option>';
					}
				}

				if($categoryModel->hasChildren($childId)){
					self::categoryListTreeLoop($selectedCategories, $childId, $level, $disabledFields);
				}

			}
		}

		return $categoryTree;
	}
	
	/**
	 * Return model instance. This is a DRY solution!
	 * This is only called within this class
	 *
	 * @author jseros
	 * @access private
	 *
	 * @param string $name Model name
	 * @return JModel Instance any model
	 */
	public function getModel($name = ''){

		$name = strtolower($name);
		$className = ucfirst($name);

		//retrieving model
		if( !class_exists('VirtueMartModel'.$className) ){

			$modelPath = JPATH_VM_ADMINISTRATOR.DS."models".DS.$name.".php";

			if( file_exists($modelPath) ){
				require( $modelPath );
			}
			else{
				JError::raiseWarning( 0, 'Model '. $name .' not found.' );
				echo 'Model '. $name .' not found.';die;
				return false;
			}
		}

		$className = 'VirtueMartModel'.$className;
		//instancing the object
		$model = new $className();

		if(empty($model)){
			JError::raiseWarning( 0, 'Model '. $name .' not created.' );
			echo 'Model '. $name .' not created.';
		}else {
			return $model;
		}

	}			

}

if (version_compare(JVERSION, '1.6.0', 'ge') ) {

    class JFormFieldVmCategories extends VmElementVmCategories {

    }

} else {

    class JElementVmCategories extends VmElementVmCategories {

    }

}