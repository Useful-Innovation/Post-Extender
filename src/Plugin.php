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
      echo '<div class="error"><p>PostExtender kräver Magic Fields 2. Gå till <a href="/wp-admin/plugins.php">plugins</a> för att aktivera</p></div>';
    });
  }
}
