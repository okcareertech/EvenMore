<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Moodle's Clean theme, an example of how to make a Bootstrap theme
 *
 * DO NOT MODIFY THIS THEME!
 * COPY IT FIRST, THEN RENAME THE COPY AND MODIFY IT INSTEAD.
 *
 * For full information about creating Moodle themes, see:
 * http://docs.moodle.org/dev/Themes_2.0
 *
 * @package   theme_clean
 * @copyright 2013 Moodle, moodle.org
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Get the HTML for the settings bits.
$html = theme_even_more_get_html_for_settings($OUTPUT, $PAGE);

if (right_to_left()) {
	$regionbsid = 'region-bs-main-and-post';
} else {
	$regionbsid = 'region-bs-main-and-pre';
}

//used to display up to 4 columns in a layout
function displayUpTo4Columns($block1,$block2,$block3,$block4)
{
	echo "<!-- start of displayUpTo4Columns function -->\n";
	//determine number of columns in use
	$numOfColumns = 0;
	$feature1 = false;
	$feature2 = false;
	$feature3 = false;
	$feature4 = false;
	if(!empty($block1))
	{
		$numOfColumns += 1;
		$feature1 = true;
	}
	if(!empty($block2))
	{
		$numOfColumns += 1;
		$feature2 = true;
	}
	if(!empty($block3))
	{
		$numOfColumns += 1;
		$feature3 = true;
	}
	if(!empty($block4))
	{
		$numOfColumns += 1;
		$feature4 = true;
	}
	
	//determine the CSS class for the columns
	switch($numOfColumns)
	{
		case 1:
			$className = "c4of4";
			break;
		case 2:
			$className = "c2of4";
			break;
		case 3:
			$className = "c1of3";
			break;
		case 4:
			$className = "c1of4";
			break;
	}
	//display the columns
	if($numOfColumns > 0)
	{
	?>
	<div class="even-more-row">
		<?php
		if($feature1)
		{
		?>
		<div class="column <?php echo $className; ?>">
			<?php echo $block1; ?>
		</div>
		<?php
		}
		if($feature2)
		{
		?>
		<div class="column <?php echo $className; ?>">
			<?php echo $block2; ?>
		</div>
		<?php
		}
		if($feature3)
		{
		?>
		<div class="column <?php echo $className; ?>">
			<?php echo $block3; ?>
		</div>
		<?php
		}
		if($feature4)
		{
		?>
		<div class="column <?php echo $className; ?>">
			<?php echo $block4; ?>
		</div>
		<?php
		}
		?>
	</div>
	<?php
	}//end of display the columns
	echo "<!-- end of displayUpTo4Columns function -->\n";
}


echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
	<title><?php echo $OUTPUT->page_title(); ?></title>
	<link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
	<?php echo $OUTPUT->standard_head_html() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
<!-- even_more:frontpage.php -->
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner" class="navbar navbar-fixed-top<?php echo $html->navbarclass ?> moodle-has-zindex">
	<nav role="navigation" class="navbar-inner">
		<div class="container-fluid">
			<a class="brand" href="<?php echo $CFG->wwwroot;?>"><?php echo
				format_string($SITE->shortname, true, array('context' => context_course::instance(SITEID)));
				?></a>
			<a class="btn btn-navbar" data-toggle="workaround-collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="nav-collapse collapse">
				<?php echo $OUTPUT->custom_menu(); ?>
				<ul class="nav pull-right">
					<li><?php echo $OUTPUT->page_heading_menu(); ?></li>
					<li class="navbar-text"><?php echo $OUTPUT->login_info() ?></li>
				</ul>
			</div>
		</div>
	</nav>
    <div class="page-overlap-hack">
    </div>
</header>

