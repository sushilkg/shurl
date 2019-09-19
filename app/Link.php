<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Link extends Model
{
    use SoftDeletes;

    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'short_tag';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($link) {
            if (empty($link->short_tag)) {
                $link->short_tag = Str::random(7);
                while (Link::where(['short_tag' => $link->short_tag])->exists()) {
                    $link->short_tag = Str::random(7);
                }
            }
        });
    }
}
