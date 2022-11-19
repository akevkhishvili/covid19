<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_statistics()
    {

        $response = Http::asForm()->post('https://devtest.ge/get-country-statistics', [
            'code' => "GE",
        ])->collect();

        $this->assertEquals('Georgia',$response['country']);
    }

    public function test_country_list()
    {
        $response = Http::get('https://devtest.ge/countries');

        $this->assertJson($response);
    }
}
