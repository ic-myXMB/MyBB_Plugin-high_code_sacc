# MyBB_Plugin-high_code_sacc
 
/*
 * MyBB: Highlight Code Select All Copy Code
 * 
 * Authors: Vintagedaddyo & ic_myXMB
 *
 * MyBB Version: 1.8.x (was created at time using 1.8.31)
 *
 * Current Plugin Version: 1.0.4
 *
 * Langs: English, EnglishGB, Spanish, French, Italiano, German
 *
 * Current HighlightJS version:  v11.7.0
 *
 */


INSTALL INSTRUCTIONS:

 1) Upload the contents of the "Upload" folder to your forum root directory
 2) Visit ACP settings and choose to enable or disable plugin
 3) Visit ACP settings and choose what codeblock style you desire (16 presently)
 4) Have Fun!


TO DO:

  - Add more of the styles found presently on HighlightJS site (around 128? to choose from)


CHANGELOG:

- Version 1.0.4

   - Added codeblock styles (had 33 previously) and now added 12 additonal codeblock styles (total: 45 currently)

  - Current Themes: Default, Solarized Dark, Solarized Light, Github, Railscasts, Monakai Sublime, Mono Blue, Tomorrow, Color Brewer, Zenburn, Agate, Android Studio, Dracula, Rainbow, VS, Atom One Dark, Atom One Light, Github Dark Dimmed, Github Dark, Dark, Stack Overflow Light, Stack Overflow Dark, Google Code, Foundation, XCode, Night Owl, Kimbie Light, Kimbie Dark, Codepen Embed, Srcery, Routeros, Panda Syntax Light, Panda Syntax Dark, DeviBeans, Lightfair, Obsidian, Nord, QT Creator Light, QT Creator Dark, Paraiso Light, Paraiso Dark, isbl Editor Light, isbl Editor Dark, nnfx Light, nnfx Dark, Grayscale 
   
- Version 1.0.3

   - Added codeblock styles (had 16 previously) and now added 17 additonal codeblock styles (total: 33 currently) 
   - decided to cut down on some of the existing lines within plugin as such was getting lengthly & cluttered with all the styles inline
   - removed existing 16 themes inline styling in the plugin and added themes directory and 16 specific theme css files
   - removed inline line-numbers css and added as css file 

- Version 1.0.2

   - minor code edits (gid and group[gid] related)
   - plugin included files directory name change
   - added plugin page settings link    

- Version 1.0.1

   - Further localization support (currently: English, EnglishGB, Spanish, French Italian,German)
   - Added 16 inline styles from the HighlightJS site
   - Removed single linked default stylesheet and related file
   - Contains Ability to select desired codeblock styles (16 currently)
   - Wraps all code tags in pre tags via JS
   - Contains ability to enable or disable the plugin
   - Contains localization support
   - Contains Select All Copy links on each codeblock
   - Contains Latest/Current HighlightJS version

- Version 1.0.0

   - Contains ability to enable or disable plugin
   - Contains localization support (currently: English, EnglishGB)
   - Contains Select All Copy links on each codeblock
   - Contains HighlightJS And Default Style
   - Initial release 

Final Note: A special thanks goes out to the past major community contributor Vintagedaddyo for teaching me MyBB plugin development, allowing me to bug him with tons of questions and also allowing me to use some of his past shared features and old plugin base for this as well helping me step by step develop this, my first MyBB plugin. :)

