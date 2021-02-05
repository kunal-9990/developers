<?php

namespace App\Services;

use Unirest;
use Algolia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Sunra\PhpSimple\HtmlDomParser;



class DocsSearchApi
{

    protected $client;
    protected $index;

    /**
     * config the APi class
     * @param array $config configuration variables
     */
     public function __construct()
     {
         $this->client  = Algolia\AlgoliaSearch\SearchClient::create(
         env('ALGOLIA_APP_ID'),
         env('ALGOLIA_SECRET')
         );
         $this->index = $this->client->initIndex( env('ALGOLIA_INDEX_NAME'));
     }

      public function search($query, $filters)
     {
         
        $this->index = $this->client->initIndex( env('ALGOLIA_INDEX_NAME'));
        $res = $this->index->search($query, [
            "filters" => $filters
        ]);
        return $res;
     }

     public function addRecord($title, $body, $url){
        $this->index->saveObject(
        [
            'title' => $title,
            'body'  => $body,
            'url'   => $url
            
        ],
        [
                'autoGenerateObjectIDIfNotExist' => true
        ]
        );         
     }

     public function deleteRecord(){
         $this->$index->deleteObject('myID');
     }

     public function deleteDocsBy($product, $version){
        //  $this->index->clearObjects();
        $filters = 'product:'.$product.' AND version:'.$version;
        $this->index->deleteBy([
        'filters' => $filters
        /* add any filter parameters */
        ]);        
     }

     public function clearObjects(){
         $this->index->clearObjects();
       
     }
     
    //  This function is written to perform the indexing on the linux based ec2 instance that is hosting the site, and not in my local windows dev environment
     public function index(){
        $records = array();
        $docspath = env("PATH_TO_PUBLIC")."documentation_files/";
        $path = realpath($docspath);
        
        echo "Indexing: \n";
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $filename)
        {
                if(endsWith($filename,".htm")){
                    $topicName;
                    $topicBody;
                    $topicUrl;
                    
                    try {
                        $dom = HtmlDomParser::str_get_html(file_get_contents(str_replace('\\', '/', $filename)));
                        if($dom){
                            $title = strip_tags($dom->find('h1', 0));
                            $body = strip_tags($dom->find('body', 0)->plaintext);
                            // $url =  str_replace('\\', '/', "/".str_replace(env('PATH_TO_PUBLIC'), "", substr($filename, strpos($filename, "\\documentation_files\\") + 21)));
                            $url =  str_replace("/Content/", "/" , str_replace(env('PATH_TO_PUBLIC')."documentation_files", "", $filename));
                            $params = explode("/", $url);
                            echo $url;
                            echo "\n";

                            if(!empty($body) && !empty($title)){

                                array_push($records, ["title"=>$title, "body"=>$body, "url"=>$url, "product"=>$params[1], "version"=>$params[2]]);
                            }

                        }
                    } catch (Exception $e) {
                        Log::error($e);
                    }
                }
                
            }
            
            $res = $this->index->saveObjects(
            $records,
            [
                'autoGenerateObjectIDIfNotExist' => true
            ]
            );




     }
     public function indexDocsBy($product, $version){
        $records = array();
        $docspath = env("PATH_TO_PUBLIC")."documentation_files/".$product."/".$version;
        $path = realpath($docspath);
        $i = 0;
        echo "Indexing: \n";

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $filename)
        {
                if(endsWith($filename,".htm") || endsWith($filename,".html")){
                    $topicName;
                    $topicBody;
                    $topicUrl;
                    
                    try {
                        $dom = HtmlDomParser::str_get_html(file_get_contents(str_replace('\\', '/', $filename)));
                        if($dom){
                            $url =  str_replace("/Content/", "/" , str_replace(env('PATH_TO_PUBLIC')."documentation_files", "", $filename));
                            $params = explode("/", $url);

                            $body = getContentFromDom($dom);
                            $h1 = strip_tags($body->find('h1', 0));
                            $title = (isset($h1) && $h1 !== " Contact Us") ? $h1 : cleanTitle(end($params));
                            
                            $body = strip_tags($body->plaintext);

                            //algolia sets char limit of records
                            $truncatedbody = (strlen($body) > 100000) ? substr($body, 0, 90000) . '...' : $body;
                            
                            if(!empty($body) && !empty($title)){
                                echo $url;
                                echo "\n";
                                echo strlen($body);
                                echo "\n";
                                echo $title;
                                echo "\n";


                                
                                array_push($records, ["title"=>$title, "body"=>$truncatedbody, "url"=>$url, "product"=>$params[1], "version"=>$params[2]]);
                                $this->index->saveObject(
                                    ["title"=>$title, "body"=>$truncatedbody, "url"=>$url, "product"=>$params[1], "version"=>$params[2]],
                                    ['autoGenerateObjectIDIfNotExist' => true]
                                );         
                                $i ++;
                            }

                        }
                    } catch (Exception $e) {
                        Log::error($e);
                    }
                }
                
            }
            
            echo "Indexing of ".$product.":".$version." is complete.\n".$i." topics indexed.";
            return;
     }

}
