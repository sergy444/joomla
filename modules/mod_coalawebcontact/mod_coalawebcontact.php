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

$lang = JFactory::getLanguage();

//Load the module language strings
if ($lang->getTag() != 'en-GB') {
    $lang->load('mod_coalawebcontact', JPATH_SITE, 'en-GB');
}
$lang->load('mod_coalawebcontact', JPATH_SITE, null, 1);

//Load the component language strings
if ($lang->getTag() != 'en-GB') {
    $lang->load('com_coalawebcontact', JPATH_ADMINISTRATOR, 'en-GB');
}
$lang->load('com_coalawebcontact', JPATH_ADMINISTRATOR, null, 1);

$doc = JFactory::getDocument();
$app = JFactory::getApplication();
$jinput = JFactory::getApplication()->input;

//Keeping the parameters in the component keeps things clean and tidy.
$comParams = JComponentHelper::getParams('com_coalawebcontact');

$moduleUniqueId = $params->get('module_unique_id');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

/* Urls */
if ($params->get('redirect_url')) {
    $redirectUrl = $params->get('redirect_url');
} else {
    $redirectUrl = $comParams->get('redirect_url');
}

$samePageUrl = JURI::getInstance()->toString();
$homeUrl = JRoute::_(JURI::root());

switch ($redirectUrl) {
    case 1: $sucessUrl = ($samePageUrl . '#top');
        break;
    case 2: $sucessUrl = ($homeUrl . '#top');
        break;
    default: $sucessUrl = JRoute::_(JURI::root());
        break;
}

/* Load css */
$cwcLoadCss = $comParams->get('cwc_load_css');
if ($params->get('form_theme')) {
    $theme = $params->get('form_theme');
} else {
    $theme = $comParams->get('form_theme');
}

$urlModMedia = JURI :: base() . 'media/coalawebcontact/components/contact/themes/'.$theme.'/css/';
if ($cwcLoadCss) {
    $doc->addStyleSheet($urlModMedia . 'cw-mod-contact-'.$theme.'.css');
}

/* Labels */
$nameLbl = $comParams->get('name_lbl', JTEXT::_('COM_CWCONTACT_LABEL_NAME'));
$nameHint = $comParams->get('name_hint', JTEXT::_('COM_CWCONTACT_NAME_HINT'));
$emailLbl = $comParams->get('email_lbl', JTEXT::_('COM_CWCONTACT_LABEL_EMAIL'));
$emailHint = $comParams->get('email_hint', JTEXT::_('COM_CWCONTACT_EMAIL_HINT'));
$messageLbl = $comParams->get("message_lbl", JTEXT::_('COM_CWCONTACT_LABEL_MESSAGE'));
$messageHint = $comParams->get('message_hint', JTEXT::_('COM_CWCONTACT_MESSAGE_HINT'));
$subjectLbl = $comParams->get('subject_lbl', JTEXT::_('COM_CWCONTACT_LABEL_SUBJECT'));
$subjectHint = $comParams->get('subject_hint', JTEXT::_('COM_CWCONTACT_SUBJECT_HINT'));
$copymeLbl = $comParams->get('copyme_lbl', JTEXT::_('COM_CWCONTACT_LABEL_COPYME'));
$sFromTitleLbl = $comParams->get('sfrom_title', JTEXT::_('COM_CWCONTACT_MAIL_TITLE_FROM'));
$sFromWebLbl = $comParams->get('sfrom_web_lbl', JTEXT::_('COM_CWCONTACT_LABEL_SFROMWEB'));
$sFromUrlLbl = $comParams->get('sfrom_url_lbl', JTEXT::_('COM_CWCONTACT_LABEL_SFROMURL'));
$sFromUrlText = $comParams->get('sfrom_url_text', JTEXT::_('COM_CWCONTACT_TEXT_URL'));
$sByTitleLbl = $comParams->get('sby_title', JTEXT::_('COM_CWCONTACT_MAIL_TITLE_FROM'));
$sByIpLbl = $comParams->get('ip_lbl', JTEXT::_('COM_CWCONTACT_LABEL_IP'));

$cInput1Lbl = $comParams->get('custom1_lbl', JTEXT::_('COM_CWCONTACT_LABEL_CUSTOM1'));
$cInput1Hint = $comParams->get('custom1_hint', JTEXT::_('COM_CWCONTACT_CUSTOM1_HINT'));

