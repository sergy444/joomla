<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

?>

<fieldset id="users-profile-core">
	<legend>
		<?php echo JText::_('COM_USERS_PROFILE_CORE_LEGEND'); ?>
	</legend>
	
     <div class="row">
	 <div class="col-md-6">
	 <div class="item_left">
        <div class="form-group">
		<label>
			<?php echo JText::_('COM_USERS_PROFILE_NAME_LABEL'); ?>
		</label>
		<dd>
			<?php echo $this->data->name; ?>
		</dd>
        </div>
         <div class="form-group">
		<label>
			<?php echo JText::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?>
		</label>
		<dd>
			<?php echo htmlspecialchars($this->data->username); ?>
		</dd>
        </div>
         <div class="form-group">
		<label>
			<?php echo JText::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?>
		</label>
		<dd>
			<?php echo JHtml::_('date', $this->data->registerDate); ?>
		</dd>
        </div>
         <div class="form-group">
		<label>
			<?php echo JText::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?>
		</label>

		<?php if ($this->data->lastvisitDate != '0000-00-00 00:00:00'){?>
			<dd>
				<?php echo JHtml::_('date', $this->data->lastvisitDate); ?>
			</dd>
            </div>
		<?php }
		else {?>
			<dd>
				<?php echo JText::_('COM_USERS_PROFILE_NEVER_VISITED'); ?>
			</dd>
            </div>
		<?php } ?>

	</div>
     </div>
     </div>
     </div>
</fieldset>
