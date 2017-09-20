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
     * Object of DB class
     * 
     * @var object
     */
    private $db;

    /**
     * 
     */
    public function __construct() {
        $this->config = json_decode(file_get_contents('./config.json'));
    }

    /**
     * 
     */
    public function index() {
        echo "Start of saving synonyms" . PHP_EOL;

        // Get synonyms list
        $synonyms = file($this->config->synonyms_file_url, FILE_IGNORE_NEW_LINES);
        if (!$synonyms || empty($synonyms)) exit;

        $this->db = new Db($this->config->db);

        $result_tags = [];
        // Parse synonyms pages
        foreach ($synonyms as $word) {
            $page = $this->get_page($this->config->site_url . $word);

            // save page to file
            $result_filename = $word . ".html";
            file_put_contents($this->config->result_filepath . $result_filename, $page);

            // find tag and save result to db
            $html = HtmlDomParser::str_get_html($page);
            
            // because we search tag with id, it's one in page
            foreach ($html->find($this->config->result_tag) as $r) {
                $result_tags[] = ['key' => $word, 'text' => $r->plaintext];                
            }

            // insert packs of 100 objects
            if(isset($result_tags[$this->config->db_chunk_size])) {
                $this->db->save($result_tags);
                $result_tags = [];
            }
        }

        echo "End of saving synonyms";
    }

    /**
     * Method for get html from url
     * 
     * @param string $url
     * @return string
     */
    private function get_page($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36");

        $html = curl_exec($ch);
        curl_close($ch);
        return mb_convert_encoding($html, 'UTF-8');
    }

}
