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

//------temporary redirects-----//

Route::get('/2019/webapps/30/en/Engagements/Accounts-and-Analysis/Detecting-misstatements-in-your-file.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});
Route::get('/2019/webapps/30/en/Engagements/Accounts-and-Analysis/Run-tests-on-your-client-data.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});
Route::get('/2019/webapps/30/en/Engagements/Accounts-and-Analysis/Visualizing-business-data.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});
Route::get('/2019/webapps/30/en/Engagements/File-Preparation/Import-clients-financial-data-from-a-CSV-file-for-analysis.htm', function () {
    return redirect('/2019/webapps/30/en/Engagements/File-Preparation/Import-clients-trial-balance-in-the-Data-page.htm#Importfromthird-partydesktopaccountingsoftware');
});
Route::get('/2019/webapps/30/en/Engagements/File-Preparation/Import-clients-financial-data-from-another-software-for-analysis.htm', function () {
    return redirect('/2019/webapps/30/en/Engagements/File-Preparation/Import-clients-trial-balance-in-the-Data-page.htm#Importfromthird-partydesktopaccountingsoftware');
});
Route::get('/2019/webapps/30/en/Engagements/File-Preparation/Import-clients-tax-data.htm', function () {
    return redirect('/2019/webapps/30/en/Engagements/File-Preparation/Import-clients-trial-balance-in-the-Data-page.htm#Importfromthird-partydesktopaccountingsoftware');
});
Route::get('/2019/webapps/30/en/Explore/Interface/Analytics/Analytics-advanced.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});
Route::get('/2019/webapps/30/en/Explore/Interface/Firm-Settings/Analytics.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});
Route::get('/2019/webapps/30/en/Explore/Known-Issues/Analytics/Analytics-known-issues.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});
Route::get('/2019/webapps/30/en/Explore/Known-Issues/Analytics/Analytics-troubleshooting.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});
Route::get('/2019/webapps/30/en/Explore/Scenarios/Testing-client-data.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});
Route::get('/2019/webapps/30/en/Explore/Whats-New/Release-history-Analytics.htm', function () {
    return redirect('/2019/webapps/30/en/Explore/Products/CaseWareCloud-Analytics.htm');
});


//------------------------------

// cloud index
Route::get('/', function () {
    return redirect('/2019/webapps/30/en/webapps'); 
});

Route::get('/download/{filename}', function($filename){
    return response()->download(public_path('/downloads/'.$filename));
});

// search
Route::get('/search/{year}/{product}/{version}/{lang}/search', 'PageController@search')->name('search');

// se-search
Route::get('/se-search/{year}/{product}/{version}/{lang}/search', 'PageController@search')->name('se-search');

// search redirect
Route::get('/search/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{topic}', function($year, $product, $version, $lang, $category, $subcategory, $topic){
        return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory.'/'.$topic);
});
// search redirect
Route::get('/search/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{subsubcategory}/{topic}', function($year, $product, $version, $lang, $category, $subcategory, $subsubcategory, $topic){
        return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory.'/'.$subsubcategory.'/'.$topic);
});
// search redirect
Route::get('/search/{year}/{product}/{version}/{lang}/{category}', function($year, $product, $version, $lang, $category){
        return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category);
});
// search redirect
Route::get('/search/{year}/{product}/{version}/{lang}/{category}/{subcategory}', function($year, $product, $version, $lang, $category, $subcategory){
        return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory);
});
// search redirect
Route::get('/se-search/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{topic}', function($year, $product, $version, $lang, $category, $subcategory, $topic){
        return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory.'/'.$topic);
});
// search redirect
Route::get('/se-search/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{subsubcategory}/{topic}', function($year, $product, $version, $lang, $category, $subcategory, $subsubcategory, $topic){
        return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory.'/'.$subsubcategory.'/'.$topic);
});
// search redirect
Route::get('/se-search/{year}/{product}/{version}/{lang}/{category}', function($year, $product, $version, $lang, $category){
        return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category);
});
// search redirect
Route::get('/se-search/{year}/{product}/{version}/{lang}/{category}/{subcategory}', function($year, $product, $version, $lang, $category, $subcategory){
        return redirect('/'.$year.'/'.$product.'/'.$version.'/'.$lang.'/'.$category.'/'.$subcategory);
});


// topics
Route::get('/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{topic}', 'PageController@showTopic')->name('topic');

// topics
Route::get('/{year}/{product}/{version}/{lang}/{category}/{subcategory}/{subsubcategory}/{topic}', 'PageController@showTopic2');

// sub category
Route::get('/{year}/{product}/{version}/{lang}/{category}/{subcategory}', 'PageController@showSubCategory');

// category
Route::get('/{year}/{product}/{version}/{lang}/{category}', 'PageController@showCategory')->name('category');

Route::post('logemail', 'Controller@logEmail');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');




Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
