<?php

namespace GoBrave\PostExtender;

class Extender
{
  public function __construct() {

  }

  public function extendPost(\WP_Post $post, $data) {
    return $this->extendPosts([$post], $data)[$post->ID];
  }


  public function extendPosts(array $posts, $data) {
    $posts = new Collection($posts);
    foreach($data as $row) {
      if(isset($posts[$row->ID]) AND (!isset($posts[$row->ID]->_extended) OR $posts[$row->ID]->_extended !== true)) {
        $posts[$row->ID] = $this->loopHelper($posts[$row->ID], $row);
      }
    }

    foreach($posts as $post) {
      $posts[$post->ID]->_extended = true;
    }

    return $posts;
  }

  private function loopHelper(\WP_Post $post, $row) {
    $row->meta_value = $this->fieldByType($row->meta_value, $row->field_type);

    if($row->group_duplicated) {
      $post = $this->setDuplicatedGroup($post, $row);
    } else if($row->field_duplicated) {
      $post = $this->setDuplicatedField($post, $row);
    } else {
      $post->{$row->meta_key} = $row->meta_value;
    }
    return $post;
  }

  private function setDuplicatedGroup(\WP_Post $post, $row) {
    $group_count = $row->group_count - 1;
    $post = $this->setDefaultGroups($post, $row, $group_count);
    $field_name = $this->filterGroupNameFromFieldName($row->meta_key, $row->group_name);

    if($row->field_duplicated) {
      $post = $this->setDuplicatedGroupAndField($post, $row, $group_count, $field_name);
    } else {
      $post->{$row->group_name}[$group_count][$field_name] = $row->meta_value;
    }
    return $post;
  }

  private function setDuplicatedGroupAndField(\WP_Post $post, $row, $group_count, $field_name) {
    if(!isset($post->{$row->group_name}[$group_count][$field_name])) {
      $post->{$row->group_name}[$group_count][$field_name] = [];
    }
    $post->{$row->group_name}[$group_count][$field_name][] = $row->meta_value;
    return $post;
  }

  private function setDuplicatedField(\WP_Post $post, $row) {
    if(!isset($post->{$row->meta_key})) {
      $post->{$row->meta_key} = [];
    }
    $post->{$row->meta_key}[] = $row->meta_value;
    return $post;
  }

  private function fieldByType($value, $type) {
    if($type === MF_FIELD_TYPE::IMAGE_MEDIA) {
      return new DataTypes\Image($value);
    }

    return $value;
  }

  private function setDefaultGroups(\WP_Post $post, $row, $group_count) {
    if(!isset($post->{$row->group_name})) {
      $post->{$row->group_name} = [];
    }
    if(!isset($post->{$row->group_name}[$group_count])) {
      $post->{$row->group_name}[$group_count] = [];
    }
    return $post;
  }

  private function filterGroupNameFromFieldName($field_name, $group_name) {
    return substr($field_name, strlen($group_name) + 1);
  }
}
