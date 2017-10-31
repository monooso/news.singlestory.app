<?php

namespace App\Models;

use App\Constants\NewsWindow;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use SaneRefresh;

    public $timestamps = false;

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

    /**
     * Return this week's article.
     *
     * @return Article
     */
    public static function thisWeek(): Article
    {
        return Article::whereDate('retrieved_at', '>', Carbon::now()->subWeek())
            ->where('period', NewsWindow::WEEK)
            ->orderBy('popularity', 'desc')
            ->first();
    }

    /**
     * Return today's articles.
     *
     * @return Article
     */
    public static function today(): Article
    {
        return Article::whereDate('retrieved_at', Carbon::now()->toDateString())
            ->where('period', NewsWindow::DAY)
            ->orderBy('popularity', 'desc')
            ->first();
    }
}
