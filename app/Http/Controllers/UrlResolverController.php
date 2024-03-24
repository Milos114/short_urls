<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UrlResolverController extends Controller
{
    public function show($hash): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        $url = Url::whereHash($hash)->first();

        return redirect($url->long_url);
    }
}
