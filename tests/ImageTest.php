<?php

use \GoBrave\PostExtender\DataTypes\Image;

class ImageTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {

  }

  public function testConstruct() {
    $image = new Image(45);
    $this->assertTrue($image instanceof Image);
  }

  public function testToString() {
    $image = new Image(53);
    $this->assertSame((string)$image, '53');
  }
}
