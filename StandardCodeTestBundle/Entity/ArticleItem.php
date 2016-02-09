<?php

namespace VG\StandardCodeTestBundle\Entity;

class ArticleItem
{
    public $title;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}