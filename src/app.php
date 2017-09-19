<?php

namespace Src;

use Sunra\PhpSimple\HtmlDomParser;
use Src\Db;

/**
 * Main application class
 */
class App {
    
    /**
     * Application config
     * 
     * @var array
     */
    private $config;
    
    /**
     * 
     */
    public function __construct() {
        $this->config = json_decode(file_get_contents('./config.json'));
        $this->db = new Db($this->config->db);
    }
    
    /**
     * 
     */
    public function index() {
        echo "Start of saving synonyms";
        
        // Get synonyms list
        $synonyms = file_get_contents($this->config->synonyms_file_url);
               
        // Parse synonyms pages
        foreach($synonyms as $word) {
            $page = file_get_contents($this->config->site_url . $word);
            
            // save page to file
            file_put_contents($this->config->result_filepath . $word, $page->plaintext);
            
            // save result to db
            $result_tag = $page->find($this->config->result_tag);
            $this->db->save($word, $result_tag);
            
            echo "Synonyms for word $word saved!" . PHP_EOL;
        }
        
        echo "End of saving synonyms";
    }
}