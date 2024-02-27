<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->truncate();

        $data = json_decode(file_get_contents(resource_path('countries.json')), true);

        // Insert units with foreign key references
        foreach ($data as $country) {
            DB::table('countries')->insert([
                'name' => $country,
            ]);
        }
    }
}
