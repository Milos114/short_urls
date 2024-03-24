<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueUrlRule implements ValidationRule
{
    public function __construct(private $longUrl)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $url = DB::table('urls')->where('long_url', $this->longUrl)->first();

        if ($url) {
            $fail('The Short Url already exists: '. $url->short_url);
        }
    }
}
