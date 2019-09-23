<?php

namespace App\Constants;

abstract class NewsSource
{
    const ASSOCIATED_PRESS = 'associated-press';
    const BBC_NEWS = 'bbc-news';
    const GOOGLE_NEWS = 'google-news';
    const INDEPENDENT = 'independent';
    const NEW_YORK_MAGAZINE = 'new-york-magazine';
    const NEWSWEEK = 'newsweek';
    const NY_TIMES = 'the-new-york-times';
    const POLITICO = 'politico';
    const REUTERS = 'reuters';
    const THE_HILL = 'the-hill';
    const THE_TELEGRAPH = 'the-telegraph';
    const THE_WALL_STREET_JOURNAL = 'the-wall-street-journal';
    const THE_WASHINGTON_POST = 'the-washington-post';

    /**
     * Return an array of the available news sources.
     *
     * @return array
     */
    public static function all(): array
    {
        return array_sort([
            static::NY_TIMES,
            static::ASSOCIATED_PRESS,
            static::BBC_NEWS,
            static::GOOGLE_NEWS,
            static::INDEPENDENT,
            static::NEWSWEEK,
            static::NEW_YORK_MAGAZINE,
            static::POLITICO,
            static::REUTERS,
            static::THE_HILL,
            static::THE_TELEGRAPH,
            static::THE_WALL_STREET_JOURNAL,
            static::THE_WASHINGTON_POST,
        ]);
    }
}
