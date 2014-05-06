<?php

namespace GoBrave\PostExtender;

abstract class PostExtender
{
  public $post;
  public static $cache = [];

  private static $default_options = [
    'numberposts' => -1,
    'orderby'     => 'menu_order',
    'order'       => 'ASC',
    'meta_key'    => '',
    'meta_value'  => ''
  ];

  public function __construct(\WP_Post $post) {
    $queryer  = new Queryer();
    $extender = new Extender();
    if(!isset($post->_extended) OR $post->_extended == false) {
      $post = $extender->extendPost($post, $queryer->getMetaFor([$post]));
    }
    $this->post = $post;
  }

  public static function find($id) {
    if(!isset(self::$cache[$id])) {
      $post = \get_post($id);
      self::$cache[$id] = new static($post);
    }
    return self::$cache[$id];
  }

  public static function all(array $options = []) {
    $queryer  = new Queryer();
    $extender = new Extender();

    $options['post_type'] = static::classToPostType();
    $cache_key = serialize($options);
    if(!isset(self::$cache[$cache_key])) {
      $posts = get_posts(array_merge(self::$default_options, $options));
      $posts = $extender->extendPosts($posts, $queryer->getMetaFor($posts));
      foreach($posts->toArray() as $key => $post) {
        $post = new static($post);
        $posts[$post->ID] = $post;
      }
      self::$cache[$cache_key] = $posts;
    }
    return self::$cache[$cache_key];
  }

  public static function get() {
    $posts = self::all();
    $posts = $posts->toArray();
    return array_shift($posts);
  }

  public function __GET($key) {
    if(isset($this->{$key})) {
      return $this->{$key};
    } else {
      return $this->post->{$key};
    }
  }

  private static function classToPostType() {
    $case_converter = new Helpers\CaseConverter();
    return $case_converter->camelToSnake(get_called_class());
  }
}
