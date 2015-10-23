<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             Joomla
 * @subpackage          CoalaWeb Contact Module
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

JHtml::_('behavior.formvalidation');
?>
<div class="custom<?php echo $moduleclass_sfx ?>">
    <div class="cw-mod-contact-<?php echo "$theme$formWidth"; ?>" id="<?php echo $moduleUniqueId ?>">
        <?php if (!$recipient) : ?>
            <div id="cw-mod-contact-<?php echo $theme; ?>">
                <span class="error">
                    <?php echo $msgRemailMissing ?>
                </span>
            </div>
        <?php else : ?>
            <div id="cw-mod-contact-<?php echo $theme; ?>">
                <?php if (isset($emailSent) && $emailSent == true) : ?>
                    <?php $app->redirect($sucessUrl, $msgEmailSent); ?>
                <?php else : ?>
                
					<p class="lead text-center">
						Do you have any idea in mind? Contact us, we will give you the answer you expect.
					</p>
                    <form id="cw-mod-contact-<?php echo $theme.'-fm'.$moduleUniqueId ?>" name="contactform" action="<?php echo $samePageUrl . '#cw-mod-contact-'.$theme.'-fm'.$moduleUniqueId ?>" method="post" enctype="multipart/form-data" class="form-validate element-line validate">
                    
                    <div class="form-respond text-center"></div>
                      <div class="row">
							<div class="col-md-6 col-sm-6 col-md-6 col-xs-12">
								<div class="item_top">   
                                    
											<?php if ($displayName == 'Y' || $displayName == 'R') : ?>
                                                <div class="form-group">
                                                    <label for="cw_mod_contact_name<?php echo $moduleUniqueId ?>">
                                                        <?php echo $nameLbl; ?>
                                                    </label>
                                                    <input type="text" name="cw_mod_contact_name<?php echo $moduleUniqueId ?>" id="cw_mod_contact_name<?php echo $moduleUniqueId ?>" value="<?php echo (isset($name) ? $name : null )?>" class="<?php echo (($displayName === 'R') ? 'required' : null) ?> form-control input-lg required" placeholder="<?php echo $nameHint; ?>" />
                                                    <?php if ($nameError) : ?>
                                                        <span class="error">
                                                            <?php echo $nameError; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                    
                                            <div class="form-group">
                                                <label for="cw_mod_contact_email<?php echo $moduleUniqueId ?>">
                                                    <?php echo $emailLbl; ?>
                                                </label>
                                                <input type="text" name="cw_mod_contact_email<?php echo $moduleUniqueId ?>" id="cw_mod_contact_email<?php echo $moduleUniqueId ?>" value="<?php echo (isset($email) ? $email : null )?>" class="required validate-email form-control input-lg required email" placeholder="<?php echo $emailHint; ?>" />
                                                <?php if ($emailError) : ?>
                                                    <span class="error">
                                                        <?php echo $emailError; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                    
                                            <?php if ($displaySubject == 'Y' || $displaySubject == 'R') : ?>
                                               <div class="form-group">
                                                    <label for="cw_mod_contact_subject<?php echo $moduleUniqueId ?>">
                                                        <?php echo $subjectLbl; ?>
                                                    </label>
                                                    <input type="text" name="cw_mod_contact_subject<?php echo $moduleUniqueId ?>" id="cw_mod_contact_subject<?php echo $moduleUniqueId ?>" value="<?php echo (isset($subject) ? $subject : null )?>" class="<?php echo (($displaySubject === 'R') ? 'required' : null) ?> form-control input-lg required" placeholder="<?php echo $subjectHint; ?>" />
                                                    <?php if ($subjectError) : ?>
                                                        <span class="error">
                                                            <?php echo $subjectError; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($displayCInput1 == 'Y' || $displayCInput1 == 'R') : ?>
                                                <div class="input">
                                                    <label for="cw_mod_contact_cinput1<?php echo $moduleUniqueId ?>">
                                                        <?php echo $cInput1Lbl; ?>
                                                    </label>
                                                    <input type="text" name="cw_mod_contact_cinput1<?php echo $moduleUniqueId ?>" id="cw_mod_contact_cinput1<?php echo $moduleUniqueId ?>" value="<?php echo (isset($cInput1) ? $cInput1 : null )?>" class="<?php echo (($displayCInput1 === 'R') ? 'required' : null) ?>" placeholder="<?php echo $cInput1Hint; ?>" />
                                                    <?php if ($cInput1Error) : ?>
                                                        <span class="error">
                                                            <?php echo $cInput1Error; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            </div>
									<!-- Form group -->

								</div>
							
                      <div class="col-md-6 col-sm-6 col-md-6 col-xs-12">
						<div class="item_bottom">
                      
                        <div class="form-group">
                            <label for="cw_mod_contact_message<?php echo $moduleUniqueId ?>">
                                <?php echo $messageLbl; ?>
                            </label>
                            <textarea name="cw_mod_contact_message<?php echo $moduleUniqueId ?>" id="cw_mod_contact_message<?php echo $moduleUniqueId ?>" class="required form-control input-lg required" rows="9" maxlength="<?php echo $charLimit ?>" placeholder="<?php echo $messageHint; ?>"><?php echo (isset($message) ? $message : null )?></textarea>
                            <?php if ($msgError) : ?>
                                <span class="error">
                                    <?php echo $msgError; ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if ($whichCaptcha == 'basic') : ?>
                            <?php if ($displayCapTitle) : ?>
                                <span class="success">
                                    <?php echo $captchaHeading; ?>
                                </span>
                            <?php endif; ?>
                            <div class="input">
                                <label for="cw_plg_contact_captcha<?php echo $moduleUniqueId; ?>">
                                <?php echo $bCaptchaQuestion; ?>
                                </label> 
                                <input type="text" class="required" name="cw_mod_contact_captcha<?php echo $moduleUniqueId ?>" id="cw_mod_contact_captcha<?php echo $moduleUniqueId ?>" value="<?php echo (isset($capEnter) ? $capEnter : null )?>" placeholder="<?php echo $captchaHint; ?>"/>
                                <?php if ($captchaError) : ?>
                                    <span class="error">
                                        <?php echo $captchaError; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                                  </div>
									<!-- Form group -->

								</div>
							</div>
                      
                      <div class="row">
							<div class="col-md-12 text-center">
								
                        
                        <?php if ($displayCopyme) : ?>
                            <div class="copyme">
                                <input type="checkbox" name="cw_mod_contact_copyme<?php echo $moduleUniqueId ?>" id="cw_mod_contact_copyme<?php echo $moduleUniqueId ?>" value="1" <?php echo ($copyme == "1" ? 'checked="checked"' : null )?> class="copyme" />
                                <label for="copyme">
                                    <?php echo $copymeLbl; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                      </div>
                      </div>
                      
                      <div class="row">
							<div class="col-md-12 text-center">
								<div class="action form-button medium">
                      
                       
                              <div class="mybutton medium">
                                <button name="submit<?php echo $moduleUniqueId ?>" type="submit" id="submit<?php echo $moduleUniqueId ?>" class="<?php echo $submitStyle; ?>"><span data-hover="Send message">Send message</span></button>
                              </div>
                                <input type="hidden" name="modsubmitted<?php echo $moduleUniqueId ?>" id="submitted" value="true" />
                                <?php echo JHTML::_( 'form.token' ); ?>
                            </div>
                       
							</div>
						</div>
                    </form>		
              
                <?php endif; ?>
            </div>
          
<?php endif; ?>
    </div>
</div>