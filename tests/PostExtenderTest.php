<?php

use \GoBrave\PostExtender\PostExtender;
use \GoBrave\PostExtender\Collection;
use \GoBrave\PostExtender\DataTypes\Image;

class PostExtenderTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->post = new WP_Post(['ID' => 2, 'post_title' => 'Lorem ipsum']);
  }

  public function testConstruct() {
    $extended_post = new Page($this->post);
  }

  public function testFind() {
    $extended_post = Page::find(2);

    $this->assertTrue($extended_post instanceof PostExtender);
    $this->assertSame($extended_post->post_title, 'Exempelsida');
    $this->assertTrue($extended_post->info_image instanceof Image);
    $this->assertSame((string)$extended_post->info_image, '4');
  }

  public function testAll() {
    $extended_posts = Page::all();
    $this->assertTrue($extended_posts instanceof Collection, 'Checking collection');
    $this->assertTrue($extended_posts[2] instanceof PostExtender, 'Checking class');
    $this->assertSame($extended_posts[2]->post_title, 'Exempelsida', 'Checking value');
    $this->assertTrue($extended_posts[7] instanceof PostExtender, 'Checking class');
    $this->assertSame($extended_posts[7]->post_title, 'Ytterligare sida', 'Checking value');
  }

  public function testUnique() {
    $startpage = Startpage::get();
    $this->assertTrue($startpage instanceof Startpage, 'Checking class');
    $this->assertTrue($startpage instanceof PostExtender, 'Checking Inheritance');
  }

  public function testClassSpecificAttribute() {
    $page = Page::find(2);
    $page->something();
    $this->assertTrue($page instanceof PostExtender, 'Checking class');
    $this->assertSame($page->something_else, 'Asd', 'Checking value');
  }

  public function testFindAllByIds() {
    $pages = Page::findAllByIds([2, 7]);
    $this->assertTrue($pages[2] instanceof PostExtender, 'Checking object');
    $this->assertTrue($pages[7] instanceof PostExtender, 'Checking object');

    $pages = Page::findAllByIds([2]);
    $this->assertTrue($pages[2] instanceof PostExtender, 'Checking object');
    $this->assertFalse(isset($pages[7]), '7 shall be missing');
  }

  public function testFindAllByIdsKeepOrder() {
    $pages = Page::findAllByIds([2, 7]);
    $pages = $pages->toArray();
    $this->assertSame($pages[0]->ID, 2);
    $this->assertSame($pages[1]->ID, 7);

    $pages = Page::findAllByIds([7, 2]);
    $pages = $pages->toArray();
    $this->assertSame($pages[0]->ID, 7);
    $this->assertSame($pages[1]->ID, 2);
  }
}
