<?php

use \GoBrave\PostExtender\Extender;
use \GoBrave\PostExtender\Collection;
use \GoBrave\PostExtender\DataTypes\Image;

class ExtenderTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->data = $this->getData();
    $this->duplicatedGroupsData = $this->getDuplicatedGroupData();
    $this->post = new WP_Post(['ID' => 4, 'post_title' => 'Lorem ipsum']);
    $this->posts = [
      new WP_Post(['ID' => 4, 'post_title' => 'Lorem ipsum']),
      new WP_Post(['ID' => 6, 'post_title' => 'Dolor sit amet'])
    ];
    $this->e = new Extender();
  }

  public function testExtendsWithBasicFields() {
    $posts = $this->e->extendPosts($this->posts, $this->data);

    $this->assertTrue($posts instanceof Collection);
    $this->assertSame($posts[4]->info_title, $this->data[0]->meta_value);
    $this->assertSame($posts[4]->info_heading, $this->data[1]->meta_value);
  }

  public function testDataTypes() {
    $posts = $this->e->extendPosts($this->posts, $this->data);
    $p = $posts[4];

    $this->assertTrue($p->info_image instanceof Image, 'Is image?');

    $page = Page::find(7);
    $group = $page->test[0];
    $this->assertTrue(is_bool($group['checker']));
    $this->assertTrue(is_int($group['related']));
    $this->assertSame($group['select'], 'Option 1');
    $this->assertSame($group['checkboxes'][0], 'Option 2');
  }

  public function testExtendWithDuplicatedFieldInRegularGroup() {
    $posts = $this->e->extendPosts($this->posts, $this->data);
    $this->assertTrue($posts instanceof Collection);
    $rels = $posts[4]->info_rel_posts;

    $this->assertTrue(is_array($rels), 'Checking for array');
    $this->assertTrue(count($rels) === 2, 'Checking array for length');
    $this->assertTrue($rels[0] === $this->data[3]->meta_value, 'Checking array for first value');
    $this->assertTrue($rels[1] === $this->data[4]->meta_value, 'Checking array for second value');
  }

  public function testExtendWithDuplicatedGroup() {
    $posts = $this->e->extendPosts($this->posts, $this->duplicatedGroupsData);
    $this->assertTrue($posts instanceof Collection);
    $images = $posts[4]->images;

    $this->assertTrue(is_array($images), 'Checking for array');
    $this->assertTrue(count($images) === 2, 'Checking array for length');
    $this->assertSame($images[0]['image'], $this->duplicatedGroupsData[3]->meta_value);
    $this->assertSame($images[1]['image'], $this->duplicatedGroupsData[0]->meta_value);
  }

  public function testExtendWithDuplicatedGroupAndField() {
    $posts = $this->e->extendPosts($this->posts, $this->duplicatedGroupsData);
    $this->assertTrue($posts instanceof Collection);
    $images = $posts[4]->images;

    $this->assertTrue(is_array($images), 'Checking for array');
    $this->assertTrue(count($images) === 2, 'Checking array for length');

    $this->assertTrue(is_array($images[1]['caption']), 'Checking sub-array');
    $this->assertTrue(count($images[1]['caption']) === 2, 'Checking sub-array length');

    $this->assertSame($images[1]['caption'][0], $this->duplicatedGroupsData[1]->meta_value);
    $this->assertSame($images[1]['caption'][1], $this->duplicatedGroupsData[2]->meta_value);
  }

  public function testExtendWithBasicField() {
    $post = $this->e->extendPost($this->post, $this->data);
    $this->assertTrue($post instanceof WP_Post);
    $this->assertSame($post->_extended, true);
    $this->assertSame($post->info_title, $this->data[0]->meta_value);
  }

  /**
   * @expectedException Exception
   */
  public function testRegularAttributeThatIsProtected() {
    $page = Page::single();
    $page->something();
    $this->assertSame($page->something_else, 'Asd');
  }

  public function testRegularAttribute() {
    $page = Page::single();
    $this->assertSame($page->a_public_attribute, 'public');
  }










  private function getData() {
    $data = [];
    $obj = new stdClass();
    $obj->ID               = 4;
    $obj->meta_key         = 'info_title';
    $obj->meta_value       = 'Något till';
    $obj->group_count      = 1;
    $obj->field_duplicated = 0;
    $obj->field_type       = 'textbox';
    $obj->group_name       = 'info';
    $obj->group_duplicated = 0;

    $data[] = $obj;

    $obj = new stdClass();
    $obj->ID               = 4;
    $obj->meta_key         = 'info_heading';
    $obj->meta_value       = 'This is the story of my life';
    $obj->group_count      = 1;
    $obj->field_duplicated = 0;
    $obj->field_type       = 'textbox';
    $obj->group_name       = 'info';
    $obj->group_duplicated = 0;

    $data[] = $obj;

    $obj = new stdClass();
    $obj->ID               = 4;
    $obj->meta_key         = 'info_image';
    $obj->meta_value       = '512';
    $obj->group_count      = 1;
    $obj->field_duplicated = 0;
    $obj->field_type       = 'image_media';
    $obj->group_name       = 'info';
    $obj->group_duplicated = 0;

    $data[] = $obj;

    // duplicated field
    $obj = new stdClass();
    $obj->ID               = 4;
    $obj->meta_key         = 'info_rel_posts';
    $obj->meta_value       = '100';
    $obj->group_count      = 1;
    $obj->field_duplicated = 1;
    $obj->field_type       = 'textbox';
    $obj->group_name       = 'info';
    $obj->group_duplicated = 0;

    $data[] = $obj;

    $obj = new stdClass();
    $obj->ID               = 4;
    $obj->meta_key         = 'info_rel_posts';
    $obj->meta_value       = '200';
    $obj->group_count      = 1;
    $obj->field_duplicated = 1;
    $obj->field_type       = 'textbox';
    $obj->group_name       = 'info';
    $obj->group_duplicated = 0;

    $data[] = $obj;

    return $data;
  }

  private function getDuplicatedGroupData() {

    $obj = new stdClass();
    $obj->ID               = 4;
    $obj->meta_key         = 'images_image';
    $obj->meta_value       = '200';
    $obj->group_count      = 2;
    $obj->field_duplicated = 0;
    $obj->field_type       = 'image_media';
    $obj->group_name       = 'images';
    $obj->group_duplicated = 1;

    $data[] = $obj;

      $obj = new stdClass();
      $obj->ID               = 4;
      $obj->meta_key         = 'images_caption';
      $obj->meta_value       = 'text 1';
      $obj->group_count      = 2;
      $obj->field_duplicated = 1;
      $obj->field_type       = 'textbox';
      $obj->group_name       = 'images';
      $obj->group_duplicated = 1;

      $data[] = $obj;

      $obj = new stdClass();
      $obj->ID               = 4;
      $obj->meta_key         = 'images_caption';
      $obj->meta_value       = 'text 2';
      $obj->group_count      = 2;
      $obj->field_duplicated = 1;
      $obj->field_type       = 'textbox';
      $obj->group_name       = 'images';
      $obj->group_duplicated = 1;

      $data[] = $obj;

    $obj = new stdClass();
    $obj->ID               = 4;
    $obj->meta_key         = 'images_image';
    $obj->meta_value       = '100';
    $obj->group_count      = 1;
    $obj->field_duplicated = 0;
    $obj->field_type       = 'image_media';
    $obj->group_name       = 'images';
    $obj->group_duplicated = 1;

    $data[] = $obj;

    return $data;
  }
}
