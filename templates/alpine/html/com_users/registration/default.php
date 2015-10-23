<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<div class="registration<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="section-title text-center">
    <div>
						<span class="line big"></span>
						<span>Pure creativity</span>
						<span class="line big"></span>
					</div>
    <h1 class="item_right">
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
    <div>
						<span class="line"></span>
						<span>We create new Layout</span>
						<span class="line"></span>
					</div>
    </div>
<?php endif; ?>

   <div class="element-line">
	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
    
     <div class="form-respond text-center"></div>
    <div class="row">
     <div class="col-md-6">
	 <div class="item_top">
     
<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
	<?php $fields = $this->form->getFieldset($fieldset->name);?>
	<?php if (count($fields)):?>
		<fieldset>
		<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
		?>
			
		<?php endif;?>
			<dl>
		<?php foreach($fields as $field):// Iterate through the fields in the set and display them.?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
            <div class="form-group">
				<dt>
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type!='Spacer'): ?>
						<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
					<?php endif; ?>
				</dt>
				<dd><?php echo ($field->type!='Spacer') ? $field->input : "&#160;"; ?></dd>
            </div>
			<?php endif;?>
		<?php endforeach;?>
			</dl>
		</fieldset>
	<?php endif;?>
<?php endforeach;?>
</div>

</div>
</div>
    <div class="row">
    <div class="col-md-6">
    <div class="action form-button medium">
    <div class="mybutton medium">
			<button type="submit" class="validate item_left"><span data-hover="<?php echo JText::_('JREGISTER');?>"><?php echo JText::_('JREGISTER');?></span></button>
			<?php /*?><?php echo JText::_('COM_USERS_OR');?><?php */?>
			<a href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><div class="mybutton medium item_right"><span data-hover="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></span></div></a>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<?php echo JHtml::_('form.token');?>
     </div>
     </div>
     </div>
     </div>
	</form>
    </div>

