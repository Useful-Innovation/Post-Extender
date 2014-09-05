<?php

use \GoBrave\PostExtender\PostExtender;

class PostExtenderStructTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    PostExtender::setConfig(new GoBrave\PostExtender\Config([
      'files_url' => MF_FILES_URL,
      'files_dir' => MF_FILES_DIR,
      'struct_dir' => __DIR__ . '/data/posttypes'
    ]));
  }

  public function testStruct() {
    $post = Page::find(2);
    $struct = $post->getStruct();
    $this->assertTrue($struct instanceof GoBrave\PostExtender\Struct, '$struct is instance of Struct');
  }

  public function testLoadAll() {
    $a = PostExtender::loadAllPostTypes();
    $this->assertTrue(isset($a['page']));
  }
}
