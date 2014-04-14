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
    var_dump($extended_posts);
    $this->assertTrue($extended_posts instanceof Collection, 'Checking collection');
    $this->assertTrue($extended_posts[2] instanceof PostExtender, 'Checking class');
    $this->assertSame($extended_posts[2]->post_title, 'Exempelsida', 'Checking value');
  }
}
