<?php

namespace GoBrave\PostExtender\DataTypes;

class Image
{
  private $id;
  private $wp;

  public function __construct($id, \GoBrave\PostExtender\IWP $wp) {
    $this->id = $id;
    $this->wp = $wp;
  }

  public function __toString() {
    return strval($this->id);
  }

  public function url($size = 'thumbnail') {
    $image = $this->wp->wp_get_attachment_image_src($this->id, $size);
    if(!$image) {
      return false;
    }

    return $image[0];
  }
}
