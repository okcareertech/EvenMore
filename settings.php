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
 * Theme More settings.
 *
 * Each setting that is defined in the parent theme Clean should be
 * defined here too, and use the exact same config name. The reason
 * is that theme_even_more does not define any layout files to re-use the
 * ones from theme_clean. But as those layout files use the function
 * {@link theme_clean_get_html_for_settings} that belong to Clean,
 * we have to make sure it works as expected by having the same settings
 * in our theme.
 *
 * @see        theme_clean_get_html_for_settings
 * @package    theme_even_more
 * @copyright  2015 State of Oklahoma
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings = null; //no root level settings page when clicking on theme name

defined('MOODLE_INTERNAL') || die;

if (is_siteadmin()) {
	//add an entry for the EvenMore theme
	$ADMIN->add('themes', new admin_category('theme_even_more','EvenMore'));
	
	//create a general settings page
	$temp = new admin_settingpage('theme_even_more_general',get_string('generalsettings','theme_even_more'));
	$temp->add(new admin_setting_heading('theme_even_more_general', 
	                                     get_string('generalsettingsheading','theme_even_more'),
	                                     format_text(get_string('generalsettingsdescription','theme_even_more'),FORMAT_MARKDOWN)));

	// @textColor setting.
	$name = 'theme_even_more/textcolor';
	$title = get_string('textcolor', 'theme_even_more');
	$description = get_string('textcolor_desc', 'theme_even_more');
	$default = '#333333';
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, null, false);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// @linkColor setting.
	$name = 'theme_even_more/linkcolor';
	$title = get_string('linkcolor', 'theme_even_more');
	$description = get_string('linkcolor_desc', 'theme_even_more');
	$default = '#BB0000';
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, null, false);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// @bodyBackground setting.
	$name = 'theme_even_more/bodybackground';
	$title = get_string('bodybackground', 'theme_even_more');
	$description = get_string('bodybackground_desc', 'theme_even_more');
	$default = '#FFFFFF';
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, null, false);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Background image setting.
	$name = 'theme_even_more/backgroundimage';
	$title = get_string('backgroundimage', 'theme_even_more');
	$description = get_string('backgroundimage_desc', 'theme_even_more');
	$setting = new admin_setting_configstoredfile($name, $title, $description, 'backgroundimage');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Background repeat setting.
	$name = 'theme_even_more/backgroundrepeat';
	$title = get_string('backgroundrepeat', 'theme_even_more');
	$description = get_string('backgroundrepeat_desc', 'theme_even_more');;
	$default = 'repeat';
	$choices = array('0' => get_string('default'),
	                 'repeat' => get_string('backgroundrepeatrepeat', 'theme_even_more'),
	                 'repeat-x' => get_string('backgroundrepeatrepeatx', 'theme_even_more'),
	                 'repeat-y' => get_string('backgroundrepeatrepeaty', 'theme_even_more'),
	                 'no-repeat' => get_string('backgroundrepeatnorepeat', 'theme_even_more'),
	                );
	$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Background position setting.
	$name = 'theme_even_more/backgroundposition';
	$title = get_string('backgroundposition', 'theme_even_more');
	$description = get_string('backgroundposition_desc', 'theme_even_more');
	$default = '0';
	$choices = array('0' => get_string('default'),
	                 'left_top' => get_string('backgroundpositionlefttop', 'theme_even_more'),
	                 'left_center' => get_string('backgroundpositionleftcenter', 'theme_even_more'),
	                 'left_bottom' => get_string('backgroundpositionleftbottom', 'theme_even_more'),
	                 'right_top' => get_string('backgroundpositionrighttop', 'theme_even_more'),
	                 'right_center' => get_string('backgroundpositionrightcenter', 'theme_even_more'),
	                 'right_bottom' => get_string('backgroundpositionrightbottom', 'theme_even_more'),
	                 'center_top' => get_string('backgroundpositioncentertop', 'theme_even_more'),
	                 'center_center' => get_string('backgroundpositioncentercenter', 'theme_even_more'),
	                 'center_bottom' => get_string('backgroundpositioncenterbottom', 'theme_even_more'),
	                );
	$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Background fixed setting.
	$name = 'theme_even_more/backgroundfixed';
	$title = get_string('backgroundfixed', 'theme_even_more');
	$description = get_string('backgroundfixed_desc', 'theme_even_more');
	$setting = new admin_setting_configcheckbox($name, $title, $description, 0);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Main content background color.
	$name = 'theme_even_more/contentbackground';
	$title = get_string('contentbackground', 'theme_even_more');
	$description = get_string('contentbackground_desc', 'theme_even_more');
	$default = '#FFFFFF';
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, null, false);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Secondary background color.
	$name = 'theme_even_more/secondarybackground';
	$title = get_string('secondarybackground', 'theme_even_more');
	$description = get_string('secondarybackground_desc', 'theme_even_more');
	$default = '#FFFFFF';
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, null, false);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Invert Navbar to dark background.
	$name = 'theme_even_more/invert';
	$title = get_string('invert', 'theme_even_more');
	$description = get_string('invertdesc', 'theme_even_more');
	$setting = new admin_setting_configcheckbox($name, $title, $description, 1);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Logo file setting.
	$name = 'theme_even_more/logo';
	$title = get_string('logo','theme_even_more');
	$description = get_string('logodesc', 'theme_even_more');
	$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Custom CSS file.
	$name = 'theme_even_more/customcss';
	$title = get_string('customcss', 'theme_even_more');
	$description = get_string('customcssdesc', 'theme_even_more');
	$default = '';
	$setting = new admin_setting_configtextarea($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// Footnote setting.
	$name = 'theme_even_more/footnote';
	$title = get_string('footnote', 'theme_even_more');
	$description = get_string('footnotedesc', 'theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	//add the general settings page to the EvenMore entry (i.e. nest the general settings under EvenMore)
	$ADMIN->add('theme_even_more',$temp);
	
	
	//create a front page blocks settings page
	$temp = new admin_settingpage('theme_even_more_frontpage', get_string('frontpagesettings','theme_even_more'));
	$temp->add(new admin_setting_heading('theme_even_more_frontpage',
	                                     get_string('frontpagesettingsheading','theme_even_more'),
	                                     format_text(get_string('frontpagesettingsdescription','theme_even_more'),FORMAT_MARKDOWN)));
	
	//slidershow images
	$name = 'theme_even_more/blocksliderimage1';
	$title = get_string('blocksliderimage1','theme_even_more');
	$description = get_string('blocksliderimage1description','theme_even_more');
	$default = '';
	$setting = new admin_setting_configstoredfile($name, $title, $description, 'blocksliderimage1');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage1url';
	$title = get_string('blocksliderimage1url','theme_even_more');
	$description = get_string('blocksliderimage1urldescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage1caption';
	$title = get_string('blocksliderimage1caption','theme_even_more');
	$description = get_string('blocksliderimage1captiondescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	$name = 'theme_even_more/blocksliderimage2';
	$title = get_string('blocksliderimage2','theme_even_more');
	$description = get_string('blocksliderimage2description','theme_even_more');
	$default = '';
	$setting = new admin_setting_configstoredfile($name, $title, $description, 'blocksliderimage2');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage2url';
	$title = get_string('blocksliderimage2url','theme_even_more');
	$description = get_string('blocksliderimage2urldescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage2caption';
	$title = get_string('blocksliderimage2caption','theme_even_more');
	$description = get_string('blocksliderimage2captiondescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	$name = 'theme_even_more/blocksliderimage3';
	$title = get_string('blocksliderimage3','theme_even_more');
	$description = get_string('blocksliderimage3description','theme_even_more');
	$default = '';
	$setting = new admin_setting_configstoredfile($name, $title, $description, 'blocksliderimage3');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage3url';
	$title = get_string('blocksliderimage3url','theme_even_more');
	$description = get_string('blocksliderimage3urldescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage3caption';
	$title = get_string('blocksliderimage3caption','theme_even_more');
	$description = get_string('blocksliderimage3captiondescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	$name = 'theme_even_more/blocksliderimage4';
	$title = get_string('blocksliderimage4','theme_even_more');
	$description = get_string('blocksliderimage4description','theme_even_more');
	$default = '';
	$setting = new admin_setting_configstoredfile($name, $title, $description, 'blocksliderimage4');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage4url';
	$title = get_string('blocksliderimage4url','theme_even_more');
	$description = get_string('blocksliderimage4urldescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage4caption';
	$title = get_string('blocksliderimage4caption','theme_even_more');
	$description = get_string('blocksliderimage4captiondescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	$name = 'theme_even_more/blocksliderimage5';
	$title = get_string('blocksliderimage5','theme_even_more');
	$description = get_string('blocksliderimage5description','theme_even_more');
	$default = '';
	$setting = new admin_setting_configstoredfile($name, $title, $description, 'blocksliderimage5');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage5url';
	$title = get_string('blocksliderimage5url','theme_even_more');
	$description = get_string('blocksliderimage5urldescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderimage5caption';
	$title = get_string('blocksliderimage5caption','theme_even_more');
	$description = get_string('blocksliderimage5captiondescription','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	//custom slider area feature blocks
	$name = 'theme_even_more/blocksliderfeature01';
	$title = get_string('blocksliderfeature01','theme_even_more');
	$description = get_string('blocksliderfeature01description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blocksliderfeature02';
	$title = get_string('blocksliderfeature02','theme_even_more');
	$description = get_string('blocksliderfeature02description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	//custom full width feature
	$name = 'theme_even_more/blockfullwidthfeature01';
	$title = get_string('blockfullwidthfeature01','theme_even_more');
	$description = get_string('blockfullwidthfeature01description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	//custom row 1 feature blocks
	$name = 'theme_even_more/blockrow01feature01';
	$title = get_string('blockrow01feature01','theme_even_more');
	$description = get_string('blockrow01feature01description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blockrow01feature02';
	$title = get_string('blockrow01feature02','theme_even_more');
	$description = get_string('blockrow01feature02description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blockrow01feature03';
	$title = get_string('blockrow01feature03','theme_even_more');
	$description = get_string('blockrow01feature03description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blockrow01feature04';
	$title = get_string('blockrow01feature04','theme_even_more');
	$description = get_string('blockrow01feature04description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	//custom row 2 feature blocks
	$name = 'theme_even_more/blockrow02feature01';
	$title = get_string('blockrow02feature01','theme_even_more');
	$description = get_string('blockrow02feature01description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blockrow02feature02';
	$title = get_string('blockrow02feature02','theme_even_more');
	$description = get_string('blockrow02feature02description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blockrow02feature03';
	$title = get_string('blockrow02feature03','theme_even_more');
	$description = get_string('blockrow02feature03description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	$name = 'theme_even_more/blockrow02feature04';
	$title = get_string('blockrow02feature04','theme_even_more');
	$description = get_string('blockrow02feature04description','theme_even_more');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
	
	
	//add the front page settings page to the EvenMore entry (i.e. nest the front page settings under EvenMore)
	$ADMIN->add('theme_even_more',$temp);
}
