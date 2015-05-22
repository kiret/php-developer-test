<?php

namespace LittleThings;

class JsonPostRepository implements PostRepository, JsonRepository
{
    /**
     * Path to the json file
     *
     * @var string
     */
    private $jsonPath;

    /**
     * Json string read from file
     *
     * @var string
     */
    private $json;

    /**
     * Array of \LittleThings\Post Objects
     *
     * @var array
     */
    public $aPosts = [];

    /**
     * Constructor
     *
     * @param string $jsonPath
     */
    function __construct($jsonPath)
    {
        $this->jsonPath = $jsonPath;

        $this->json = $this->readJson();

        $aJson = json_decode($this->json, TRUE);

        if(json_last_error() !== JSON_ERROR_NONE)
            throwException ("Json format is not valid!");

        $this->aPosts = $this->hydrate($aJson);
    }

    /**
     * Creates array of posts from associative array
     *
     * @param array $posts
     * @return array
     **/
    protected function hydrate(array $posts)
    {
        return array_map(function ($post) {
            return new Post(
                $post['id'],
                $post['date'],
                $post['authorId'],
                $post['title'],
                $post['slug']
            );
        }, $posts);
    }

    /**
     * Return array of \LittleThings\Post Objects
     *
     * @return \LittleThings\PostCollection
     */
    public function all()
    {
        $collection = new PostCollection($this->aPosts);

        return $collection;
    }

    /**
     * Add \LittleThings\Post Object to the collection
     *
     * @param \LittleThings\Post $post
     */
    public function add(Post $post)
    {
        $this->aPosts[] = $post;
    }

    /**
     * Find \LittleThings\Post Object by id
     *
     * @param integer $id
     * @return \LittleThings\Post
     */
    public function findById($id)
    {
        foreach($this->aPosts as $oPost)
        {
            if($oPost->id == $id)
                return $oPost;
        }
    }

    /**
     * Read json file content
     *
     * @return string
     */
    public function readJson()
    {
        if(!file_exists($this->jsonPath))
            throwException ("File does not exist!");

        $content = file_get_contents($this->jsonPath);

        return $content;
    }

    /**
     * Write data into json file
     *
     * @param array $data
     */
    public function writeJson(array $data)
    {

    }
}