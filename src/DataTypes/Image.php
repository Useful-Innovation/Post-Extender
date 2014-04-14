<?php

namespace GoBrave\PostExtender\DataTypes;

class Image
{
  private $id;
  public function __construct($id) {
    $this->id = $id;
  }

  public function __toString() {
    return strval($this->id);
  }
}