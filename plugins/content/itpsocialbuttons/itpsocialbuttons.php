<?php
/**
 * @package      ITPSocialButtons
 * @subpackage   Plugins
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2013 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * ITPSocialButtons Plugin
 *
 * @package		ITPrism Plugins
 * @subpackage	Buttons
 */
class plgContentITPSocialButtons extends JPlugin {
    
	private $plgUrlPath 	= "";
	private $currentView    = "";
    private $currentTask    = "";
    private $currentOption  = "";
    private $currentLayout  = "";
	
    /**
     * Prepare the content 
     * There are three positions where the icons can be added - on the top, on the bottom and on both.
     *
     * @param   string	 The context of the content being passed to the plugin.
	 * @param   object	 The article object.
	 * @param   object	 The article params
	 * @param   integer  The 'page'  number
     * 
     * @return  void
     */
    public function onContentPrepare($context, &$article, &$params, $page = 0) {
        
        if (!$article OR !isset($this->params)) { return; }
        
        // Check for correct trigger
        if(strcmp("on_content_prepare", $this->params->get("trigger_place")) != 0) {
            return;
        }
        
        // Generate content
        $content = $this->processGenerating($context, $article, $params, $page = 0);
        
        // If there is no result, return void.
        if(is_null($content)) { return; }
        
        $position = $this->params->get('position');
        
        switch($position){
            
            case 1: // Top
                $article->text = $content . $article->text;
                break;
                
            case 2: // Bottom
                $article->text = $article->text . $content;
                break;
                
            default: // Both
                $article->text = $content . $article->text . $content;
                break;
                
        }
        
    }
    
    /**
     * Add social buttons into the article before content.
     *
     * @param	string	The context of the content being passed to the plugin.
     * @param	object	The article object.  Note $article->text is also available
     * @param	object	The article params
     * @param	int		The 'page' number
     * 
     * @return string
     */
    public function onContentBeforeDisplay($context, &$article, &$params, $page = 0) {
    
        // Check for correct trigger
        if(strcmp("on_content_before_display", $this->params->get("trigger_place")) != 0) {
            return "";
        }
    
        // Generate content
        $content = $this->processGenerating($context, $article, $params, $page = 0);
        
        // If there is no result, return empty string.
        if(is_null($content)) { return ""; }
        
        return $content;
    }
    
    /**
     * Add social buttons into the article after content.
     *
     * @param	string	The context of the content being passed to the plugin.
     * @param	object	The article object.  Note $article->text is also available
     * @param	object	The article params
     * @param	int		The 'page' number
     * 
     * @return string
     */
    public function onContentAfterDisplay($context, &$article, &$params, $page = 0) {
    
        // Check for correct trigger
        if(strcmp("on_content_after_display", $this->params->get("trigger_place")) != 0) {
            return "";
        }
    
        // Generate content
        $content = $this->processGenerating($context, $article, $params, $page = 0);
        
        // If there is no result, return empty string.
        if(is_null($content)) { return ""; }
        
        return $content;
    }
    
    /**
     * Execute the process of buttons generating.
     *
     * @param string    $context
     * @param object    $article
     * @param JRegistry $params
     * @param number    $page
     * 
     * @return NULL|string
     */
    private function processGenerating($context, &$article, &$params, $page = 0) {
    
        $app = JFactory::getApplication();
        /** @var $app JSite **/

        if($app->isAdmin()) {
            return null;
        }
        
        $doc     = JFactory::getDocument();
        /**  @var $doc JDocumentHtml **/
        
        // Check document type
        $docType = $doc->getType();
        if(strcmp("html", $docType) != 0){
            return null;
        }
       
        $this->plgUrlPath 	  =  JURI::root() . "plugins/content/itpsocialbuttons/";
        
        // Get request data
        $this->currentOption  =  $app->input->getCmd("option");
        $this->currentView    =  $app->input->getCmd("view");
        $this->currentTask    =  $app->input->getCmd("task");
        $this->currentLayout  = $app->input->getCmd("layout");
        
        if($this->isRestricted($article, $context, $params)) {
        	return null;
        }
        
        if($this->params->get("loadCss")) {
            $doc->addStyleSheet(JURI::root() . "plugins/content/itpsocialbuttons/style.css");
        }
        
        // Load language file
        $this->loadLanguage();
    
        // Generate and return content
        return $this->getContent($article, $context);
    
    }
    
