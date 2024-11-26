<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_types')->delete();

        $data = [
            ['name' => 'First Form', 'code' => 'F1'],
            ['name' => 'Second Form', 'code' => 'F2'],
            ['name' => 'Third Form', 'code' => 'F3'],
            ['name' => 'Fourth Form', 'code' => 'F4'],
            ['name' => 'Fifth Form', 'code' => 'F5'],
            ['name' => 'Lower Six', 'code' => 'LS'],
            ['name' => 'Upper Six', 'code' => 'US'],
        ];

        DB::table('class_types')->insert($data);
    }
}
