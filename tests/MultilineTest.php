<?php

use \GoBrave\PostExtender\DataTypes\Multiline;

class MultilineTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->multiline = new Multiline('this is content', new Wp());
  }

  public function testConstruct() {
    $this->assertTrue($this->multiline instanceof Multiline);
  }

  public function testToString() {
    $this->assertSame((string)$this->multiline, '<p>this is content</p>');
  }

  public function testGetContent() {
    $this->assertSame($this->multiline->content(), '<p>this is content</p>');
  }

  public function testPlainString() {
    $this->assertSame($this->multiline->plain(), 'this is content');
  }

  public function testRaw() {
    $content = $this->multiline->raw();
    $this->assertSame($content, 'this is content');
  }
}
