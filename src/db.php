<?php

namespace Src;

/**
 * Mongodb class
 */
class Db {
    
    /**
     * MongoDB collection
     * 
     * @var object
     */
    private $collection;

    /**
     * 
     */
    public function __construct($db) {
        $this->collection = (new MongoDB\Client)->{$db['name']}->{$db['collection']};
    }

    /**
     * Save data to DB
     * 
     * @param string $key
     * @param string $value
     */
    public function save($key, $value) {
        return $this->collection->insertOne([
            'key' => $key,
            'text' => $value,
        ]);
    }

}
