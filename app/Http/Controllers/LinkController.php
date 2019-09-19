<?php

namespace App\Http\Controllers;

use App\Exceptions\LinkExpiredException;
use App\Exceptions\LinkGoneException;
use App\Link;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{

    /**
     * Store a link and generate short tag
     * @return string
     */
    public function store(): string
    {
        request()->validate(['long_url' => 'required', 'short_tag' => 'unique:links']);

        $link = Link::create(request(['long_url', 'short_tag', 'expiration_date']));

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

        $link->update(['hits' => $link->hits + 1]);

        return redirect($link->long_url);
    }
}
