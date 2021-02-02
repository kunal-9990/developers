<?php
// comment
namespace App\Http\Controllers;

use App;
use Exception;
use App\Services\DocsCmsApi;
use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class PageController extends Controller
{
    function api($slug){
        return view('pages.api-iframe', compact('slug'));

    }
    // home
    function level1(Request $request){

        $authenticated = isAuthenticated($request);
        $page = $this->cms->get_custom_post_by_name('en', 'level1', 'home');
        
        
        if(empty($page['results'])){
            return response()->view('errors.languageunavailable');
        }
        else{        
            // $page = $this->getPlaylists($page);
            // $page = $this->getDownloads($page);
            // $page = $this->getProductNavigation($page);
            $pageContent = $page['results'][0];
            return view('pages.dev-level-1', compact('pageContent', 'recent', 'exclusiveTo','title', 'authenticated'));
        }
    }


    function level2(Request $request, $slug){

        $authenticated = isAuthenticated($request);
        $page = $this->cms->get_custom_post_by_name('en', 'level2', "{$slug}");


        if(empty($page['results'])){
            return response()->view('errors.languageunavailable');
        }
        else{        
            $pageContent = $page['results'][0];
            return view('pages.dev-level-2', compact('pageContent', 'recent', 'exclusiveTo','title', 'authenticated'));
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
    
     
    // display the topics in /public/documentation_files
    function showTopic($product, $version, $category, $param1 = null, $param2 = null, $param3 = null, $param4 = null){
        $product =  strtolower($product);
        //build topic path using supplied parameters
        $topicpath = env('PATH_TO_PUBLIC').'documentation_files/'.$product."/".$version."/"."Content/".$category;
        // dd($topicpath);
        $topicpath .= (isset($param1)) ? "/".$param1 : "";
        $topicpath .= (isset($param2)) ? "/".$param2 : "";
        $topicpath .= (isset($param3)) ? "/".$param3 : "";
        $topicpath .= (isset($param4)) ? "/".$param4 : "";
        $topicpath .= (isset($param5)) ? "/".$param5 : "";
        $topicpath .= (isset($param6)) ? "/".$param6 : "";
        $topicpath .= (isset($param7)) ? "/".$param7 : "";
        try {
            $dom = HtmlDomParser::str_get_html(file_get_contents($topicpath));
        } catch (Exception $e) {
            return response()->view('errors.404');
        }

        $maincontentarea;
        // find the element containing topic information according
        //desktop sdk
        if($dom->find('div[id=contentBody]', 0)){
            $maincontentarea = $dom->find('div[class=content]', 0);
        }

        //cloud sdk
        elseif($dom->find('div[class=col-xs-9]', 0)){
            $maincontentarea = $dom->find('div[class=col-xs-9]', 0);
        }
        //cloud sdk
        elseif(isset($param4)){
            $maincontentarea = $dom->find('html', 0);
        }

        //sherlock and developer_content
        else{
            $maincontentarea = $dom->find('body', 0);
        }
        
        
        $htmlElement = $dom->find('html', 0);
        (isset($htmlElement->attr['data-mc-conditions'])) ? $exclusiveTo = $htmlElement->attr['data-mc-conditions'] : $exclusiveTo = '' ;
        $recent = getRecentlyViewed();
        $title = strip_tags($dom->find('h1', 0));

        return view('pages.documentation', compact('maincontentarea', 'recent', 'exclusiveTo','title'));
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