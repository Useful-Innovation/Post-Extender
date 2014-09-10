<?php

namespace GoBrave\PostExtender;

abstract class PostExtender
{
  use \GoBrave\PostExtender\Helpers\Finders;

  private static $config;
  private static $structs;
  private $struct;
  private $wp;

  public $post;

  protected static $cache = [];

  private static $default_options = [
    'numberposts' => -1,
    'orderby'     => 'menu_order',
    'order'       => 'ASC',
    'meta_key'    => '',
    'meta_value'  => ''
  ];

  private function __construct(\WP_Post $post, \GoBrave\Util\IWP $wp) {
    $this->wp = $wp;
    $queryer  = new Queryer();
    $extender = new Extender(self::$config);
    if(!isset($post->_extended) OR $post->_extended == false) {
      $post = $extender->extendPost($post, $queryer->getMetaFor([$post]));
    }
    $this->post = $post;
    $this->struct = self::findOrCreateStruct($this->post->post_type);
  }

  public static function setConfig(\GoBrave\PostExtender\Config $config) {
    self::$config = $config;
  }

  public static function extend(\WP_Post $post) {
    return new static($post, new \GoBrave\Util\Wp());
  }

  public function __GET($key) {
    return $this->post->{$key};
  }

  public static function classToPostType() {
    return Helpers\CaseConverter::camelToSnake(get_called_class());
  }

  public function getStruct() {
    return $this->struct;
  }

  public function url() {
    return $this->wp->get_permalink($this->post->ID);
  }

  public function permalink() {
    return $this->url();
  }

  public static function loadAllPostTypes() {
    foreach(glob(self::$config->getStructDir() . '/*.json') as $struct_file) {
      $post_type = pathinfo($struct_file, PATHINFO_FILENAME);
      if(!isset(self::$structs[$post_type])) {
        self::$structs[$post_type] = new Struct($struct_file);
      }
    }
    return self::$structs;
  }

  public static function findOrCreateStruct($post_type) {
    if(isset(self::$structs[$post_type])) {
      return self::$structs[$post_type];
    }
    return self::$structs[$post_type] = new Struct(self::$config->getStructDir() . '/' . $post_type . '.json');
  }
}
