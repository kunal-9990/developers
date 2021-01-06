<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\View;
use App\Services\DocsSearchApi;
use App;

class SearchController extends Controller
{

    // function search($query){
    //     $results = $this->search->search($query);
    //     return view('pages.new-search', compact('results','query'));
    // }

    function all(){
        $this->search->indexfolder('2020/workingpapers', 'https://documentation.caseware.com');
    }

    function searchform(Request $request){
        $query = $request->input('search');
        $cloud = $request->input('cloud');
        $hybrid = $request->input('hybrid');
        $year = $request->input('year');
        $version = $request->input('version');
        $language = $request->input('language');
        $filters = "";
        
        // if($year){

        //     $filters .= "year:".$year;
        // }
        // if($version){

        //     $filters .= " AND version:".$version;
        // }
        // if($language){

        //     $filters .= " AND language:".$language;
        // }

        // if(empty($cloud)){

        //     $filters .= " AND NOT product:webapps";
        // }

        // if(empty($hybrid)){

        //     $filters .= " AND NOT product:hybrid";
        // }


        

       




        $results = $this->search->search($query, $filters);
        return view('pages.new-search', compact('results','query'));
    }
}
