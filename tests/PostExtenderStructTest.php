<?php

class PostExtenderStructTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {

  }

  public function testStruct() {
    $post = Page::find(2);
    $struct = $post->getStruct();
    $this->assertTrue($struct instanceof GoBrave\PostExtender\Struct, '$struct is instance of Struct');
  }
}
