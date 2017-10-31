<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use SaneRefresh;

    protected $fillable = [
        'abstract',
        'byline',
        'external_id',
        'period',
        'popularity',
        'title',
        'url',
    ];

    protected $dates = ['retrieved_at'];

    public $timestamps = false;
}
