<?php

/**
 * @package LiveUpdate
 * @copyright Copyright ©2011 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU LGPLv3 or later <http://www.gnu.org/copyleft/lesser.html>
 */
defined('_JEXEC') or die();

/**
 * Configuration class for your extension's updates.
 */
class LiveUpdateConfig extends LiveUpdateAbstractConfig {

    var $_extensionName = 'com_coalawebcontact';
    var $_versionStrategy = 'different';

    public function __construct() {
        jimport('joomla.filesystem.file');
        // Require helper file
        if (!defined('DS'))
            define('DS', DIRECTORY_SEPARATOR);
        $version_php = JPATH_COMPONENT_ADMINISTRATOR . DS . 'version.php';
        if (!defined('COM_CWCONTACT_VERSION') && JFile::exists($version_php)) {
            require_once $version_php;
        }

        $isPro = (COM_CWCONTACT_PRO == 1);

        // Load the component parameters, not using JComponentHelper to avoid conflicts ;)
        jimport('joomla.html.parameter');
        jimport('joomla.application.component.helper');
        $db = JFactory::getDbo();
        $sql = $db->getQuery(true)
                ->select($db->quoteName('params'))
                ->from($db->quoteName('#__extensions'))
                ->where($db->quoteName('type') . ' = ' . $db->quote('component'))
                ->where($db->quoteName('element') . ' = ' . $db->quote('com_coalawebcontact'));
        $db->setQuery($sql);
        $rawparams = $db->loadResult();
        $params = new JRegistry();
        if (version_compare(JVERSION, '3.0', 'ge')) {
            $params->loadString($rawparams, 'JSON');
        } else {
            $params->loadJSON($rawparams);
        }

        // Determine the appropriate update URL based on whether we're on Core or Professional edition
        if ($isPro) {
            $this->_updateURL = 'https://coalaweb.com/index.php?option=com_ars&view=update&format=ini&id=12';
            $this->_extensionTitle = 'CoalaWeb Contact Pro';
        } else {
            $this->_updateURL = 'https://coalaweb.com/index.php?option=com_ars&view=update&format=ini&id=11';
            $this->_extensionTitle = 'CoalaWeb Contact Core';
        }

        // Get the minimum stability level for updates
        $this->_minStability = 'beta';

        // Do we need authorized URLs?
        $this->_requiresAuthorization = $isPro;

        // Should I use our private CA store?
        if (@file_exists(dirname(__FILE__) . '/../assets/cacert.pem')) {
            $this->_cacerts = dirname(__FILE__) . '/../assets/cacert.pem';
        }

        parent::__construct();
    }

}