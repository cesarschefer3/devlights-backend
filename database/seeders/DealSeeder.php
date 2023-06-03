<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(base_path('deals.json'));
        $deals = json_decode($json, true, 512, JSON_OBJECT_AS_ARRAY);

        foreach ($deals as $deal) {
            DB::table('deals')->insert($deal);
        }

    }
}
