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
 * Plugin Version: 1.0.4
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

	// Settings Link
	if(empty($high_code_sacc_settingsgroup_cache)) {

		// Gid Query
		$gid_query = $db->simple_select('settinggroups', 'gid, name', 'isdefault = 0');
        
		// While
		while($group = $db->fetch_array($gid_query)) {

			// Cache 
			$high_code_sacc_settingsgroup_cache[$group['name']] = $group['gid'];
		}
	}

	// Gid
	$gid = isset($high_code_sacc_settingsgroup_cache['high_code_sacc']) ? $high_code_sacc_settingsgroup_cache['high_code_sacc'] : 0;
    
	// Settings Link
	$high_code_sacc_config = '<br />';
    
	// If Gid
	if($gid) {

		// Globals
		global $mybb;
		
		// Settings Link
		$high_code_sacc_config = '<a style="float: right;" href="index.php?module=config&amp;action=change&amp;gid='.$gid.'"><img src="../inc/plugins/high_code_sacc/images/settings.png" width="16px" height="16px" style="padding: 2px; vertical-align: middle;">'.$lang->high_code_sacc_config.'</a>';
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
        'optionscode'   => "select\n0=Default\n1=Solarized Dark\n2=Solarized Light\n3=Github\n4=Railscasts\n5=Monakai Sublime\n6=Mono Blue\n7=Tomorrow\n8=Color Brewer\n9=Zenburn\n10=Agate\n11=Android Studio\n12=Dracula\n13=Rainbow\n14=VS\n15=Atom One Dark\n16=Atom One Light\n17=Github Dark Dimmed\n18=Github Dark\n19=Dark\n20=Stack Overflow Light\n21=Stack Overflow Dark\n22=Google Code\n23=Foundation\n24=XCode\n25=Night Owl\n26=Kimbie Light\n27=Kimbie Dark\n28=Codepen Embed\n29=Srcery\n30=Routeros\n31=Panda Syntax Light\n32=Panda Syntax Dark\n33=DeviBeans\n34=Lightfair\n35=Obsidian\n36=Nord\n37=QT Creator Light\n38=QT Creator Dark\n39=Paraiso Light\n40=Paraiso Dark\n41=isbl Editor Light\n42=isbl Editor Dark\n43=nnfx Light\n44=nnfx Dark\n45=Grayscale",
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
<link href=\"inc/plugins/high_code_sacc/themes/default.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #f3f3f3; }
.codeblock { background: #f3f3f3; }
.codeblock .title { color: #444444; }
.codeblock .title a:link { color: #444444; }
.hljs-ln .ln-num::before { color: #444444 !important; }
</style>";

  }

  // Style 1: Solarized Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "1") {

     // Style
     $codeblock_style = "<!-- Solarized Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/solarized-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background:#002b36; }
.codeblock { background: #002b36; }
.codeblock .title { color: #93a1a1; }
.codeblock .title a:link { color: #93a1a1; }
.hljs-ln .ln-num::before { color: #93a1a1 !important; }
</style>";

  }

  // Style 2: Solarized Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "2") {

     // Style
     $codeblock_style = "<!-- Solarized Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/solarized-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background:#fdf6e3; }
.codeblock { background: #fdf6e3; }
.codeblock .title { color: #586e75; }
.codeblock .title a:link { color: #586e75; }
.hljs-ln .ln-num::before { color: #586e75 !important; }
</style>";

  }  

  // Style 3: Github
  if ($mybb->settings['high_code_sacc_setting_2'] == "3") {

     // Style
     $codeblock_style = "<!-- Github CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/github.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #ffffff; }
.codeblock { background: #ffffff; }
.codeblock .title { color: #333333; }
.codeblock .title a:link { color: #333333; }
.hljs-ln .ln-num::before { color: #333333 !important; }
</style>";

  }  

  // Style 4: Railscasts
  if ($mybb->settings['high_code_sacc_setting_2'] == "4") {

     // Style
     $codeblock_style = "<!-- Railscasts CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/railscasts.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #2b2b2b; }
.codeblock { background: #2b2b2b; }
.codeblock .title { color: #e6e1dc; }
.codeblock .title a:link { color: #e6e1dc; }
.hljs-ln .ln-num::before { color: #e6e1dc !important; }
</style>";

  }

  // Style 5: Monakai Sublime
  if ($mybb->settings['high_code_sacc_setting_2'] == "5") {

     // Style
     $codeblock_style = "<!-- Monakai Sublime CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/monokai-sublime.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #23241f; }
.codeblock { background: #23241f; }
.codeblock .title { color: #f8f8f2; }
.codeblock .title a:link { color: #f8f8f2; }
.hljs-ln .ln-num::before { color: #f8f8f2 !important; }
</style>";

  }

  // Style 6: Mono Blue
  if ($mybb->settings['high_code_sacc_setting_2'] == "6") {

     // Style
     $codeblock_style = "<!-- Mono Blue CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/mono-blue.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #eaeef3; }
.codeblock { background: #eaeef3; }
.codeblock .title { color: #00193a; }
.codeblock .title a:link { color: #00193a; }
.hljs-ln .ln-num::before { color: #00193a !important; }
</style>";

  } 

  // Style 7: Tomorrow
  if ($mybb->settings['high_code_sacc_setting_2'] == "7") {

     // Style
     $codeblock_style = "<!-- Tomorrow CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/tomorrow.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #ffffff; }
.codeblock { background: #ffffff; }
.codeblock .title { color: #4d4d4c; }
.codeblock .title a:link { color: #4d4d4c; }
.hljs-ln .ln-num::before { color: #4d4d4c!important; }
</style>";

  } 

  // Style 8: Color Brewer
  if ($mybb->settings['high_code_sacc_setting_2'] == "8") {

     // Style
     $codeblock_style = "<!-- Color Brewer CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/color-brewer.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #ffffff; }
.codeblock { background: #ffffff; }
.codeblock .title { color: #000000; }
.codeblock .title a:link { color: #000000; }
.hljs-ln .ln-num::before { color: #000000 !important; }
</style>";

  }   

  // Style 9: Zenburn
  if ($mybb->settings['high_code_sacc_setting_2'] == "9") {

     // Style
     $codeblock_style = "<!-- Zenburn CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/zenburn.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #383838; }
.codeblock { background: #383838; }
.codeblock .title { color: #dcdccc; }
.codeblock .title a:link { color: #dcdccc; }
.hljs-ln .ln-num::before { color: #dcdccc !important; }
</style>";

  } 

  // Style 10: Agate
  if ($mybb->settings['high_code_sacc_setting_2'] == "10") {

     // Style
     $codeblock_style = "<!-- Agate CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/agate.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #333333; }
.codeblock { background: #333333; }
.codeblock .title { color: #ffffff; }
.codeblock .title a:link { color: #ffffff; }
.hljs-ln .ln-num::before { color: #ffffff !important; }
</style>";

  } 

  // Style 11: Android Studio
  if ($mybb->settings['high_code_sacc_setting_2'] == "11") {

     // Style
     $codeblock_style = "<!-- Android Studio CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/androidstudio.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #282b2e; }
.codeblock { background: #282b2e; }
.codeblock .title { color: #a9b7c6; }
.codeblock .title a:link { color: #a9b7c6; }
.hljs-ln .ln-num::before { color: #a9b7c6 !important; }
</style>";

  }

  // Style 12: Dracula
  if ($mybb->settings['high_code_sacc_setting_2'] == "12") {

     // Style
     $codeblock_style = "<!-- Dracula CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/dracula.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #282936; }
.codeblock { background: #282936; }
.codeblock .title { color: #e9e9f4; }
.codeblock .title a:link { color: #e9e9f4; }
.hljs-ln .ln-num::before { color: #e9e9f4 !important; }
</style>";

  } 

  // Style 13: Rainbow
  if ($mybb->settings['high_code_sacc_setting_2'] == "13") {

     // Style
     $codeblock_style = "<!-- Rainbow CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/rainbow.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #474949; }
.codeblock { background: #474949; }
.codeblock .title { color: #d1d9e1; }
.codeblock .title a:link { color: #d1d9e1; }
.hljs-ln .ln-num::before { color: #d1d9e1 !important; }
</style>";

  } 

  // Style 14: VS
  if ($mybb->settings['high_code_sacc_setting_2'] == "14") {

     // Style
     $codeblock_style = "<!-- VS CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/vs.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #ffffff; }
.codeblock { background: #ffffff; }
.codeblock .title { color: #000000; }
.codeblock .title a:link { color: #000000; }
.hljs-ln .ln-num::before { color: #000000 !important; }
</style>";

  } 

  // Style 15: Atom One Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "15") {

     // Style
     $codeblock_style = "<!-- Atom One Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/atom-one-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #282c34; }
.codeblock { background: #282c34; }
.codeblock .title { color: #abb2bf; }
.codeblock .title a:link { color: #abb2bf; }
.hljs-ln .ln-num::before { color: #abb2bf !important; }
</style>";

  }  

  // Style 16: Atom One Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "16") {

     // Style
     $codeblock_style = "<!-- Atom One Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/atom-one-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #fafafa; }
.codeblock { background: #fafafa; }
.codeblock .title { color: #383a42; }
.codeblock .title a:link { color: #383a42; }
.hljs-ln .ln-num::before { color: #383a42 !important; }
</style>";

  }

  // Style 17: Github Dark Dimmed
  if ($mybb->settings['high_code_sacc_setting_2'] == "17") {

     // Style
     $codeblock_style = "<!-- Github Dark Dimmed -->
<link href=\"inc/plugins/high_code_sacc/themes/github-dark-dimmed.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #22272e; }
.codeblock { background: #22272e; }
.codeblock .title { color: #adbac7; }
.codeblock .title a:link { color: #adbac7; }
.hljs-ln .ln-num::before { color: #adbac7 !important; }
</style>";

  }  

  // Style 18: Github Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "18") {

     // Style
     $codeblock_style = "<!-- Github Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/github-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #0d1117; }
.codeblock { background: #0d1117; }
.codeblock .title { color: #c9d1d9; }
.codeblock .title a:link { color: #c9d1d9; }
.hljs-ln .ln-num::before { color: #c9d1d9 !important; }
</style>";

  }

  // Style 19: Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "19") {

     // Style
     $codeblock_style = "<!-- Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #303030; }
.codeblock { background: #303030; }
.codeblock .title { color: #DDDDDD; }
.codeblock .title a:link { color: #DDDDDD; }
.hljs-ln .ln-num::before { color: #DDDDDD !important; }
</style>";

  }

  // Style 20: Stack Overflow Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "20") {

     // Style
     $codeblock_style = "<!-- Stack Overflow Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/stackoverflow-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #f6f6f6; }
.codeblock { background: #f6f6f6; }
.codeblock .title { color: #2f3337; }
.codeblock .title a:link { color: #2f3337; }
.hljs-ln .ln-num::before { color: #2f3337 !important; }
</style>";

  }

  // Style 21: Stack Overflow Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "21") {

     // Style
     $codeblock_style = "<!-- Stack Overflow Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/stackoverflow-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #1c1b1b; }
.codeblock { background: #1c1b1b; }
.codeblock .title { color: #FFFFFF; }
.codeblock .title a:link { color: #FFFFFF; }
.hljs-ln .ln-num::before { color: #FFFFFF !important; }
</style>";

  }

  // Style 22: Google Code
  if ($mybb->settings['high_code_sacc_setting_2'] == "22") {

     // Style
     $codeblock_style = "<!-- Google Code CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/googlecode.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #FFFFFF; }
.codeblock { background: #FFFFFF; }
.codeblock .title { color: #000000; }
.codeblock .title a:link { color: #000000; }
.hljs-ln .ln-num::before { color: #000000 !important; }
</style>";

  }

  // Style 23: Foundation
  if ($mybb->settings['high_code_sacc_setting_2'] == "23") {

     // Style
     $codeblock_style = "<!-- Foundation CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/foundation.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #eeeeee; }
.codeblock { background: #eeeeee; }
.codeblock .title { color: #000000; }
.codeblock .title a:link { color: #000000; }
.hljs-ln .ln-num::before { color: #000000 !important; }
</style>";

  }

  // Style 24: XCode
  if ($mybb->settings['high_code_sacc_setting_2'] == "24") {

     // Style
     $codeblock_style = "<!-- XCode CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/xcode.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #FFFFFF; }
.codeblock { background: #FFFFFF; }
.codeblock .title { color: #000000; }
.codeblock .title a:link { color: #000000; }
.hljs-ln .ln-num::before { color: #000000 !important; }
</style>";

  }

  // Style 25: Night Owl
  if ($mybb->settings['high_code_sacc_setting_2'] == "25") {

     // Style
     $codeblock_style = "<!-- Night Owl CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/night-owl.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #011627; }
.codeblock { background: #011627; }
.codeblock .title { color: #d6deeb; }
.codeblock .title a:link { color: #d6deeb; }
.hljs-ln .ln-num::before { color: #d6deeb !important; }
</style>";

  }

  // Style 26: Kimbie Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "26") {

     // Style
     $codeblock_style = "<!-- Kimbie Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/kimbie-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #fbebd4; }
.codeblock { background: #fbebd4; }
.codeblock .title { color: #84613d; }
.codeblock .title a:link { color: #84613d; }
.hljs-ln .ln-num::before { color: #84613d !important; }
</style>";

  }

  // Style 27: Kimbie Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "27") {

     // Style
     $codeblock_style = "<!-- Kimbie Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/kimbie-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #221a0f; }
.codeblock { background: #221a0f; }
.codeblock .title { color: #d3af86; }
.codeblock .title a:link { color: #d3af86; }
.hljs-ln .ln-num::before { color: #d3af86 !important; }
</style>";

  }

  // Style 28: Codepen Embed
  if ($mybb->settings['high_code_sacc_setting_2'] == "28") {

     // Style
     $codeblock_style = "<!-- Codepen Embed CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/codepen-embed.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #222222; }
.codeblock { background: #222222; }
.codeblock .title { color: #FFFFFFF; }
.codeblock .title a:link { color: #FFFFFF; }
.hljs-ln .ln-num::before { color: #FFFFFF !important; }
</style>";

  }

  // Style 29: Srcery
  if ($mybb->settings['high_code_sacc_setting_2'] == "29") {

     // Style
     $codeblock_style = "<!-- Srcery CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/srcery.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #1c1b19; }
.codeblock { background: #1c1b19; }
.codeblock .title { color: #fce8c3; }
.codeblock .title a:link { color: #fce8c3; }
.hljs-ln .ln-num::before { color: #fce8c3 !important; }
</style>";

  }

  // Style 30: Routeros
  if ($mybb->settings['high_code_sacc_setting_2'] == "30") {

     // Style
     $codeblock_style = "<!-- Routeros CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/routeros.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #f0f0f0; }
.codeblock { background: #f0f0f0; }
.codeblock .title { color: #444444; }
.codeblock .title a:link { color: #444444; }
.hljs-ln .ln-num::before { color: #444444 !important; }
.table {color: #A0A0A0;}
</style>";

  }

  // Style 31: Panda Syntax Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "31") {

     // Style
     $codeblock_style = "<!-- Panda Syntax Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/panda-syntax-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #e6e6e6; }
.codeblock { background: #e6e6e6; }
.codeblock .title { color: #2a2c2d; }
.codeblock .title a:link { color: #2a2c2d; }
.hljs-ln .ln-num::before { color: #2a2c2d !important; }
</style>";

  }

  // Style 32: Panda Syntax Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "32") {

     // Style
     $codeblock_style = "<!-- Panda Syntax Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/panda-syntax-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #2a2c2d; }
.codeblock { background: #2a2c2d; }
.codeblock .title { color: #e6e6e6; }
.codeblock .title a:link { color: #e6e6e6; }
.hljs-ln .ln-num::before { color: #e6e6e6 !important; }
</style>";

  }

  // Style 33: DeviBeans
  if ($mybb->settings['high_code_sacc_setting_2'] == "33") {

     // Style
     $codeblock_style = "<!-- DeviBeans CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/devibeans.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #000000; }
.codeblock { background: #000000; }
.codeblock .title { color: #a39e9b; }
.codeblock .title a:link { color: #a39e9b; }
.hljs-ln .ln-num::before { color: #a39e9b !important; }
</style>";

  }
  
  // Style 34: Lightfair
  if ($mybb->settings['high_code_sacc_setting_2'] == "34") {

     // Style
     $codeblock_style = "<!-- Lightfair CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/lightfair.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #fff; }
.codeblock { background: #fff; }
.codeblock .title { color: ##444; }
.codeblock .title a:link { color: ##444; }
.hljs-ln .ln-num::before { color: ##444 !important; }
</style>";

  }

  // Style 35: Obsidian
  if ($mybb->settings['high_code_sacc_setting_2'] == "35") {

     // Style
     $codeblock_style = "<!-- Obsidian CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/obsidian.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #282b2e; }
.codeblock { background: #282b2e; }
.codeblock .title { color: #e0e2e4; }
.codeblock .title a:link { color: #e0e2e4; }
.hljs-ln .ln-num::before { color: #e0e2e4 !important; }
</style>";

  }

  // Style 36: Nord
  if ($mybb->settings['high_code_sacc_setting_2'] == "36") {

     // Style
     $codeblock_style = "<!-- Nord CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/nord.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #2e3440; }
.codeblock { background: #2e3440; }
.codeblock .title { color: #d8dee9; }
.codeblock .title a:link { color: #d8dee9; }
.hljs-ln .ln-num::before { color: #d8dee9 !important; }
</style>";

  }

  // Style 37: QT Creator Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "37") {

     // Style
     $codeblock_style = "<!-- QT Creator Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/qtcreator-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #fff; }
.codeblock { background: #fff; }
.codeblock .title { color: #000; }
.codeblock .title a:link { color: #000; }
.hljs-ln .ln-num::before { color: #000 !important; }
</style>";

  }

  // Style 38: QT Creator Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "38") {

     // Style
     $codeblock_style = "<!-- QT Creator Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/qtcreator-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #000000; }
.codeblock { background: #000000; }
.codeblock .title { color: #aaa; }
.codeblock .title a:link { color: #aaa; }
.hljs-ln .ln-num::before { color: #aaa !important; }
</style>";

  }

  // Style 39: Paraiso Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "39") {

     // Style
     $codeblock_style = "<!-- Paraiso Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/paraiso-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #e7e9db; }
.codeblock { background: #e7e9db; }
.codeblock .title { color: #4f424c; }
.codeblock .title a:link { color: #4f424c; }
.hljs-ln .ln-num::before { color: #4f424c !important; }
</style>";

  }

  // Style 40: Paraiso Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "40") {

     // Style
     $codeblock_style = "<!-- Paraiso Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/paraiso-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #2f1e2e; }
.codeblock { background: #2f1e2e; }
.codeblock .title { color: #a39e9b; }
.codeblock .title a:link { color: #a39e9b; }
.hljs-ln .ln-num::before { color: #a39e9b !important; }
</style>";

  }

  // Style 41: isbl Editor Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "41") {

     // Style
     $codeblock_style = "<!-- isbl Editor Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/isbl-editor-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #fff; }
.codeblock { background: #fff; }
.codeblock .title { color: #000; }
.codeblock .title a:link { color: #000; }
.hljs-ln .ln-num::before { color: #000 !important; }
</style>";

  }

  // Style 42: isbl Editor Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "42") {

     // Style
     $codeblock_style = "<!-- isbl Editor Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/isbl-editor-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #404040; }
.codeblock { background: #404040; }
.codeblock .title { color: #a39e9b; }
.codeblock .title a:link { color: #a39e9b; }
.hljs-ln .ln-num::before { color: #a39e9b !important; }
</style>";

  }

  // Style 43: nnfx Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "43") {

     // Style
     $codeblock_style = "<!-- nnfx Light CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/nnfx-light.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #fff; }
.codeblock { background: #fff; }
.codeblock .title { color: #000; }
.codeblock .title a:link { color: #000; }
.hljs-ln .ln-num::before { color: #000 !important; }
</style>";

  }

  // Style 44: nnfx Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "44") {

     // Style
     $codeblock_style = "<!-- nnfx Dark CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/nnfx-dark.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #333; }
.codeblock { background: #333; }
.codeblock .title { color: #fff; }
.codeblock .title a:link { color: #fff; }
.hljs-ln .ln-num::before { color: #fff !important; }
</style>";

  }
  
  // Style 45: Grayscale
  if ($mybb->settings['high_code_sacc_setting_2'] == "45") {

     // Style
     $codeblock_style = "<!-- Grayscale CSS -->
<link href=\"inc/plugins/high_code_sacc/themes/grayscale.min.css\" rel=\"stylesheet\" />
<style>
/*  Extra */
.hljs { background: #fff; }
.codeblock { background: #fff; }
.codeblock .title { color: #333; }
.codeblock .title a:link { color: #333; }
.hljs-ln .ln-num::before { color: #333 !important; }
</style>";

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
