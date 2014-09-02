<?php

namespace GoBrave\PostExtender;

class Struct
{
  private $data;

  public function __construct($json_file) {
    if(!file_exists($json_file)) {
      throw new \Exception('Json file \'' . $json_file . '\' does not exists', 1);
    }

    $this->data = json_decode(file_get_contents($json_file));
    if(!$this->data) {
      throw new \Exception('Json format is not correct', 1);
    }
  }

  public function parent() {
    if($this->data->parent) {
      return $this->data->parent;
    }
    return false;
  }

  public function hasPage() {
    if($this->data->has_page) {
      return $this->data->has_page;
    }
    return false;
  }

  public function single() {
    if($this->data->single) {
      return $this->data->single;
    }
    return false;
  }

  public function rewrite() {
    if($this->data->rewrite) {
      return $this->data->rewrite;
    }
    return false;
  }

}
