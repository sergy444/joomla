<?php
/** 
 * mod_contactus_copyright file for contact Module 
 * @package    Getshopped
 * @subpackage Module
 * @author Das Infomedia.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 // no direct access
ini_set("display_errors","0");  
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
 if ($params->def('prepare_content', 1))
	{
		JPluginHelper::importPlugin('content');
		$module->content = JHtml::_('content.prepare', $module->content, '', 'mod_custom.content');
	}
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
	
	$app = JFactory::getApplication();
	$template   = $app->getTemplate(true);
	$params     = $template->params;
	
	$social = $params->get('social');
	
	 $twitter=$params->get('nav_twitter_sw');
	 $facebook=$params->get('nav_facebook_sw');
	 $google=$params->get('nav_google_sw');
	 $youtube=$params->get('nav_youtube_sw');
	 
	 $twi=$params->get('nav_twitter');
	 $fb=$params->get('nav_facebook');
	 $go=$params->get('nav_google');
	 $you=$params->get('nav_youtube');
	 
	 $copyright=$params->get('copyright');
require( JModuleHelper::getLayoutPath( 'mod_contactus_copyright' ) );
