<?php
namespace App\Helpers;

use App\Exceptions\LinkAlreadyExistsException;
use App\Models\Link;
use Illuminate\Support\Str;

class LinkHelper {

    static public function findEndingUrlKey() {
        $shortLink = '';
        $exists = true;

        while ($exists) {
            $shortLink = Str::random(config('settings.key_length'));
            $exists = Link::where('short_url', $shortLink)->first();
        }

        return $shortLink;
    }

    static public function checkIfCustomLinkExists($customEnding)
    {
        $exists = Link::where('short_url', $customEnding)->first();
        if(!$exists) {
            return;
        }
        throw new LinkAlreadyExistsException('Link already exists!');
    }
}