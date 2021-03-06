<?php
/**
*
* Controller for the front end Manufacturerviews
*
* @package	VirtueMart
* @subpackage User
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: manufacturer.php 2420 2010-06-01 21:12:57Z oscar $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
 * VirtueMart Component Controller
 *
 * @package		VirtueMart
 */
class VirtueMartControllerWishlist extends JController
{

	/**
	* Send the ask question email.
	* @author Kohl Patrick, Christopher Roussel
	*/
	public function __construct() {
		parent::__construct();
		
	}
	public function display() {
 		$user = JFactory::getUser();
		if($user->id==0){
		$app =& JFactory::getApplication();
		$this->setRedirect('index.php?option=com_users&view=login&Itemid=497');	
		}
		
		$view = $this->getView('Wishlist', 'html');
		
 
		$view->display();
	}

}

// No closing tag
