<?php

namespace GoBrave\PostExtender;

abstract class PostExtender
{
  use \GoBrave\PostExtender\Helpers\Finders;

  private $struct;

  public $post;
  public static $struct_dir = false;

  protected static $cache = [];

  private static $default_options = [
    'numberposts' => -1,
    'orderby'     => 'menu_order',
    'order'       => 'ASC',
    'meta_key'    => '',
    'meta_value'  => ''
  ];

  private function __construct(\WP_Post $post) {
    $queryer  = new Queryer();
    $extender = new Extender();
    if(!isset($post->_extended) OR $post->_extended == false) {
      $post = $extender->extendPost($post, $queryer->getMetaFor([$post]));
    }
    $this->post = $post;
    if(self::$struct_dir) {
      $this->struct = new Struct(self::$struct_dir . '/' . $this->post->post_type . '.json');
    }
  }

  public static function extend(\WP_Post $post) {
    return new static($post);
  }

  public function __GET($key) {
    if(isset($this->{$key})) {
      return $this->{$key};
    } else {
      return $this->post->{$key};
    }
  }

  public static function classToPostType() {
    return Helpers\CaseConverter::camelToSnake(get_called_class());
  }

  public function getStruct() {
    return $this->struct;
  }
}
