<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Statistics;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GetCovid19Statistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will get statistics from https://devtest.ge/get-country-statistics';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $countries = Country::all();

        try {
            foreach ($countries as $country) {

                $response = Http::asForm()->post('https://devtest.ge/get-country-statistics', [
                    'code' => $country->code,
                ])->collect();

                $todayRecord = Statistics::query()
                    ->whereDate('created_at', Carbon::parse($response['created_at'])->today())
                    ->where('country_id', $country->id,)
                    ->first();
                if ($todayRecord) {
                    $todayRecord->update([
                        'confirmed' => $response['confirmed'],
                        'recovered' => $response['recovered'],
                        'death' => $response['deaths'],
                    ]);
                } else {
                    Statistics::create([
                        'country_id' => $country->id,
                        'confirmed' => $response['confirmed'],
                        'recovered' => $response['recovered'],
                        'death' => $response['deaths'],
                    ]);
                }
            }
        } catch (Throwable $e) {

            Log::error($e->getMessage());

            return "table updated failed with message: " . $e->getMessage();
        }

        Log::info("covid table updated!");

        return "covid19 table updated!";
    }
}
