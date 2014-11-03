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
    return $this->sql($ids);
  }

  private function sql($ids) {
    global $wpdb, $table_prefix;

    if(!$ids) {
      return [];
    }

    $sql = "
      SELECT
        " . $wpdb->prefix . "posts.ID,
        " . $wpdb->prefix . "postmeta.meta_key,
        " . $wpdb->prefix . "postmeta.meta_value,
        " . $wpdb->prefix . "mf_post_meta.group_count,
        " . $table_prefix . "mf_custom_fields.duplicated as field_duplicated,
        " . $table_prefix . "mf_custom_fields.type as field_type,
        " . $table_prefix . "mf_custom_groups.name as group_name,
        " . $table_prefix . "mf_custom_groups.duplicated as group_duplicated
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
          " . $table_prefix . "mf_custom_fields
          ON
            " . $wpdb->prefix . "postmeta.meta_key = " . $table_prefix . "mf_custom_fields.name
        LEFT JOIN
          " . $table_prefix . "mf_custom_groups
          ON
            " . $table_prefix . "mf_custom_fields.custom_group_id = " . $table_prefix . "mf_custom_groups.id
      WHERE
        " . $wpdb->prefix . "posts.post_status = 'publish'
        AND
        " . $wpdb->prefix . "posts.ID IN (" . implode(', ', $ids) . ")
        AND
        " . $table_prefix . "mf_custom_groups.post_type = " . $wpdb->prefix . "posts.post_type
        AND
        " . $table_prefix . "mf_custom_fields.post_type = " . $wpdb->prefix . "posts.post_type
        AND
        " . $table_prefix . "mf_custom_groups.name != 'NULL'
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
