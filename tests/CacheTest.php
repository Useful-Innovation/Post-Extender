<?php

class CacheTest extends PHPUnit_Framework_TestCase
{
  public function testCacheForSingleFind() {
    $before = WPDB::$counter;
    Page::find(2);
    $middle1 = WPDB::$counter;

    $this->assertSame($middle1 - $before, 2);

    Page::find(7);
    $middle2 = WPDB::$counter;

    $this->assertSame($middle2 - $middle1, 2);

    Page::find(7);
    $end = WPDB::$counter;

    $this->assertSame($end - $middle2, 0, 'Testing cache');
  }
}
