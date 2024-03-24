<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Str;

class UniqueUrlService
{
    public function handle(): string
    {
        $stringAppends = Url::pluck('short_url')->map(function ($url) {
            $array = explode('/', $url);
            return end($array);
        })->all();

        $randomString = Str::random(6);

        if (in_array($randomString, $stringAppends, true)) {
            $this->handle();
        }

        return $randomString;
    }
}
