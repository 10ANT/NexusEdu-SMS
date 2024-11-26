<?php
namespace Database\Seeders;

use App\Models\MyClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks to avoid constraint violations
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the sections table before seeding
        DB::table('sections')->truncate();

        // Get all class IDs
        $classIds = MyClass::pluck('id')->all();

        // Define simplified Jamaican class sections with letters
        $data = [
            ['name' => 'A', 'my_class_id' => $classIds[0], 'active' => 1, 'teacher_id' => null], // Set teacher_id to null if not needed
            ['name' => 'B', 'my_class_id' => $classIds[1], 'active' => 1, 'teacher_id' => null],
            ['name' => 'C', 'my_class_id' => $classIds[2], 'active' => 1, 'teacher_id' => null],
            ['name' => 'D', 'my_class_id' => $classIds[3], 'active' => 1, 'teacher_id' => null],
            ['name' => 'E', 'my_class_id' => $classIds[4], 'active' => 1, 'teacher_id' => null],
        ];

        // Insert the data into the sections table
        DB::table('sections')->insert($data);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
