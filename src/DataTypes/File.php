<?php

namespace GoBrave\PostExtender\DataTypes;

class File
{
  const APPROPRIATE = 'APPROPRIATE';
  const B  = 1;
  const KB = 1024;
  const MB = 1048576; // 1024 * 1024
  const GB = 1073741824; // 1024 * 1024 * 1024

  private static $units = [
    self::B  => 'B',
    self::KB => 'KB',
    self::MB => 'MB',
    self::GB => 'GB'
  ];

  private $real_filename;
  private $basename;
  private $filename;
  private $extension;
  private $wp;
  private $base_url;
  private $base_path;

  public function __construct($filename, \GoBrave\PostExtender\IWP $wp, $base_url, $base_path) {
    $this->real_filename = $filename;
    $info = pathinfo(substr($this->real_filename, 10));
    $this->basename  = $info['basename'];
    $this->filename  = $info['filename'];
    $this->extension = $info['extension'];
    $this->wp = $wp;
    $this->base_url  = rtrim($base_url, '/');
    $this->base_path = rtrim($base_path, '/');
  }

  public function url() {
    return $this->base_url . '/' . $this->raw();
  }

  public function dir() {
    return $this->base_path;
  }

  public function basename() {
    return $this->basename;
  }

  public function filename() {
    return $this->filename;
  }

  public function extension() {
    return $this->extension;
  }

  public function raw() {
    return $this->real_filename;
  }

  public function __toString() {
    return (string)$this->filename;
  }

  public function size() {
    return filesize(implode('/', [$this->base_path, $this->real_filename]));
  }

  public function sizeFormatted($unit = self::APPROPRIATE, $precision = 0, $decimal_separator = ',', $thousands_separator = ' ') {
    $size = $this->size();
    if($unit === self::APPROPRIATE) {
      $unit = $this->findAppropriate($size);
    }
    $size = $size / $unit;
    $size = round($size, $precision);
    $size = number_format($size, $precision, $decimal_separator, $thousands_separator);
    $size = $size . ' ' . $this->unitToString($unit);
    return $size;
  }

  //
  //  Helpers
  //
  private function findAppropriate($size) {
    if($size > self::GB)
      return self::GB;
    if($size > self::MB)
      return self::MB;
    if($size > self::KB)
      return self::KB;
    return self::B;
  }

  private function unitToString($unit) {
    return self::$units[$unit];
  }

}
