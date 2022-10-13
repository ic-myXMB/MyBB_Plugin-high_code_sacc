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
 * Plugin Version: 1.0.1
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
    global $lang;

    // Language Load
    $lang->load("high_code_sacc");
    
    // Array Return  
    return array(
        'name' => $lang->high_code_sacc_name,
        'description' => $lang->high_code_sacc_description,
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

    // gid
    $gid = $db->insert_query('settinggroups', $settinggroups);
    
    // disporder
    $disporder = '0';
    
    // Setting 1
    $setting = array(
        'sid'           => '0',
        'name'          => 'high_code_sacc_setting_1',
        'title'         => $db->escape_string($lang->high_code_sacc_setting_1_title),
        'description'   => $db->escape_string($lang->high_code_sacc_setting_1_description),
        'optionscode'   => 'yesno',
        'value'         => '1',
        'disporder'     => $disporder++,
        'gid'           => $gid
    );

    // Query Insert
    $db->insert_query('settings', $setting);

    // Setting 2
    $setting = array(
        'sid'           => '0',
        'name'          => 'high_code_sacc_setting_2',
        'title'         => $db->escape_string($lang->high_code_sacc_setting_2_title),
        'description'   => $db->escape_string($lang->high_code_sacc_setting_2_description),
        'optionscode'   => "select\n0=Default\n1=Solarized Dark\n2=Solarized Light\n3=Github\n4=Railscasts\n5=Monakai Sublime\n6=Mono Blue\n7=Tomorrow\n8=Color Brewer\n9=Zenburn\n10=Agate\n11=Android Studio\n12=Dracula\n13=Rainbow\n14=VS\n15=Atom One Dark\n16=Atom One Light",
        'value'         => '0',
        'disporder'     => $disporder++,
        'gid'           => $gid
    );

    // Query Insert
    $db->insert_query('settings', $setting);
    
    // Rebuild Settings
    rebuild_settings(); 

    // Edit Templates
    require_once MYBB_ROOT."/inc/adminfunctions_templates.php";

    // Add Template Edits

    // Showthread Template
    find_replace_templatesets('showthread', '#'.preg_quote('</head>').'#i', '{$high_code_sacc}</head>');
    // Portal Template
    find_replace_templatesets('portal', '#'.preg_quote('</head>').'#i', '{$high_code_sacc}</head>');

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
  find_replace_templatesets('showthread', '#'.preg_quote('{$high_code_sacc}</head>').'#i', '</head>');
  // Portal Template
  find_replace_templatesets('portal', '#'.preg_quote('{$high_code_sacc}</head>').'#i', '</head>');

}

