<?php

namespace App\Models;

use App\Constants\NewsWindow;
use App\Exceptions\NoAvailableArticleException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
        'source',
        'title',
        'url',
    ];

    protected $dates = ['retrieved_at'];

    /**
     * Return this week's article from the given source.
     *
     * @param string $source
     *
     * @return self
     */
    public static function thisWeek(string $source): self
    {
        try {
            $threshold = Carbon::now()->subWeek()->toDateTimeString();

            return static::where([
                ['period', '=', NewsWindow::WEEK],
                ['retrieved_at', '>', $threshold],
                ['source', '=', $source],
            ])->orderBy('popularity', 'desc')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $message = sprintf('"%s" has no article for this week', $source);
            throw new NoAvailableArticleException($message);
        }
    }

    /**
     * Return "today's" articles from the given source. In reality, we settle
     * for any article retrieved within the past 24 hours.
     *
     * @param string $source
     *
     * @return self
     */
    public static function today(string $source): self
    {
        try {
            $threshold = Carbon::now()->subDay()->toDateTimeString();

            return static::where([
                ['period', '=', NewsWindow::DAY],
                ['retrieved_at', '>', $threshold],
                ['source', '=', $source],
            ])->orderBy('popularity', 'desc')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $message = sprintf('"%s" has no article for today', $source);
            throw new NoAvailableArticleException($message);
        }
    }

    /**
     * Scope to only include articles more than two weeks old
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOutdated(Builder $query): Builder
    {
        return $query->whereDate('retrieved_at', '<', now()->subWeeks(2));
    }
}
