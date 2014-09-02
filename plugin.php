<?php
/**
 * @package PostExtender
 * @version 0.1
 */
/*
Plugin Name: Magic Fields 2 - Post Extender
Description: Extends posts with all it's meta data in one db-request
Author: Emil Lunnergård
Version: 0.1
*/

//
//    This is not a necessary part of the lib. If you want to load this as a plugin, use this file.
//

require_once(__DIR__ . '/vendor/autoload.php');

if(function_exists('add_action')) {
  \add_action('plugins_loaded', function() {
    define('MF_POST_EXTENDER', true);
    new GoBrave\PostExtender\Plugin();
  });
}

