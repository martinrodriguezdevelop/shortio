<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortLinkStoreRequest;
use App\Services\ShortLinkService;
use Throwable;

class ShortenLinkController extends Controller
{
    protected $service;
    public function __construct(ShortLinkService $service)
    {
        $this->service = $service;
    }

    public function store(ShortLinkStoreRequest $request)
    {
        try {
            $link = $this->service->store($request);
            return response()->json($link, 200);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage() ], 400);
        }
    }
}
