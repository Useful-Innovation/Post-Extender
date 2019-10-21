<?php namespace GoBrave\PostExtender\DataTypes;

use GoBrave\PostExtender\DataTypeInterface;

class Image implements DataTypeInterface
{
    private $id;
    private $wp;

    public function __construct($id, \GoBrave\Util\IWP $wp)
    {
        $this->id = $id;
        $this->wp = $wp;
    }

    public function raw()
    {
        return $this->id;
    }

    public function __toString()
    {
        return strval($this->id);
    }

    public function url($size = 'thumbnail')
    {
        $image = $this->wp->wp_get_attachment_image_src($this->id, $size);
        if (!$image) {
            return false;
        }

        return $image[0];
    }

    public function alt()
    {
        $meta = get_post_meta($this->id, '_wp_attachment_image_alt', true);
        if (!$meta) {
            return false;
        }
        return $meta;
    }
}
