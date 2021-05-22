<?php

namespace App\Console\Commands;

use DB;
use Settings;
use Log;
use Illuminate\Console\Command;
use App\Models\Character\Character;

class ChangeFeature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-feature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes current featured character.';

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
     * @return mixed
     */
    public function handle()
    {
        $characterCount = Character::count();
        $setting = DB::table('site_settings')->where('key', 'featured_character')->get();
        //
        if($characterCount && $setting) {
            $id = mt_rand(1, $characterCount);
            //
            if($id == $setting->value) {
                $id = $id + mt_rand(-5, 5);
            }
            Log::debug('test');
            DB::table('site_settings')->where('key', 'featured_character')->update(['value' => $id]);
        }
    }
}
