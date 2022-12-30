<?php

namespace App\Http\Controllers;

use App\Services\ShortLinkService;
use Throwable;

class LinkController extends Controller
{
    protected $service;
    public function __construct(ShortLinkService $service)
    {
        $this->service = $service;
    }

    public function show($shortUrl)
    {
        try {
            $longUrl = $this->service->getShortLink($shortUrl);
            return redirect()->to($longUrl, 301);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

    }
}
