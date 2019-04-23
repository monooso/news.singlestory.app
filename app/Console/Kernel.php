<?php

namespace App\Console;

use App\Constants\NewsSource;
use App\Jobs\DeleteOutdatedArticles;
use App\Jobs\FetchDailyNews;
use App\Jobs\FetchWeeklyNews;
use App\Jobs\SendDailyStory;
use App\Jobs\SendWeeklyStory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected const TIMEZONE = 'America/New_York';

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        foreach (NewsSource::all() as $source) {
            $this->fetchWeeklyNews($schedule, $source);
            $this->fetchDailyNews($schedule, $source);
        }

        $this->sendWeeklyStory($schedule);
        $this->sendDailyStory($schedule);

        $this->deleteOutdatedArticles($schedule);
    }

    protected function fetchWeeklyNews(Schedule $schedule, string $source)
    {
        $schedule->job(new FetchWeeklyNews($source))
            ->weekly()
            ->saturdays()
            ->at('01:00')
            ->timezone(static::TIMEZONE);
    }

    protected function fetchDailyNews(Schedule $schedule, string $source)
    {
        $schedule->job(new FetchDailyNews($source))->dailyAt('02:00')->timezone(static::TIMEZONE);
    }

    protected function sendWeeklyStory(Schedule $schedule)
    {
        $schedule->job(SendWeeklyStory::class)
            ->weekly()
            ->saturdays()
            ->at('04:00')
            ->timezone(static::TIMEZONE);
    }

    protected function sendDailyStory(Schedule $schedule)
    {
        $schedule->job(SendDailyStory::class)->dailyAt('05:00')->timezone(static::TIMEZONE);
    }

    protected function deleteOutdatedArticles(Schedule $schedule)
    {
        $schedule->job(DeleteOutdatedArticles::class)->dailyAt('10:00')->timezone(static::TIMEZONE);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
