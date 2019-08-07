<?php

namespace ProbablyRational\ReverseProxy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function handle(Request $request)
    {
        $url = config('reverseproxy.forward_url');
        if(is_null($url)){
            return response()->json(['error' => 'Please make sure REVERSE_PROXY_FORWARD_URL is set in .env'], 500);
        }

        $client = new \GuzzleHttp\Client();
        $method = strtolower($request->method());

        $headers = $request->header();

        unset($headers['host']);

        $params = [
            'query' => $_GET,
            'headers' => $headers,
            'http_errors' => false
        ];

        if($request->method() == 'POST' || $request->method() == 'PUT'){
            $params['form_params'] = $_POST;
        }
        
        $response = $client->$method($url, $params);

        return response($response->getBody(), $response->getStatusCode())->withHeaders($response->getHeaders());
    }
}