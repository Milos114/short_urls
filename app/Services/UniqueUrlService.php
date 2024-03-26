<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Str;

class UniqueUrlService
{
    public function handle(): string
    {
        do {
            $hash = 'Str::random(6)';
        } while (in_array($hash, Url::pluck('hash')->all(), true));

        return $hash;
    }
}
