<?php

namespace GoBrave\PostExtender;

class Collection implements \ArrayAccess, \IteratorAggregate
{
  private $items;
  private $key;
  public function __construct(array $items = [], $key = 'ID') {
    $this->items = $items;
    $this->key   = $key;
  }

  //
  //  ArrayAccess
  //
  public function offsetGet($offset) {
    if(!$this->offsetExists($offset)) {
      throw new \OutOfRangeException("Undefined offset '" . $offset . "'");
    }
    return $this->get($offset);
  }

  public function offsetSet($offset, $item) {
    return $this->set($offset, $item);
  }

  public function offsetUnset($offset) {
    if($this->offsetExists($offset)) {
      $pos = $this->posFor($offset, $this->key);
      unset($this->items[$pos]);
    }
  }

  public function offsetExists($offset) {
    return $this->posFor($offset, $this->key) !== false;
  }

  //
  //  IteratorAggregate
  //
  public function getIterator() {
    return new \ArrayIterator($this->toArray());
  }

  //
  //  Regular API
  //
  public function get($item_identifier) {
    return $this->items[$this->posFor($item_identifier, $this->key)];
  }

  public function set($item_identifier, $item) {
    $pos = $this->posFor($item_identifier, $this->key);
    if($pos !== false) {
      $this->items[$pos] = $item;
    } else {
      $this->items[] = $item;
    }
  }

  public function toArray() {
    return $this->items;
  }

  public function length() {
    return count($this->items);
  }




  //
  //  Helpers
  //
  private function posFor($item_identifier, $key) {
    foreach($this->items as $pos => $item) {
      if($item->{$key} == $item_identifier) {
        return $pos;
        break;
      }
    }
    return false;
  }
}
