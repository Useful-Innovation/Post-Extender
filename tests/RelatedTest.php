<?php

use \GoBrave\PostExtender\DataTypes\Related;

class RelatedTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->related = new Related(2, new Wp(), '');
  }

  public function testConstruct() {
    $this->assertTrue($this->related instanceof Related);
  }

  public function testToString() {
    $this->assertSame((string)$this->related, '2');
  }

  public function testGet() {
    $post = $this->related->get();
    $this->assertTrue($post instanceof \GoBrave\PostExtender\PostExtender);
    $this->assertTrue($post->ID == 2);
  }

  public function testGetId() {
    $id = $this->related->id();
    $this->assertSame($id, 2);
  }

  public function testRelatedGetWhenClassIsInAnotherNamespace() {
    $related = new Related(2, new Wp(), 'Something');
    $p = $related->get();
    $this->assertTrue($p instanceof Something\Page, 'Checking that class is in correct namespace');
  }
}
