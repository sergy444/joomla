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
// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_coalawebcontact')) {
    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require helper file
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

JLoader::register('CoalawebcontactHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'coalawebcontact.php');

// Load version.php
jimport('joomla.filesystem.file');
$version_php = JPATH_COMPONENT_ADMINISTRATOR . DS . 'version.php';
if (!defined('COM_CWCONTACT_VERSION') && JFile::exists($version_php)) {
    require_once $version_php;
}

$lang = JFactory::getLanguage();
if ($lang->getTag() != 'en-GB') {
    $lang->load('com_coalawebcontact', JPATH_ADMINISTRATOR, 'en-GB');
}
$lang->load('com_coalawebcontact', JPATH_ADMINISTRATOR, null, 1);

// Lets make sure CoalaWeb Gears is loaded
$cwgp = JPluginHelper::getPlugin('system', 'cwgears');
if (!isset($cwgp->name)) {
    JFactory::getApplication()->set('_messageQueue', '');
    $msg = JText::_('COM_CWCONTACT_NOGEARSPLUGIN_GENERAL_MESSAGE');
    JFactory::getApplication()->enqueueMessage($msg, 'notice');
}


require_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'liveupdate' . DS . 'liveupdate.php';
if (JRequest::getCmd('view', '') == 'liveupdate') {
    LiveUpdate::handleRequest();
    return;
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('Coalawebcontact');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
?>
<div class="cw-powerby-back">
    <span class="cw-powerby-back">
        <?php echo JTEXT::_('COM_CWCONTACT_POWEREDBY_MSG'); ?> <a href="http://www.coalaweb.com" target="_blank" title="CoalaWeb">CoalaWeb</a> <?php
        echo JTEXT::_('COM_CWCONTACT_POWEREDBY_VERSION');
        if (COM_CWCONTACT_PRO == 1) {
            echo COM_CWCONTACT_VERSION . ' ' . JTEXT::_('COM_CWCONTACT_POWEREDBY_PRO');
        } else {
            echo COM_CWCONTACT_VERSION;
        }
        ?>
    </span>
</div>
