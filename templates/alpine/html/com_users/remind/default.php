<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
 

<div class="remind<?php echo $this->pageclass_sfx?>">
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
	<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=remind.remind'); ?>" method="post" class="form-validate">
     
      <div class="form-respond text-center"></div>
          <div class="row">
		    <div class="col-md-6">
		 <div class="item_top">
		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
		<p><?php echo JText::_($fieldset->label); ?></p>		<fieldset>
			<dl>
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field): ?>
			<div class="form-group">	<dt><?php echo $field->label; ?></dt>
				<dd><?php echo $field->input; ?></dd> </div>
			<?php endforeach; ?>
			</dl>
		</fieldset>
		<?php endforeach; ?>
        </div>
        </div>
        </div>
		
        <div class="row">
            <div class="col-md-6">
            <div class="action form-button medium">

			<div class="mybutton medium">
			<button type="submit" class="validate item_left"><span data-hover="<?php echo JText::_('JSUBMIT'); ?>"><?php echo JText::_('JSUBMIT'); ?></span></button>
			<?php echo JHtml::_('form.token'); ?>
		</div>
        </div>
        </div>
        </div>
	</form>
    </div>
</div>


