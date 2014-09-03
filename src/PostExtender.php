<?php

namespace GoBrave\PostExtender;

abstract class PostExtender
{
  use \GoBrave\PostExtender\Helpers\Finders;

  private static $config;
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

  private function __construct(\WP_Post $post, \GoBrave\PostExtender\IWp $wp) {
    $this->wp = $wp;
    $queryer  = new Queryer();
    $extender = new Extender(self::$config);
    if(!isset($post->_extended) OR $post->_extended == false) {
      $post = $extender->extendPost($post, $queryer->getMetaFor([$post]));
    }
    $this->post = $post;
    $this->struct = new Struct(self::$config->getStructDir() . '/' . $this->post->post_type . '.json');
  }

  public static function setConfig(\GoBrave\PostExtender\Config $config) {
    self::$config = $config;
  }

  public static function extend(\WP_Post $post) {
    return new static($post, new \GoBrave\PostExtender\Wp());
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
    if(!self::$all_structs) {
      $post_types = array();
      foreach(self::$config->getStructDir() . '/*.json') as $post_type) {
        $post_types[] = json_decode(file_get_contents($post_type));
      }
      self::$all_structs = $post_types;
    }
    return self::$all_structs;
  }
}
