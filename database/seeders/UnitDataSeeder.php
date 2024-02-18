<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UnitDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit_details')->truncate();

        $data = json_decode(file_get_contents(resource_path('units.json')), true);

        // Insert units with foreign key references
        foreach ($data as $unit) {
            // $phaseId = DB::table('phases')->where('name', $unit['Phase'])->first()->id;
            // $typeId = DB::table('unit_types')->where('name', $unit['Type'])->first()->id;
            // $buildingId = DB::table('buildings')->where('name', $unit['Building'])->first()->id ?? null; // Handle empty building value

            DB::table('unit_details')->insert([
                'unit_name' => $unit['Unit No'],
                'project_id' => $unit['Project'], // Assuming project ID is known, replace with actual logic
                'phase_id' => $unit['Phase'],
                'type_id' => $unit['Type'],
                'building_id' => $unit['Building'],
            ]);
        }
    }
}