// High_Code_Sacc Func
function high_code_sacc() {

  // All Currently Inclued Styles Inline
  
  // Globals
  global $mybb, $high_code_sacc;
  
  // Style 0: Default
  if ($mybb->settings['high_code_sacc_setting_2'] == "0") {

     // Style
     $codeblock_style = "/*!
  Theme: Default
  Description: Original highlight.js style
  Author: (c) Ivan Sagalaev <maniac@softwaremaniacs.org>
  Maintainer: @highlightjs/core-team
  Website: https://highlightjs.org/
  License: see project LICENSE
  Touched: 2021
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{background:#f3f3f3;color:#444}.hljs-comment{color:#697070}.hljs-punctuation,.hljs-tag{color:#444a}.hljs-tag .hljs-attr,.hljs-tag .hljs-name{color:#444}.hljs-attribute,.hljs-doctag,.hljs-keyword,.hljs-meta .hljs-keyword,.hljs-name,.hljs-selector-tag{font-weight:700}.hljs-deletion,.hljs-number,.hljs-quote,.hljs-selector-class,.hljs-selector-id,.hljs-string,.hljs-template-tag,.hljs-type{color:#800}.hljs-section,.hljs-title{color:#800;font-weight:700}.hljs-link,.hljs-operator,.hljs-regexp,.hljs-selector-attr,.hljs-selector-pseudo,.hljs-symbol,.hljs-template-variable,.hljs-variable{color:#ab5656}.hljs-literal{color:#695}.hljs-addition,.hljs-built_in,.hljs-bullet,.hljs-code{color:#397300}.hljs-meta{color:#1f7199}.hljs-meta .hljs-string{color:#38a}.hljs-emphasis{font-style:italic}.hljs-strong{font-weight:700}

/*  Extra */
.hljs { background:#FFFFFF; }
.codeblock { background: #FFFFFF; }
.codeblock .title { color: #333333; }
.codeblock .title a:link { color: #0072BC; }
.hljs-ln .ln-num::before { color: #777777 !important; }";

  }

  // Style 1: Solarized Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "1") {

     // Style
     $codeblock_style = "/*!
  Theme: Solarized Dark
  Author: Ethan Schoonover (modified by aramisgithub)
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: @highlightjs/core-team
  Version: 2021.09.0
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#93a1a1;background:#002b36}.hljs ::selection,.hljs::selection{background-color:#586e75;color:#93a1a1}.hljs-comment{color:#657b83}.hljs-tag{color:#839496}.hljs-operator,.hljs-punctuation,.hljs-subst{color:#93a1a1}.hljs-operator{opacity:.7}.hljs-bullet,.hljs-deletion,.hljs-name,.hljs-selector-tag,.hljs-template-variable,.hljs-variable{color:#dc322f}.hljs-attr,.hljs-link,.hljs-literal,.hljs-number,.hljs-symbol,.hljs-variable.constant_{color:#cb4b16}.hljs-class .hljs-title,.hljs-title,.hljs-title.class_{color:#b58900}.hljs-strong{font-weight:700;color:#b58900}.hljs-addition,.hljs-code,.hljs-string,.hljs-title.class_.inherited__{color:#859900}.hljs-built_in,.hljs-doctag,.hljs-keyword.hljs-atrule,.hljs-quote,.hljs-regexp{color:#2aa198}.hljs-attribute,.hljs-function .hljs-title,.hljs-section,.hljs-title.function_,.ruby .hljs-property{color:#268bd2}.diff .hljs-meta,.hljs-keyword,.hljs-template-tag,.hljs-type{color:#6c71c4}.hljs-emphasis{color:#6c71c4;font-style:italic}.hljs-meta,.hljs-meta .hljs-keyword,.hljs-meta .hljs-string{color:#d33682}.hljs-meta .hljs-keyword,.hljs-meta-keyword{font-weight:700}

/*  Extra */
.hljs { background:#002b36; }
.codeblock { background: #002b36; }
.codeblock .title { color: #93a1a1; }
.codeblock .title a:link { color: #93a1a1; }
.hljs-ln .ln-num::before { color: #93a1a1 !important; }";

  }

  // Style 2: Solarized Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "2") {

     // Style
     $codeblock_style = "/*!
  Theme: Solarized Light
  Author: Ethan Schoonover (modified by aramisgithub)
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: @highlightjs/core-team
  Version: 2021.09.0
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#586e75;background:#fdf6e3}.hljs ::selection,.hljs::selection{background-color:#93a1a1;color:#586e75}.hljs-comment{color:#839496}.hljs-tag{color:#657b83}.hljs-operator,.hljs-punctuation,.hljs-subst{color:#586e75}.hljs-operator{opacity:.7}.hljs-bullet,.hljs-deletion,.hljs-name,.hljs-selector-tag,.hljs-template-variable,.hljs-variable{color:#dc322f}.hljs-attr,.hljs-link,.hljs-literal,.hljs-number,.hljs-symbol,.hljs-variable.constant_{color:#cb4b16}.hljs-class .hljs-title,.hljs-title,.hljs-title.class_{color:#b58900}.hljs-strong{font-weight:700;color:#b58900}.hljs-addition,.hljs-code,.hljs-string,.hljs-title.class_.inherited__{color:#859900}.hljs-built_in,.hljs-doctag,.hljs-keyword.hljs-atrule,.hljs-quote,.hljs-regexp{color:#2aa198}.hljs-attribute,.hljs-function .hljs-title,.hljs-section,.hljs-title.function_,.ruby .hljs-property{color:#268bd2}.diff .hljs-meta,.hljs-keyword,.hljs-template-tag,.hljs-type{color:#6c71c4}.hljs-emphasis{color:#6c71c4;font-style:italic}.hljs-meta,.hljs-meta .hljs-keyword,.hljs-meta .hljs-string{color:#d33682}.hljs-meta .hljs-keyword,.hljs-meta-keyword{font-weight:700}

/*  Extra */
.hljs { background:#fdf6e3; }
.codeblock { background: #fdf6e3; }
.codeblock .title { color: #586e75; }
.codeblock .title a:link { color: #586e75; }
.hljs-ln .ln-num::before { color: #586e75 !important; }";

  }  

  // Style 3: Github
  if ($mybb->settings['high_code_sacc_setting_2'] == "3") {

     // Style
     $codeblock_style = "/*!
  Theme: Github
  Author: Defman21
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: @highlightjs/core-team
  Version: 2021.09.0
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#333;background:#fff}.hljs ::selection,.hljs::selection{background-color:#c8c8fa;color:#333}.hljs-comment{color:#969896}.hljs-tag{color:#e8e8e8}.hljs-operator,.hljs-punctuation,.hljs-subst{color:#333}.hljs-operator{opacity:.7}.hljs-bullet,.hljs-deletion,.hljs-name,.hljs-selector-tag,.hljs-template-variable,.hljs-variable{color:#ed6a43}.hljs-attr,.hljs-link,.hljs-literal,.hljs-number,.hljs-symbol,.hljs-variable.constant_{color:#0086b3}.hljs-class .hljs-title,.hljs-title,.hljs-title.class_{color:#795da3}.hljs-strong{font-weight:700;color:#795da3}.hljs-addition,.hljs-built_in,.hljs-code,.hljs-doctag,.hljs-keyword.hljs-atrule,.hljs-quote,.hljs-regexp,.hljs-string,.hljs-title.class_.inherited__{color:#183691}.hljs-attribute,.hljs-function .hljs-title,.hljs-section,.hljs-title.function_,.ruby .hljs-property{color:#795da3}.diff .hljs-meta,.hljs-keyword,.hljs-template-tag,.hljs-type{color:#a71d5d}.hljs-emphasis{color:#a71d5d;font-style:italic}.hljs-meta,.hljs-meta .hljs-keyword,.hljs-meta .hljs-string{color:#333}.hljs-meta .hljs-keyword,.hljs-meta-keyword{font-weight:700}

/*  Extra */
.hljs { background: #ffffff; }
.codeblock { background: #ffffff; }
.codeblock .title { color: #333333; }
.codeblock .title a:link { color: #333333; }
.hljs-ln .ln-num::before { color: #333333 !important; }";

  }  

  // Style 4: Railscasts
  if ($mybb->settings['high_code_sacc_setting_2'] == "4") {

     // Style
     $codeblock_style = "/*!
  Theme: Railscasts
  Author: Ryan Bates (http://railscasts.com)
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: @highlightjs/core-team
  Version: 2021.09.0
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#e6e1dc;background:#2b2b2b;}.hljs ::selection,.hljs::selection{background-color:#3a4055;color:#e6e1dc}.hljs-comment{color:#5a647e}.hljs-tag{color:#d4cfc9}.hljs-operator,.hljs-punctuation,.hljs-subst{color:#e6e1dc}.hljs-operator{opacity:.7}.hljs-bullet,.hljs-deletion,.hljs-name,.hljs-selector-tag,.hljs-template-variable,.hljs-variable{color:#da4939}.hljs-attr,.hljs-link,.hljs-literal,.hljs-number,.hljs-symbol,.hljs-variable.constant_{color:#cc7833}.hljs-class .hljs-title,.hljs-title,.hljs-title.class_{color:#ffc66d}.hljs-strong{font-weight:700;color:#ffc66d}.hljs-addition,.hljs-code,.hljs-string,.hljs-title.class_.inherited__{color:#a5c261}.hljs-built_in,.hljs-doctag,.hljs-keyword.hljs-atrule,.hljs-quote,.hljs-regexp{color:#519f50}.hljs-attribute,.hljs-function .hljs-title,.hljs-section,.hljs-title.function_,.ruby .hljs-property{color:#6d9cbe}.diff .hljs-meta,.hljs-keyword,.hljs-template-tag,.hljs-type{color:#b6b3eb}.hljs-emphasis{color:#b6b3eb;font-style:italic}.hljs-meta,.hljs-meta .hljs-keyword,.hljs-meta .hljs-string{color:#bc9458}.hljs-meta .hljs-keyword,.hljs-meta-keyword{font-weight:700}

/*  Extra */
.hljs { background: #2b2b2b; }
.codeblock { background: #2b2b2b; }
.codeblock .title { color: #e6e1dc; }
.codeblock .title a:link { color: #e6e1dc; }
.hljs-ln .ln-num::before { color: #e6e1dc !important; }";

  }

  // Style 5: Monakai Sublime
  if ($mybb->settings['high_code_sacc_setting_2'] == "5") {

     // Style
     $codeblock_style = "/*!
  Theme: Monakai Sublime
  Author: 
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: 
  Version: 
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{background:#23241f;color:#f8f8f2;}.hljs-subst,.hljs-tag{color:#f8f8f2}.hljs-emphasis,.hljs-strong{color:#a8a8a2}.hljs-bullet,.hljs-link,.hljs-literal,.hljs-number,.hljs-quote,.hljs-regexp{color:#ae81ff}.hljs-code,.hljs-section,.hljs-selector-class,.hljs-title{color:#a6e22e}.hljs-strong{font-weight:700}.hljs-emphasis{font-style:italic}.hljs-attr,.hljs-keyword,.hljs-name,.hljs-selector-tag{color:#f92672}.hljs-attribute,.hljs-symbol{color:#66d9ef}.hljs-class .hljs-title,.hljs-params,.hljs-title.class_{color:#f8f8f2}.hljs-addition,.hljs-built_in,.hljs-selector-attr,.hljs-selector-id,.hljs-selector-pseudo,.hljs-string,.hljs-template-variable,.hljs-type,.hljs-variable{color:#e6db74}.hljs-comment,.hljs-deletion,.hljs-meta{color:#75715e;}

/*  Extra */
.hljs { background: #23241f; }
.codeblock { background: #23241f; }
.codeblock .title { color: #f8f8f2; }
.codeblock .title a:link { color: #f8f8f2; }
.hljs-ln .ln-num::before { color: #f8f8f2 !important; }";

  }

  // Style 6: Mono Blue
  if ($mybb->settings['high_code_sacc_setting_2'] == "6") {

     // Style
     $codeblock_style = "/*!
  Theme: Mono Blue
  Author: 
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: 
  Version: 
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{background:#eaeef3;color:#00193a}.hljs-doctag,.hljs-keyword,.hljs-name,.hljs-section,.hljs-selector-tag,.hljs-strong,.hljs-title{font-weight:700}.hljs-comment{color:#738191}.hljs-addition,.hljs-built_in,.hljs-literal,.hljs-name,.hljs-quote,.hljs-section,.hljs-selector-class,.hljs-selector-id,.hljs-string,.hljs-tag,.hljs-title,.hljs-type{color:#0048ab}.hljs-attribute,.hljs-bullet,.hljs-deletion,.hljs-link,.hljs-meta,.hljs-regexp,.hljs-subst,.hljs-symbol,.hljs-template-variable,.hljs-variable{color:#4c81c9}.hljs-emphasis{font-style:italic}

/*  Extra */
.hljs { background: #eaeef3; }
.codeblock { background: #eaeef3; }
.codeblock .title { color: #00193a; }
.codeblock .title a:link { color: #00193a; }
.hljs-ln .ln-num::before { color: #00193a !important; }";

  } 

  // Style 7: Tomorrow
  if ($mybb->settings['high_code_sacc_setting_2'] == "7") {

     // Style
     $codeblock_style = "/*!
  Theme: Tomorrow
  Author: Chris Kempson (http://chriskempson.com)
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: @highlightjs/core-team
  Version: 2021.09.0
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#4d4d4c;background:#fff}.hljs ::selection,.hljs::selection{background-color:#d6d6d6;color:#4d4d4c}.hljs-comment{color:#8e908c}.hljs-tag{color:#969896}.hljs-operator,.hljs-punctuation,.hljs-subst{color:#4d4d4c}.hljs-operator{opacity:.7}.hljs-bullet,.hljs-deletion,.hljs-name,.hljs-selector-tag,.hljs-template-variable,.hljs-variable{color:#c82829}.hljs-attr,.hljs-link,.hljs-literal,.hljs-number,.hljs-symbol,.hljs-variable.constant_{color:#f5871f}.hljs-class .hljs-title,.hljs-title,.hljs-title.class_{color:#eab700}.hljs-strong{font-weight:700;color:#eab700}.hljs-addition,.hljs-code,.hljs-string,.hljs-title.class_.inherited__{color:#718c00}.hljs-built_in,.hljs-doctag,.hljs-keyword.hljs-atrule,.hljs-quote,.hljs-regexp{color:#3e999f}.hljs-attribute,.hljs-function .hljs-title,.hljs-section,.hljs-title.function_,.ruby .hljs-property{color:#4271ae}.diff .hljs-meta,.hljs-keyword,.hljs-template-tag,.hljs-type{color:#8959a8}.hljs-emphasis{color:#8959a8;font-style:italic}.hljs-meta,.hljs-meta .hljs-keyword,.hljs-meta .hljs-string{color:#a3685a}.hljs-meta .hljs-keyword,.hljs-meta-keyword{font-weight:700}

/*  Extra */
.hljs { background: #ffffff; }
.codeblock { background: #ffffff; }
.codeblock .title { color: #4d4d4c; }
.codeblock .title a:link { color: #4d4d4c; }
.hljs-ln .ln-num::before { color: #4d4d4c!important; }";

  } 

  // Style 8: Color Brewer
  if ($mybb->settings['high_code_sacc_setting_2'] == "8") {

     // Style
     $codeblock_style = "/*!
  Theme: Color Brewer
  Author:
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer:
  Version:
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#000;background:#fff}.hljs-addition,.hljs-meta,.hljs-string,.hljs-symbol,.hljs-template-tag,.hljs-template-variable{color:#756bb1}.hljs-comment,.hljs-quote{color:#636363}.hljs-bullet,.hljs-link,.hljs-literal,.hljs-number,.hljs-regexp{color:#31a354}.hljs-deletion,.hljs-variable{color:#88f}.hljs-built_in,.hljs-doctag,.hljs-keyword,.hljs-name,.hljs-section,.hljs-selector-class,.hljs-selector-id,.hljs-selector-tag,.hljs-strong,.hljs-tag,.hljs-title,.hljs-type{color:#3182bd}.hljs-emphasis{font-style:italic}.hljs-attribute{color:#e6550d}

/*  Extra */
.hljs { background: #ffffff; }
.codeblock { background: #ffffff; }
.codeblock .title { color: #000000; }
.codeblock .title a:link { color: #000000; }
.hljs-ln .ln-num::before { color: #000000 !important; }";

  }   

  // Style 9: Zenburn
  if ($mybb->settings['high_code_sacc_setting_2'] == "9") {

     // Style
     $codeblock_style = "/*!
  Theme: Zenburn
  Author: elnawe
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: @highlightjs/core-team
  Version: 2021.09.0
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#dcdccc;background:#383838}.hljs ::selection,.hljs::selection{background-color:#606060;color:#dcdccc}.hljs-comment{color:#6f6f6f}.hljs-tag{color:grey}.hljs-operator,.hljs-punctuation,.hljs-subst{color:#dcdccc}.hljs-operator{opacity:.7}.hljs-bullet,.hljs-deletion,.hljs-name,.hljs-selector-tag,.hljs-template-variable,.hljs-variable{color:#dca3a3}.hljs-attr,.hljs-link,.hljs-literal,.hljs-number,.hljs-symbol,.hljs-variable.constant_{color:#dfaf8f}.hljs-class .hljs-title,.hljs-title,.hljs-title.class_{color:#e0cf9f}.hljs-strong{font-weight:700;color:#e0cf9f}.hljs-addition,.hljs-code,.hljs-string,.hljs-title.class_.inherited__{color:#5f7f5f}.hljs-built_in,.hljs-doctag,.hljs-keyword.hljs-atrule,.hljs-quote,.hljs-regexp{color:#93e0e3}.hljs-attribute,.hljs-function .hljs-title,.hljs-section,.hljs-title.function_,.ruby .hljs-property{color:#7cb8bb}.diff .hljs-meta,.hljs-keyword,.hljs-template-tag,.hljs-type{color:#dc8cc3}.hljs-emphasis{color:#dc8cc3;font-style:italic}.hljs-meta,.hljs-meta .hljs-keyword,.hljs-meta .hljs-string{color:#000}.hljs-meta .hljs-keyword,.hljs-meta-keyword{font-weight:700}

/*  Extra */
.hljs { background: #383838; }
.codeblock { background: #383838; }
.codeblock .title { color: #dcdccc; }
.codeblock .title a:link { color: #dcdccc; }
.hljs-ln .ln-num::before { color: #dcdccc !important; }";

  } 

  // Style 10: Agate
  if ($mybb->settings['high_code_sacc_setting_2'] == "10") {

     // Style
     $codeblock_style = "pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}/*!
   Theme: Agate
   Author: (c) Taufik Nurrohman <hi@taufik-nurrohman.com>
   Maintainer: @taufik-nurrohman
   Updated: 2021-04-24

   #333
   #62c8f3
   #7bd694
   #888
   #a2fca2
   #ade5fc
   #b8d8a2
   #c6b4f0
   #d36363
   #fc9b9b
   #fcc28c
   #ffa
   #fff
*/ .hljs{background:#333;color:#fff}.hljs-doctag,.hljs-meta-keyword,.hljs-name,.hljs-strong{font-weight:700}.hljs-code,.hljs-emphasis{font-style:italic}.hljs-section,.hljs-tag{color:#62c8f3}.hljs-selector-class,.hljs-selector-id,.hljs-template-variable,.hljs-variable{color:#ade5fc}.hljs-meta-string,.hljs-string{color:#a2fca2}.hljs-attr,.hljs-quote,.hljs-selector-attr{color:#7bd694}.hljs-tag .hljs-attr{color:inherit}.hljs-attribute,.hljs-title,.hljs-type{color:#ffa}.hljs-number,.hljs-symbol{color:#d36363}.hljs-bullet,.hljs-template-tag{color:#b8d8a2}.hljs-built_in,.hljs-keyword,.hljs-literal,.hljs-selector-tag{color:#fcc28c}.hljs-code,.hljs-comment,.hljs-formula{color:#888}.hljs-link,.hljs-regexp,.hljs-selector-pseudo{color:#c6b4f0}.hljs-meta{color:#fc9b9b}.hljs-deletion{background:#fc9b9b;color:#333}.hljs-addition{background:#a2fca2;color:#333}.hljs-subst{color:#fff}.hljs a{color:inherit}.hljs a:focus,.hljs a:hover{color:inherit;text-decoration:underline}.hljs mark{background:#555;color:inherit}

/*  Extra */
.hljs { background: #333333; }
.codeblock { background: #333333; }
.codeblock .title { color: #ffffff; }
.codeblock .title a:link { color: #ffffff; }
.hljs-ln .ln-num::before { color: #ffffff !important; }";

  } 

  // Style 11: Android Studio
  if ($mybb->settings['high_code_sacc_setting_2'] == "11") {

     // Style
     $codeblock_style = "/*!
  Theme: Android Studio
  Author:
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer:
  Version:
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#a9b7c6;background:#282b2e}.hljs-bullet,.hljs-literal,.hljs-number,.hljs-symbol{color:#6897bb}.hljs-deletion,.hljs-keyword,.hljs-selector-tag{color:#cc7832}.hljs-link,.hljs-template-variable,.hljs-variable{color:#629755}.hljs-comment,.hljs-quote{color:grey}.hljs-meta{color:#bbb529}.hljs-addition,.hljs-attribute,.hljs-string{color:#6a8759}.hljs-section,.hljs-title,.hljs-type{color:#ffc66d}.hljs-name,.hljs-selector-class,.hljs-selector-id{color:#e8bf6a}.hljs-emphasis{font-style:italic}.hljs-strong{font-weight:700}

/*  Extra */
.hljs { background: #282b2e; }
.codeblock { background: #282b2e; }
.codeblock .title { color: #a9b7c6; }
.codeblock .title a:link { color: #a9b7c6; }
.hljs-ln .ln-num::before { color: #a9b7c6 !important; }";

  }

  // Style 12: Dracula
  if ($mybb->settings['high_code_sacc_setting_2'] == "12") {

     // Style
     $codeblock_style = "/*!
  Theme: Dracula
  Author: Mike Barkmin (http://github.com/mikebarkmin) based on Dracula Theme (http://github.com/dracula)
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer: @highlightjs/core-team
  Version: 2021.09.0
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#e9e9f4;background:#282936}.hljs ::selection,.hljs::selection{background-color:#4d4f68;color:#e9e9f4}.hljs-comment{color:#626483}.hljs-tag{color:#62d6e8}.hljs-operator,.hljs-punctuation,.hljs-subst{color:#e9e9f4}.hljs-operator{opacity:.7}.hljs-bullet,.hljs-deletion,.hljs-name,.hljs-selector-tag,.hljs-template-variable,.hljs-variable{color:#ea51b2}.hljs-attr,.hljs-link,.hljs-literal,.hljs-number,.hljs-symbol,.hljs-variable.constant_{color:#b45bcf}.hljs-class .hljs-title,.hljs-title,.hljs-title.class_{color:#00f769}.hljs-strong{font-weight:700;color:#00f769}.hljs-addition,.hljs-code,.hljs-string,.hljs-title.class_.inherited__{color:#ebff87}.hljs-built_in,.hljs-doctag,.hljs-keyword.hljs-atrule,.hljs-quote,.hljs-regexp{color:#a1efe4}.hljs-attribute,.hljs-function .hljs-title,.hljs-section,.hljs-title.function_,.ruby .hljs-property{color:#62d6e8}.diff .hljs-meta,.hljs-keyword,.hljs-template-tag,.hljs-type{color:#b45bcf}.hljs-emphasis{color:#b45bcf;font-style:italic}.hljs-meta,.hljs-meta .hljs-keyword,.hljs-meta .hljs-string{color:#00f769}.hljs-meta .hljs-keyword,.hljs-meta-keyword{font-weight:700}

/*  Extra */
.hljs { background: #282936; }
.codeblock { background: #282936; }
.codeblock .title { color: #e9e9f4; }
.codeblock .title a:link { color: #e9e9f4; }
.hljs-ln .ln-num::before { color: #e9e9f4 !important; }";

  } 

  // Style 13: Rainbow
  if ($mybb->settings['high_code_sacc_setting_2'] == "13") {

     // Style
     $codeblock_style = "/*!
  Theme: Rainbow
  Author: 
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer:
  Version:
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{background:#474949;color:#d1d9e1}.hljs-comment,.hljs-quote{color:#969896;font-style:italic}.hljs-addition,.hljs-keyword,.hljs-literal,.hljs-selector-tag,.hljs-type{color:#c9c}.hljs-number,.hljs-selector-attr,.hljs-selector-pseudo{color:#f99157}.hljs-doctag,.hljs-regexp,.hljs-string{color:#8abeb7}.hljs-built_in,.hljs-name,.hljs-section,.hljs-title{color:#b5bd68}.hljs-class .hljs-title,.hljs-selector-id,.hljs-template-variable,.hljs-title.class_,.hljs-variable{color:#fc6}.hljs-name,.hljs-section,.hljs-strong{font-weight:700}.hljs-bullet,.hljs-link,.hljs-meta,.hljs-subst,.hljs-symbol{color:#f99157}.hljs-deletion{color:#dc322f}.hljs-formula{background:#eee8d5}.hljs-attr,.hljs-attribute{color:#81a2be}.hljs-emphasis{font-style:italic}

/*  Extra */
.hljs { background: #474949; }
.codeblock { background: #474949; }
.codeblock .title { color: #d1d9e1; }
.codeblock .title a:link { color: #d1d9e1; }
.hljs-ln .ln-num::before { color: #d1d9e1 !important; }";

  } 

  // Style 14: VS
  if ($mybb->settings['high_code_sacc_setting_2'] == "14") {

     // Style
     $codeblock_style = "/*!
  Theme: VS
  Author: 
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer:
  Version:
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{background:#fff;color:#000}.hljs-comment,.hljs-quote,.hljs-variable{color:green}.hljs-built_in,.hljs-keyword,.hljs-name,.hljs-selector-tag,.hljs-tag{color:#00f}.hljs-addition,.hljs-attribute,.hljs-literal,.hljs-section,.hljs-string,.hljs-template-tag,.hljs-template-variable,.hljs-title,.hljs-type{color:#a31515}.hljs-deletion,.hljs-meta,.hljs-selector-attr,.hljs-selector-pseudo{color:#2b91af}.hljs-doctag{color:grey}.hljs-attr{color:red}.hljs-bullet,.hljs-link,.hljs-symbol{color:#00b0e8}.hljs-emphasis{font-style:italic}.hljs-strong{font-weight:700}

/*  Extra */
.hljs { background: #ffffff; }
.codeblock { background: #ffffff; }
.codeblock .title { color: #000000; }
.codeblock .title a:link { color: #000000; }
.hljs-ln .ln-num::before { color: #000000 !important; }";

  } 

  // Style 15: Atom One Dark
  if ($mybb->settings['high_code_sacc_setting_2'] == "15") {

     // Style
     $codeblock_style = "/*!
  Theme: Atom One Dark
  Author: 
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer:
  Version:
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#abb2bf;background:#282c34}.hljs-comment,.hljs-quote{color:#5c6370;font-style:italic}.hljs-doctag,.hljs-formula,.hljs-keyword{color:#c678dd}.hljs-deletion,.hljs-name,.hljs-section,.hljs-selector-tag,.hljs-subst{color:#e06c75}.hljs-literal{color:#56b6c2}.hljs-addition,.hljs-attribute,.hljs-meta .hljs-string,.hljs-regexp,.hljs-string{color:#98c379}.hljs-attr,.hljs-number,.hljs-selector-attr,.hljs-selector-class,.hljs-selector-pseudo,.hljs-template-variable,.hljs-type,.hljs-variable{color:#d19a66}.hljs-bullet,.hljs-link,.hljs-meta,.hljs-selector-id,.hljs-symbol,.hljs-title{color:#61aeee}.hljs-built_in,.hljs-class .hljs-title,.hljs-title.class_{color:#e6c07b}.hljs-emphasis{font-style:italic}.hljs-strong{font-weight:700}.hljs-link{text-decoration:underline}

/*  Extra */
.hljs { background: #282c34; }
.codeblock { background: #282c34; }
.codeblock .title { color: #abb2bf; }
.codeblock .title a:link { color: #abb2bf; }
.hljs-ln .ln-num::before { color: #abb2bf !important; }";

  }  

  // Style 16: Atom One Light
  if ($mybb->settings['high_code_sacc_setting_2'] == "16") {

     // Style
     $codeblock_style = "/*!
  Theme: Atom One Light
  Author: 
  License: ~ MIT (or more permissive) [via base16-schemes-source]
  Maintainer:
  Version:
*/ pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#383a42;background:#fafafa}.hljs-comment,.hljs-quote{color:#a0a1a7;font-style:italic}.hljs-doctag,.hljs-formula,.hljs-keyword{color:#a626a4}.hljs-deletion,.hljs-name,.hljs-section,.hljs-selector-tag,.hljs-subst{color:#e45649}.hljs-literal{color:#0184bb}.hljs-addition,.hljs-attribute,.hljs-meta .hljs-string,.hljs-regexp,.hljs-string{color:#50a14f}.hljs-attr,.hljs-number,.hljs-selector-attr,.hljs-selector-class,.hljs-selector-pseudo,.hljs-template-variable,.hljs-type,.hljs-variable{color:#986801}.hljs-bullet,.hljs-link,.hljs-meta,.hljs-selector-id,.hljs-symbol,.hljs-title{color:#4078f2}.hljs-built_in,.hljs-class .hljs-title,.hljs-title.class_{color:#c18401}.hljs-emphasis{font-style:italic}.hljs-strong{font-weight:700}.hljs-link{text-decoration:underline}

/*  Extra */
.hljs { background: #fafafa; }
.codeblock { background: #fafafa; }
.codeblock .title { color: #383a42; }
.codeblock .title a:link { color: #383a42; }
.hljs-ln .ln-num::before { color: #383a42 !important; }";

  }

  // Add To / Remove From Head On Showthread And Portal templates

  // If Plugin Active
  if ($mybb->settings['high_code_sacc_setting_1'] == "1") { 

     // Globals
     global $headerinclude;

     // Headerinclude
     $headerinclude .= "
<!-- Select All / Copy -->
<script type=\"text/javascript\">
function selectCode(a)
{
   var e = a.parentNode.parentNode.getElementsByTagName('CODE')[0];
   if (window.getSelection)
   {
      var s = window.getSelection();
       if (s.setBaseAndExtent)
      {
         s.setBaseAndExtent(e, 0, e.parentNode, 1);
      }
      else
      {
         var r = document.createRange();
         r.selectNodeContents(e);
         s.removeAllRanges();
         s.addRange(r);      
      }
   }
   else if (document.getSelection)
   {
      var s = document.getSelection();
      var r = document.createRange();
      r.selectNodeContents(e);
      s.removeAllRanges();
      s.addRange(r);
   }
   else if (document.selection)
   {
      var r = document.body.createTextRange();
      r.moveToElementText(e);
      r.select();     
   }
   document.execCommand('copy');
}
</script>
<!-- Highlight JS --> 
<script src=\"inc/plugins/highlight/jscripts/highlight.min.js\"></script>
<!-- Highlight JS And Plugins Init -->  
<script src=\"inc/plugins/highlight/jscripts/high_code_sacc_init.js\"></script>
<!-- Highlight JS Custom LineNumbers Plugin Style --> 
<style>
/** Linenumbers Plug **/
.hljs-ln {
    position: relative;
    padding-left: 3em !important;
}
.hljs-ln .ln-bg {
    position: absolute;
    z-index: 1;
    top: 0;
    left: 0;
    width: 2.2em;
    height: 100%;
    border-right: 1px solid #ccc;
    /*background: rgba(255, 255, 255, 0.18);*/
    margin-left: 0.5em;
}
.hljs-ln .ln-num {
    position: relative;
    display: inline-block;
    height: 1em;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.hljs-ln .ln-num::before {
    position: absolute;
    z-index: 2;
    top: 0;
    right: 0;
    margin-right: 1em;
    color: #777;
    font-style: normal;
    font-weight: normal;
    content: attr(data-num);
}
/* pre, code */
pre, code {
    padding: 0;
    margin: 0;
    white-space: pre;
} 
</style>";
  
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
     $high_code_sacc = "<style>".$codeblock_style."</style>";
  }

  // If Plugin Not Active 
  if ($mybb->settings['high_code_sacc_setting_1'] == "0") { 
  	 // Empty Codeblock Style Inline
     $high_code_sacc = "";
  }

}

?>
