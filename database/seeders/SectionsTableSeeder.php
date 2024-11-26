<?php
namespace Database\Seeders;

use App\Models\MyClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
{
    public function run()
    {
        // Truncate the sections table before seeding
        DB::table('sections')->truncate();

        // Get all class IDs
        $classIds = MyClass::pluck('id')->all();

        // Define simplified Jamaican class sections with letters
        $data = [
            ['name' => 'A', 'my_class_id' => $classIds[0], 'active' => 1],
            ['name' => 'B', 'my_class_id' => $classIds[1], 'active' => 1],
            ['name' => 'C', 'my_class_id' => $classIds[2], 'active' => 1],
            ['name' => 'D', 'my_class_id' => $classIds[3], 'active' => 1],
            ['name' => 'E', 'my_class_id' => $classIds[4], 'active' => 1],
        ];

        // Insert the data into the sections table
        DB::table('sections')->insert($data);
    }
}
