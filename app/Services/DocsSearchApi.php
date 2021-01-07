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

     public function addRecord(){
        $this->index->saveObject(
        [
            'objectID' => 'myID',
            'firstname' => 'Jimmie',
            'lastname'  => 'Barninger'
        ]
        );         
     }

     public function deleteRecord(){
         $this->$index->deleteObject('myID');
     }

     public function clearObjects(){
         $this->index->clearObjects();
     }

     public function index(){
        $records = array();
        $docspath = env("PATH_TO_PUBLIC")."documentation_files/";
        $path = realpath($docspath);
        
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
                            // $url =  str_replace('\\', '/', "/".str_replace("\\Content\\", "/", substr($filename, strpos($filename, "\\documentation_files\\") + 21)));
                            $url =  str_replace('\\', '/', "/".str_replace("\\Content\\", "/", substr($filename, strpos($filename, "\\documentation_files\\") + 21)));
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

    //  public function indexfolder($folder, $domain){
    //     $records = array();
    //     $docspath = "C:/code/casewareDocs/docs.caseware.com-mk4/tmp/".$folder;
    //     $path = realpath($docspath);
        
    //     // foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $filename)
    //     // {
    //     //         if(endsWith($filename,".htm")){
    //     //             $topicName;
    //     //             $topicBody;
    //     //             $topicUrl;

                    
    //     //             try {
    //     //                 $dom = HtmlDomParser::str_get_html(file_get_contents(str_replace('\\', '/', $filename)));
    //     //                 if($dom){
    //     //                     $title = strip_tags($dom->find('h1', 0));
    //     //                     $body = strip_tags($dom->find('body', 0)->plaintext);
    //     //                     $url =  str_replace('\\', '/', substr($filename, strpos($filename, "\\tmp\\") + 4));
    //     //                     $params = explode("/", $url);

    //     //                     if(gettype($body)=="string"){

    //     //                         array_push($records, ["title"=>$title, "body"=>$body, "url"=>$url, "year"=>$params[1], "product"=>$params[2], "version"=>$params[3], "language"=>$params[4]]);
    //     //                     }

    //     //                 }
    //     //             } catch (Exception $e) {
    //     //                 Log::error($e);
    //     //             }
    //     //         }
                
    //     //     }
    //     //     dd($records);
    //         // $res = $this->index->saveObjects(
    //         // $records,
    //         // [
    //         //     'autoGenerateObjectIDIfNotExist' => true
    //         // ]
    //         // );




    //  }

}
