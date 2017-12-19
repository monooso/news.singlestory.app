<?php

namespace Tests\Unit\News;

use stdClass;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    const NEW_YORK_TIMES = 'nytimes';
    const NEWS_API = 'newsapi';

    /**
     * Returns the dummy News API JSON response data for the given response
     * code.
     *
     * @param int $code
     *
     * @return stdClass
     */
    protected function loadNewsApiResponseJson(int $code): stdClass
    {
        return json_decode($this->loadNewsApiResponseData($code));
    }

    /**
     * Returns the raw dummy News API response data for the given response code.
     *
     * @param int $code
     *
     * @return string
     */
    protected function loadNewsApiResponseData(int $code): string
    {
        return $this->loadResponseData(static::NEWS_API, $code);
    }

    /**
     * Returns the raw dummy response data for the given API and response code.
     *
     * @param string $api
     * @param int    $code
     *
     * @return string
     */
    protected function loadResponseData(string $api, int $code): string
    {
        $filename = sprintf('tests/_data/%s/most-popular-%d.json', $api, $code);

        return file_get_contents(base_path($filename));
    }

    /**
     * Returns the dummy New York Times JSON response data for the given
     * response code.
     *
     * @param int $code
     *
     * @return stdClass
     */
    protected function loadNewYorkTimesResponseJson(int $code): stdClass
    {
        return json_decode($this->loadNewYorkTimesResponseData($code));
    }

    /**
     * Returns the raw dummy New York Times response data for the given
     * response code.
     *
     * @param int $code
     *
     * @return string
     */
    protected function loadNewYorkTimesResponseData(int $code): string
    {
        return $this->loadResponseData(static::NEW_YORK_TIMES, $code);
    }

    /**
     * Returns the dummy JSON response data for the given API and response code.
     *
     * @param string $api
     * @param int    $code
     *
     * @return stdClass
     */
    protected function loadResponseJson(string $api, int $code): stdClass
    {
        return json_decode($this->loadResponseData($api, $code));
    }
}
