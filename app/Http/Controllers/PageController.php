<?php
// comment
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\View;
use App\Services\DocsCmsApi;
use App;

class PageController extends Controller
{

    // home
    function home($region, $lang){

        $page = $this->cms->get_custom_post_by_name($lang, 'home', $region);
        
        
        if(empty($page['results'])){
            return response()->view('errors.languageunavailable');
        }
        else{        
            // $page = $this->getPlaylists($page);
            // $page = $this->getDownloads($page);
            // $page = $this->getProductNavigation($page);
            $pageContent = $page['results'][0];
            return view('pages.dev-level-1', compact('pageContent', 'recent', 'exclusiveTo','title' ));
        }
    }


    function level2($slug){

        $page = $this->cms->get_custom_post_by_name('en', 'level2', "{$slug}");
        if(empty($page['results'])){
            return response()->view('errors.languageunavailable');
        }
        else{        
            $pageContent = $page['results'][0];
            return view('pages.dev-level-2', compact('pageContent', 'recent', 'exclusiveTo','title'));
        }
    }

    
    // Blog Overview
    function blogOverview(){
        $page = $this->cms->page('int', 'en', 'blog');
        // App::setLocale($lang);
        if(empty($page['results'])){
            return response()->view('errors.languageunavailable');
        }
        else{        
            $pageContent = $page['results'][0];
            $posts = $this->cms->posts();
            $categories = $this->cms->categories();
            $tags = $this->cms->tags();
            return view('pages.blog-overview', compact('pageContent', 'posts', 'tags', 'categories', 'recent', 'exclusiveTo','title' ));
        }
    }

    // Blog Detail
    function blogDetail($post){

        // App::setLocale($lang);
        
        $postContent = $this->cms->post('en', $post)['results'][0]; // TODO - remove hardcode english... if post doesnt exist show 404
        $posts = $this->cms->posts();
        $categories = $this->cms->categories();
        $tags = $this->cms->tags();

        return view('pages.blog-detail', compact('postContent', 'posts', 'tags', 'categories', 'recent', 'exclusiveTo','title' ));
    }

    function csh($region, $lang, $slug){


        $page = $this->cms->get_custom_post_by_name($lang, 'csh', "{$region}-{$slug}");
        if(empty($page['results'])){
            return response()->view('errors.languageunavailable');
        }
        else{        
            $pageContent = $page['results'][0];
            return view('pages.csh', compact('pageContent', 'recent', 'exclusiveTo','title'));
        }
    }


    // TEMP - FAQ
    function faq($region, $lang, $slug){
        $page = $this->cms->get_custom_post_by_name($lang, 'faq', "{$region}-{$slug}");
        if(empty($page['results'])){
            return response()->view('errors.languageunavailable');
        }
        else{
            $pageContent = $page['results'][0];
            return view('pages.faq', compact('pageContent', 'recent', 'exclusiveTo','title'));
        }
    }

    // TEMP - Videos overview 
    

    
    function videosOverview($region, $lang, $slug = null){
        $page = $this->cms->page($region, $lang, 'videos');
        if(empty($page['results'])){
            return response()->view('errors.languageunavailable');
        }
        else{
            $pageContent = $page['results'][0];
            $videos = $this->cms->get_custom_post_by_type('videos');
            $categories = $this->cms->categories();
            $tags = $this->cms->tags();
            return view('pages.videos', compact('slug', 'pageContent', 'videos', 'categories', 'tags', 'title', 'playlists'));
        }
        $page = $this->getPlaylists($page);
    }
    
 
    
