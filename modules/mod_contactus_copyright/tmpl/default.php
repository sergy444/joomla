<?php
/** 
 * Default View for Contact us Module 
 * @package    Getshopped
 * @subpackage Module
 * @author Das Infomedia.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 // no direct access
defined('_JEXEC') or die;

 ?>
<div class="<?php echo $moduleclass_sfx ?>">
<?php 
	if($social=='1')
	{ ?>
                 
  <div class="social-icon">
    
	<?php if($facebook == '1') { ?>
    <a href="<?php echo $fb; ?>" target="_blank"> <i class="fa fa-facebook fa-3x"></i> </a> 
    <?php } ?>
   
    <?php if($twitter == '1') { ?> 
    <a href="<?php echo $twi; ?>" target="_blank"> <i class="fa fa-twitter fa-3x"></i> </a> 
    <?php } ?>
   
    <?php if($google == '1') { ?>
    <a href="<?php echo $go; ?>" target="_blank"> <i class="fa fa-google-plus fa-3x"></i> </a> 
    <?php } ?>
    
    <?php if($youtube == '1') { ?>
    <a href="<?php echo $you; ?>" target="_blank"> <i class="fa fa-youtube fa-3x"></i> </a> 
    <?php } ?>
  </div>
    <?php } ?>
  <?php echo $copyright; ?>
</div>
