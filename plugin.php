<?php
/**
 * @package PostExtender
 * @version 0.1
 */
/*
Plugin Name: Post Extender
Description: Extends posts with all it's meta data in one db-request
Author: Emil Lunnergård
Version: 0.1
*/

require_once(__DIR__ . '/vendor/autoload.php');

\add_action('plugins_loaded', function() {
  new GoBrave\PostExtender\Plugin();
});

