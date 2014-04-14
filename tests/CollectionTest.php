<?php

use GoBrave\PostExtender\Collection;

class CollectionTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->data = [
      (object)['ID' => 4, 'post_title' => 'This is a title'],
      (object)['ID' => 8, 'post_title' => 'Lorem ipsum'],
      (object)['ID' => 2, 'post_title' => 'This is a key']
    ];
    $this->c = new Collection($this->data, 'ID');
  }

  public function testConstruct() {
    $collection = new Collection();
  }

  public function testLength() {
    $this->assertSame($this->c->length(), 3);
    $collection = new Collection();
    $this->assertSame($collection->length(), 0);
  }

  public function testGet() {
    $this->assertSame($this->c[4]->post_title, $this->data[0]->post_title);
  }

  public function testIsset() {
    $this->assertTrue(isset($this->c[4]), 'Cannot find item with id 4');
    $this->assertFalse(isset($this->c[1502]), 'Cannot find item with id 1502');
  }

  public function testUnset() {
    unset($this->c[2]);
    $this->assertFalse(isset($this->c[2]), 'Cannot find item with id 2');
    $this->assertSame($this->c->length(), 2);
  }

  public function testSetAsNew() {
    $title = 'Dolor sit amet';
    $this->c[10] = (object)['ID' => 10, 'post_title' => $title];
    $this->assertTrue(isset($this->c[10]));
    $this->assertSame($this->c->length(), 4, 'Array didnt get longer');
  }

  public function testSetAsUpdate() {
    $title = 'Dolor sit amet';
    $this->c[4] = (object)['ID' => 4, 'post_title' => $title];
    $this->assertTrue(isset($this->c[4]));
    $this->assertSame($this->c->length(), 3, 'Array got longer...');
  }

  public function testIteratorAggregate() {
    $this->assertTrue($this->c instanceof \IteratorAggregate);
    foreach($this->c as $key => $item) {
      $this->assertTrue(is_int($key));
      $this->assertTrue($item instanceof stdClass);
    }
  }

  /**
   * @expectedException OutOfRangeException
   */
  public function testGetANonExistingItem() {
    $this->c[159];
  }
}
