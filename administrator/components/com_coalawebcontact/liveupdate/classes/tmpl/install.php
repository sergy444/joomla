<?php
/**
 * @package LiveUpdate
 * @copyright Copyright (c)2010-2013 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU LGPLv3 or later <http://www.gnu.org/copyleft/lesser.html>
 */
defined('_JEXEC') or die();

$state = $this->get('State');
$message1 = $state->get('message');
$message2 = $state->get('extmessage');
?>
<table class="adminform">
    <tbody>
        <?php if ($message1) : ?>
            <tr>
                <th><?php echo JText::_($message1) ?></th>
            </tr>
        <?php endif; ?>
        <?php if ($message2) : ?>
            <tr>
                <td><?php echo $message2; ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="cw-powerby-back">
    <span class="cw-powerby-back">
        Powered by <a href="https://www.akeebabackup.com/software/akeeba-live-update.html">Akeeba Live Update</a>
    </span>
</div>

<iframe style="width: 0px; height: 0px; border: none;" frameborder="0" marginheight="0" marginwidth="0" height="0" width="0"
        src="index.php?option=<?php echo JRequest::getCmd('option', '') ?>&view=<?php echo JRequest::getCmd('view', '') ?>&task=cleanup"></iframe>