// Fields
if ($params->get('display_subject')) {
    $displaySubject = $params->get('display_subject');
} else {
    $displaySubject = $comParams->get('display_subject');
}

if ($params->get('display_name')) {
    $displayName= $params->get('display_name');
} else {
    $displayName = $comParams->get('display_name');
}

if ($params->get('display_copyme') >= '0') {
    $displayCopyme = $params->get('display_copyme');
} else {
    $displayCopyme = $comParams->get('display_copyme');
}

// Custom Fields
if ($params->get('display_c_input1')) {
    $displayCInput1 = $params->get('display_c_input1');
} else {
    $displayCInput1 = $comParams->get('display_c_input1');
}

$charLimit = 300;

/* Captcha */
if ($params->get('which_captcha')) {
    $whichCaptcha = $params->get('which_captcha');
} else {
    $whichCaptcha = $comParams->get('which_captcha');
}

if ($params->get('display_captcha_title') >= '0') {
    $displayCapTitle = $params->get('display_captcha_title');
} else {
    $displayCapTitle = $comParams->get('display_captcha_title');
}

$captchaHeading = $comParams->get('captcha_heading', JTEXT::_('COM_CWCONTACT_CAPTCHA_HEADING'));
$captchaHint = $comParams->get('captcha_hint', JTEXT::_('COM_CWCONTACT_CAPTCHA_HINT'));

/* Basic Captcha */
if ($params->get('bcaptcha_question')) {
    $bCaptchaQuestion = $params->get('bcaptcha_question');
} else {
    $bCaptchaQuestion = $comParams->get('bcaptcha_question', JTEXT::_('COM_CWCONTACT_BCAPTCHA_DEFAULT_QUESTION'));
}
if ($params->get('bcaptcha_answer')) {
    $bCaptchaAnswer = $params->get('bcaptcha_answer');
} else {
    $bCaptchaAnswer = $comParams->get('bcaptcha_answer', JTEXT::_('COM_CWCONTACT_BCAPTCHA_DEFAULT_ANSWER'));
}

/* Button Options */
if ($params->get('submit_btn')) {
    $submitBtn = $params->get('submit_btn');
} else {
    $submitBtn = $comParams->get('submit_btn', JTEXT::_('COM_CWCONTACT_LABEL_SUB_BUTTON'));
}

if ($params->get('submit_btn_style')) {
    $submitStyle = $params->get('submit_btn_style');
} else {
    $submitStyle = $comParams->get('submit_btn_style');
}

/* General Options */
if ($params->get('email_subject')) {
    $emailSubject = $params->get('email_subject');
} else {
    $emailSubject = $comParams->get('email_subject');
}

if ($params->get('recipient')) {
    $recipient = $params->get('recipient');
} else {
    $recipient = $comParams->get('recipient');
}

/* Module Settings */
if ($params->get('form_width')) {
    $formWidth = $params->get('form_width');
} else {
    $formWidth = $comParams->get('form_width');
}

/* Powered by */
$copy = $params->get('copy');
$powered = $params->get('powered', JTEXT::_('MOD_CWCONTACT_POWERED'));

/* Messages */
$msgRemailMissing = $comParams->get('msg_remail_missing', JTEXT::_('COM_CWCONTACT_MSG_REMAIL_MISSING'));
$msgEmailSent = $comParams->get('msg_email_sent', JTEXT::_('COM_CWCONTACT_MSG_EMAIL_SENT'));
$msgSubjectMissing = $comParams->get('msg_subject_missing', JTEXT::_('COM_CWCONTACT_MSG_SUBJECT_MISSING'));
$msgNameMissing = $comParams->get('msg_name_missing', JTEXT::_('COM_CWCONTACT_MSG_NAME_MISSING'));
$msgEmailMissing = $comParams->get('msg_email_missing', JTEXT::_('COM_CWCONTACT_MSG_EMAIL_MISSING'));
$msgEmailInvalid = $comParams->get('msg_email_invalid', JTEXT::_('COM_CWCONTACT_MSG_EMAIL_INVALID'));
$msgMessageMissing = $comParams->get('msg_message_missing', JTEXT::_('COM_CWCONTACT_MSG_MESSAGE_MISSING'));
$msgCaptchaWrong = $comParams->get('msg_captcha_wrong', JTEXT::_('COM_CWCONTACT_MSG_CAPTCHA_WRONG'));
$msgCInput1Missing = $comParams->get('msg_custom1_missing', JTEXT::_('COM_CWCONTACT_MSG_CUSTOM1_MISSING'));

