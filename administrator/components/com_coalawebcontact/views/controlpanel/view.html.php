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
jimport('joomla.application.component.view');

class CoalawebcontactViewControlpanel extends JViewLegacy {

    function display($tpl = null) {

        $canDo = CoalawebcontactHelper::getActions();
        $model = $this->getModel();

        if (version_compare(JVERSION, '3.0', '>')) {
            CoalawebcontactHelper::addSubmenu('controlpanel');
        }

        // Is this the Professional release?
        jimport('joomla.filesystem.file');
        $isPro = (COM_CWCONTACT_PRO == 1);
        $this->assign('isPro', $isPro);

        $version = (COM_CWCONTACT_VERSION);
        $this->assign('version', $version);

        $releaseDate = (COM_CWCONTACT_DATE);
        $this->assign('release_date', $releaseDate);

        $needsDlid = $model->needsDownloadID();
        $this->assign('needsdlid', $needsDlid);

        if (COM_CWCONTACT_PRO == 1) {
            JToolBarHelper::title(JText::_('COM_CWCONTACT_TITLE_PRO') . ' [ ' . JText::_('COM_CWCONTACT_TITLE_CPANEL') . ' ]', 'cw-cpanel');
        } else {
            JToolBarHelper::title(JText::_('COM_CWCONTACT_TITLE_CORE') . ' [ ' . JText::_('COM_CWCONTACT_TITLE_CPANEL') . ' ]', 'cw-cpanel');
        }
        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_coalawebcontact');
        }

        $help_url = 'http://coalaweb.com/support-menu/documentation/item/coalaweb-contact-guide';
        JToolBarHelper::help('COM_CWCONTACT_TITLE_HELP', false, $help_url);

        parent::display($tpl);
    }

}
