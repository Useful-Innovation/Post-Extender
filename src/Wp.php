<?php

namespace GoBrave\PostExtender;

class WP implements IWP
{
  public function __call($name, $arguments) {
    if(function_exists($name)) {
      return call_user_func_array($name, $arguments);
    }
    throw new \Exception('Function ' . $name . ' does not exist');
  }
}