    private function isRestricted($article, $context, $params) {
    	
    	$result = false;
    	
    	switch($this->currentOption) {
            case "com_content":
            	
            	// It's an implementation of "com_myblog"
            	// I don't know why but $option contains "com_content" for a value
            	// I hope it will be fixed in the future versions of "com_myblog"
            	if(strcmp($context, "com_myblog") != 0) {
                    $result = $this->isContentRestricted($article, $context);
	                break;
            	} 
	                
            case "com_myblog":
                $result = $this->isMyBlogRestricted($article, $context);
                break;
                    
            case "com_k2":
                $result = $this->isK2Restricted($article, $context, $params);
                break;
                
            case "com_virtuemart":
                $result = $this->isVirtuemartRestricted($article, $context);
                break;

            case "com_jevents":
                $result = $this->isJEventsRestricted($article, $context);
                break;

            case "com_easyblog":
                $result = $this->isEasyBlogRestricted($article, $context);
                break;

            case "com_vipportfolio":
                $result = $this->isVipPortfolioRestricted($article, $context);
                break;
                
            case "com_zoo":
                $result = $this->isZooRestricted($article, $context);
                break;    
                
             case "com_jshopping":
                $result = $this->isJoomShoppingRestricted($article, $context);
                break;  

            case "com_hikashop":
                $result = $this->isHikaShopRestricted($article, $context);
                break; 
                
            case "com_vipquotes":
                $result = $this->isVipQuotesRestricted($article, $context);
                break;
                
            default:
                $result = true;
                break;   
        }
        
        return $result;
        
    }
    
