<?php if (!defined('APPLICATION')) exit();
// DO NOT EDIT THIS FILE
// All of the settings defined here can be overridden in the /conf/config.php file.



// ^^ That's for users of your application, not you (the developer).
// This file is where to place any default config settings for your application.

// Usually you'll want to name your config settings in 3 parts: app short name, section of the app, and setting name:
$Configuration['FancyPages']['Setup']['Initialized'] = TRUE;
if(!C('FancyPage.Default.Page'))
$Configuration['FancyPages']['Default']['Page'] = 'defaultpage';

// You can access the above anywhere in your application like this: $DefaultValue = C('Skeleton.Section.Setting');