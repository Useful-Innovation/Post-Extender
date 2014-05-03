<?php

namespace GoBrave\PostExtender\Helpers;

class CaseConverter
{

  //
  //  Gives
  //    camel_case -> camelCase
  //    camel_case -> CamelCase (with second param as true)
  //
  public function snakeToCamel($string, $upper_case_first_letter = false) {
    $string = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    $string = strtolower(substr($string,0,1)) . substr($string,1);
    if($upper_case_first_letter) {
      $string = ucfirst($string);
    }
    return $string;
  }

  //
  //  Gives
  //    camelCase -> camel_case
  //    CamelCase -> camel_case
  //
  public function camelToSnake($string) {
    $string = strtolower(substr($string, 0, 1)) . substr($string, 1);
    return preg_replace_callback(
      '/[A-Z]/',
      create_function('$match', 'return "_" . strtolower($match[0]);'),
      $string
    );
  }
}