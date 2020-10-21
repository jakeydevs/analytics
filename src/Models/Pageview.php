<?php

namespace Jakeydevs\Analytics\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pageview extends Model
{
    use HasFactory;

    /** @var Array */
    public $guarded = [];

    protected static function newFactory()
    {
        return new PageviewFactory;
    }
}
