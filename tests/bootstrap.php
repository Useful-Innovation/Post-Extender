<?php

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
      $data = unserialize('a:8:{i:0;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:10:"info_image";s:10:"meta_value";s:1:"4";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:11:"image_media";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:1;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:10:"info_title";s:10:"meta_value";s:3:"asd";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"1";s:10:"field_type";s:7:"textbox";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:2;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:10:"info_title";s:10:"meta_value";s:3:"qwe";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"1";s:10:"field_type";s:7:"textbox";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:3;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:9:"test_file";s:10:"meta_value";s:29:"1397294301Bonnr1190009484.pdf";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:4:"file";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:4;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:12:"test_checker";s:10:"meta_value";s:1:"1";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:8:"checkbox";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:5;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:11:"test_select";s:10:"meta_value";s:25:"a:1:{i:0;s:8:"Option 2";}";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:8:"dropdown";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:6;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:15:"test_checkboxes";s:10:"meta_value";s:25:"a:1:{i:0;s:8:"Option 1";}";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:13:"checkbox_list";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:7;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:12:"test_related";s:10:"meta_value";s:1:"2";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:12:"related_type";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}}');
    } else {
      $data = unserialize('a:17:{i:0;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:10:"info_image";s:10:"meta_value";s:1:"4";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:11:"image_media";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:1;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:10:"info_title";s:10:"meta_value";s:3:"asd";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"1";s:10:"field_type";s:7:"textbox";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:2;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:10:"info_title";s:10:"meta_value";s:3:"qwe";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"1";s:10:"field_type";s:7:"textbox";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:3;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:9:"test_file";s:10:"meta_value";s:29:"1397294301Bonnr1190009484.pdf";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:4:"file";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:4;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:12:"test_checker";s:10:"meta_value";s:1:"1";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:8:"checkbox";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:5;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:11:"test_select";s:10:"meta_value";s:25:"a:1:{i:0;s:8:"Option 2";}";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:8:"dropdown";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:6;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:15:"test_checkboxes";s:10:"meta_value";s:25:"a:1:{i:0;s:8:"Option 1";}";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:13:"checkbox_list";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:7;O:8:"stdClass":8:{s:2:"ID";s:1:"2";s:8:"meta_key";s:12:"test_related";s:10:"meta_value";s:1:"2";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:12:"related_type";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:8;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:10:"info_image";s:10:"meta_value";s:1:"4";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:11:"image_media";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:9;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:10:"info_title";s:10:"meta_value";s:9:"caption 1";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"1";s:10:"field_type";s:7:"textbox";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:10;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:10:"info_title";s:10:"meta_value";s:9:"caption 2";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"1";s:10:"field_type";s:7:"textbox";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:11;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:10:"info_title";s:10:"meta_value";s:9:"caption 3";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"1";s:10:"field_type";s:7:"textbox";s:10:"group_name";s:4:"info";s:16:"group_duplicated";s:1:"0";}i:12;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:9:"test_file";s:10:"meta_value";s:29:"1397294593Bonnr1190009484.pdf";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:4:"file";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:13;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:12:"test_checker";s:10:"meta_value";s:1:"1";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:8:"checkbox";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:14;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:11:"test_select";s:10:"meta_value";s:25:"a:1:{i:0;s:8:"Option 1";}";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:8:"dropdown";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:15;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:15:"test_checkboxes";s:10:"meta_value";s:25:"a:1:{i:0;s:8:"Option 2";}";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:13:"checkbox_list";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}i:16;O:8:"stdClass":8:{s:2:"ID";s:1:"7";s:8:"meta_key";s:12:"test_related";s:10:"meta_value";s:1:"2";s:11:"group_count";s:1:"1";s:16:"field_duplicated";s:1:"0";s:10:"field_type";s:12:"related_type";s:10:"group_name";s:4:"test";s:16:"group_duplicated";s:1:"1";}}');
    }

    return $data;
  }
}

$wpdb = new WPDB();

$titles = [
  2 => 'Exempelsida',
  7 => 'Ytterligare sida'
];
function get_post($id) {
  global $titles;
  return new WP_Post(['ID' => $id, 'post_title' => $titles[$id]]);
}

function get_posts($options) {
  global $titles;
  return [
    new WP_Post(['ID' => 2, 'post_title' => $titles[2]]),
    new WP_Post(['ID' => 7, 'post_title' => $titles[7]])
  ];
}

class Page extends \GoBrave\PostExtender\PostExtender
{
  protected $something_else;

  public function something() {
    $this->something_else = 'Asd';
  }
}