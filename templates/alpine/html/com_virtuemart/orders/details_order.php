<?php
/** 
 * details_orders file view orders in com_virtuemart for Template
 * @package    Getshopped
 * @subpackage Template
 * @author Das Infomedia.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 // no direct access
defined('_JEXEC') or die('Restricted access');
?>
   <p class="order-date"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PO_DATE') ?> : <?php echo vmJsApi::date($this->orderdetails['details']['BT']->created_on, 'LC4', true); ?>
   </p>
   
   <div class="col2-set order-info-box">
         <div class="col-md-6">
      <div class="box">
        <div class="box-title">
         <h3><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIP_TO_LBL') ?></h3>
         </div> 
      <table class="detail_order_table" border="0">
        <?php
	    foreach ($this->shipmentfields['fields'] as $field) {
		if (!empty($field['value'])) {
		    echo '<tr><td class="key">' . $field['title'] . '</td>'
		    . '<td>' . $field['value'] . '</td></tr>';
		}
	    }
	    ?>
      </table>
      </div>
        </div>
       
       	 <div class="col-md-6 last">
      		<div class="box box-payment">
         		<div class="box-title">
         			<h3><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPMENT_LBL') ?></h3>
         		</div> 
         
          	<div class="box-content">
           		<p><?php echo $this->shipment_name;?></p>
	           
          	</div>
      	</div>
     </div> 
  </div>
  
     <div class="col2-set order-info-box">
     <div class="col-md-6">
      <div class="box">
        <div class="box-title">
         <h3><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_BILL_TO_LBL') ?></h3>
         </div> 
          <table class="detail_order_table" border="0">
            <?php
            foreach ($this->userfields['fields'] as $field) {
            if (!empty($field['value'])) {
                echo '<tr><td class="key">' . $field['title'] . '</td>'
                . '<td>' . $field['value'] . '</td></tr>';
            }
            }
            ?>
          </table>
         </div>
        </div>
        
     <div class="col-md-6 last">
      <div class="box box-payment">
         <div class="box-title">
         <h3><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PAYMENT_LBL') ?></h3>
         </div> 
         
          <div class="box-content">
           <p><?php echo $this->payment_name; ?></p>
          </div>
      </div>
     </div>   
        
      </div> 
     
      
     
