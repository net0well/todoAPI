<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IpController extends Controller
{
    
    public function getIp(Request $request)
    {
        
        $request->validate([
            'Ip' => 'required|ip',
        ]);

        $ip = $request->input('Ip');

        $url = 'http://api.ipinfo.io/lite/'.$ip.'?token='.env('IP_TOKEN');

        $response = Http::get($url);

        if($response->successful()) {
            $data = $response->json();
            return response()->json([
                'ip' => $ip,
                'as_name' => $data['as_name'] ?? null,
                'as_domain' => $data['as_domain'] ?? null,
                'country_code' => $data['country_code'] ?? null,
                'country' => $data['country'] ?? null,
                'continent' => $data['continent'] ?? null
            ]);
        }
        return response()->json(['error' => 'Unable to retrieve IP information'], 500);
    }
    
}
