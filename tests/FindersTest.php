<?php

class FindersTest extends PHPUnit_Framework_TestCase
{
  public function testAll() {
    $collection = Page::all();
    $this->assertTrue($collection->length() > 0);
  }

  public function testGet() {
    $page = Page::get();
    $this->assertTrue($page instanceof \GoBrave\PostExtender\PostExtender);
  }

  public function testByIds() {
    $collection = Page::findAllByIds([2, 7]);
    $this->assertTrue($collection->length() === 2);
  }
}
