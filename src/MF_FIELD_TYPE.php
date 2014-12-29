<?php

namespace GoBrave\PostExtender;

class MF_FIELD_TYPE
{
  const IMAGE_MEDIA      = 'image_media';
  const CHECKBOX_LIST    = 'checkbox_list';
  const CHECKBOX         = 'checkbox';
  const TEXTBOX          = 'textbox';
  const MULTILINE        = 'multiline';
  const MARKDOWN         = 'markdown_editor';
  const RELATED_TYPE     = 'related_type';
  const FILE             = 'file';
  const DROPDOWN         = 'dropdown';
  const RADIOBUTTON_LIST = 'radiobutton_list';

  private static $array  = [
    self::IMAGE_MEDIA      => self::IMAGE_MEDIA,
    self::CHECKBOX_LIST    => self::CHECKBOX_LIST,
    self::CHECKBOX         => self::CHECKBOX,
    self::TEXTBOX          => self::TEXTBOX,
    self::MULTILINE        => self::MULTILINE,
    self::MARKDOWN         => self::MARKDOWN,
    self::RELATED_TYPE     => self::RELATED_TYPE,
    self::FILE             => self::FILE,
    self::DROPDOWN         => self::DROPDOWN,
    self::RADIOBUTTON_LIST => self::RADIOBUTTON_LIST
  ];

  public static function AS_ARRAY() {
    return self::$array;
  }
}
