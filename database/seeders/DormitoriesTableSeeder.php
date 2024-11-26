<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DormitoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dormitories')->delete();
        $data = [
            ['name' => 'Powell Dorm'],
            ['name' => 'Blake Dorm'],
            ['name' => 'Hutchinson Residence Dorm'],
            ['name' => 'White Dorm'],
            ['name' => 'Wright Dorm'],
        ];
        DB::table('dormitories')->insert($data);
    }
}
