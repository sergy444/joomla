<?php
/*
* @package Alpine
* @copyright (C) 2014 by mojoomla.com - All rights reserved!
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author mojoomla.com <sales@mojoomla.com>
*/

?>
<?php
defined( '_JEXEC' ) or die( 'Restricted index access' );
$path = $this->baseurl.'/templates/'.$this->template;
$app = JFactory::getApplication();

//factory
$document = JFactory::getDocument();

//General
$app->getCfg('sitename');
$siteName = $this->params->get('siteName');
$templateparams	= $app->getTemplate(true)->params;

//Logo Options

$logo = $this->params->get('logoFile');

//Color Options

//Social Media Options

$social = $this->params->get('social');
$_SESSION['social']=$social;


//Font Options

 $body_fontsize = $this->params->get('body_fontsize');
 $body_fontstyle = $this->params->get('body_fontstyle');

//RTL Options

$rtl_onoff = $this->params->get('rtl_onoff');
$_SESSION['rtl_onoff']=$rtl_onoff;

?>