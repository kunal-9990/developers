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
    protected $signature = 'TOC:update';

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
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('C:\code\casewareDocs\developers\public\documentation_files'));

        $files = array(); 

        foreach ($rii as $file) {

            if ($file->isDir()){ 
                continue;
            }
            if ($file->getExtension() == 'htm') {
                $files[] = $file->getPathname(); 
            }

        }

        if(file_exists(env('PATH_TO_PUBLIC')."/documentation_files/OnlineOutput.xml")){
            unlink(env('PATH_TO_PUBLIC')."/documentation_files/OnlineOutput.xml");
        }    
        $topics = $files;
        $toc = fopen(env('PATH_TO_PUBLIC')."/documentation_files/OnlineOutput.xml", "w");
        $opening = '<?xml version="1.0" encoding="utf-8"?><CatapultToc Version="1">'."\n";
        fwrite($toc, $opening);
        $category = "";
        foreach($topics as $topic) {
            $fullPath = explode("/", str_replace('\\', '/', $topic));
            $currentCat = array_slice($fullPath, -2, 1);
            $currentCat = $currentCat[0];
            if($category != $currentCat[0]){
                if($category == ""){
                    $newCat = '<TocEntry Title="'.ucwords($currentCat).'">'."\n";
                }
                else{
                    $newCat = '</TocEntry>'."\n".'<TocEntry Title="'.ucwords($currentCat).'">';
                }
                fwrite($toc, $newCat);
                $category = $currentCat[0];
            }
            
            $title = str_replace(".html", "", end($fullPath));
            $title = ucwords(str_replace("-", " ", $title));
            $components = explode("Content", $topic);
            $tocPath = str_replace(".html", "",end($components));


            $entry = '<TocEntry Title="'.$title.'" Link="'.$tocPath.'" />'."\n";
            fwrite($toc, $entry);
        }

        $closing = '</TocEntry></CatapultToc>';
        fwrite($toc, $closing);
        fclose($toc); 
        }
}
