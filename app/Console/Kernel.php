<?php

namespace App\Console;

use App\Jobs\FetchDailyNews;
use App\Jobs\FetchWeeklyNews;
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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(FetchWeeklyNews::class)
            ->weekly()
            ->saturdays()
            ->at('01:00')
            ->timezone('America/New_York');
        
        $schedule->job(FetchDailyNews::class)
            ->dailyAt('02:00')
            ->timezone('America/New_York');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
