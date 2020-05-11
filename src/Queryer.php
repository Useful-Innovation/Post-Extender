<?php

namespace GoBrave\PostExtender;

class Queryer
{

  public function __construct() {

  }

  public function getMetaFor(array $posts) {
    $ids = [];
    foreach($posts as $post) {
      $ids[] = $post->ID;
    }
    return array_map(function($item) {
      $item->options = unserialize($item->options);
      return $item;
    }, $this->sql($ids));
  }

  private function sql($ids) {
    global $wpdb;

    if(!$ids) {
      return [];
    }

    $sql = "
      SELECT
        " . $wpdb->prefix . "posts.ID,
        " . $wpdb->prefix . "postmeta.meta_key,
        " . $wpdb->prefix . "postmeta.meta_value,
        " . $wpdb->prefix . "mf_post_meta.group_count,
        " . $wpdb->base_prefix . "mf_custom_fields.duplicated as field_duplicated,
        " . $wpdb->base_prefix . "mf_custom_fields.type as field_type,
        " . $wpdb->base_prefix . "mf_custom_fields.options as options,
        " . $wpdb->base_prefix . "mf_custom_groups.name as group_name,
        " . $wpdb->base_prefix . "mf_custom_groups.duplicated as group_duplicated
      FROM
        " . $wpdb->prefix . "posts
        LEFT JOIN
          " . $wpdb->prefix . "postmeta
          ON
            " . $wpdb->prefix . "posts.id = " . $wpdb->prefix . "postmeta.post_id
        LEFT JOIN
          " . $wpdb->prefix . "mf_post_meta
          ON
            " . $wpdb->prefix . "postmeta.meta_id = " . $wpdb->prefix . "mf_post_meta.meta_id
        LEFT JOIN
          " . $wpdb->base_prefix . "mf_custom_fields
          ON
            " . $wpdb->prefix . "postmeta.meta_key = " . $wpdb->base_prefix . "mf_custom_fields.name
        LEFT JOIN
          " . $wpdb->base_prefix . "mf_custom_groups
          ON
            " . $wpdb->base_prefix . "mf_custom_fields.custom_group_id = " . $wpdb->base_prefix . "mf_custom_groups.id
      WHERE
        " . $wpdb->prefix . "posts.ID IN (" . implode(', ', $ids) . ")
        AND
        " . $wpdb->base_prefix . "mf_custom_groups.post_type = " . $wpdb->prefix . "posts.post_type
        AND
        " . $wpdb->base_prefix . "mf_custom_fields.post_type = " . $wpdb->prefix . "posts.post_type
        AND
        " . $wpdb->base_prefix . "mf_custom_groups.name != 'NULL'
        AND
        " . $wpdb->prefix . "mf_post_meta.group_count != 'NULL'
      GROUP BY
        " . $wpdb->prefix . "mf_post_meta.meta_id
      ORDER BY
        " . $wpdb->prefix . "posts.ID, " . $wpdb->prefix . "postmeta.meta_id
    ";

    return $wpdb->get_results($sql);
  }
}
