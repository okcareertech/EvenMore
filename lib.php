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
 * Theme More lib.
 *
 * @package    theme_more
 * @copyright  2014 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Extra LESS code to inject.
 *
 * This will generate some LESS code from the settings used by the user. We cannot use
 * the {@link theme_more_less_variables()} here because we need to create selectors or
 * alter existing ones.
 *
 * @param theme_config $theme The theme config object.
 * @return string Raw LESS code.
 */
function theme_even_more_extra_less($theme)
{
	$content = '';
	$imageurl = $theme->setting_file_url('backgroundimage', 'backgroundimage');
	// Sets the background image, and its settings.
	if (!empty($imageurl))
	{
		$content .= 'body { ';
		$content .= "background-image: url('$imageurl');";
		if (!empty($theme->settings->backgroundfixed))
		{
			$content .= 'background-attachment: fixed;';
		}
		if (!empty($theme->settings->backgroundposition))
		{
			$content .= 'background-position: ' . str_replace('_', ' ', $theme->settings->backgroundposition) . ';';
		}
		if (!empty($theme->settings->backgroundrepeat))
		{
			$content .= 'background-repeat: ' . $theme->settings->backgroundrepeat . ';';
		}
		$content .= ' }';
	}
	// If there the user wants a background for the content, we need to make it look consistent,
	// therefore we need to round its borders, and adapt the border colour.
	if (!empty($theme->settings->contentbackground))
	{
		$content .= '
	#region-main
	{
		.well;
		background-color: ' . $theme->settings->contentbackground . ';
		border-color: darken(' . $theme->settings->contentbackground . ', 7%);
	}';
	}
	return $content;
}

/**
 * Returns variables for LESS.
 *
 * We will inject some LESS variables from the settings that the user has defined
 * for the theme. No need to write some custom LESS for this.
 *
 * @param theme_config $theme The theme config object.
 * @return array of LESS variables without the @.
 */
function theme_even_more_less_variables($theme)
{
	$variables = array();
	if (!empty($theme->settings->bodybackground))
	{
		$variables['bodyBackground'] = $theme->settings->bodybackground;
	}
	if (!empty($theme->settings->textcolor))
	{
		$variables['textColor'] = $theme->settings->textcolor;
	}
	if (!empty($theme->settings->linkcolor))
	{
		$variables['linkColor'] = $theme->settings->linkcolor;
	}
	if (!empty($theme->settings->secondarybackground))
	{
		$variables['wellBackground'] = $theme->settings->secondarybackground;
	}
	return $variables;
}

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param string $css The CSS
 * @param theme_config $theme The theme config object.
 * @return string The parsed CSS The parsed CSS.
 */
function theme_even_more_process_css($css, $theme)
{
	// Set the background image for the logo.
	$logo = $theme->setting_file_url('logo', 'logo');
	$css = theme_even_more_set_logo($css, $logo);
	
	// Set custom CSS.
	if (!empty($theme->settings->customcss))
	{
		$customcss = $theme->settings->customcss;
	}
	else
	{
		$customcss = null;
	}
	$css = theme_even_more_set_customcss($css, $customcss);
	
	return $css;
}

/**
 * Adds the logo to CSS.
 *
 * @param string $css The CSS.
 * @param string $logo The URL of the logo.
 * @return string The parsed CSS
 */
function theme_even_more_set_logo($css, $logo)
{
	$tag = '[[setting:logo]]';
	$replacement = $logo;
	if (is_null($replacement))
	{
		$replacement = '';
	}
	
	$css = str_replace($tag, $replacement, $css);
	
	return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_even_more_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
	//check for slideshow theme images
	$blocksliderAreasStartWith = 'blocksliderimage';
	$isSlideshowArea = strncmp($filearea,$blocksliderAreasStartWith,strlen($blocksliderAreasStartWith)) == 0;
	
	//get the file
	if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === 'logo' || $filearea === 'backgroundimage' || $isSlideshowArea)) {
		$theme = theme_config::load('even_more');
		// By default, theme files must be cache-able by both browsers and proxies.
		if (!array_key_exists('cacheability', $options)) {
			$options['cacheability'] = 'public';
		}
		return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
	} else {
		send_file_not_found();
	}
}

/**
 * Adds any custom CSS to the CSS before it is cached.
 *
 * @param string $css The original CSS.
 * @param string $customcss The custom CSS to add.
 * @return string The CSS which now contains our custom CSS.
 */
function theme_even_more_set_customcss($css, $customcss)
{
	$tag = '[[setting:customcss]]';
	$replacement = $customcss;
	if (is_null($replacement))
	{
		$replacement = '';
	}
	
	$css = str_replace($tag, $replacement, $css);
	
	return $css;
}

/**
 * Returns an object containing HTML for the areas affected by settings.
 *
 * Do not add Clean specific logic in here, child themes should be able to
 * rely on that function just by declaring settings with similar names.
 *
 * @param renderer_base $output Pass in $OUTPUT.
 * @param moodle_page $page Pass in $PAGE.
 * @return stdClass An object with the following properties:
 *      - navbarclass A CSS class to use on the navbar. By default ''.
 *      - heading HTML to use for the heading. A logo if one is selected or the default heading.
 *      - footnote HTML to use as a footnote. By default ''.
 */
function theme_even_more_get_html_for_settings(renderer_base $output, moodle_page $page)
{
	global $CFG;
	$return = new stdClass;
	
	$return->navbarclass = '';
	if (!empty($page->theme->settings->invert))
	{
		$return->navbarclass .= ' navbar-inverse';
	}
	
	if (!empty($page->theme->settings->logo))
	{
		$return->heading = html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
	}
	else
	{
		$return->heading = $output->page_heading();
	}
	
	$return->footnote = '';
	if (!empty($page->theme->settings->footnote))
	{
		$return->footnote = '<div class="footnote text-center">'.format_text($page->theme->settings->footnote).'</div>';
	}
	
	return $return;
}


function theme_even_more_page_init(moodle_page $page)
{
	global $CFG;
	$page->requires->jquery();
	$page->requires->jquery_plugin('bootstrap', 'theme_even_more');
	$page->requires->jquery_plugin('flexslider', 'theme_even_more');
	$page->requires->jquery_plugin('easing', 'theme_even_more');
	$page->requires->jquery_plugin('even_more', 'theme_even_more');
}
