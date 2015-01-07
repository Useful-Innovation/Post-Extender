<?php

namespace GoBrave\PostExtender\DataTypes;

use \GoBrave\PostExtender\Helpers\CaseConverter;

class Related
{
  private $id;
  private $wp;
  private $namespace;

  public function __construct($id, \GoBrave\Util\IWP $wp, $namespace = '') {
    $this->id        = $id;
    $this->wp        = $wp;
    $this->namespace = trim($namespace, '\\');
  }

  public function __toString() {
    return (string)$this->id();
  }

  public function id() {
    return $this->id;
  }

  public function get() {
    $post  = $this->wp->get_post($this->id);
    $class = implode('\\', [$this->namespace, CaseConverter::snakeToCamel($post->post_type, true)]);
    return $class::extend($post);
  }
}
