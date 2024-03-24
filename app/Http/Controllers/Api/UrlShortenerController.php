<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlRequest;
use App\Models\Url;
use App\Services\GoogleSafeBrowsingApiService;
use App\Services\UniqueUrlService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UrlShortenerController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => Url::all()]);
    }

    /**
     * @throws ValidationException
     */
    public function store(UrlRequest $request, UniqueUrlService $uniqueUrlService, GoogleSafeBrowsingApiService $googleService): JsonResponse
    {
        $isSafeCheckEnabled = $request->get('safe_check')
            && $googleService->handle($request->get('url')) !== [];

        if ($isSafeCheckEnabled) {
            throw ValidationException::withMessages([
                'malware_url' => 'Unsafe URL detected!',
            ]);
        }

        $hash = $uniqueUrlService->handle();

        $url = Url::create([
            'long_url' => $request->get('url'),
            'short_url' => url('') . '/url/' . $hash,
            'hash' => $hash
        ]);

        return response()->json(['data' => $url]);
    }

    public function delete(Url $url): \Illuminate\Http\Response|ResponseFactory
    {
        $url->delete();

        return response(Response::HTTP_NO_CONTENT);
    }
}
