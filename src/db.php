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
        $this->collection = (new \MongoDB\Client)->{$db->name}->{$db->collection};
    }

    /**
     * Insert items to DB
     * 
     * @param array $items
     * @return array
     */
    public function save($items) {
        return $this->collection->insertMany($items);
    }

}
