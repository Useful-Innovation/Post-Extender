<?php

require_once(__DIR__ . '/vendor/autoload.php');

$wp = new GoBrave\PostExtender\Wp();

$wp->asd(1, 2, 3);

function asd($a, $b, $c) {
  var_dump($a, $b, $c);
}