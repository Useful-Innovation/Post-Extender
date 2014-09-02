<?php

use GoBrave\PostExtender\Struct;

class StructTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->s = new Struct(__DIR__ . '/data/page.json');
    $this->f = new Struct(__DIR__ . '/data/failure.json');
  }

  public function testStruct() {
    $struct = new Struct(__DIR__ . '/data/page.json');
  }

  /**
   * @expectedException Exception
   */
  public function testMissingFile() {
    $struct = new Struct(__DIR__ . '/asd.json');
  }

  /**
   * @expectedException Exception
   */
  public function testBadFormatFile() {
    $struct = new Struct(__DIR__ . '/data/format.json');
  }

  public function testParent() {
    $this->assertSame($this->s->parent(), 'ui_category');
    $this->assertFalse($this->f->parent());
  }

  public function testHasPage() {
    $this->assertSame($this->s->hasPage(), true);
    $this->assertFalse($this->f->hasPage());
  }

  public function testSingle() {
    $this->assertSame($this->s->single(), true);
    $this->assertFalse($this->f->single());
  }

  public function testRewrite() {
    $this->assertSame($this->s->rewrite(), 'sida');
    $this->assertFalse($this->f->rewrite());
  }
}
