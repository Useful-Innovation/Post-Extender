<?php

namespace GoBrave\PostExtender\Helpers;

use GoBrave\PostExtender\Queryer;
use GoBrave\PostExtender\Extender;
use GoBrave\Util\Collection;

trait Finders
{
  public static function find($id) {
    if(!isset(self::$cache[$id])) {
      $post = \get_post($id);
      self::$cache[$id] = static::extend($post);
    }
    return self::$cache[$id];
  }

  public static function all(array $options = []) {
    $queryer  = new Queryer();
    $extender = new Extender(self::$config);

    $options['post_type'] = static::classToPostType();
    $cache_key = serialize($options);
    if(!isset(self::$cache[$cache_key])) {
      $posts = get_posts(array_merge(self::$default_options, $options));
      $posts = $extender->extendPosts($posts, $queryer->getMetaFor($posts));
      foreach($posts->toArray() as $key => $post) {
        $post = static::extend($post);
        $posts[$post->ID] = $post;
      }
      self::$cache[$cache_key] = $posts;
    }
    return self::$cache[$cache_key];
  }

  public static function findAllByIds(array $ids) {
    $temp  = self::all();
    $posts = new Collection();

    foreach($ids as $id) {
      if(isset($temp[$id])) {
        $posts[$id] = $temp[$id];
      }
    }

    return $posts;
  }

  public static function single() {
    $posts = self::all();
    $posts = $posts->toArray();
    return array_shift($posts);
  }
}
