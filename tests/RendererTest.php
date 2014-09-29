<?php

class RendererTest extends PHPUnit_Framework_TestCase
{
  public function testExistanceOfRenderer() {
    $post = Page::find(2);
    $this->assertTrue($post->renderer instanceof GoBrave\Util\Renderer);
  }
}
