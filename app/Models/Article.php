<?php

namespace App\Models;

use App\Constants\NewsWindow;
use App\Exceptions\NoAvailableArticleException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     *
     * @throws NoAvailableArticleException
     */
    public static function thisWeek(): Article
    {
        try {
            $threshold = Carbon::now()->subWeek();

            return Article::whereDate('retrieved_at', '>', $threshold)
                ->where('period', NewsWindow::WEEK)
                ->orderBy('popularity', 'desc')
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new NoAvailableArticleException('There is no article for this week');
        }
    }

    /**
     * Return today's articles.
     *
     * @return Article
     *
     * @throws NoAvailableArticleException
     */
    public static function today(): Article
    {
        try {
            $today = Carbon::now()->toDateString();

            return Article::whereDate('retrieved_at', $today)
                ->where('period', NewsWindow::DAY)
                ->orderBy('popularity', 'desc')
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new NoAvailableArticleException('There is no article for today');
        }
    }
}
