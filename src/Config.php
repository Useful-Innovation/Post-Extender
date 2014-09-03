<?php

namespace GoBrave\PostExtender;

class Config
{
  private $files_url;
  private $files_dir;
  private $struct_dir;

  public function __construct($settings = []) {
    if(count($settings) > 0) {
      foreach(['files_url', 'files_dir', 'struct_dir'] as $key) {
        if(isset($settings[$key])) {
          $this->{$key} = $settings[$key];
        }
      }
    }
  }

  public function setFilesUrl($files_url) {
    $this->files_url = $files_url;
  }

  public function getFilesUrl() {
    return $this->files_url;
  }

  public function setFilesDir($files_dir) {
    $this->files_dir = $files_dir;
  }

  public function getFilesDir() {
    return $this->files_dir;
  }

  public function setStructDir($struct_dir) {
    $this->struct_dir = $struct_dir;
  }

  public function getStructDir() {
    return $this->struct_dir;
  }
}
