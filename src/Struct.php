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

  public function name() {
    return $this->data->post_type ?: false;
  }

  public function parent() {
    return $this->data->parent ?: false;
  }

  public function hasPage() {
    return $this->data->has_page ?: false;
  }

  public function single() {
    return $this->data->single ?: false;
  }

  public function rewrite() {
    return $this->data->rewrite ?: false;
  }

  public function singular() {
    return $this->data->singular ?: false;
  }

  public function plural() {
    return $this->data->plural ?: false;
  }

}
