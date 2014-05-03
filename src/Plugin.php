<?php

namespace GoBrave\PostExtender;

class Plugin
{
  public function __construct() {
    if(!defined('MF_BASENAME')) {
      $this->warning();
    }
  }

  public function warning() {
    \add_action('admin_notices', function() {
      global $current_screen;
      echo '<div class="error"><p>The Post Extender depends on Magic Fields 2. Please go to <a href="/wp-admin/plugins.php">plugins</a> for activation</p></div>';
    });
  }
}