	/**
     * 
     * Checks allowed articles, exluded categories/articles,... for component COM_CONTENT
     * @param object $article
     * @param string $context
     */
    private function isContentRestricted(&$article, $context) {
        
        // Check for correct context
        if(false === strpos($context, "com_content")) {
           return true;
        }
        
    	/** Check for selected views, which will display the buttons. **/   
        /** If there is a specific set and do not match, return an empty string.**/
        $showInArticles     = $this->params->get('showInArticles');
        if(!$showInArticles AND (strcmp("article", $this->currentView) == 0)){
            return true;
        }
        
        // Will be displayed in view "categories"?
        $showInCategories   = $this->params->get('showInCategories');
        if(!$showInCategories AND (strcmp("category", $this->currentView) == 0)){
            return true;
        }
        
        // Will be displayed in view "featured"?
        $showInFeatured   = $this->params->get('showInFeatured');
        if(!$showInFeatured AND (strcmp("featured", $this->currentView) == 0)){
            return true;
        }
        
        // Exclude articles
        $excludeArticles = $this->params->get('excludeArticles');
        if(!empty($excludeArticles)){
            $excludeArticles = explode(',', $excludeArticles);
        }
        settype($excludeArticles, 'array');
        JArrayHelper::toInteger($excludeArticles);
        
        // Exluded categories
        $excludedCats           = $this->params->get('excludeCats');
        if(!empty($excludedCats)){
            $excludedCats = explode(',', $excludedCats);
        }
        settype($excludedCats, 'array');
        JArrayHelper::toInteger($excludedCats);
        
        // Included Articles
        $includedArticles = $this->params->get('includeArticles');
        if(!empty($includedArticles)){
            $includedArticles = explode(',', $includedArticles);
        }
        settype($includedArticles, 'array');
        JArrayHelper::toInteger($includedArticles);
        
        if(!in_array($article->id, $includedArticles)) {
            // Check exluded articles
            if(in_array($article->id, $excludeArticles) OR in_array($article->catid, $excludedCats)){
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * 
     * This method does verification for K2 restrictions
     * @param jIcalEventRepeat $article
     * @param string $context
     */
    private function isK2Restricted(&$article, $context, $params) {
        
        // Check for correct context
        if(strpos($context, "com_k2") === false) {
           return true;
        }
        
        if($article instanceof TableK2Category){
            return true;
        }
        
        $displayInItemlist     = $this->params->get('k2DisplayInItemlist', 0);
        if(!$displayInItemlist AND (strcmp("itemlist", $this->currentView) == 0)){
            return true;
        }
        
        $displayInArticles     = $this->params->get('k2DisplayInArticles', 0);
        if(!$displayInArticles AND (strcmp("item", $this->currentView) == 0) ) {
            return true;
        }
        
        // Exclude articles
        $excludeArticles = $this->params->get('k2_exclude_articles');
        if(!empty($excludeArticles)){
            $excludeArticles = explode(',', $excludeArticles);
        }
        settype($excludeArticles, 'array');
        JArrayHelper::toInteger($excludeArticles);
        
        // Exluded categories
        $excludedCats           = $this->params->get('k2_exclude_cats');
        if(!empty($excludedCats)){
            $excludedCats = explode(',', $excludedCats);
        }
        settype($excludedCats, 'array');
        JArrayHelper::toInteger($excludedCats);
        
        // Included Articles
        $includedArticles = $this->params->get('k2_include_articles');
        if(!empty($includedArticles)){
            $includedArticles = explode(',', $includedArticles);
        }
        settype($includedArticles, 'array');
        JArrayHelper::toInteger($includedArticles);
        
        if(!in_array($article->id, $includedArticles)) {
            // Check exluded articles
            if(in_array($article->id, $excludeArticles) OR in_array($article->catid, $excludedCats)){
                return true;
            }
        }
        
        $this->prepareK2Object($article, $params);
        
        return false;
    }
    
	/**
     * 
     * Prepare some elements of the K2 object
     * @param object $article
     * @param JRegistry $params
     */
    private function prepareK2Object(&$article, $params) {
        
        if(empty($article->metadesc)) {
            $introtext         = strip_tags($article->introtext);
            $metaDescLimit     = $params->get("metaDescLimit", 150);
            $article->metadesc = substr($introtext, 0, $metaDescLimit);
        }
            
    }
    
    /**
     * 
     * This method does verification for JEvents restrictions
     * @param jIcalEventRepeat $article
     * @param string $context
     */
    private function isJEventsRestricted(&$article, $context) {
        
        // Display buttons only in the description
        if (!is_a($article, "jIcalEventRepeat")) { 
            return true; 
        };
        
        // Check for correct context
        if(strpos($context, "com_jevents") === false) {
           return true;
        }
        
        // Display only in task 'icalrepeat.detail'
        if(strcmp("icalrepeat.detail", $this->currentTask) != 0) {
           return true;
        }
        
        $displayInEvents     = $this->params->get('jeDisplayInEvents', 0);
        if(!$displayInEvents){
            return true;
        }
        
        return false;
    }
    
    /**
     * Do verification for Vip Quotes extension. Is it restricted?
     *
     * @param ojbect $article
     * @param string $context
     */
    private function isVipQuotesRestricted(&$article, $context) {
    
        // Check for correct context
        if(strpos($context, "com_vipquotes") === false) {
            return true;
        }
    
        // Display only in view 'quote'
        $allowedViews = array("author", "quote");
        if(!in_array($this->currentView, $allowedViews)) {
            return true;
        }
    
        $displayOnViewQuote     = $this->params->get('vipquotes_display_quote', 0);
        if(!$displayOnViewQuote){
            return true;
        }
    
        $displayOnViewAuthor     = $this->params->get('vipquotes_display_author', 0);
        if(!$displayOnViewAuthor){
            return true;
        }
    
        return false;
    }
    
    /**
     * 
     * This method does verification for VirtueMart restrictions.
     * 
     * @param stdClass $article
     * @param string $context
     */
    private function isVirtuemartRestricted(&$article, $context) {
            
        // Check for correct context
        if(strpos($context, "com_virtuemart") === false) {
           return true;
        }

        // Display content only in the view "productdetails"
        if(strcmp("productdetails", $this->currentView) != 0){
            return true;
        }
        
        // Only display content in the view "productdetails"
        $displayInDetails     = $this->params->get('vmDisplayInDetails', 0);
        if(!$displayInDetails){
            return true;
        }
        
        return false;
        
    }
    
	/**
     * It's a method that verify restriction for the component "com_myblog".
     * 
     * @param object $article
     * @param string $context
     */
	private function isMyBlogRestricted(&$article, $context) {

        // Check for correct context
        if(strpos($context, "myblog") === false) {
           return true;
        }
        
	    // Display content only in the task "view"
        if(strcmp("view", $this->currentTask) != 0){
            return true;
        }
        
        // Check for enabled option for that extensions
        if(!$this->params->get('mbDisplay', 0)){
            return true;
        }
        
        return false;
    }
    
	/**
     * 
     * It's a method that verify restriction for the component "com_vipportfolio"
     * @param object $article
     * @param string $context
     */
	private function isVipPortfolioRestricted(&$article, $context) {

        // Check for correct context
        if(strpos($context, "com_vipportfolio") === false) {
           return true;
        }
        
	    // Verify the option for displaying in layout "lineal"
        $displayInLineal     = $this->params->get('vipportfolio_lineal', 0);
        if(!$displayInLineal){
            return true;
        }
        
        return false;
    }
    
	/**
     * It's a method that verify restriction for the component "com_zoo".
     * 
     * @param object $article
     * @param string $context
     */
	private function isZooRestricted(&$article, $context) {
	    
        // Check for correct context
        if(false === strpos($context, "com_zoo")) {
           return true;
        }
        
	    // Verify the option for displaying in view "item"
        $displayInItem     = $this->params->get('zoo_display', 0);
        if(!$displayInItem){
            return true;
        }
        
	    // Check for valid view or task
	    // I have check for task because if the user comes from view category, the current view is "null" and the current task is "item"
        if( (strcmp("item", $this->currentView) != 0 ) AND (strcmp("item", $this->currentTask) != 0 )){
            return true;
        }
        
        // A little hack used to prevent multiple displaying of buttons, becaues
        // if there are more than one textares the buttons will be displayed in everyone.
        static $numbers = 0;
        if($numbers == 1) {
            return true;
        }
        $numbers = 1;
        
        return false;
    }
    
	/**
     * It's a method that verify restriction for the component "com_easyblog".
     * 
     * @param object $article
     * @param string $context
     */
	private function isEasyBlogRestricted(&$article, $context) {
	    
	    
        $allowedViews = array("categories", "entry", "latest", "tags");   
        // Check for correct context
        if(strpos($context, "easyblog") === false) {
           return true;
        }
        
        // Only put buttons in allowed views
        if(!in_array($this->currentView, $allowedViews)) {
        	return true;
        }
        
   		// Verify the option for displaying in view "categories"
        $displayInCategories     = $this->params->get('ebDisplayInCategories', 0);
        if(!$displayInCategories AND (strcmp("categories", $this->currentView) == 0)){
            return true;
        }
        
   		// Verify the option for displaying in view "latest"
        $displayInLatest     = $this->params->get('ebDisplayInLatest', 0);
        if(!$displayInLatest AND (strcmp("latest", $this->currentView) == 0)){
            return true;
        }
        
		// Verify the option for displaying in view "entry"
        $displayInEntry     = $this->params->get('ebDisplayInEntry', 0);
        if(!$displayInEntry AND (strcmp("entry", $this->currentView) == 0)){
            return true;
        }
        
	    // Verify the option for displaying in view "tags"
        $displayInTags     = $this->params->get('ebDisplayInTags', 0);
        if(!$displayInTags AND (strcmp("tags", $this->currentView) == 0)){
            return true;
        }
        
        return false;
    }
    
	/**
     * 
     * It's a method that verify restriction for the component "com_joomshopping"
     * @param object $article
     * @param string $context
     */
	private function isJoomShoppingRestricted(&$article, $context) {
        
        // Check for correct context
        if(false === strpos($context, "com_content.article")) {
           return true;
        }
        
	    // Check for enabled functionality for that extension
        $displayInDetails     = $this->params->get('joomshopping_display', 0);
        if(!$displayInDetails OR !isset($article->product_id)){
            return true;
        }
        
        return false;
    }
    
	/**
     * 
     * It's a method that verify restriction for the component "com_hikashop"
     * @param object $article
     * @param string $context
     */
	private function isHikaShopRestricted(&$article, $context) {
	    
        // Check for correct context
        if(false === strpos($context, "text")) {
           return true;
        }
        
		// Display content only in the view "product"
        if(strcmp("product", $this->currentView) != 0){
            return true;
        }
        
	    // Check for enabled functionality for that extension
        $displayInDetails     = $this->params->get('hikashop_display', 0);
        if(!$displayInDetails){
            return true;
        }
        
        return false;
    }
    
    private function getUrl(&$article, $context) {

        $uri = "";
        $url = JURI::getInstance();
        $domain= $url->getScheme() ."://" . $url->getHost();
        
        switch($this->currentOption) {
            case "com_content":
            	
            	// It's an implementation of "com_myblog"
            	// I don't know why but $option contains "com_content" for a value
            	// I hope it will be fixed in the future versions of "com_myblog"
            	if(strcmp($context, "com_myblog") != 0) {
                	$uri = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug), false);
                	break;
            	}
            	
            case "com_myblog":
                $uri = $article->permalink;
                break;    
                
                
            case "com_k2":
                $uri = $article->link;
                break;
                
            case "com_virtuemart":
                $uri = $article->link;
                break;
                
            case "com_jevents":
                // Display buttons only in the description
                if (is_a($article, "jIcalEventRepeat")) { 
                    $uri = $this->getCurrentURI($url);
                };
                
                break;

            case "com_easyblog":
            	$uri	= EasyBlogRouter::getRoutedURL( 'index.php?option=com_easyblog&view=entry&id=' . $article->id , false , false );
                break;

            case "com_vipportfolio":
                $uri = JRoute::_($article->link, false);
                break;
                    
            case "com_zoo":
                $uri = $this->getCurrentURI($url);
                break;
                
            case "com_jshopping":
                $uri = $this->getCurrentURI($url);
                break;

            case "com_hikashop":
                $uri = $article->link;
                break;
                
            case "com_vipquotes":
                $uri = $article->link;
                break;
                
            default:
                $uri = "";
                break;   
        }
        
        return $domain.$uri;
        
    }
    
	/**
     * 
     * Generate a URI based on currend URL
     */
    private function getCurrentURI($url) {
        
        $uri    = $url->getPath();
        if($url->getQuery()) {
            $uri .= "?".$url->getQuery();
        }
        
        return $uri;
            
    }
    
    private function getTitle(&$article, $context) {
        
        $title = "";
        
        switch($this->currentOption) {
            case "com_content":
            	
            	// It's an implementation of "com_myblog"
            	// I don't know why but $option contains "com_content" for a value
            	// I hope it will be fixed in the future versions of "com_myblog"
            	if(strcmp($context, "com_myblog") != 0) {
            		$title= $article->title;
            		break;
            	}
                
            case "com_myblog":
                $title= $article->title;
                break;    
                
            case "com_k2":
                $title= $article->title;
                break;
                
            case "com_virtuemart":
                $title = (!empty($article->custom_title)) ? $article->custom_title : $article->product_name;
                break;
                
            case "com_jevents":
                // Display buttons only in the description
                if (is_a($article, "jIcalEventRepeat")) { 
                    
                    $title    = JString::trim($article->title());
                    if(!$title) {
                        $doc     = JFactory::getDocument();
                        /**  @var $doc JDocumentHtml **/
                        $title    =  $doc->getTitle();
                    }
                };
                
                break;   

            case "com_easyblog":
                $title= $article->title;
                break;
                
            case "com_vipportfolio":
                $title = $article->title;
                break;
                    
            case "com_zoo":
                $doc      = JFactory::getDocument();
                /**  @var $doc JDocumentHtml **/
                $title    =  $doc->getTitle();
                break;

            case "com_jshopping":
                $title    = $article->title;
                break;

            case "com_hikashop":
                $title = $article->title;
                break;
                
            case "com_vipquotes":
                $title = $article->title;
                break;
                
            default:
                $title = "";
                break;   
        }
        
        return $title;
        
    }
    
    /**
     * 
     * Generate the HTML code with buttons
     * @param object $article
     */
    private function getContent(&$article, $context){
        
        $url    = $base = rawurlencode( $this->getUrl($article, $context) );
        $title  = rawurlencode( $this->getTitle($article, $context) );
        
        // Convert the url to short one
        if($this->params->get("shortUrlService")) {
            $url = $this->getShortUrl($url);
        }
        
        $html 	= '<div class="itp-social-buttons-box">';
        
        if($this->params->get('showTitle')){
            $html .= '<h4>' . $this->params->get('title') . '</h4>';
        }
        
        $html .='<div class="' . $this->params->get('displayLines') . '">';
        $html .= '<div class="' . $this->params->get('displayIcons') . '">';
        
        // Prepare buttons
        if($this->params->get("displayDelicious")) {
            $html .= $this->getDeliciousButton($title, $url);
        }
        if($this->params->get("displayDigg")) {
            $html .= $this->getDiggButton($title, $url);
        }
        if($this->params->get("displayFacebook")) {
            $html .= $this->getFacebookButton($title, $url);
        }
        if($this->params->get("displayGoogle")) {
            $html .= $this->getGoogleButton($title, $url);
        }
        if($this->params->get("displaySumbleUpon")) {
            $html .= $this->getStumbleuponButton($title, $base);
        }
        if($this->params->get("displayTechnorati")) {
            $html .= $this->getTechnoratiButton($title, $url);            
        }
        if($this->params->get("displayTwitter")) {
            $html .= $this->getTwitterButton($title, $url);
        }
        if($this->params->get("displayLinkedIn")) {
            $html .= $this->getLinkedInButton($title, $url);
        }
        
        // Get additional social buttons
        $html .= $this->getExtraButtons($title, $url, $this->params);
        
        $html .= '</div></div></div>';
        
        return $html;
    }
    
	/**
     * A method that make a long url to short url
     * 
     * @param string $link
     * @param array $params
     * @return string
     */
    private function getShortUrl($link){
        
        JLoader::register("ItpSocialButtonsPluginShortUrl", dirname(__FILE__).DIRECTORY_SEPARATOR."shorturl.php");
        
        $options = array(
            "login"     => $this->params->get("login"),
            "api_key"   => $this->params->get("apiKey"),
            "service"   => $this->params->get("shortUrlService"),
        );

        $shortLink = "";
        try {
            
            $shortUrl  = new ItpSocialButtonsPluginShortUrl($link, $options);
            $shortLink = $shortUrl->getUrl();
            
            // Get original link
            if(!$shortLink) {
                $shortLink = $link;
            } 
            
        } catch(Exception $e) {
            
            JLog::add($e->getMessage());
            
            // Get original link
            if(!$shortLink) {
                $shortLink = $link;
            }
                
        }
        
        return $shortLink;
            
    }
    
    /**
     * Generate a code for the extra buttons. 
     * Is also replace indicators {URL} and {TITLE} with that of the article.
     * 
     * @param string $title Article Title
     * @param string $url   Article URL
     * @param array $params Plugin parameters
     * 
     * @return string
     */
    private function getExtraButtons($title, $url, &$params) {
        
        $html  = "";
        // Extra buttons
        for($i=1; $i < 6;$i++) {
            $btnName = "ebuttons" . $i;
            $extraButton = $params->get($btnName, "");
            if(!empty($extraButton)) {
                
                // Parse ITPrism markup
                if(false !== strpos($extraButton, "<itp:email")) {
                    $matches     = array();
                    if(preg_match('/src="([^"]*)"/i', $extraButton, $matches)) {
                        $extraButton = $this->sendToFriendIcon($matches[1], $url);
                    }
                }
                
                $extraButton = str_replace("{URL}", $url, $extraButton);
                $extraButton = str_replace("{TITLE}", $title, $extraButton);
                $html  .= $extraButton;
            }
        }
        
        return $html;
    }
    
    /**
     * 
     * Generate a link that displays a popup with e-mail form.
     * The form can be used to send page to your friends
     * 
     * @param string $imageSrc
     * @param string $link
     */
    private function sendToFriendIcon($imageSrc, $link) {
        
        JLoader::register("MailToHelper", JPATH_SITE . '/components/com_mailto/helpers/mailto.php');
        
        $link     = rawurldecode($link);
        
		$template = JFactory::getApplication()->getTemplate();
		$url	  = 'index.php?option=com_mailto&tmpl=component&template='.$template.'&link='.MailToHelper::addLink($link);

		$status   = 'width=400,height=350,menubar=yes,resizable=yes';

		$attribs  = array(
		    'title'   => JText::_('JGLOBAL_EMAIL'),
			'onclick' => "window.open(this.href,'win2','".$status."'); return false;"
		);

		$text   = '<img src="'.$imageSrc.'" alt="'. JText::_('PLG_CONTENT_ITPSOCIALBUTTONS_SHARE_WITH_FRIENDS').'" title="'. JText::_('PLG_CONTENT_ITPSOCIALBUTTONS_SHARE_WITH_FRIENDS').'" />';
		
		$output = JHtml::_('link', $url, $text, $attribs);
		return $output;
	}
	
    private function getDeliciousButton($title, $link){
        
        $img_url = $this->plgUrlPath . "images/" . $this->params->get('icons_package') . "/delicious.png";
        
        return '<a href="http://del.icio.us/post?url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Delicious") . '" target="blank" ><img src="' . $img_url . '" alt="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Delicious") . '" /></a>';
    }
    
    private function getDiggButton($title, $link){
        
        $img_url = $this->plgUrlPath . "images/" . $this->params->get('icons_package') . "/digg.png";
        
        return '<a href="http://digg.com/submit?url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Digg") . '" target="blank" ><img src="' . $img_url . '" alt="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Digg") . '" /></a>';
    }
    
    private function getFacebookButton($title, $link){
        
        $img_url = $this->plgUrlPath . "images/" . $this->params->get('icons_package') . "/facebook.png";
        
        return '<a href="http://www.facebook.com/sharer.php?u=' . $link . '&amp;t=' . $title . '" title="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Facebook") . '" target="blank" ><img src="' . $img_url . '" alt="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Facebook") . '" /></a>';
    }
    
    private function getGoogleButton($title, $link){
        
        $img_url = $this->plgUrlPath . "images/" . $this->params->get('icons_package') . "/google.png";
        
        return '<a href="https://plus.google.com/share?url=' . $link . '" title="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Google Plus") . '" target="blank" ><img src="' . $img_url . '" alt="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Google Plus") . '" /></a>';
    }
    
    private function getStumbleuponButton($title, $link){
        
        $img_url = $this->plgUrlPath . "images/" . $this->params->get('icons_package') . "/stumbleupon.png";
        
        return '<a href="http://www.stumbleupon.com/submit?url=' . $link . '&amp;title=' . $title . '" title="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Stumbleupon") . '" target="blank" ><img src="' . $img_url . '" alt="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Stumbleupon") . '" /></a>';
    }
    
    private function getTechnoratiButton($title, $link){
        
        $img_url = $this->plgUrlPath . "images/" . $this->params->get('icons_package') . "/technorati.png";
        
        return '<a href="http://technorati.com/faves?add=' . $link . '" title="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Technorati") . '" target="blank" ><img src="' . $img_url . '" alt="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Technorati") . '" /></a>';
    }
    
    private function getTwitterButton($title, $link){
        
        $img_url = $this->plgUrlPath . "images/" . $this->params->get('icons_package') . "/twitter.png";
        
        return '<a href="http://twitter.com/share?text=' . $title . "&amp;url=" . $link . '" title="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Twitter") . '" target="blank" ><img src="' . $img_url . '" alt="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "Twitter") . '" /></a>';
    }
    
    private function getLinkedInButton($title, $link){
        
        $img_url = $this->plgUrlPath . "images/" . $this->params->get('icons_package') . "/linkedin.png";
        
        return '<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $link .'&amp;title=' . $title . '" title="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "LinkedIn") . '" target="blank" ><img src="' . $img_url . '" alt="' . JText::sprintf("PLG_CONTENT_ITPSOCIALBUTTONS_SUBMIT", "LinkedIn") . '" /></a>';
    }
}
