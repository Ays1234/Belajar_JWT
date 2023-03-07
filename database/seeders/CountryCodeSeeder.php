<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CountryCode;
use File;

class CountryCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CountryCode::truncate();
  
        $json = File::get("database/data/countrycodes.json");
        $countries = json_decode($json);
  
        foreach ($countries as $key => $value) {
            CountryCode::create([
                "name" => $value->name,
                "dial_code" => $value->dial_code,
                "code" => $value->code
            ]);
        }
    }
}
