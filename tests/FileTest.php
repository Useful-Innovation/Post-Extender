<?php

use \GoBrave\PostExtender\DataTypes\File;

class FileTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->file = new File('1407267522some_file.pdf', new Wp(), MF_FILES_URL, MF_FILES_PATH);
  }

  public function testConstruct() {
    $this->assertTrue($this->file instanceof File);
  }

  public function testToString() {
    $this->assertSame((string)$this->file, 'some_file');
  }

  public function testAccessors() {
    $this->assertSame($this->file->basename(), 'some_file.pdf', 'Testing basename');
    $this->assertSame($this->file->filename(), 'some_file', 'Testing filename');
    $this->assertSame($this->file->extension(), 'pdf', 'Testing extension');
    $this->assertSame($this->file->raw(), '1407267522some_file.pdf', 'Testing raw');
  }

  public function testToUrl() {
    $url = $this->file->url();
    $this->assertTrue($url == 'http://files_mf/1407267522some_file.pdf', 'Checking that file returns url');
  }

  public function testSize() {
    $size = $this->file->size();
    $this->assertTrue($size == 28);
  }

  public function testSizeFormatted() {
    $file = new File('1407267522kb_file.pdf', new Wp(), MF_FILES_URL, MF_FILES_PATH);
    $size = $file->sizeFormatted(File::KB, 2, ',');
    $this->assertTrue($size == '12,43 KB');
    $size = $file->sizeFormatted(File::KB, 1, ',');
    $this->assertTrue($size == '12,4 KB');
    $size = $file->sizeFormatted(File::KB, 1, '.');
    $this->assertTrue($size == '12.4 KB');
    $size = $file->sizeFormatted(File::KB, 0);
    $this->assertTrue($size == '12 KB');

    $size = $file->sizeFormatted();
    $this->assertTrue($size == '12 KB');

    $file = new File('1407267522mb_file.pdf', new Wp(), MF_FILES_URL, MF_FILES_PATH);
    $size = $file->sizeFormatted(File::MB);
    $this->assertTrue($size == '1 MB');
    $size = $file->sizeFormatted(File::MB, 2);
    $this->assertTrue($size == '1,09 MB');

    $size = $file->sizeFormatted();
    $this->assertTrue($size == '1 MB');

    $size = $this->file->sizeFormatted();
    $this->assertTrue($size == '28 B');
  }
}
