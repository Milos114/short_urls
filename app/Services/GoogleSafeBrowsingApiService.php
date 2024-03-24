<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class GoogleSafeBrowsingApiService
{
    /**
     * @throws Exception
     */
    public function handle(string $url)
    {
        $response = Http::post('https://safebrowsing.googleapis.com/v4/threatMatches:find?key='.config('services.google.api_key'),
            [
                'client' => [
                    'clientId' => 'Test Company Name',
                    'clientVersion' => '1.5.2',
                ],
                'threatInfo' => [
                    'threatTypes' =>
                        ["MALWARE", "SOCIAL_ENGINEERING"]
                    ,
                    'platformTypes' =>
                        ['WINDOWS']
                    ,
                    'threatEntryTypes' =>
                        ['URL']
                    ,
                    'threatEntries' => [
                        ['url' => $url]
                    ]
                ]
            ]
        );

        if ($response->json('error.code') === 400) {
            throw new Exception($response->json('error.message'));
        }

        return $response->json();
    }
}
