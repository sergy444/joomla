<?php
defined('_JEXEC') or die('Restricted access');

/**
 * @package             Joomla
 * @subpackage          CoalaWeb Contact Component
 * @author              Steven Palmer
 * @author url          http://coalaweb.com
 * @author email        support@coalaweb.com
 * @license             GNU/GPL, see /assets/en-GB.license.txt
 * @copyright           Copyright (c) 2013 Steven Palmer All rights reserved.
 *
 * CoalaWeb Contact is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
$user = JFactory::getUser();
?>
<?php if ($this->needsdlid): ?>
    <?php echo JText::_('COM_CWCONTACT_NODOWNLOADID_GENERAL_MESSAGE'); ?>
<?php endif; ?>

<div id="cpanel" style="float:left;width:58%;">

    <div style="float:left;">    
        <?php echo LiveUpdate::getIcon(); ?>
    </div>

    <div style="float:left;">
        <div class="icon">
            <a onclick="Joomla.popupWindow('http://coalaweb.com/support-menu/documentation/item/coalaweb-contact-guide', 'Help', 700, 500, 1);" href="#">
                <img alt="<?php echo JText::_('COM_CWCONTACT_TITLE_HELP'); ?>" src="<?php echo JURI::root() ?>/media/coalaweb/components/generic/images/icons/icon-48-cw-support.png" />
                <span><?php echo JText::_('COM_CWCONTACT_TITLE_HELP'); ?></span>
            </a>
        </div>
    </div>

    <div style="float:left;">
        <div class="icon">
            <?php if (version_compare(JVERSION, '3.0', '>')) { ?>
                <a href="index.php?option=com_config&view=component&component=com_coalawebcontact">
                    <img alt="<?php echo JText::_('COM_CWCONTACT_TITLE_OPTIONS'); ?>" src="<?php echo JURI::root() ?>/media/coalaweb/components/generic/images/icons/icon-48-cw-options.png" />
                    <span><?php echo JText::_('COM_CWCONTACT_TITLE_OPTIONS'); ?></span>
                </a>
            <?php } else { ?>
                <a class="modal" rel="{handler: 'iframe', size: {x: 875, y: 550}, onClose: function() {}}" href="index.php?option=com_config&view=component&component=com_coalawebcontact&path=&tmpl=component">
                    <img alt="<?php echo JText::_('COM_CWCONTACT_TITLE_OPTIONS'); ?>" src="<?php echo JURI::root() ?>/media/coalaweb/components/generic/images/icons/icon-48-cw-options.png" />
                    <span><?php echo JText::_('COM_CWCONTACT_TITLE_OPTIONS'); ?></span>
                </a>
            <?php } ?>
        </div>
    </div>
<?php if (!$this->isPro): ?>
    <div style="float:left;">
        <div class="icon">
            <a onclick="Joomla.popupWindow('http://coalaweb.com/go-contact-pro/levels', 'Help', 700, 500, 1)" href="#">
                <img alt="<?php echo JText::_('COM_CWCONTACT_TITLE_UPGRADE'); ?>" src="<?php echo JURI::root() ?>/media/coalaweb/components/generic/images/icons/icon-48-cw-upgrade.png" />
                <span><?php echo JText::_('COM_CWCONTACT_TITLE_UPGRADE'); ?></span>
            </a>
        </div>
    </div>
<?php endif; ?>

    <div class="clr"></div>
</div>
<div id="tabs" style="float:right; width:40%;">

    <?php
    $options = array(
        'onActive' => 'function(title, description){
        description.setStyle("display", "block");
        title.addClass("open").removeClass("closed");
    }',
        'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',
        'startOffset' => 0, // 0 starts on the first tab, 1 starts the second, etc...
        'useCookie' => true, // this must not be a string. Don't use quotes.
        'startTransition' => 1,
    );
    ?>

    <?php echo JHtml::_('sliders.start', 'slider_group_id', $options); ?>



    <?php echo JHtml::_('sliders.panel', JText::_('COM_CWCONTACT_SLIDER_TITLE_ABOUT'), 'slider_1_id'); ?>
    <div class="cw-slider">
        <?php if ($this->isPro): ?>
            <h1><?php echo JText::_('COM_CWCONTACT_TITLE_PRO'); ?></h1>
            <?php echo JText::_('COM_CWCONTACT_ABOUT_DESCRIPTION'); ?>
        <?php else : ?>
            <h1><?php echo JText::_('COM_CWCONTACT_TITLE_CORE'); ?></h1>
            <?php echo JText::_('COM_CWCONTACT_ABOUT_DESCRIPTION'); ?>
        <?php endif; ?>
    </div>

    <?php echo JHtml::_('sliders.panel', JText::_('COM_CWCONTACT_SLIDER_TITLE_SUPPORT'), 'slider_2_id'); ?>
    <div class="cw-slider">
        <?php echo JText::_('COM_CWCONTACT_SUPPORT_DESCRIPTION'); ?>
    </div>
    
    <?php echo JHtml::_('sliders.panel', JText::_('COM_CWCONTACT_SLIDER_TITLE_VERSION'), 'slider_3_id'); ?>
    <?php
        $version = (COM_CWCONTACT_VERSION);
        $date = (COM_CWCONTACT_DATE);
        $ispro = (COM_CWCONTACT_PRO);
        $type = ($ispro == 1 ? JText::_('COM_CWCONTACT_RELEASE_TYPE_PRO') : JText::_('COM_CWCONTACT_RELEASE_TYPE_CORE'));
    ?>
    <div class="cw-slider">
        <?php if (!$this->isPro): ?>
        <div class="cw-message-block">
            <div class="cw-message">
                <p class="upgrade"><?php echo JText::_('COM_CWONTACT_MSG_UPGRADE'); ?></p>
            </div>
        </div>
        <?php endif; ?>
        <div class="cw-module">
            <h3> <?php echo JText::_('COM_CWCONTACT_RELEASE_TITLE'); ?> </h3>
            <ul class="cw_module">
                <li>  <?php echo JText::_('COM_CWCONTACT_FIELD_RELEASE_TYPE_LABEL'); ?>  <strong><?php echo $type; ?> </strong></li>
                <li>   <?php echo JText::_('COM_CWCONTACT_FIELD_RELEASE_VERSION_LABEL'); ?> <strong> <?php echo $version?> </strong></li>
                <li>  <?php echo JText::_('COM_CWCONTACT_FIELD_RELEASE_DATE_LABEL'); ?>  <strong> <?php echo $date; ?>  </strong></li>
            </ul>
        </div>
    </div>

    <?php echo JHtml::_('sliders.end'); ?>       
</div>
<div class="clr"></div>