/* Start a session */
if (!isset($_SESSION)) {
    session_start();
}

/* Initialize variables */
$subjectError = '';
$nameError = '';
$emailError = '';
$msgError = '';
$captchaError = '';
$cInput1Error = '';

$subject = $jinput->post->get('cw_mod_contact_subject' . $moduleUniqueId, '', 'STRING');
$name = $jinput->post->get('cw_mod_contact_name' . $moduleUniqueId, '', 'STRING');
$email = $jinput->post->get('cw_mod_contact_email' . $moduleUniqueId, '', 'STRING');
$message = $jinput->post->get('cw_mod_contact_message' . $moduleUniqueId, '', 'SAFE_HTML');
$capEnter = $jinput->post->get('cw_mod_contact_captcha' . $moduleUniqueId, '', 'INT');
$copyme = $jinput->post->get('cw_mod_contact_copyme' . $moduleUniqueId, '', 'INT');
$remoteHost = $jinput->server->get('REMOTE_ADDR');
//Custom Inputs
$cInput1 = $jinput->post->get('cw_mod_contact_cinput1' . $moduleUniqueId, '', 'STRING');

$sitename = $app->getCfg('sitename');

$submitted = $jinput->post->get('modsubmitted' . $moduleUniqueId, '', 'STRING');

/*
 * Lets do some server side php validation!
 */
if ($submitted) {
    /* Lets start with a subject */
    if ($displaySubject == 'R') {
        if (!$subject) {
            $subjectError = $msgSubjectMissing;
            $hasError = true;
        } else {
            $subject = $subject;
        }
    } else {
        $subject = $subject;
    }

    /* Now for the name */
    if ($displayName == 'R') {
        if (!$name) {
            $nameError = $msgNameMissing;
            $hasError = true;
        } else {
            $name = $name;
        }
    } else {
        $name = $name;
    }
    
    /* Custom 1 */
    if ($displayCInput1 == 'R') {
        if (!$cInput1) {
            $cInput1Error = $msgCInput1Missing;
            $hasError = true;
        } else {
            $cInput1 = $cInput1;
        }
    } else {
        $cInput1= $cInput1;
    }

    /* Next we have the email, lets make sure it's not empty and in the right format. */
    if (!$email) {
        $emailError = $msgEmailMissing;
        $hasError = true;
    } else if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", strtolower($email))) {
        $emailError = $msgEmailInvalid;
        $hasError = true;
    } else {
        $email = $email;
    }

    /* The message is quite important! */
    if (!$message) {
        $msgError = $msgMessageMissing;
        $hasError = true;
    } else {
        $message = $message;
    }

    switch ($whichCaptcha) {
        case "basic":
            if ($capEnter != $bCaptchaAnswer) {
                $captchaError = $msgCaptchaWrong;
                $hasError = true;
            } else {
                $captcha = $capEnter;
            }
            break;
    }


    /*
     * No Errors? Nice lets start sending the mail.
     */
    if (!isset($hasError)) {
        $mail = JFactory::getMailer();
        $config = JFactory::getConfig();

        $sender = array($email, $name);

        $mail->setSender($sender);
        $mail->addRecipient($recipient);

        //Check subject
        if ($subject) {
            $extSubject = ($emailSubject . ': ' . $subject);
        } else {
            $extSubject = ($emailSubject);
        }

        $mail->setSubject($extSubject);

        $emailFormat = $comParams->get('email_format');
        
        switch ($emailFormat) {
            case "nohtml":
                $body = $extSubject . "\n";
                $body .= $messageLbl . ": " . $message . "\n";
                $body .= $name ? $nameLbl . ": " . $name . "\n" : "";
                $body .= $emailLbl . ": " . $email . "\n";
                $body .= $cInput1 ? $cInput1Lbl . ": " . $cInput1 . "\n" : "";
                $body .= $sFromWebLbl . ": " . $sitename . "\n";

                $mail->setBody($body);
                break;
        }
        $send = $mail->Send();

        if ($copyme && $copyme == '1') {
            $mail->ClearAllRecipients();
            $mail->addRecipient($sender);
            $send = $mail->send();
        }

        $emailSent = true;
    }
}

require JModuleHelper::getLayoutPath('mod_coalawebcontact', $params->get('layout', 'default'));