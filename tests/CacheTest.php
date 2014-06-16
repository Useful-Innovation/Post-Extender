<?php

class CacheTest extends PHPUnit_Framework_TestCase
{
  public function testCacheForFind() {
    $before = WPDB::$counter;
    Page::find(2);
    $middle1 = WPDB::$counter;
    $this->assertSame($middle1 - $before, 2);
    Page::find(7);
    $middle2 = WPDB::$counter;
    $this->assertSame($middle2 - $middle1, 2);
    Page::find(7);
    $end = WPDB::$counter;
    $this->assertSame($end - $middle2, 0, 'Testing cache for Page::find');
  }

  public function testCacheForAll() {
    $start = WPDB::$counter;
    Page::all();
    $step1 = WPDB::$counter;
    $this->assertSame($step1 - $start, 2);
    Page::all();
    $step2 = WPDB::$counter;
    $this->assertSame($step2 - $step1, 0, 'Testing cache for Page::all');
  }
}
