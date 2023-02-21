<?php

namespace App\Http\Controllers;

use \Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;


class LoginController extends Controller
{   
    
    function login (Request $request) {
        $inputs = $request->all();
        $email = $inputs['email'];
        $password = $inputs['password'];

        $client = new \GuzzleHttp\Client();
        $jar = new \GuzzleHttp\Cookie\CookieJar;
        $loginres;
        $sdkres;


        try {
            $loginres = $client->post('https://my.caseware.com/api/account/login', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-Requested-With'=>'XMLHttpRequest',
                    ],
                    'json' => [
                        'Email' => $email,
                        'Password' => $password
                    ],
                    'cookies' => $jar,
                    'http_errors' => false
                ]);
            

        } catch (Exception $e){
            return redirect()->back()->withErrors( 'Issue connecting to MyCaseWare server.');
        }

        if($loginres->getStatusCode() == "200") {
            try {
                $sdkres = $client->post('https://my.caseware.com/api/account/sdk', [
                        'headers' => [
                            'Accept' => 'application/json',
                            'X-Requested-With'=>'XMLHttpRequest',
                        ],
                        'cookies' => $jar,
                        'http_errors' => false
                ]);
                $contents = (string) $sdkres->getBody();
                $sdkresBody = json_decode($contents, true);
                $productSdkList =  $myArray = explode(';', $sdkresBody["Products"]);
                if($sdkresBody["Success"] && (in_array("SDK", $productSdkList) || in_array("SherlockApi", $productSdkList) || in_array("Sherlock", $productSdkList))){
                    
                    $request->session()->put('authenticated', true);

                    if(in_array("SDK", $productSdkList)){
                        $request->session()->put('license', 'SDK');
                        
                        $targetUrl = $request->session()->get('targetUrl', '/');

                        // dd($targetUrl);
                        if(gettype($targetUrl) == "string"){
                            if($targetUrl == "/documentation_files/login/undefined/OnlineOutput.xml"){
                                return redirect("/");

                            }
                            else{

                                return redirect($targetUrl);
                            }
                        }
                        else{
                            return redirect('/');
                        }
                    }
                  
                    elseif(in_array("SherlockApi", $productSdkList) && in_array("Sherlock", $productSdkList)) {
                        $request->session()->put('license', 'SherlockApiAndSherlock');
                        return redirect('/');
                    }
                  
                    elseif(in_array("SherlockApi", $productSdkList)) {
                        $request->session()->put('license', 'SherlockApi');
                        return redirect('/');
                    }
                  
                    elseif(in_array("Sherlock", $productSdkList)) {
                          $request->session()->put('license', 'Sherlock');
                          return redirect('/');
                    }
                }
                else {
                    return redirect()->back()->withErrors( 'Your MyCaseWare account does not have an SDK developer license.');  
                }

            } catch (Exception $e){
                return redirect()->back()->withErrors( 'Issue connecting to MyCaseWare server.');
            }
        }
        else {
            return redirect()->back()->withErrors( 'Invalid Credentials');
        }

    }

    function logout (Request $request) {
        $request->session()->forget('targetUrl');
        $request->session()->forget('authenticated');
        $request->session()->forget('license');
        $request->session()->flush();
        return redirect('/login');

    }
}
