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
jimport('joomla.application.component.model');

class CoalawebcontactModelControlpanel extends JModelLegacy {

    public function needsDownloadID() {
        // Do I need a Download ID?
        $ret = true;
        $isPro = (COM_CWCONTACT_PRO == 1);
        if (!$isPro) {
            $ret = false;
        } else {
            jimport('joomla.application.component.helper');
            $componentParams = JComponentHelper::getParams('com_coalawebcontact');
            $dlid = $componentParams->get('downloadid');
            if (preg_match('/^([0-9]{1,}:)?[0-9a-f]{32}$/i', $dlid)) {
                $ret = false;
            }
        }

        return $ret;
    }

}
