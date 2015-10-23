<?php
/** 
 * mod_client_parallax file for contact Module 
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
	
	$app        = JFactory::getApplication();
	$template   = $app->getTemplate(true);
	$params     = $template->params;
	
$p5title1=$params->get('p5title1');
$p5title2=$params->get('p5title2');

$p5img1=$params->get('p5img1');
$p5link1=$params->get('p5link1');
$p5img2=$params->get('p5img2');
$p5link2=$params->get('p5link2');
$p5img3=$params->get('p5img3');
$p5link3=$params->get('p5link3');
$p5img4=$params->get('p5img4');
$p5link4=$params->get('p5link4');
$p5img5=$params->get('p5img5');
$p5link5=$params->get('p5link5');
$p5img6=$params->get('p5img6');
$p5link6=$params->get('p5link6');	

$p5bg=$params->get('p5bg');	

require( JModuleHelper::getLayoutPath( 'mod_client_parallax' ) );
