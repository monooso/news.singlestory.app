<?php

namespace App\Constants;

abstract class EmailSchedule
{
    const DAILY = 'daily';
    const NEVER = 'never';
    const WEEKLY = 'weekly';

    /**
     * Returns an array of the available schedules.
     *
     * @return array
     */
    public static function all(): array
    {
        return [static::DAILY, static::NEVER, static::WEEKLY];
    }
}
