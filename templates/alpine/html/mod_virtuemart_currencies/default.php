<?php // no direct access
defined('_JEXEC') or die('Restricted access');
vmJsApi::jQuery();
//vmJsApi::chosenDropDowns();
$document = JFactory::getDocument();
$document->addScript(JURI::base().'templates/alpine/js/jquery.selectbox.js');
?>





<!-- Currency Selector Module -->

<?php echo $text_before ?>

<form action="<?php echo vmURI::getCleanUrl() ?>" method="post">

	<?php echo JHTML::_('select.genericlist', $currencies, 'virtuemart_currency_id', 'class="inputbox vm-chzn-select" Onchange="this.form.submit()"', 'virtuemart_currency_id', 'currency_txt', $virtuemart_currency_id) ; ?>
    <noscript><input type="submit" value="Submit"></noscript>
</form>
<script type="text/javascript">
(function($){

$("#virtuemart_currency_id").selectbox();
})(jQuery);
</script>