<?php

namespace GoBrave\PostExtender\DataTypes;

use \GoBrave\PostExtender\Helpers\CaseConverter;

class Related
{
  private $id;
  private $wp;

  public function __construct($id, \GoBrave\PostExtender\IWP $wp) {
    $this->id = $id;
    $this->wp = $wp;
  }

  public function __toString() {
    return (string)$this->id;
  }

  public function get() {
    $post  = $this->wp->get_post($this->id);
    $class = CaseConverter::snakeToCamel($post->post_type, true);
    return new $class($post);
  }
}
