<?php

namespace GoBrave\PostExtender;

use \GoBrave\Util\WP;

class DataTypeFactory
{
  const FORCE_TYPE = 'force_type';

  private $config;

  public function __construct(Config $config) {
    $this->config = $config;
  }

  public function create($type, $value, $options = []) {

    $type = $this->forceType($type, $options);

    //
    //  Object types
    //
    if($type === MF_FIELD_TYPE::IMAGE_MEDIA)
      return $value ? new DataTypes\Image($value, new WP()) : null;
    if($type === MF_FIELD_TYPE::FILE)
      return $value ? new DataTypes\File($value, new WP(), MF_FILES_URL, MF_FILES_DIR) : null;
    if($type === MF_FIELD_TYPE::RELATED_TYPE)
      return $value ? new DataTypes\Related($value, new WP(), $this->config->getNamespace()) : null;
    if($type === MF_FIELD_TYPE::MULTILINE)
      return $value ? new DataTypes\Multiline($value, new WP()) : null;


    //
    //  Primitive types
    //
    if($type === MF_FIELD_TYPE::CHECKBOX)
      return (bool)$value;
    if($type === MF_FIELD_TYPE::CHECKBOX_LIST)
      return unserialize($value);
    if($type === MF_FIELD_TYPE::DROPDOWN) {
      $temp = unserialize($value);
      return array_pop($temp);
    }

    return $value;
  }


  private function forceType($original_type, $options) {
    if(!isset($options[self::FORCE_TYPE])) {
      return $original_type;
    }

    if(!in_array($options[self::FORCE_TYPE], MF_FIELD_TYPE::AS_ARRAY())) {
      return $original_type;
    }

    return $options[self::FORCE_TYPE];
  }
}
