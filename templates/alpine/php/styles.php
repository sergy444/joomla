<?php
/*
* @package Alpine
* @copyright (C) 2014 by mojoomla.com - All rights reserved!
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author mojoomla.com <sales@mojoomla.com>
*/
?>
<?php
defined( '_JEXEC' ) or die( 'Restricted index access' );?>   
<link rel="stylesheet" href="templates/system/css/system.css" type="text/css"  />
<?php if(($body_fontstyle == "Arial, Helvetica, sans-serif") || ($body_fontstyle == "Courier, monospace") || ($body_fontstyle == "Tahoma, Geneva, sans-serif") || ($body_fontstyle == "Garamond, serif") || ($body_fontstyle == "Georgia, serif") || ($body_fontstyle == "Impact, Charcoal, sans-serif") || ($body_fontstyle == "Lucida Console, Monaco, monospace") || ($body_fontstyle == "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($body_fontstyle == "MS Sans Serif, Geneva, sans-serif") || ($body_fontstyle == "MS Serif, New York, sans-serif") || ($body_fontstyle == "Palatino Linotype, Book Antiqua, Palatino, serif") || ($body_fontstyle == "Times New Roman, Times, serif") || ($body_fontstyle == "Trebuchet MS, Helvetica, sans-serif") || ($body_fontstyle == "Verdana, Geneva, sans-serif") || ($body_fontstyle != "NewCicleFina, NewCicleFina") || ($body_fontstyle != "Domine, sans-serif, Domine, sans-serif")) : ?>
<style type="text/css">body{font-family:<?php echo ($body_fontstyle); ?> !important;}</style>

<?php elseif(($body_fontstyle != "Arial, Helvetica, sans-serif") || ($body_fontstyle != "Courier, monospace") || ($body_fontstyle != "Tahoma, Geneva, sans-serif") || ($body_fontstyle != "Garamond, serif") || ($body_fontstyle != "Georgia, serif") || ($body_fontstyle != "Impact, Charcoal, sans-serif") || ($body_fontstyle != "Lucida Console, Monaco, monospace") || ($body_fontstyle != "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($body_fontstyle != "MS Sans Serif, Geneva, sans-serif") || ($body_fontstyle != "MS Serif, New York, sans-serif") || ($body_fontstyle != "Palatino Linotype, Book Antiqua, Palatino, serif") || ($body_fontstyle != "Times New Roman, Times, serif") || ($body_fontstyle != "Trebuchet MS, Helvetica, sans-serif") || ($body_fontstyle != "Verdana, Geneva, sans-serif") || ($body_fontstyle != "NewCicleFina, NewCicleFina") || ($body_fontstyle != "Domine, sans-serif, Domine, sans-serif")): ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $body_fontstyle ?>" />
<style type="text/css">body{font-family:<?php echo ($body_fontstyle); ?> }</style>
<?php endif; ?>

<style type="text/css">

/*--Body font size--*/
body{font-size: <?php echo ($body_fontsize); ?>}
</style>
