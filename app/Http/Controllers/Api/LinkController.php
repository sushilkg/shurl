<?php

namespace App\Http\Controllers;

use App\Exceptions\LinkExpiredException;
use App\Exceptions\LinkGoneException;
use App\Link;
use App\Rules\BlacklistedUrls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{

    public function rules(): array
    {
        return [
            'long_url' => ['required', new BlacklistedUrls()],
            'short_tag' => 'unique:links'
        ];
    }

    /**
     * This method will store the link.
     * @return string
     * 
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->make([
                'errors' => $validator->errors()
            ], 422);
        }

        $expiration_date = request('expiration_date');
        if (!empty($expiration_date)) {
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
