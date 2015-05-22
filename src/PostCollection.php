<?php

namespace LittleThings;

use IteratorAggregate;
use JsonSerializable;

class PostCollection implements IteratorAggregate, JsonSerializable
{
    /**
     * Collection of LittleThing\Post objects
     *
     * @var array
     **/
    protected $posts = [];

    /**
     * Constructor
     *
     * @param array $posts
     * @return void
     **/
    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get number of posts for current collection
     *
     * @return integer
     **/
    public function count()
    {
        return count($this->posts);
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return $this->posts;
    }

    /**
     * @return \ArrayIterator
     */
    function getIterator()
    {
        return new \ArrayIterator($this->posts);

    }
}