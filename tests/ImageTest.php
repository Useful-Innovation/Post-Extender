<?php

use \GoBrave\PostExtender\DataTypes\Image;

class ImageTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->image = new Image(53, new Wp());
  }

  public function testConstruct() {
    $this->assertTrue($this->image instanceof Image);
  }

  public function testToString() {
    $this->assertSame((string)$this->image, '53');
  }

  public function testToUrl() {
    $url = $this->image->url();
    $this->assertTrue(substr($url, 0, 7) == 'http://', 'Checking that image returns url');
  }

  public function testToUrlFail() {
    $url = $this->image->url('fail');
    $this->assertFalse($url);
  }
}
