<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
?>
<div class="profile<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
<div class="section-title text-center">
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
</div>
<?php endif; ?>

<?php echo $this->loadTemplate('core'); ?>

<?php echo $this->loadTemplate('params'); ?>

<?php echo $this->loadTemplate('custom'); ?>
<div class="mybutton medium">
<?php if (JFactory::getUser()->id == $this->data->id) : ?>
<a href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id='.(int) $this->data->id);?>">
	<span data-hover="<?php echo JText::_('COM_USERS_Edit_Profile'); ?>"><?php echo JText::_('COM_USERS_Edit_Profile'); ?></span></a>
<?php endif; ?>
</div>
</div>