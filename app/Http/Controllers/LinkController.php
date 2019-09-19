<?php

namespace App\Http\Controllers;

use App\Exceptions\LinkExpiredException;
use App\Exceptions\LinkGoneException;
use App\Link;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{
    /**
     * Save links
     */
    public function store(): void
    {
        Link::create(request(['long_url', 'short_tag', 'expiration_date', 'hits']));
    }

    /**
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

        if ($link->expiration_date < now()->format('Y-m-d H:i:s')) {
            throw new LinkExpiredException('Link expired!');
        }

        $link->update(['hits' => $link->hits + 1]);

        return redirect($link->long_url);
    }
}
