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
        // DB::table('unit_types')->truncate();
        // DB::table('buildings')->truncate();
        // DB::table('phases')->truncate();
        // DB::table('projects')->truncate();
        
        $data = json_decode(file_get_contents(resource_path('units.json')), true);

        // $projects = collect($data)->pluck('Project')->unique();
        // $phases = collect($data)->pluck('Phase')->unique();
        // $types = collect($data)->pluck('Type')->unique();
        // $buildings = collect($data)->pluck('Building')->unique();


        // // Insert distinct Project
        // foreach ($projects as $project) {
        //     DB::table('projects')->insert([
        //         'name' => $project,
        //     ]);
        // }

        // // Insert distinct phases
        // foreach ($phases as $phase) {
        //     DB::table('phases')->insert([
        //         'name' => $phase,
        //     ]);
        // }

        // // Insert distinct types
        // foreach ($types as $type) {
        //     DB::table('unit_types')->insert([
        //         'name' => $type,
        //     ]);
        // }

        // // Insert distinct buildings
        // foreach ($buildings as $building) {
        //     DB::table('buildings')->insert([
        //         'name' => $building,
        //     ]);
        // }

        // Insert units with foreign key references
        foreach ($data as $unit) {
            $phaseId = DB::table('phases')->where('name', $unit['Phase'])->first()->id;
            $typeId = DB::table('unit_types')->where('name', $unit['Type'])->first()->id;
            $buildingId = DB::table('buildings')->where('name', $unit['Building'])->first()->id ?? null; // Handle empty building value

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