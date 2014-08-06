<?php

use \GoBrave\PostExtender\DataTypes\File;

class FileTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->file = new File('1407267522SomePdf.pdf', new Wp(), 'http://files_mf/');
  }

  public function testConstruct() {
    $this->assertTrue($this->file instanceof File);
  }

  public function testToString() {
    $this->assertSame((string)$this->file, 'SomePdf');
  }

  public function testAccessors() {
    $this->assertSame($this->file->basename(), 'SomePdf.pdf', 'Testing basename');
    $this->assertSame($this->file->filename(), 'SomePdf', 'Testing filename');
    $this->assertSame($this->file->extension(), 'pdf', 'Testing extension');
    $this->assertSame($this->file->raw(), '1407267522SomePdf.pdf', 'Testing raw');
  }

  public function testToUrl() {
    $url = $this->file->url();
    $this->assertTrue($url == 'http://files_mf/1407267522SomePdf.pdf', 'Checking that file returns url');
  }
}