    // search
    function search($year, $product, $version, $lang){
        return view('pages.search', compact('recent'));
    }
    
     
    // topic
    function showTopic($product, $version, $category, $topic){

        $product =  strtolower($product);

        try {
            $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$product."/".$version."/"."Content/".$category."/".$topic ));
            $doNotTranslate = true;
        } catch (Exception $e) {
            return response()->view('errors.404');
        }

        $maincontentarea = $dom->find('body', 0);
        if($maincontentarea == ""){
            $maincontentarea = $dom->find('div[class=content]', 0);
        }        
        $htmlElement = $dom->find('html', 0);
        (isset($htmlElement->attr['data-mc-conditions'])) ? $exclusiveTo = $htmlElement->attr['data-mc-conditions'] : $exclusiveTo = '' ;
        $recent = getRecentlyViewed();
        $title = strip_tags($dom->find('h1', 0));

        return view('pages.documentation', compact('maincontentarea', 'recent', 'exclusiveTo','title'));
    }

    // topics with subsubcategory
    function showTopic2($year, $product, $version, $lang, $category, $subcategory, $subsubcategory, $topic){

        App::setLocale($lang);
                
        // if(!endsWith($topic,".html")){
        //     $topic .= ".html";
        // }

        $product =  strtolower($product);

        if($subcategory == "TranslatedDocs"){
            $doNotTranslate = true;
        }

        try {
            $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/".$lang."/Content/".$category."/".$subcategory."/".$subsubcategory."/".$topic.".htm" ));
            $doNotTranslate = true;        
        } catch (Exception $e) {
            try {
            $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/en/".$category."/".$subcategory."/".$subsubcategory."/".$topic.".htm;" ));
                } catch (Exception $e) {
                    // return response()->view('errors.404');
                    return env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/".$lang."/Content/".$category."/".$subcategory."/".$subsubcategory."/".$topic;
                }
        }        

        $maincontentarea = $dom->find('section[class=main-section]', 0);
        if($maincontentarea == ""){
            $maincontentarea = $dom->find('div[class=content]', 0);
        }        
        (isset($htmlElement->attr['data-mc-conditions'])) ? $exclusiveTo = $htmlElement->attr['data-mc-conditions'] : $exclusiveTo = '' ;
        $recent = getRecentlyViewed();
        $title = strip_tags($dom->find('h1', 0));

        return view('pages.documentation', compact('maincontentarea', 'recent', 'exclusiveTo','title', 'doNotTranslate'));
    }

    // subcategory
    function showSubCategory($year, $product, $version, $lang, $category, $subcategory){

        App::setLocale($lang);
                
        
        // if(!endsWith($subcategory,".html")){
        //     $subcategory .= ".html";
        // }

        $product =  strtolower($product);

        try {
            $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/".$lang."/Content/".$category."/".$subcategory.".htm" ));
            $doNotTranslate = true;        
        } catch (Exception $e) {
            try {
            $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/en/".$category."/".$subcategory.".html" ));
                } catch (Exception $e) {
                    return response()->view('errors.404');
                    // return env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/".$lang."/Content/".$category."/".$subcategory;
                }
        }          

        $maincontentarea = $dom->find('div[id=mc-main-content]', 0);
        if($maincontentarea == ""){
            $maincontentarea = $dom->find('div[class=content]', 0);
        }        
        $recent = getRecentlyViewed();
        return view('pages.documentation', compact('maincontentarea', 'recent'));
    }
    
    // category
    function showCategory($product, $version, $category){ 
        App::setLocale($lang);
        // dd(env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/".$lang."/Content/".$category);
        
        // if(!endsWith($category,".htm")){ 
        //     $category .= ".htm";
        // }

        $product =  strtolower($product);

        try {
            $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$product."/".$version."/Content/".$category.".htm" ));
            $doNotTranslate = true;
        } catch (Exception $e) {
            try {
                $dom = HtmlDomParser::str_get_html(file_get_contents( env('PATH_TO_PUBLIC').'documentation_files/'.$year."/".$product."/".$version."/"."Content/en/".$category.".html"));
                } catch (Exception $e) {
                    return response()->view('errors.404');
                }
        }  

        $maincontentarea = $dom->find('div[id=content-section]', 0);
        if($maincontentarea == ""){
            $maincontentarea = $dom->find('div[class=content]', 0);
        }
        $htmlElement = $dom->find('html', 0);
        (isset($htmlElement->attr['data-mc-conditions'])) ? $exclusiveTo = $htmlElement->attr['data-mc-conditions'] : $exclusiveTo = '' ;
        $recent = getRecentlyViewed();
        $title = strip_tags($dom->find('h1', 0));

        return view('pages.documentation-home', compact('maincontentarea', 'recent', 'exclusiveTo','title'));
    }
          
    function getPlaylists($page)
    {   
        $playlists = array();
        foreach($page['results'][0]->acf->modular_template as $template){
            $playlistVids = array();
            if($template->acf_fc_layout == 'playlist'){
                foreach($template->playlist as $video){
                    $videoContent = $this->cms->get_custom_post_by_id(
                        'videos',
                        $video->ID
                    )->get('results');
                    array_push($playlistVids, $videoContent);
                }
                $template->playlist = $playlistVids;
            }

            if($template->acf_fc_layout == 'video_gallery'){

                foreach($template->video_gallery as $video){
                    $videoContent = $this->cms->get_custom_post_by_id(
                        'videos',
                        $video->ID
                    )->get('results');
                    array_push($playlistVids, $videoContent);
                }
                $template->video_gallery = $playlistVids;
            }
        }
        return $page;
    }   

    function getDownloads($page)
    {   
        foreach($page['results'][0]->acf->modular_template as $template){
            $downloads = array();
            if($template->acf_fc_layout == 'downloads'){
                foreach($template->quick_links as $dl){
                    $dlContent = $this->cms->get_custom_post_by_id(
                        'downloads',
                        $dl->ID
                    )->get('results')->acf;
                    array_push($downloads, $dlContent);
                }
                $template->quick_links = $downloads;
            }
        }
        return $page;
    }   

    function getProductNavigation($page)
    {   
        foreach($page['results'][0]->acf->modular_template as $template){
            $productBlocks = array();
            if($template->acf_fc_layout == 'product_navigation'){
                foreach($template->navigation as $pb){
                    $pbContent = $this->cms->get_custom_post_by_id(
                        'product_blocks',
                        $pb->ID
                    )->get('results')->acf;
                    array_push($productBlocks, $pbContent);
                }
                $template->navigation = $productBlocks;
            }
        }
        return $page;
    }   
}