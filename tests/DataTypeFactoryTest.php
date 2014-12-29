<?php

use GoBrave\PostExtender\DataTypes\File;
use GoBrave\PostExtender\DataTypes\Image;
use GoBrave\PostExtender\DataTypes\Multiline;
use GoBrave\PostExtender\DataTypes\Related;
use GoBrave\PostExtender\DataTypeFactory;
use GoBrave\PostExtender\Config;

class DataTypeFactoryTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->f = new DataTypeFactory(new Config());
  }


  /**
  * @dataProvider typesAndClasses
  */
  public function testCreateByComplexType($type, $class, $data) {
    $obj = $this->f->create($type, $data);
    $this->assertTrue($obj instanceof $class);
  }

  public function typesAndClasses() {
    return [
      ['file',          'GoBrave\PostExtender\DataTypes\File',      '1407267522some_file.pdf'],
      ['image_media',   'GoBrave\PostExtender\DataTypes\Image',     157],
      ['multiline',     'GoBrave\PostExtender\DataTypes\Multiline', 'some long text'],
      ['related_type',  'GoBrave\PostExtender\DataTypes\Related',   157]
    ];
  }




  public function testCreateForCheckbox() {
    $obj = $this->f->create('checkbox', '1');
    $this->assertTrue($obj);
    $obj = $this->f->create('checkbox', '0');
    $this->assertFalse($obj);
  }

  public function testCreateForCheckboxList() {
    $obj = $this->f->create('checkbox_list', 'a:1:{i:0;s:8:"Option 1";}');
    $this->assertTrue($obj[0] === 'Option 1');
  }

  public function testCreateForDropdown() {
    $obj = $this->f->create('dropdown', 'a:1:{i:0;s:8:"Option 1";}');
    $this->assertTrue($obj === 'Option 1');
  }

  public function testCreateForTextbox() {
    $obj = $this->f->create('textbox', 'lorem ipsum');
    $this->assertTrue($obj === 'lorem ipsum');
  }






  public function testCreateWithForcedType() {
    $obj = $this->f->create('textbox', 16, ['force_type' => 'related_type']);
    $this->assertTrue($obj instanceof GoBrave\PostExtender\DataTypes\Related);
  }

  public function testCreateWithNonExistingForcedType() {
    $data = 'something textie';
    $obj  = $this->f->create('textbox', $data, ['force_type' => 'a-type-that-does-not-exist']);
    $this->assertTrue($obj === $data);
  }

}
