<?php
namespace App\Services;

use App\Exceptions\LinkNotFoundException;
use App\Helpers\LinkHelper;
use App\Models\Link;

class ShortLinkService
{
    private $link;
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function store($request)
    {
        $hasCustomEnding = isset($request->custom);

        $shortUrl = $hasCustomEnding ? $request->custom : LinkHelper::findEndingUrlKey();

        if($hasCustomEnding) {
            LinkHelper::checkIfCustomLinkExists($request->custom);
        }

        $link = $this->link->create([
            'short_url' => $shortUrl,
            'long_url' => $request->url,
            'ip' => $request->ip(),
            'custom' => $hasCustomEnding,
            'user_id' => 1
        ]);

        return $link;
    }

    public function getShortLink($shortUrl)
    {
        $link = $this->link->where('short_url', $shortUrl)->first();

        if(!$link) {
            throw new LinkNotFoundException('link not found!');
        }

        $link->update([
            'clicks' => $link->clicks + 1
        ]);

        return $link->long_url;
    }
}