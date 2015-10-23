<?php
/**
 * Helper class for Hello World! module
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class modCopyrightHelper
{
    /**
     * Retrieves the hello message
     *
     * @param array $params An object containing the module parameters
     * @access public
     */    
    public static function getCopyright ($params )
    {
        $app = JFactory::getApplication();
	   $template   = $app->getTemplate(true);
	   $params     = $template->params;
	
     $social = $params->get('social');
	 
	 // fetach the detil of radio button
	 
	 $fb_b=$params->get('nav_facebook_sw');
	 $tw_b=$params->get('nav_twitter_sw');
	 $g_b=$params->get('nav_google_sw');
	 $ln_b=$params->get('nav_linkedin_sw');
	 $s_b=$params->get('nav_skype_sw');
	 $fl_b=$params->get('nav_flicker_sw');
	 $delicious_b=$params->get('nav_delicious_sw');
	 $email_b=$params->get('nav_email_sw');
	 $rss_b=$params->get('nav_rssfeed_sw');
	 
	 // fetach the detail of text box
	 $copy=$params->get('copyright');
	 $fb=$params->get('facebook');
	 $tw=$params->get('twitter');
	 $g=$params->get('google');
	 $ln=$params->get('linkedin');
	 $s=$params->get('skype');
	 $fl=$params->get('flicker');
	 $delicious=$params->get('delicious');
	 $email=$params->get('email');
	 $rss=$params->get('rss');
	 
	 ?>
                  <?php 
				    if($social=='1')
					{ ?>
                
                    <div class="social-icons">
                      <?php
					      if($fb_b=='1'){	
					     ?>
                        <a class="facebook-icon" title="Facebook" href="<?php echo $fb;?>">Facebook</a>
                        <?php } ?>
                        
                         <?php
					      if($tw_b=='1'){	
					     ?>
                        <a class="twitter-icon" title="Twitter" href="<?php echo $tw;?>">Twitter</a>
                         <?php } ?>
                         
                          <?php
					      if($rss_b=='1'){	
					     ?>
                        <a class="rss-icon" title="RSS" href="<?php echo $rss;?>">RSS</a>
                         <?php } ?>
                         
                          <?php
					      if($delicious_b=='1'){	
					     ?>
                        <a class="delicious-icon" title="Delicious" href="<?php echo $delicious;?>">Delicious</a>
                         <?php } ?>
                         
                          <?php
					      if($ln_b=='1'){	
					     ?>
                        <a class="linkedin-icon" title="Linkedin" href="<?php echo $ln;?>">Linkedin</a>
                         <?php } ?>
                         
                          <?php
					      if($fl_b=='1'){	
					     ?>
                        <a class="flickr-icon" title="Flickr" href="<?php echo $fl;?>">Flickr</a>
                         <?php } ?>
                         
                          <?php
					      if($s_b=='1'){	
					     ?>
                        <a class="skype-icon" title="Skype" href="<?php echo $s;?>">Skype</a>
                         <?php } ?>
                         
                          <?php
					      if($email_b=='1'){	
					     ?>
                        <a class="mail-icon" title="Mail to" href="<?php echo $email;?>">Mail to</a>
                         <?php } ?>
                    </div>
                    <?php } ?>
                    <address><?php echo $copy; ?></address>
  
        
     <?php
	  
    }
}
?>