<div id="page" class="container-fluid">
	
	<header id="page-header" class="clearfix">
		<?php echo $html->heading; ?>
		<div id="page-navbar" class="clearfix">
			<nav class="breadcrumb-nav"><?php echo $OUTPUT->navbar(); ?></nav>
			<div class="breadcrumb-button"><?php echo $OUTPUT->page_heading_button(); ?></div>
		</div>
		<div id="course-header">
			<?php echo $OUTPUT->course_header(); ?>
		</div>
	</header>
	
	<?php
	/*************************
	 * slideshow feature row *
	 *************************/
	
	//local constants
	$MAX_SLIDES=5; //hard-coded number of slideshow images
	
	//local vars
	$settings = $PAGE->theme->settings;
	$slideshowImages = array();
	$renderSlideshow = false;
	$showRow = false;
	
	//get the slideshow images
	for($i=1;$i<=$MAX_SLIDES;$i++)
	{
		//get the variable variable
		$variableName = 'blocksliderimage'.$i;
		if(!empty($PAGE->theme->settings->{$variableName}))
		{
			//get the image source
			$image = array();
			$image['src'] = $PAGE->theme->setting_file_url($variableName,$variableName);
			
			//get the image link url
			$linkVariableName = $variableName.'url';
			$image['url'] = (!empty($PAGE->theme->settings->{$linkVariableName}))?($PAGE->theme->settings->{$linkVariableName}):('#');
			
			//get the image caption
			$captionVariableName = $variableName.'caption';
			$image['caption'] = (!empty($PAGE->theme->settings->{$captionVariableName}))?($PAGE->theme->settings->{$captionVariableName}):('');
			
			//append the image the array
			$slideshowImages[] = $image;
			
			//turn on the flag to show the row
			$showRow = true;
			$renderSlideshow = true;
		}
		else
		{
			//do nothing
		}
	}
	//check for the other non-slideshow features
	$block1 = $PAGE->theme->settings->blocksliderfeature01;
	$block2 = $PAGE->theme->settings->blocksliderfeature02;
	$renderFeature1 = false;
	$renderFeature2 = false;
	if(!empty($block1))
	{
		$showRow = true;
		$renderFeature1 = true;
	}
	if(!empty($block2))
	{
		$showRow = true;
		$renderFeature2 = true;
	}
	
	
	if($showRow)
	{
		//determine feature CSS classes
		if($renderSlideshow && ($renderFeature1 || $renderFeature2))
		{
			//case: slideshow and at least 1 other feature
			$slideshowClass = "c3of4";
			$featureClass = "c1of4";
		}
		elseif($renderSlideshow && !($renderFeature1 || $renderFeature2))
		{
			//case: slideshow and no other features
			$slideshowClass = "c4of4";
			$featureClass = "N/A";
		}
		elseif($renderFeature1 && $renderFeature2)
		{
			//case: no slideshow and both other features
			$slideshowClass = "N/A";
			$featureClass = "c2of4";
		}
		else
		{
			//case: no slideshow and only 1 other feature
			$slideshowClass = "N/A";
			$featureClass = "c4of4";
		}
		?>
		<div class="even-more-row">
			<?php
			
			//check to see if there are slideshow images that need to be rendered
			if($renderSlideshow)
			{
			?>
			<div class="column <?php echo $slideshowClass; ?>">
				<div class="container slidewrap">
					<div id="main-slider" class="flexslider">
						<ul class="slides">
							<?php
							//loop through images and render accordingly
							foreach($slideshowImages as $image)
							{
								//strip the formatting from the caption for accessibility
								$accessibleCaption = str_replace('<p>','. ',$image['caption']); //creates proper spacing between words for screen readers
								$accessibleCaption = strip_tags($accessibleCaption);
								?>
								<li>
									<a href="<?php echo $image['url']; ?>">
										<img src="<?php echo $image['src']; ?>" alt="<?php echo $accessibleCaption; ?>"/>
										<div class="flex-caption">
											<?php echo $image['caption']; ?>
										</div>
									</a>
								</li>
								<?php
							}
							?>
						</ul>
					</div>
				</div>
			</div>
			<?php
			}// end of if($renderSlideshow)
			else
			{
				//do nothing
			}
			?>
			<?php
			if($renderFeature1)
			{
			?>
			<div class="column <?php echo $featureClass;?>">
				<?php echo $PAGE->theme->settings->blocksliderfeature01; ?>
			</div>
			<?php
			}
			if($renderFeature2)
			{
			?>
			<div class="column <?php echo $featureClass;?>">
				<?php echo $PAGE->theme->settings->blocksliderfeature02; ?>
			</div>
			<?php
			}
			?>
		</div>
	<?php
	}//end of if($showRow)
	?>
	
	
	
	<?php
	/**********************
	 * other feature rows *
	 **********************/
	
	//full width block
	displayUpTo4Columns($PAGE->theme->settings->blockfullwidthfeature01,null,null,null);
	
	//row 1 of up to 4 columns
	displayUpTo4Columns($PAGE->theme->settings->blockrow01feature01,
	                    $PAGE->theme->settings->blockrow01feature02,
	                    $PAGE->theme->settings->blockrow01feature03,
	                    $PAGE->theme->settings->blockrow01feature04);
	
	//row 2 of up to 4 columns
	displayUpTo4Columns($PAGE->theme->settings->blockrow02feature01,
	                    $PAGE->theme->settings->blockrow02feature02,
	                    $PAGE->theme->settings->blockrow02feature03,
	                    $PAGE->theme->settings->blockrow02feature04);
	
	?>
	<div id="page-content" class="row-fluid">
		<div id="<?php echo $regionbsid ?>" class="span9">
			<div class="row-fluid">
				<section id="region-main" class="span8 pull-right">
					<?php
					echo $OUTPUT->course_content_header();
					echo $OUTPUT->main_content();
					echo $OUTPUT->course_content_footer();
					?>
				</section>
				<?php echo $OUTPUT->blocks('side-pre', 'span4 desktop-first-column'); ?>
			</div>
		</div>
		<?php echo $OUTPUT->blocks('side-post', 'span3'); ?>
	</div>

	<footer id="page-footer">
		<div id="course-footer"><?php echo $OUTPUT->course_footer(); ?></div>
		<p class="helplink"><?php echo $OUTPUT->page_doc_link(); ?></p>
		<?php
		echo $html->footnote;
		echo $OUTPUT->login_info();
		echo $OUTPUT->home_link();
		echo $OUTPUT->standard_footer_html();
		?>
	</footer>

	<?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</body>
</html>
