<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use App\Services\DocsCmsApi;
use App\Services\DocsSearchApi;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Http\Redirect;
use App\Facades\LocaleFacade;
use Illuminate\Support\Facades\App;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $cms;
    public $search;

    public function __construct(DocsCmsApi $cms, DocsSearchApi $search, Request $request) {

        $this->search = $search;
        $this->cms = $cms;
        //Grab the menus
        View::share('header', $cms->menu('header')->get('results')->items);
        $footerRegion = 'int';
        View::share('footer', $cms->menu('footer-'.$footerRegion)->get('results')->items);
 

        //Build a breadcrumb array
        // View::share('breadcrumbs', $this->generateBreadcrumbs($request->segments()));
    }
    
        // default
        function logEmail() {
            
            function get_client_ip() {
                $ipaddress = '';
                if (getenv('HTTP_CLIENT_IP'))
                    $ipaddress = getenv('HTTP_CLIENT_IP');
                else if(getenv('HTTP_X_FORWARDED_FOR'))
                    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                else if(getenv('HTTP_X_FORWARDED'))
                    $ipaddress = getenv('HTTP_X_FORWARDED');
                else if(getenv('HTTP_FORWARDED_FOR'))
                    $ipaddress = getenv('HTTP_FORWARDED_FOR');
                else if(getenv('HTTP_FORWARDED'))
                   $ipaddress = getenv('HTTP_FORWARDED');
                else if(getenv('REMOTE_ADDR'))
                    $ipaddress = getenv('REMOTE_ADDR');
                else
                    $ipaddress = 'UNKNOWN';
                return $ipaddress;
            }
            
            if(isset($_POST['email']))
            {
              $email = $_POST['email'];
            }
            else{
              $email = "Email not provided.";
            }
            if(isset($_POST['file']))
            {
              $file = $_POST['file'];
            }
            if(isset($_POST['page']))
            {
              $page = $_POST['page'];
            }
            
            if(isset($_POST['title']))
            {
              $title = $_POST['title'];
            }
            
            $ipAddress = get_client_ip();
            
            $txt = $email.",".$file.",".$title.",".$page.",".gmdate("Y-m-d\TH:i:s\Z").",".$ipAddress;

            Log::useFiles(storage_path().'/logs/emails.log');
            Log::info($txt);


           
        }
}