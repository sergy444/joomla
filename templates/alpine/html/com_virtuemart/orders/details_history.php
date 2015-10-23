<?php
/**
*
* Order history view
*
* @package	VirtueMart
* @subpackage Orders
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: details_history.php 4252 2011-10-04 21:36:23Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<table id="my-orders-table" class="adminlist data-table" width="100%" cellspacing="2" cellpadding="4" border="0">
   <thead>
    <tr class="for-mobile first">
      <th class="last" colspan="3">Order history</th>
   </tr>
	<tr align="left" class="sectiontableheader for-desktop last">
		<th align="left" ><?php echo JText::_('COM_VIRTUEMART_DATE') ?></th>
		<th align="left" ><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PO_STATUS') ?></th>
		<th align="left" ><?php echo JText::_('COM_VIRTUEMART_ORDER_COMMENT') ?></th>
	</tr>
    </thead>
<?php
	foreach($this->orderdetails['history'] as $_hist) {
		if (!$_hist->customer_notified) {
			continue;
		}
?>    
       <tbody>
		<tr valign="top" class="for-desktop first">
			<td align="left">
				<?php echo vmJsApi::date($_hist->created_on,'LC2',true); ?>
			</td>
			<td align="left" >
				<?php echo $this->orderstatuses[$_hist->order_status_code]; ?>
			</td>
			<td align="left" >
				<?php echo $_hist->comments; ?>
			</td>
		</tr>
        
        <tr class="for-mobile last"> 
           <td class="last" colspan="3">
              <div>
                <span class="label"><?php echo JText::_('COM_VIRTUEMART_DATE') ?> :</span>
                 <?php echo vmJsApi::date($_hist->created_on,'LC2',true); ?>
              </div>
              
              <div>
                <span class="label"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PO_STATUS') ?> :</span>
                 <?php echo $this->orderstatuses[$_hist->order_status_code];?>
              </div>
              
              <div>
                <span class="label"><?php echo JText::_('COM_VIRTUEMART_ORDER_COMMENT') ?> :</span>
                <?php echo $_hist->comments; ?>
              </div>
           </td>
        </tr>
        </tbody>
<?php
	}
?>
</table>
