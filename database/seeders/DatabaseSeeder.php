<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Country;
use Artisan;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name'=>'admin',
            'email'=>'admin@example.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('admin')
        ]);

        $countries = Http::get('https://devtest.ge/countries')->collect();

        foreach($countries as $country){
            Country::create([
                'code'=>$country['code'],
                'name'=>json_encode($country['name'])
            ]);
        }

        Artisan::call('statistics:update');
    }
}
