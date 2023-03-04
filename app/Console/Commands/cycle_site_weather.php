<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Settings;
use DB;
use App\Models\Weather\WeatherSeason;
use App\Models\Weather\Weather;
use App\Models\Weather\WeatherTable;

class cycle_site_weather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cycle-site-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cycles the site\'s weather.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentweather = Weather::where('id', Settings::get('site_weather'))->first();
        $currentseason = WeatherSeason::where('id', Settings::get('site_season'))->first();

        if(Settings::get('site_weather') == 1) {
            $results = [];
            for ($i = 0; $i < 1; $i++)
                $results[] = $currentseason->roll();
                $neweath = $results->id;
            DB::table('site_settings')->where('key', 'site_weather')->update(['value' => $neweath]);
        }
        

    }
}
