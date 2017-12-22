<?php

namespace App\Console;

use App\Constants\NewsSource;
use App\Jobs\FetchDailyNews;
use App\Jobs\FetchWeeklyNews;
use App\Jobs\SendDailyStory;
use App\Jobs\SendWeeklyStory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        foreach (NewsSource::all() as $source) {
            $schedule->job(new FetchWeeklyNews($source))
                ->weekly()
                ->saturdays()
                ->at('01:00')
                ->timezone('America/New_York');

            $schedule->job(new FetchDailyNews($source))
                ->dailyAt('02:00')
                ->timezone('America/New_York');
        }

        $schedule->job(SendWeeklyStory::class)
            ->weekly()
            ->saturdays()
            ->at('04:00')
            ->timezone('America/New_York');

        $schedule->job(SendDailyStory::class)
            ->dailyAt('05:00')
            ->timezone('America/New_York');
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
