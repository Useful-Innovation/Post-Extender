<?php

namespace GoBrave\PostExtender;

abstract class PostExtender
{
  public $post;
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
    $this->post = $extender->extendPost($post, $queryer->getMetaFor([$post]));
  }

  public static function find($id) {
    $post = \get_post($id);
    return new static($post);
  }

  public static function all(array $options = []) {
    $post_type = static::classToPostType();
    $options['post_type'] = $post_type;
    $posts = get_posts(array_merge(self::$default_options, $options));
    $queryer  = new Queryer();
    $extender = new Extender();
    $posts = $extender->extendPosts($posts, $queryer->getMetaFor($posts));
    foreach($posts as $post) {
      $post = new static($post);
      $posts[$post->ID] = $post;
    }
    return $posts;
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
