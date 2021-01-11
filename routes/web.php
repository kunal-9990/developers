<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$current_version = env("CURRENT_VERSION");

Route::get('/toc', function(){


        function cleanTitle($string){
            $string = str_replace(".html", "", end($string));
            $string = ucwords(str_replace("-", " ", $string));
            $string = ucwords(str_replace("_", " ", $string));
            $string = ucwords(str_replace(".htm", "", $string));
            return $string;
        }

        function pathToLink($path) {
            
            $path = str_replace('\\', '/', $path);
            $path = str_replace(env("PATH_TO_PUBLIC"), "", $path);
            $path = str_replace("documentation_files", "", $path);
            $path = str_replace("/Content", "", $path);
            return $path;
        }

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
            $currentCat = cleanTitle($currentCat);

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
            $link = pathToLink($topic);
            $title = cleanTitle($fullPath);
            $components = explode("Content", $topic);
            $tocPath = str_replace(".html", "",end($components));


            $entry = '<TocEntry Title="'.$title.'" Link="'.$link.'" />'."\n";
            fwrite($toc, $entry);
        }

        $closing = '</TocEntry></CatapultToc>';
        fwrite($toc, $closing);
        fclose($toc); 
        

});

Route::get('/new-search', 'SearchController@searchform');
Route::get('/new-search/all', 'SearchController@all'); 
Route::get('/new-search/{query}', 'SearchController@search');

//allow unauthenticated users to cast a max of 10 votes per minute
Route::middleware('throttle:30|180,1')->group(function () {        
        Route::post('/api/vote/create', 'VoteController@createVote');
        Route::post('/api/vote/updateVoteState', 'VoteController@updateVoteState');
});

Route::get('/api/vote/getData', 'VoteController@getVoteData');

// home page - to come

// TEMPORARY HARD CODE

// Route::get('/{region}/{lang}/{product}/{version}/webapps', function() {
//         return redirect('/ca/en/csh');
// });

Route::group(['middleware' => 'setregion'], function () {

        Route::get('/{region}/{lang}/videos/{slug?}', 'PageController@videosOverview')->name('videos');
        // Route::get('/blog', 'PageController@blogOverview')->name('blogoverview');
        // Route::get('/blog/{post}', 'PageController@blogDetail')->name('blogdetail');
        Route::get('/{region}/{lang}/{slug}/context-specific-help', 'PageController@csh')->name('csh');
        Route::get('/{region}/{lang}/{slug}/frequently-asked-questions', 'PageController@faq')->name('faq');
        Route::get('/{region}/{lang}/{slug}', 'PageController@product')->name('product');
        Route::get('/{region}/{lang}/', 'PageController@home')->name('home');
        Route::get('/{slug}', 'PageController@level2')->name('level2');

        Route::get('/', function() {
                return redirect('/ca/en');
        });
});


// // search
// Route::get('/search/{year}/{product}/{version}/{lang}/search', 'PageController@search')->name('search');

// // se-search
// Route::get('/se-search/{year}/{product}/{version}/{lang}/search', 'PageController@search')->name('se-search');

// // search redirect
// Route::get('/search/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{topic}', function($year, $product, $version, $lang, $category, $subcategory, $topic){
//         return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory.'/'.$topic);
// });
// // search redirect
// Route::get('/search/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{subsubcategory}/{topic}', function($year, $product, $version, $lang, $category, $subcategory, $subsubcategory, $topic){
//         return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory.'/'.$subsubcategory.'/'.$topic);
// });
// // search redirect
// Route::get('/search/{year}/{product}/{version}/{lang}/{category}', function($year, $product, $version, $lang, $category){
//         return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category);
// });
// // search redirect
// Route::get('/search/{year}/{product}/{version}/{lang}/{category}/{subcategory}', function($year, $product, $version, $lang, $category, $subcategory){
//         return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory);
// });
// // search redirect
// Route::get('/se-search/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{topic}', function($year, $product, $version, $lang, $category, $subcategory, $topic){
//         return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory.'/'.$topic);
// });
// // search redirect
// Route::get('/se-search/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{subsubcategory}/{topic}', function($year, $product, $version, $lang, $category, $subcategory, $subsubcategory, $topic){
//         return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory.'/'.$subsubcategory.'/'.$topic);
// });
// // search redirect
// Route::get('/se-search/{year}/{product}/{version}/{lang}/{category}', function($year, $product, $version, $lang, $category){
//         return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category);
// });
// // search redirect
// Route::get('/se-search/{year}/{product}/{version}/{lang}/{category}/{subcategory}', function($year, $product, $version, $lang, $category, $subcategory){
//         return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory);
// });



//Flare Content routes
// topics
Route::get('/{product}/{version}/{category}/{topic}', 'PageController@showTopic')->name('topic');

// // topics
// Route::get('/{product}/{version}/{category}/{subcategory}/{subsubcategory}/{topic}', 'PageController@showTopic2');

// // sub category
// Route::get('/{product}/{version}/{category}/{subcategory}', 'PageController@showSubCategory');

// // category
// Route::get('/{product}/{version}/{category}', 'PageController@showCategory')->name('category');

Route::post('logemail', 'Controller@logEmail');
