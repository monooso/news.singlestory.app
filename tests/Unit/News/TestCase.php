<?php

namespace Tests\Unit\News;

use stdClass;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Returns the raw dummy response data for the given response code.
     *
     * @param int $code
     *
     * @return string
     */
    protected function loadResponseData(int $code): string
    {
        $filename = base_path('tests/_data/nytimes/most-shared-' . $code . '.json');
        return file_get_contents($filename);
    }

    /**
     * Returns the dummy JSON response data for the given response code.
     *
     * @param int $code
     *
     * @return stdClass
     */
    protected function loadResponseJson(int $code): stdClass
    {
        return json_decode($this->loadResponseData($code));
    }
}
