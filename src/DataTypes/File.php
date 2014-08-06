<?php

namespace GoBrave\PostExtender\DataTypes;

class File
{
  private $real_filename;
  private $basename;
  private $filename;
  private $extension;
  private $wp;
  private $base_url;

  public function __construct($filename, \GoBrave\PostExtender\IWP $wp, $base_url) {
    $this->real_filename = $filename;
    $info = pathinfo(substr($this->real_filename, 10));
    $this->basename  = $info['basename'];
    $this->filename  = $info['filename'];
    $this->extension = $info['extension'];
    $this->wp = $wp;
    $this->base_url = rtrim($base_url, '/');
  }

  public function url() {
    return $this->base_url . '/' . $this->raw();
  }

  public function basename() {
    return $this->basename;
  }

  public function filename() {
    return $this->filename;
  }

  public function extension() {
    return $this->extension;
  }

  public function raw() {
    return $this->real_filename;
  }

  public function __toString() {
    return (string)$this->filename;
  }

}
