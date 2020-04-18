<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use stdClass;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Assets that the given times are with X seconds of each other.
     *
     * @param Carbon $expected
     * @param Carbon $actual
     * @param int    $seconds
     */
    protected function assertTimeWithin(
        Carbon $expected,
        Carbon $actual,
        int $seconds
    ) {
        $message = sprintf(
            'Expected time difference to be less than %d seconds',
            $seconds
        );

        $this->assertEqualsWithDelta($expected, $actual, $seconds, $message);
    }

    /**
     * Converts the given array into a stdClass instance.
     *
     * @param array $input
     *
     * @return stdClass
     */
    protected function objectify(array $input): stdClass
    {
        return (object)$input;
    }
}
