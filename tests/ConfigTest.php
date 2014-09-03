<?php

use \GoBrave\PostExtender\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->c = new Config();
  }

  public function testFilesUrl() {
    $this->c->setFilesUrl(__DIR__);
    $this->assertSame($this->c->getFilesUrl(), __DIR__);
  }

  public function testFilesDir() {
    $this->c->setFilesDir(__DIR__);
    $this->assertSame($this->c->getFilesDir(), __DIR__);
  }

  public function testStructDir() {
    $this->c->setStructDir(__DIR__);
    $this->assertSame($this->c->getStructDir(), __DIR__);
  }

  public function testShortcutConstruct() {
    $c = new Config([
      'files_url' => __DIR__,
      'files_dir' => __DIR__,
      'struct_dir' => __DIR__
    ]);

    $this->assertSame($c->getFilesUrl(), __DIR__);
    $this->assertSame($c->getFilesDir(), __DIR__);
    $this->assertSame($c->getStructDir(), __DIR__);
  }
}
