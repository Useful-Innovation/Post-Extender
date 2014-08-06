<?php

namespace GoBrave\PostExtender;

interface IWP
{
  public function __call($function, $arguments);
}
