<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;

    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'short_tag';
    }
}
