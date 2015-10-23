<?php 
/**
* Mj Slideshow view file
* @copyright (C) 2012 by Dasinfomedia - All rights reserved!
* @package Mj-Slideshow
* @license GNU/GPL, see LICENSE.php
*/

//No Direct Access
defined('_JEXEC') or die('Restricted Access');

//Sllideshow effect

//Taking the Contents of Slideshow in an Array. Making Both Image and It's title Compulsory.

	$content_slides = array();
	if($img1 != "" && $title1 != "")
	{	
 		$one = array($img1, $title1, $title11, $desc1,$link1);
		array_push($content_slides, $one);
	}
	
	if($img2 != "" && $title2 != "")
	{	
 		$two = array($img2, $title2, $title22, $desc2 , $link2);
		array_push($content_slides, $two);
	}
	
	if($img3 != "" && $title3 != "")
	{	
 		$three = array($img3, $title3, $title33, $desc3, $link3);
		array_push($content_slides, $three);
	}
	
	if($img4 != "" && $title4 != "")
	{	
 		$four = array($img4, $title4, $title44, $desc4, $link4);
		array_push($content_slides, $four);
	}
	
	if($img5 != "" && $title5 != "")
	{	
 		$five = array($img5, $title5, $title55, $desc5, $link5);
		array_push($content_slides, $five);
	}


$document = &JFactory::getDocument();

//Add js and css for slideshow.


// for only effect 1
if(($SelectEffect==1))
{
?>

<div class="intro-pattern">
  <div class="text-slider">
    <div class="intro-item">
      <div class="intro-flexslider">
        <ul class="slides">
          <?php 
                        $j=0;
                        for($i = 1; $i <= count($content_slides); $i++ )
                          {?>
          <li>
            <div class="section-title text-center">
              <h1>
                <?php  echo $content_slides[$j][1]; ?>
              </h1>
              <p class="lead">
                <?php  echo $content_slides[$j][3]; ?>
              </p>
            </div>
            <div class="mybutton ultra"> <a class="start-button" href="<?php  echo $content_slides[$j][4]; ?>"> <span data-hover="<?php echo $btnhover; ?>"><?php echo $btntitle; ?></span> </a> </div>
          </li>
          <?php $j++; } ?>
        </ul>
      </div>
      
    </div>
  </div>
</div>

<?php
$document->addStyleDeclaration('
		.intro-pattern {
			background:url('.$bgimg.') no-repeat scroll center center #000000;	
		}');
  ?>

<?php
}

if(($SelectEffect==2))
{
?>

            <a id="slider_left" class="fullscreen-slider-arrow"><img src="templates/alpine/img/arrow_left.png" alt="Slide Left" /></a>
			<a id="slider_right" class="fullscreen-slider-arrow"><img src="templates/alpine/img/arrow_right.png" alt="Slide Right" /></a>

			<div id="fullscreen-slider">
				<!-- Slider item -->
                <?php 
				$j=0;
				for($i = 1; $i <= count($content_slides); $i++ )
				  {?>
				<div class="slider-item">
                
					<img src="<?php  echo $content_slides[$j][0]; ?>" alt="slideshow">
					<div class="pattern">
						<div class="slide-content">

							<!-- Section title -->
							<div class="section-title text-center">
								<div>
									<span class="line big"></span>
									<span><?php  echo $content_slides[$j][2]; ?></span>
									<span class="line big"></span>
								</div>
								<h1><?php  echo $content_slides[$j][1]; ?></h1>
								<p class="lead">
									<?php  echo $content_slides[$j][3]; ?>
								</p>
								<div class="mybutton ultra">
									<a class="start-button" href="<?php  echo $content_slides[$j][4]; ?>"> <span data-hover="<?php echo $btnhover; ?>"><?php echo $btntitle; ?></span> </a>
								</div>
							</div>
							<!-- Section title -->

						</div>
					</div>
                  
				</div>
                 <?php $j++; } ?>
				<!-- Slider item -->

				<!-- Slider item -->
				
				<!-- Slider item -->

			</div>

<?php }  ?>

<?php
if(($SelectEffect==3))
{
?>

   
			<div class="intro-video">
				<!-- Video Background - Here you need to replace the videoURL with your youtube video URL -->
				<a id="video-volume" onClick="$('#bgndVideo').toggleVolume()"><i class="fa fa-volume-down"></i></a>
                <a id="bgndVideo" class="player" data-property="{videoURL:'<?php echo $url; ?>',containment:'body',autoPlay:true, mute:true, startAt:115, opacity:1}">youtube</a>
				<!--/Video Background -->

				<div class="text-slider">
    <div class="intro-item">
      <div class="intro-flexslider">
        <ul class="slides">
          <?php 
                        $j=0;
                        for($i = 1; $i <= count($content_slides); $i++ )
                          {?>
          <li>
            <div class="section-title text-center">
              <h1>
                <?php  echo $content_slides[$j][1]; ?>
              </h1>
              <p class="lead">
                <?php  echo $content_slides[$j][3]; ?>
              </p>
            </div>
            <div class="mybutton ultra"> <a class="start-button" href="<?php  echo $content_slides[$j][4]; ?>"> <span data-hover="<?php echo $btnhover; ?>"><?php echo $btntitle; ?></span> </a> </div>
          </li>
          <?php $j++; } ?>
        </ul>
      </div>
      
    </div>
  </div>
			</div>
	
    
<?php } ?>	