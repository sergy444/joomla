<?php

/**
 *
 * Modify user form view, User info
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk, Eugen Stranz
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit_address_userfields.php 6349 2012-08-14 16:56:24Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<style type="text/css">
.adminForm input
 {
    border: 1px solid #DEDEDE;
    color: #595959;
    padding: 10px 4%;
    width: 80%;
 }
.adminForm input:hover
 {
  background:none!important;
 }
.adminForm input:focus {
    border-color: hsl(0, 0%, 69%);
}
table.user-details {
    margin-top: 20px!important;
    width: 50%;
}
.adminForm label
 {
    text-transform: uppercase;
    font-family: 'Raleway',sans-serif;
	 display: inline-block;
    font-weight: bold;
    margin-bottom: 5px;
 }
</style>
<?php 

// Status Of Delimiter
$closeDelimiter = false;
$openTable = true;
$hiddenFields = '';

// Output: Userfields
foreach($this->userFields['fields'] as $field) {

	if($field['type'] == 'delimiter') {

		// For Every New Delimiter
		// We need to close the previous
		// table and delimiter
		if($closeDelimiter) { ?>
			</table>
		
		<?php
		$closeDelimiter = false;
		} //else {
			?>
			

			<?php
			$closeDelimiter = true;
			$openTable = true;
		//}
	} elseif ($field['hidden'] == true) {

		// We collect all hidden fields
		// and output them at the end
		$hiddenFields .= $field['formcode'] . "\n";

	} else {

		// If we have a new delimiter
		// we have to start a new table
		if($openTable) {
			$openTable = false;
			?>

			<table  class="adminForm user-details accnt_detail"> 

		<?php
		}

		// Output: Userfields
		?>
				<tr>
					<td class="key" title="<?php echo $field['description'] ?>" >
                    
						<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
							<?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
						</label>
					</td>
					<td>
						<?php echo $field['formcode'] ?>
					</td>
				</tr>
	<?php
	}

}

// At the end we have to close the current
// table and delimiter ?>

			</table>
		</fieldset>

<?php // Output: Hidden Fields
echo $hiddenFields
?>