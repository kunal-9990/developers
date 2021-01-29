<?php

namespace App\Console\Commands;

use RecursiveIteratorIterator;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;

class UpdateTOC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TOC:update2 {product?} {version?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        
        function cleanTitle($string){
            $string = str_replace(".html", "", $string);
            $string = str_replace("-", " ", $string);
            $string = str_replace("_", " ", $string);
            $string = str_replace(".htm", "", $string);
            return $string;
        }
        
        function pathToLink($path) {
            
            $path = str_replace('\\', '/', $path);
            $path = str_replace(env("PATH_TO_PUBLIC"), "", $path);
            $path = str_replace("documentation_files", "", $path);
            $path = str_replace("/Content", "", $path);
            return $path;
        }
        
        $product = $this->argument('product');
        $version = $this->argument('version');
        $pathtoproductversiontopics = env("PATH_TO_PUBLIC").'documentation_files/'.$product.'/'.$version;
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($pathtoproductversiontopics));

        $files = array(); 

        foreach ($rii as $file) {

            if ($file->isDir()){ 
                continue;
            }
            if ($file->getExtension() == 'htm' || $file->getExtension() == 'html') {
                $filepath =  str_replace("\\","/",$file->getPathname());
                $filepath =  str_replace("/Content","",$filepath);
                $filepath =  str_replace(env("PATH_TO_PUBLIC").'documentation_files/'.$product.'/'.$version,"",$filepath);

                array_push($files, $filepath);
            }

        }

       if(file_exists(env('PATH_TO_PUBLIC')."/documentation_files/".$product."/".$version."/OnlineOutput.xml")){
            unlink(env('PATH_TO_PUBLIC')."/documentation_files/".$product."/".$version."/OnlineOutput.xml");
        }    
        $toc = fopen(env('PATH_TO_PUBLIC')."/documentation_files/".$product."/".$version."/OnlineOutput.xml", "w");
        $opening = '<?xml version="1.0" encoding="utf-8"?><CatapultToc Version="1">'."\n";
        fwrite($toc, $opening);
        $previouscat = "";
        $previoussubcat = "";
        $currentcat ="";
        $currentsubcat = "";
        echo "Indexing:";
        echo "\n";

        $i=0;

        while($i < count($files)){
            $splicedpath = explode("/", str_replace('\\', '/', $files[$i]));
            $topicDepth = count($splicedpath);
            
            //topic is within a category
            if($topicDepth == 3){
                $currentcat = array_slice($splicedpath, -2, 1)[0];
                $currentcat = cleanTitle($currentcat);
                $currentsubcat = "";
            }
            //topic is within a subcategory
            elseif($topicDepth == 4){
                $currentcat = array_slice($splicedpath, -3, 1)[0];
                $currentcat = cleanTitle($currentcat);
                $currentsubcat = array_slice($splicedpath, -2, 1)[0];
                $currentsubcat = cleanTitle($currentsubcat);
            }

            $entry;
            
            if($currentcat == ""){
                $title = cleanTitle(end($splicedpath));
                $entry = "\t".'<TocEntry Title="'.$title.'" Link="'.$files[$i].'" />'."\n";
                fwrite($toc, $entry);
            }
            
            elseif($currentcat !== $previouscat){
                // if($currentsubcat !== $previoussubcat){
                //     fwrite($toc, "\t\t</TocEntry>\n");
                // }
                $newcat = "";
                if($previouscat){
                    if($previoussubcat){
                        $newcat .=  "\t\t</TocEntry>\n";
                    }                    
                    $newcat .=  "\t</TocEntry>\n";
                }

                $newcat .=  "\t".'<TocEntry Title="'.ucwords($currentcat).'">'."\n";
                fwrite($toc, $newcat);
                $previouscat = $currentcat;
                $previoussubcat = "";
                
            }
            if($currentsubcat !== $previoussubcat && $currentsubcat){
                $newsubcat = "";
                if($previoussubcat !== ""){
                    $newsubcat .=  "\t\t</TocEntry>\n";
                }
                $newsubcat .=  "\t\t".'<TocEntry Title="'.ucwords($currentsubcat).'">'."\n";
                fwrite($toc, $newsubcat);
                $previoussubcat = $currentsubcat;
            }
            
            $title = cleanTitle(end($splicedpath));
            if($currentsubcat !== ""){
                $entry = "\t\t\t".'<TocEntry Title="'.$title.'" Link="/'.$product."/".$version.$files[$i].'" />'."\n";
            }
            elseif($currentcat !== "") {

                $entry = "\t\t".'<TocEntry Title="'.$title.'" Link="/'.$product."/".$version.$files[$i].'" />'."\n";
            }
            fwrite($toc, $entry);


            if($i == count($files)-1 && $currentsubcat !== ""){
                fwrite($toc,  "\t\t</TocEntry>\n");
            }

            echo $files[$i];
            echo "\n";
            $i++;

        }
        
        
        
        
        
        // $topics = $files;
        // foreach($topics as $topic) {

        //     // $fullpath = explode("/", str_replace('\\', '/', $topic));
        //     // $basedirdepth = array_search("Content", $fullpath);
        //     // $topicDepth = count($fullpath) - $basedirdepth;

        //     // // find topic depth and determine the category and subcategory accordingly

        //     // //topic is within a category
        //     // if($topicDepth == 3){
        //     //     $currentcat = array_slice($fullpath, -2, 1)[0];
        //     //     $currentcat = cleanTitle($currentcat);
        //     //     $currentsubcat = "";
        //     // }
        //     // //topic is within a subcategory
        //     // elseif($topicDepth == 4){
        //     //     $currentcat = array_slice($fullpath, -3, 1)[0];
        //     //     $currentcat = cleanTitle($currentcat);
        //     //     $currentsubcat = array_slice($fullpath, -2, 1)[0];
        //     //     $currentsubcat = cleanTitle($currentsubcat);
        //     // }

            
 
        //     // if($currentcat !== "Print"){
                
    
        //     //     echo "\n";
        //     //     echo "Category: ". $currentcat;
        //     //     echo "\n";
        //     //     echo "Subcategory: ". $currentsubcat;
        //     //     echo "\n";


        //     //     if($previouscat !== $currentcat){
        //     //             if($previouscat == ""){
        //     //                 $newcat = '<TocEntry Title="'.ucwords($currentcat).'">'."\n";
        //     //             }
        //     //             else{
        //     //                 $newcat = '</TocEntry>'."\n".'<TocEntry Title="'.ucwords($currentcat).'">'."\n";
        //     //             }
        //     //             fwrite($toc, $newcat);
        //     //     }

        //     //     if($previoussubcat !== $currentsubcat){

                    
        //     //         if($previoussubcat !== "" ){
        //     //             if($currentsubcat == ""){
        //     //                 $newcat = "\t".'</TocEntry>'."\n";
        //     //             }
        //     //             else{
        //     //                 $newcat = "\t".'</TocEntry>'."\n"."\t".'<TocEntry Title="'.ucwords($currentsubcat).'">'."\n";
        //     //             }
        //     //         }
        //     //         elseif($previoussubcat == ""){
        //     //             $newcat = "\n\t".'<TocEntry Title="'.ucwords($currentsubcat).'">'."\n";
        //     //         }
        //     //         fwrite($toc, $newcat);
        //     //     }

        //     //     $previouscat = $currentcat;
        //     //     $previoussubcat = $currentsubcat;

        //     //     $link = pathToLink($topic);
        //     //     echo $link;
        //     //     echo "\n";
        //     //     $title = cleanTitle(end($fullpath));
        //     //     $components = explode("Content", $topic);
        //     //     $tocPath = str_replace(".html", "",end($components));
                
        //     //     if($currentsubcat){
        //     //         $entry = "\t\t".'<TocEntry Title="'.$title.'" Link="'.$link.'" />'."\n";
        //     //     }
        //     //     else{

        //     //         $entry = "\t".'<TocEntry Title="'.$title.'" Link="'.$link.'" />'."\n";
        //     //     }
        //     //     fwrite($toc, $entry);
        //     // }
        // }

        $closing = "\t</TocEntry>\n</CatapultToc>";
        fwrite($toc, $closing);
        fclose($toc); 
    }


}
