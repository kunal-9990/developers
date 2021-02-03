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
                if($sdkresBody["Success"] && in_array("SDK", $productSdkList)){
                    $key = env('AUTH_SECRET');
                    $authToken = JWT::encode(true, $key);
                    $request->session()->put('authenticated', $authToken);
                    $targetUrl = $request->session()->pull('targetUrl', '/');


                    if(gettype($targetUrl) == "string"){
                        return redirect($targetUrl);
                    }
                    else{
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
        $request->session()->forget('authenticated');
        return redirect('/login');

    }
}
