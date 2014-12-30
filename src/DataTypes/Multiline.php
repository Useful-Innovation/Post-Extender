<?php

namespace GoBrave\PostExtender\DataTypes;

class Multiline
{
  private $content;
  private $wp;

  public function __construct($content, \GoBrave\Util\IWP $wp) {
    $this->content = $content;
    $this->wp = $wp;
  }

  public function plain() {
    return strip_tags($this->content());
  }

  public function content() {
    return $this->wp->apply_filters('the_content', $this->content);
  }

  public function __toString() {
    return $this->content();
  }
}
