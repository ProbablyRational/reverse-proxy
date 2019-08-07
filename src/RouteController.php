<?php

namespace ProbablyRational\ReverseProxy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RouteController extends Controller
{
    public function handle(Request $request)
    {
        $url = config('reverseproxy.forward_url');
        if(is_null($url)){
            return Response::json(['error' => 'Please make sure REVERSE_PROXY_FORWARD_URL is set in .env'], 500);
        }

        $client = new \GuzzleHttp\Client();

        switch ($request->method()) {
            case 'POST':
                $myBody['name'] = "Demo";
                $request = $client->post($url, ['body'=>$myBody]);
                $response = $request->send();
                break;
            default:
                $request = $client->get($url);
                $response = $request->getBody();
                break;
        }

        dd($response);
    }
}