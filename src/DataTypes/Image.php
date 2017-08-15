<?php namespace GoBrave\PostExtender\DataTypes;

use GoBrave\PostExtender\DataTypeInterface;

class Image implements DataTypeInterface
{
  private $id;
  private $wp;

  public function __construct($id, \GoBrave\Util\IWP $wp) {
    $this->id = $id;
    $this->wp = $wp;
  }

  public function raw() {
    return $this->id;
  }

  public function __toString() {
    return strval($this->id);
  }

  public function url($size = 'thumbnail') {
    $image = $this->wp->wp_get_attachment_image_src($this->id, $size);
    if(!$image) {
      return false;
    }

    if(defined('CUSTOM_UPLOAD_PATH')){
      $image[0] = str_replace(wp_upload_dir('base_url'), CUSTOM_UPLOAD_PATH, $image[0]);
    }

    return $image[0];
  }
}
