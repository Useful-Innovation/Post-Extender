<?php

use GoBrave\PostExtender\Wp;

class WpTest extends PHPUnit_Framework_TestCase
{

  /**
   * @expectedException Exception
   */
  public function testWpMissingFunction() {
    $wp = new Wp();
    $wp->oaisjd();
  }
}
