<?php

namespace App\Constants;

abstract class NewsSource
{
    const ABC_NEWS = 'abc-news';
    const NY_TIMES = 'the-new-york-times';
    const AL_JAZEERA = 'al-jazeera-english';
    const ASSOCIATED_PRESS = 'associated-press';
    const BBC_NEWS = 'bbc-news';
    const BREITBART_NEWS = 'breitbart-news';
    const CBS_NEWS = 'cbs-news';
    const CNBC = 'cnbc';
    const CNN = 'cnn';
    const DAILY_MAIL = 'daily-mail';
    const FINANCIAL_TIMES = 'financial-times';
    const FOX_NEWS = 'fox-news';
    const GOOGLE_NEWS = 'google-news';
    const INDEPENDENT = 'independent';
    const METRO = 'metro';
    const MIRROR = 'mirror';
    const MSNBC = 'MSNBC';
    const NBC_NEWS = 'nbc-news';
    const NEWSWEEK = 'newsweek';
    const NEW_YORK_MAGAZINE = 'new-york-magazine';
    const POLITICO = 'politico';
    const REUTERS = 'reuters';
    const THE_ECONOMIST = 'the-economist';
    const THE_GUARDIAN_AU = 'the-guardian-au';
    const THE_GUARDIAN_UK = 'the-guardian-uk';
    const THE_HILL = 'the-hill';
    const THE_HUFFINGTON_POST = 'the-huffington-post';
    const THE_TELEGRAPH = 'the-telegraph';
    const THE_WALL_STREET_JOURNAL = 'the-wall-street-journal';
    const THE_WASHINGTON_POST = 'the-washington-post';
    const TIME = 'time';
    const USA_TODAY = 'usa-today';

    /**
     * Return an array of the available news sources.
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            static::ABC_NEWS,
            static::NY_TIMES,
            static::AL_JAZEERA,
            static::ASSOCIATED_PRESS,
            static::BBC_NEWS,
            static::BREITBART_NEWS,
            static::CBS_NEWS,
            static::CNBC,
            static::CNN,
            static::DAILY_MAIL,
            static::FINANCIAL_TIMES,
            static::FOX_NEWS,
            static::GOOGLE_NEWS,
            static::INDEPENDENT,
            static::METRO,
            static::MIRROR,
            static::MSNBC,
            static::NBC_NEWS,
            static::NEWSWEEK,
            static::NEW_YORK_MAGAZINE,
            static::POLITICO,
            static::REUTERS,
            static::THE_ECONOMIST,
            static::THE_GUARDIAN_AU,
            static::THE_GUARDIAN_UK,
            static::THE_HILL,
            static::THE_HUFFINGTON_POST,
            static::THE_TELEGRAPH,
            static::THE_WALL_STREET_JOURNAL,
            static::THE_WASHINGTON_POST,
            static::TIME,
            static::USA_TODAY,
        ];
    }
}
