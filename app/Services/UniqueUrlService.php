<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Str;

class UniqueUrlService
{
    public function handle(): string
    {
        $hash = Str::random(6);

        if (in_array($hash, Url::pluck('hash')->all(), true)) {
            $this->handle();
        }

        return $hash;
    }
}
