<?php
/**
* Mj Slideshow view file
* Author by Dasinfomedia Team.
* @copyright (C) 2013 by Dasinfomedia - All rights reserved!
* @package Mj-Slideshow
* @license GNU/GPL, see LICENSE.php
*/
//No Direct Access to this file
defined('_JEXEC') or die('Restricted Access');

// Select effect of Slideshow

$SelectEffect = $params->get("SelectEffect");
$bgimg=$params->get('slideshow_background');
$url=$params->get('video');

//Button Options

$btntitle = $params->get('btntitle');
$btnhover = $params->get('btnhover');


//get details of Image 1

$img1 = $params->get('image1', "");
$title1 = $params->get('title1');
$title11 = $params->get('title11');
$desc1 = $params->get('desc1');
$link1 = $params->get('link1');

//get details of Image 2

$img2 = $params->get('image2', "");
$title2 = $params->get('title2');
$title22 = $params->get('title22');
$desc2 = $params->get('desc2');
$link2 = $params->get('link2');

//get details of Image 3

$img3 = $params->get('image3', "");
$title3 = $params->get('title3');
$title33 = $params->get('title33');
$desc3 = $params->get('desc3');
$link3 = $params->get('link3');

//get details of Image 4

$img4 = $params->get('image4', "");
$title4 = $params->get('title4');
$title44 = $params->get('title44');
$desc4 = $params->get('desc4');
$link4 = $params->get('link4');

//get details of Image 5

$img5 = $params->get('image5', "");
$title5 = $params->get('title5');
$title55 = $params->get('title55');
$desc5 = $params->get('desc5');
$link5 = $params->get('link5');



require JModuleHelper::getLayoutPath('mod_mj-slideshow');

?>

