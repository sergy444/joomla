<?php
/*
* @package Alpine
* @copyright (C) 2014 by mojoomla.com - All rights reserved!
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author mojoomla.com <sales@mojoomla.com>
*/
?>
<?php ini_set("display_errors","0");
$app = JFactory::getApplication();
$menu   = $app->getMenu();
$menu1 = $menu->getActive();
//Page title
$pagetitle = $menu1->title;
$doc =& JFactory::getDocument();
$app = JFactory::getApplication();

require("php/variables.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no" />
<meta name="description" content="Responsive One Page HTML5/CSS3 Parallax Site Template" />
<meta name="author" content="Dasinfomedia">
<!-- GoogleFontFamily -->
<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
<!-- Stylesheet -->
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/normalize.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/flexslider.css" rel="stylesheet">
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/style.css" rel="stylesheet">
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/style-responsive.css" rel="stylesheet">
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/isotope.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/accordion/accordion.css">
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/html/com_virtuemart/assets/css/vmsite-ltr.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/html/com_virtuemart/assets/css/chosen.css" rel="stylesheet" type="text/css" />
<!-- Primary color theme -->
<?php
$tplthemecolor = $this->params->get('themecolor');
$_SESSION['themecolor'] = $tplthemecolor;
?>
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/color/<?php echo $_SESSION['themecolor']; ?>.css" rel="stylesheet" type="text/css" />
<link rel = "stylesheet" media = "screen" href = "<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/color-switcher.css" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/color/blu.css" title="blu" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/color/green.css" title="green" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/color/light-violet.css" title="light-violet" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/color/orange.css" title="orange" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/color/red.css" title="red" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/color/violet.css" title="violet" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/selectbox.css" rel="stylesheet" type="text/css" />
<?php  
// Include rtl css 
if($_SESSION['rtl_onoff'] == '1') : ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template_rtl.css" type="text/css" />
<?php endif; ?>
<?php
	if((!$this->countModules('mj-left')) && (!$this->countModules('mj-right')) ) {
	$cls = "col-md-12";
	}
	if((!$this->countModules('mj-left')) && ($this->countModules('mj-right')) )
    {
	$cls = "col-md-9";
	}
	if(($this->countModules('mj-left')) && (!$this->countModules('mj-right')) )
    {
	$cls = "col-md-9";
	}
?>
<?php 
require("php/styles.php");
?>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<?php if ($menu->getActive() == $menu->getDefault()) { ?>
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/condition.css" rel="stylesheet" type="text/css" />
<?php } ?>
<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/style-switcher/jquery-1.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/style-switcher/styleselector.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/style-switcher/styleswitcher.js"></script>
<jdoc:include type="head" />
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="75">
<!-- Intro loader -->
<div class="mask">
  <div id="intro-loader"></div>
</div>
<!-- Intro loader -->
<!-- Home Section -->
       
<?php if($this->countModules('mj-slider')) { ?>
<section id="home" class="intro-pattern" data-stellar-background-ratio="0.6" data-stellar-vertical-offset="20">
  <jdoc:include type="modules" name="mj-slider" style="xhtml" />
</section>
<?php } ?>

<!-- End Home Section -->
<!-- Navbar -->
<?php if($this->countModules('mj-menu')) { ?>
<div id="navigation" class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="navbar-inner">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <i class="fa fa-bars fa-2x"></i> </button>
      <?php
           if($this->params->get('logoFile')==NULL)
            {
            ?>
      <a id="brand" class="navbar-brand" href="#home"> <img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/img/logo.png" alt=""> </a>
      <?php
           }
          else
         {
         ?>
      <a href="<?php echo $this->baseurl; ?>"><img src="<?php echo $logo; ?>" alt="logo" /></a>
      <?php }  ?>
    </div>
    <jdoc:include type="modules" name="mj-menu" style="xhtml" />
  </div>
</div>
<?php } ?>
<!-- End Navbar -->
<!-- Breadcrumbs -->
<?php if($this->countModules('mj-breadcrumbs')) { ?>
<div class="topbar">
  <div class="col-md-8">
    <jdoc:include type="modules" name="mj-breadcrumbs" style="xhtml" />
  </div>
  <div class="col-md-4">
    <jdoc:include type="modules" name="mj-topbar" style="xhtml" />
  </div>
</div>
<?php } ?>
<!-- Breadcrumbs -->
<!-- Content -->
<?php if($this->countModules('mj-position5')) { ?>
<div class="parallax" style="background-image: url('templates/alpine/images/separator2.jpg');" data-stellar-background-ratio="0.6" data-stellar-vertical-offset="20">
  <div class="parallax-overlay">
    <div class="vm-content">
      <div class="text-center">
        <jdoc:include type="modules" name="mj-position5" style="xhtml" />
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if(($this->countModules('mj-position3_1')) || ($this->countModules('mj-position3_2')))   { ?>
<div class="layout2_fusection1">
  <div class="container vm-content">
    <div class="section-title text-center">
      <div class="col-md-9">
        <div class="left">
          <jdoc:include type="modules" name="mj-position3_1" style="xhtml" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="right">
          <jdoc:include type="modules" name="mj-position3_2" style="xhtml" />
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
	 
	 } ?>
<?php if($this->countModules('mj-position4')) { ?>
<div class="parallax" style="background-image: url('templates/alpine/images/separator3.jpg');" data-stellar-background-ratio="0.6" data-stellar-vertical-offset="20">
  <div class="parallax-overlay parallax-background-color">
    <div class="vm-content">
      <div class="text-center">
        <jdoc:include type="modules" name="mj-position4" style="xhtml" />
      </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="container">
  <?php if($this->countModules('mj-left')) { ?>
  <div class="col-md-3">
    <jdoc:include type="modules" name="mj-left" style="xhtml" />
  </div>
  <?php } ?>
  <div class="<?php echo $cls; ?> shopcontent">
    <jdoc:include type="message" />
    <?php if ($menu->getActive() != $menu->getDefault()) { ?>
    <section id="#Joomla" class="vm-content">
      <jdoc:include type="component" />
    </section>
    <?php } ?>
  </div>
  <?php if($this->countModules('mj-right')) { ?>
  <div class="col-md-3 shopright">
    <div class="right_sidebar">
      <jdoc:include type="modules" name="mj-right" style="xhtml" />
    </div>
  </div>
  <?php } ?>
</div>
<?php if($this->countModules('mj-position7')) { ?>
<div class="clients">
  <jdoc:include type="modules" name="mj-position7" style="xhtml" />
</div>
<?php } ?>
<!-- End Content -->
<!-- About Section -->
<?php if($this->countModules('mj-aboutus')) { ?>
<section id="about" class="section-content">
  <jdoc:include type="modules" name="mj-aboutus" style="xhtml" />
</section>
<?php } ?>
<!-- About Section -->
<!-- Parallax Container -->
<?php if($this->countModules('mj-aboutus_parallax')) { ?>
<jdoc:include type="modules" name="mj-aboutus_parallax" style="xhtml" />
<?php } ?>
<!-- Parallax Container -->
<!-- Service Section -->
<?php if($this->countModules('mj-services')) { ?>
<section id="service" class="section-content">
  <jdoc:include type="modules" name="mj-services" style="xhtml" />
</section>
<?php } ?>
<!-- Service Section -->
<!-- Parallax Container -->
<?php if($this->countModules('mj-services_parallax')) { ?>
<jdoc:include type="modules" name="mj-services_parallax" style="xhtml" />
<?php } ?>
<!-- Parallax Container -->
<!-- Portfolio Section -->
<?php if($this->countModules('mj-portfolio')) { ?>
<section id="portfolio" class="section-content">
  <jdoc:include type="modules" name="mj-portfolio" style="xhtml" />
  <jdoc:include type="modules" name="mj-spportfolio" style="xhtml" />
</section>
<?php } ?>
<!-- Portfolio Section -->
<!-- Parallax Container -->
<?php if($this->countModules('mj-portfolio_parallax')) { ?>
<jdoc:include type="modules" name="mj-portfolio_parallax" style="xhtml" />
<?php } ?>
<!-- Parallax Container -->
<!-- Team Section -->
<?php if($this->countModules('mj-team')) { ?>
<section id="team" class="section-content">
  <jdoc:include type="modules" name="mj-team" style="xhtml" />
</section>
<?php } ?>
<!-- Team Section -->
<!-- Parallax Container -->
<?php if($this->countModules('mj-team_parallax')) { ?>
<jdoc:include type="modules" name="mj-team_parallax" style="xhtml" />
<?php } ?>
<!-- Parallax Container -->
<!-- Client Section -->
<?php if($this->countModules('mj-client')) { ?>
<section id="client" class="section-content">
  <jdoc:include type="modules" name="mj-client" style="xhtml" />
</section>
<?php } ?>
<!-- Client Section -->
<!-- Parallax Container -->
<?php if($this->countModules('mj-client_parallax')) { ?>
<jdoc:include type="modules" name="mj-client_parallax" style="xhtml" />
<?php } ?>
<!-- Parallax Container -->
<!-- Pricing Section -->
<?php if($this->countModules('mj-pricing')) { ?>
<section id="pricing" class="section-content">
  <jdoc:include type="modules" name="mj-pricing" style="xhtml" />
</section>
<?php } ?>
<!-- Pricing Section -->
<!-- Parallax Container -->
<?php if($this->countModules('mj-pricing_parallax')) { ?>
<jdoc:include type="modules" name="mj-pricing_parallax" style="xhtml" />
<?php } ?>
<!-- Parallax Container -->
<!-- Blog Section -->
<?php if($this->countModules('mj-blog')) { ?>
<section id="blog" class="section-content timeline-content bgdark">
  <jdoc:include type="modules" name="mj-blog" style="xhtml" />
</section>
<?php } ?>
<!-- Blog Section -->
<!-- Parallax Container -->
<?php if($this->countModules('mj-blog_parallax')) { ?>
<jdoc:include type="modules" name="mj-blog_parallax" style="xhtml" />
<?php } ?>
<!-- Parallax Container -->
<!-- Contact Section -->
<section id="contact" class="section-content">
  <!-- Section title -->
  <?php if($this->countModules('mj-contactus')) { ?>
  <div class="container">
    <jdoc:include type="modules" name="mj-contactus" style="xhtml" />
  </div>
  <?php } ?>
  <!-- Section title -->
  <!-- Google maps print -->
  <?php if($this->countModules('mj-map')) { ?>
  <div id="map" class="element-line">
    <jdoc:include type="modules" name="mj-map" style="xhtml" />
  </div>
  <?php } ?>
  <!-- Google maps print -->
  <!-- form contact -->
  <?php if($this->countModules('mj-contactform')) { ?>
  <div class="container">
    <div class="element-line">
      <jdoc:include type="modules" name="mj-contactform" style="xhtml" />
    </div>
  </div>
  <?php } ?>
  <!-- form contact -->
</section>
<!-- Contact Section -->
<!-- Back to top -->
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>
<?php if($this->countModules('mj-contactus_copyright')) { ?>
<footer class="text-center">
  <jdoc:include type="modules" name="mj-contactus_copyright" style="xhtml" />
</footer>
<?php } ?>
<!-- Js Library -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.cycle.all.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/modernizr.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.mb.YTPlayer.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.sticky.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.fitvids.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.easing-1.3.pack.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.parallax-1.1.3.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery-countTo.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.appear.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.easy-pie-chart.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.maximage.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.isotope.min.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/skrollr.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.hoverdir.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.validate.min.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/script.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/retina-1.1.0.min.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery.flexslider-min.js" type="text/javascript">        </script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/etalage.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/accordion/custom.js"></script>
<?php  
// Include rtl css 
if($_SESSION['rtl_onoff'] == '1') : ?>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/etalage_rtl.js"></script>
<?php endif; ?>
<!--<div id="style-selector">
  <div class="style-selector-wrapper"> <span class="title">Choose Theme Options</span>
    <div> <span class="title-sub"></span> <span class="title-sub2">Predefined Color Skins</span>
      <ul class="styles">
        <li><a href="#" onClick="setActiveStyleSheet('blu'); return false;"><span class="pre-color-skin1"></span></a></li>
        <li><a href="#" onClick="setActiveStyleSheet('green'); return false;"><span class="pre-color-skin2"></span></a></li>
        <li><a href="#" onClick="setActiveStyleSheet('light-violet'); return false;"><span class="pre-color-skin3"></span></a></li>
        <li><a href="#" onClick="setActiveStyleSheet('orange'); return false;"><span class="pre-color-skin4"></span></a></li>
        <li><a href="#" onClick="setActiveStyleSheet('red'); return false;"><span class="pre-color-skin5"></span></a></li>
        <li><a href="#" onClick="setActiveStyleSheet('violet'); return false;"><span class="pre-color-skin6"></span></a></li>
      </ul>
      <a href="#" class="close showmore icon-chevron-right"></a> </div>
  </div>
</div>-->
<!-- Js Library -->
</body>
</html>
