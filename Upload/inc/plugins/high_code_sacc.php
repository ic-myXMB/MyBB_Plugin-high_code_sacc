<?php
/*
 * MyBB: Highlight Code Select All Copy Code
 *
 * File: high_code_sacc.php
 * 
 * Authors: Vintagedaddyo & ic_myXMB
 *
 * MyBB Version: 1.8
 *
 * Plugin Version: 1.0.3
 * 
 */

// If Not Defined
if(!defined("IN_MYBB")) {
  // Then Die
  die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Add Plugin Hooks

// Load in Showthread
$plugins->add_hook("showthread_start", "high_code_sacc");

// Load in Portal 
$plugins->add_hook("portal_start", "high_code_sacc");

// Plugin Information
function high_code_sacc_info() {
    
    // Globals
    global $db, $lang, $high_code_sacc_settingsgroup_cache;
    
    // Lang Load
	$lang->load("high_code_sacc");

	// Configuration link
	if(empty($high_code_sacc_settingsgroup_cache)) {
		// Query
		$gid_query = $db->simple_select('settinggroups', 'gid, name', 'isdefault = 0');
        
        // While
		while($group = $db->fetch_array($gid_query)) {
			// Cache 
			$high_code_sacc_settingsgroup_cache[$group['name']] = $group['gid'];
		}
	}

    // Gid
	$gid = isset($high_code_sacc_settingsgroup_cache['high_code_sacc']) ? $high_code_sacc_settingsgroup_cache['high_code_sacc'] : 0;
    
    // Config Link
	$high_code_sacc_config = '<br />';
    
    // If Gid
	if($gid) {
	    // Globals
		global $mybb;
		
        // Config Link
		$high_code_sacc_config = '<a style="float: right;" href="index.php?module=config&amp;action=change&amp;gid='.$gid.'">'.$lang->high_code_sacc_config.'</a>';
	}
    
    // Array Return  
    return array(
        'name' => $lang->high_code_sacc_name,
        'description' => $lang->high_code_sacc_description .$high_code_sacc_config,
        'website' => $lang->high_code_sacc_website,
        'author' => $lang->high_code_sacc_author,
        'authorsite' => $lang->high_code_sacc_author_site,
        'version' => $lang->high_code_sacc_version,
        'codename' => $lang->high_code_sacc_code_name,
        'compatibility' => $lang->high_code_sacc_compatability
    );
    
}

// Plugin Activate
function high_code_sacc_activate() {

  // Add Plugin Settings

  // Globals
  global $db, $mybb, $lang; 

   // Language Load
  $lang->load("high_code_sacc");

    // Settings Group
    $settinggroups = array(
        'name'          => 'high_code_sacc', 
        'title'         => $db->escape_string($lang->high_code_sacc_settingsgroup_title),
        'description'   => $db->escape_string($lang->high_code_sacc_settingsgroup_description),
        'disporder'     => '101',
        'isdefault'     => '0'
    );

    // Group
    $group['gid'] = $db->insert_query('settinggroups', $settinggroups);

    // Gid
    $gid = $db->insert_id();

    // Disporder
    $disporder = '0';
    
    // Setting 1
    $setting_1 = array(
        'sid'           => '0',
        'name'          => 'high_code_sacc_setting_1',
        'title'         => $db->escape_string($lang->high_code_sacc_setting_1_title),
        'description'   => $db->escape_string($lang->high_code_sacc_setting_1_description),
        'optionscode'   => 'yesno',
        'value'         => '1',
        'disporder'     => $disporder++,
        'gid'           => intval($gid)
    );

    // Query Insert
    $db->insert_query('settings', $setting_1);

    // Setting 2
    $setting_2 = array(
        'sid'           => '0',
        'name'          => 'high_code_sacc_setting_2',
        'title'         => $db->escape_string($lang->high_code_sacc_setting_2_title),
        'description'   => $db->escape_string($lang->high_code_sacc_setting_2_description),
        'optionscode'   => "select\n0=Default\n1=Solarized Dark\n2=Solarized Light\n3=Github\n4=Railscasts\n5=Monakai Sublime\n6=Mono Blue\n7=Tomorrow\n8=Color Brewer\n9=Zenburn\n10=Agate\n11=Android Studio\n12=Dracula\n13=Rainbow\n14=VS\n15=Atom One Dark\n16=Atom One Light",
        'value'         => '0',
        'disporder'     => $disporder++,
        'gid'           => intval($gid)
    );

    // Query Insert
    $db->insert_query('settings', $setting_2);
    
    // Rebuild Settings
    rebuild_settings(); 

    // Edit Templates
    require_once MYBB_ROOT."/inc/adminfunctions_templates.php";

    // Add Template Edits

    // Showthread Template
    find_replace_templatesets('showthread', '#'.preg_quote('</head>').'#i', '{$high_code_sacc}
</head>');

    // Portal Template
    find_replace_templatesets('portal', '#'.preg_quote('</head>').'#i', '{$high_code_sacc}
</head>');

}

// Plugin Deactivate
function high_code_sacc_deactivate() {

  // Remove Settings

  // Globals  
  global $db;

  // Delete Query
  $db->delete_query('settinggroups', 'name = \'high_code_sacc\'');
  $db->delete_query('settings', 'name LIKE \'%high_code_sacc%\'');

  // Edit Templates
  require_once MYBB_ROOT."/inc/adminfunctions_templates.php";

  // Remove Template Edits

  // Showthread Template
  find_replace_templatesets('showthread', '#'.preg_quote('{$high_code_sacc}
</head>').'#i', '</head>');

  // Portal Template
  find_replace_templatesets('portal', '#'.preg_quote('{$high_code_sacc}
</head>').'#i', '</head>');

}

// High_Code_Sacc Func
function high_code_sacc() {

  // All Currently Included Stylesheets
  
  // Globals
  global $mybb, $high_code_sacc;
  
  // Style 0: Default
  if ($mybb->settings['high_code_sacc_setting_2'] == "0") {

     // Style
     $codeblock_style = "<!-- Default CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/default.css\" rel=\"stylesheet\" />";

  }

  // Style 1: Solarized Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "1") {

     // Style
     $codeblock_style = "<!-- Solarized Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/solarized-dark.css\" rel=\"stylesheet\" />";

  }

  // Style 2: Solarized Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "2") {

     // Style
     $codeblock_style = "<!-- Solarized Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/solarized-light.css\" rel=\"stylesheet\" />";

  }  

  // Style 3: Github
  if ($mybb->settings['high_code_sacc_setting_2'] == "3") {

     // Style
     $codeblock_style = "<!-- Github CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/github.css\" rel=\"stylesheet\" />";

  }  

  // Style 4: Railscasts
  if ($mybb->settings['high_code_sacc_setting_2'] == "4") {

     // Style
     $codeblock_style = "<!-- Railscasts CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/railscasts.css\" rel=\"stylesheet\" />";

  }

  // Style 5: Monakai Sublime
  if ($mybb->settings['high_code_sacc_setting_2'] == "5") {

     // Style
     $codeblock_style = "<!-- Monakai Sublime CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/monakai-sublime.css\" rel=\"stylesheet\" />";

  }

  // Style 6: Mono Blue
  if ($mybb->settings['high_code_sacc_setting_2'] == "6") {

     // Style
     $codeblock_style = "<!-- Mono Blue CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/mono-blue.css\" rel=\"stylesheet\" />";

  } 

  // Style 7: Tomorrow
  if ($mybb->settings['high_code_sacc_setting_2'] == "7") {

     // Style
     $codeblock_style = "<!-- Tomorrow CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/tomorrow.css\" rel=\"stylesheet\" />";

  } 

  // Style 8: Color Brewer
  if ($mybb->settings['high_code_sacc_setting_2'] == "8") {

     // Style
     $codeblock_style = "<!-- Color Brewer CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/color-brewer.css\" rel=\"stylesheet\" />";

  }   

  // Style 9: Zenburn
  if ($mybb->settings['high_code_sacc_setting_2'] == "9") {

     // Style
     $codeblock_style = "<!-- Zenburn CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/zenburn.css\" rel=\"stylesheet\" />";

  } 

  // Style 10: Agate
  if ($mybb->settings['high_code_sacc_setting_2'] == "10") {

     // Style
     $codeblock_style = "<!-- Agate CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/agate.css\" rel=\"stylesheet\" />";

  } 

  // Style 11: Android Studio
  if ($mybb->settings['high_code_sacc_setting_2'] == "11") {

     // Style
     $codeblock_style = "<!-- Android Studio CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/android-studio.css\" rel=\"stylesheet\" />";

  }

  // Style 12: Dracula
  if ($mybb->settings['high_code_sacc_setting_2'] == "12") {

     // Style
     $codeblock_style = "<!-- Dracula CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/dracula.css\" rel=\"stylesheet\" />";

  } 

  // Style 13: Rainbow
  if ($mybb->settings['high_code_sacc_setting_2'] == "13") {

     // Style
     $codeblock_style = "<!-- Rainbow CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/rainbow.css\" rel=\"stylesheet\" />";

  } 

  // Style 14: VS
  if ($mybb->settings['high_code_sacc_setting_2'] == "14") {

     // Style
     $codeblock_style = "<!-- VS CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/vs.css\" rel=\"stylesheet\" />";

  } 

  // Style 15: Atom One Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "15") {

     // Style
     $codeblock_style = "<!-- Atom One Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/atom-one-dark.css\" rel=\"stylesheet\" />";

  }  

  // Style 16: Atom One Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "16") {

     // Style
     $codeblock_style = "<!-- Atom One Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/atom-one-light.css\" rel=\"stylesheet\" />";

  }

  // Add To / Remove From Head On Showthread And Portal templates

  // If Plugin Active
  if ($mybb->settings['high_code_sacc_setting_1'] == "1") { 

     // Globals
     global $headerinclude;

     // Headerinclude
     $headerinclude .= "
<!-- Select All / Copy JS -->
<script src=\"inc/plugins/high_code_sacc/jscripts/high_code_sacc_select_all.js\"></script>
<!-- Highlight JS --> 
<script src=\"inc/plugins/high_code_sacc/jscripts/highlight.min.js\"></script>
<!-- Highlight JS And Plugins Init -->  
<script src=\"inc/plugins/high_code_sacc/jscripts/high_code_sacc_init.js\"></script>
<!-- Highlight JS Custom LineNumbers Plugin CSS --> 
<link href=\"inc/plugins/high_code_sacc/themes/plugin/line-numbers-plugin.css\" rel=\"stylesheet\" />";
  
     // Globals
     global $lang;

     // Language Load
     $lang->load("high_code_sacc");

     // Do The (Select All) Links Via Lang Files

     // Php Code (Select All) Is Lang PHP Code
     $lang->php_code .= ''.$lang->high_code_sacc_php_code.'';

     // Code Code (Select All) Is Lang Code
     $lang->code .= ''.$lang->high_code_sacc_code.'';

  	 // Add Codeblock Style Inline
     //$high_code_sacc = "<style>".$codeblock_style."</style>";

  	 // Add Codeblock Style Stylesheet Linkage
     $high_code_sacc = "".$codeblock_style."";

  }

  // If Plugin Not Active 
  if ($mybb->settings['high_code_sacc_setting_1'] == "0") { 
  	 // Empty Codeblock Style
     $high_code_sacc = "";
  }

}

?>
