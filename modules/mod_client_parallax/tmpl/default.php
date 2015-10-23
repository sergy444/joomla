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
$document = &JFactory::getDocument();

  $content_slides = array();
	 
	if($p5img1 != "")
	{	
 		$one = array($p5img1, $p5link1);
		array_push($content_slides, $one);
	}
	
	if($p5img2 != "")
	{	
 		$two = array($p5img2, $p5link2);
		array_push($content_slides, $two);
	}
	
	if($p5img3 != "")
	{	
 		$three = array($p5img3, $p5link3);
		array_push($content_slides, $three);
	}
	
	if($p5img4 != "")
	{	
 		$four = array($p5img4, $p5link4);
		array_push($content_slides, $four);
	}
	
	if($p5img5 != "")
	{	
 		$five = array($p5img5, $p5link5);
		array_push($content_slides, $five);
	}
	
	if($p5img6 != "")
	{	
 		$six = array($p5img6, $p5link6);
		array_push($content_slides, $six);
	}

 ?>
<div class="<?php echo $moduleclass_sfx ?>">
 
 <div id="five-parallax" class="parallax" data-stellar-background-ratio="0.6" data-stellar-vertical-offset="20">
			<div class="parallax-overlay parallax-background-color">
				<div class="section-content">
					<div class="container text-center">

						<!-- Parallax title -->
						<h1><?php echo $p5title1; ?></h1>
						<p class="lead">
							<?php echo $p5title2; ?>
						</p>
						<!-- Parallax title -->

						<!-- Parallax content -->
						<div class="parallax-content">
							<div class="row text-center client-list">

								<!-- Client item -->
                                 <?php 
								$j=0;
								for($i = 1; $i <= count($content_slides); $i++ )
								 {?>
								<div class="col-md-2 col-sm-4 col-md-2 col-xs-6">
									<div class="element-line">
										<div class="item_right">
                                        
											<a href="<?php  echo $content_slides[$j][1]; ?>" class="zoom"> <img class="img-responsive" src="<?php  echo $content_slides[$j][0]; ?>" alt=""> </a>
                                
										</div>
									</div>
								</div>
                                
                                <?php $j++; } ?>
								<!-- Client item -->

							</div>
						</div>
						<!-- Parallax content -->

					</div>
				</div>
			</div>
		</div>
 
</div>

<?php
$document->addStyleDeclaration('
		#five-parallax {
			background-image:url(../'.$p5bg.');	
		}');
  ?>