<?php
// comment
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
class PageController extends Controller
{


    // default
    function home() {

        return view('pages.home');
    }

    // documentation home
    function documentationHome() {
        return view('pages.documentation');
    }

    // search
    function search($product, $version, $lang){
        // return redirect('/'.$product.'/'.$version.'/'.$lang.'/search#search-'.request()->search);
        return view('pages.search', compact('recent'));

    }
    
    // topic
    function showTopic($year, $product, $version, $lang, $category, $subcategory, $topic){
        if(!endsWith($topic,".htm")){
            $topic .= ".htm";
        }
        // $product =  strtolower($product);
        // dd($version);
        $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/".$category."/".$subcategory."/".$topic ));

        $maincontentarea = $dom->find('body', 0);

        $recent = getRecentlyViewed();

        return view('pages.documentation', compact('maincontentarea', 'recent'));
    }

    // topics with subsubcategory
    function showTopic2($year, $product, $version, $lang, $category, $subcategory, $subsubcategory, $topic){
        if(!endsWith($topic,".htm")){
            $topic .= ".htm";
        }
        // $product =  strtolower($product);

        // dd($version);
        $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/".$category."/".$subcategory."/".$subsubcategory."/".$topic ));

        $maincontentarea = $dom->find('body', 0);

        $recent = getRecentlyViewed();


        return view('pages.documentation', compact('maincontentarea', 'recent'));
    }

    // subcategory
    function showSubCategory($year, $product, $version, $lang, $category, $subcategory){

        if(!endsWith($subcategory,".htm")){
            $subcategory .= ".htm";
        }

        $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/".$category."/".$subcategory ));

        $maincontentarea = $dom->find('body', 0);

        $recent = getRecentlyViewed();

        return view('pages.documentation', compact('maincontentarea', 'recent'));
    }
    
    // category
    function showCategory($year, $product, $version, $lang, $category){

        if(!endsWith($category,".htm")){
            $category .= ".htm";
        }
        
        $dom = HtmlDomParser::str_get_html(file_get_contents(env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."/Content/".$category ));

        $maincontentarea = $dom->find('body', 0);
        // dd($maincontentarea);
        $recent = getRecentlyViewed();

        return view('pages.documentation', compact('maincontentarea', 'recent'));
    }
}
