<?php

define('MF_FILES_URL', 'http://files_mf');
define('MF_FILES_DIR', __DIR__ . '/data');

require_once(__DIR__ . '/bootstrap_namespace.php');
require_once(__DIR__ . '/bootstrap_data.php');

class WP_Post
{
  public function __construct($values) {
    foreach($values as $key => $value) {
      $this->{$key} = $value;
    }
  }
}

class WPDB
{
  public $prefix = 'wp_';
  public static $counter = 0;
  public function __construct() {
    register_shutdown_function(function() {
        echo 'SQL Queries: ' . self::$counter . PHP_EOL;
    });
  }

  public function get_results($sql) {
    self::$counter++;

    if(strpos($sql, 'IN (2)') !== false) {
      $data = unserialize(serialize(DATA::$POST_1));
    } else {
      $data = unserialize(serialize(DATA::$POSTS));
    }

    return $data;
  }
}

GoBrave\PostExtender\PostExtender::setConfig(new GoBrave\PostExtender\Config([
  'files_url'  => MF_FILES_URL,
  'files_dir'  => MF_FILES_DIR,
  'struct_dir' => __DIR__ . '/data',
  'namespace'  => ''
]));
$wpdb = new WPDB();

$titles = [
  2 => 'Exempelsida',
  7 => 'Ytterligare sida'
];
function get_post($id) {
  global $titles;
  WPDB::$counter++;
  return new WP_Post(['ID' => $id, 'post_type' => 'page', 'post_title' => $titles[$id]]);
}

function get_posts($options) {
  global $titles;
  WPDB::$counter++;
  return [
    new WP_Post(['ID' => 2, 'post_type' => 'page', 'post_title' => $titles[2]]),
    new WP_Post(['ID' => 7, 'post_type' => 'page', 'post_title' => $titles[7]])
  ];
}

function get_permalink($id) {
  return 'http://permalink_to_something';
}

class Page extends \GoBrave\PostExtender\PostExtender
{
  protected $something_else;
  public $a_public_attribute = 'public';

  public function something() {
    $this->something_else = 'Asd';
  }
}

class Startpage extends \GoBrave\PostExtender\PostExtender { }

class UIStartpage extends \GoBrave\PostExtender\PostExtender
{
  const POST_TYPE = 'startpage';
}

class Wp implements \GoBrave\Util\IWP
{
  public function __call($a, $b) {

  }

  public function wp_get_attachment_image_src($id, $size) {
    if($size == 'fail') {
      return false;
    }
    return [
      'http://ui-twelve.dev/wp-content/uploads/2014/08/Screen-Shot-2014-08-05-at-120808-150x150.png',
      150,
      150,
      true
    ];
  }

  public function apply_filters($filter, $value) {
    if($filter == 'the_content') {
      return '<p>' . $value . '</p>';
    }
  }

  public function get_post($id) {
    return get_post($id);
  } 
}
