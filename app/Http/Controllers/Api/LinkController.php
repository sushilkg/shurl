<?php

namespace App\Http\Controllers;

use App\Exceptions\LinkExpiredException;
use App\Exceptions\LinkGoneException;
use App\Link;
use App\Rules\BlacklistedUrls;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{

    /**
     * Store a link and generate short tag
     * @return string
     */
    public function store(): string
    {
        request()->validate([
            'long_url' => ['required', new BlacklistedUrls()],
            'short_tag' => 'unique:links'
        ]);

        $expiration_date = null;
        if (!empty(request('expiration_date'))) {
            $expiration_date = date('Y-m-d H:i:s', strtotime(request('expiration_date')));
        }

        $link = Link::create([
            'long_url' => request('long_url'),
            'short_tag' => request('short_tag'),
            'expiration_date' => $expiration_date,

        ]);

        return $link;
    }

    /**
     * Fetch and redirect short tag to long url
     * @param $short_tag
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws LinkExpiredException
     * @throws LinkGoneException
     */
    public function get($short_tag)
    {
        $link = Link::withTrashed()->where('short_tag', $short_tag)->first();

        if (!$link) {
            throw new NotFoundHttpException('Link not found!');
        }

        if ($link->trashed()) {
            throw new LinkGoneException('Link gone!');
        }

        if ($link->expiration_date !== null && $link->expiration_date < now()->format('Y-m-d H:i:s')) {
            throw new LinkExpiredException('Link expired!');
        }

        $link->increment('hits', 1);

        return redirect($link->long_url);
    }
}
