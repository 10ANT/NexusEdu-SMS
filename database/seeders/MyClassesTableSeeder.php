<?php

namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MyClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete all existing records from the my_classes table
        DB::table('my_classes')->delete();

        // Fetch all class type ids
        $ct = ClassType::pluck('id')->all();

        // Define the classes grouped by type and physical location
        $data = [
            // First Form (F1) -> Alpha
            ['name' => 'Alpha 1', 'class_type_id' => $ct[0]],
            ['name' => 'Alpha 2', 'class_type_id' => $ct[0]],
            ['name' => 'Alpha 3', 'class_type_id' => $ct[0]],
            
            // Second Form (F2) -> Beta
            ['name' => 'Beta 1', 'class_type_id' => $ct[1]],
            ['name' => 'Beta 2', 'class_type_id' => $ct[1]],
            ['name' => 'Beta 3', 'class_type_id' => $ct[1]],
            
            // Third Form (F3) -> Sigma
            ['name' => 'Sigma 1', 'class_type_id' => $ct[2]],
            ['name' => 'Sigma 2', 'class_type_id' => $ct[2]],
            ['name' => 'Sigma 3', 'class_type_id' => $ct[2]],
            
            // Fourth Form (F4) -> Delta
            ['name' => 'Delta 1', 'class_type_id' => $ct[3]],
            ['name' => 'Delta 2', 'class_type_id' => $ct[3]],
            ['name' => 'Delta 3', 'class_type_id' => $ct[3]],
            
            // Fifth Form (F5) -> Epsilon
            ['name' => 'Epsilon 1', 'class_type_id' => $ct[4]],
            ['name' => 'Epsilon 2', 'class_type_id' => $ct[4]],
            ['name' => 'Epsilon 3', 'class_type_id' => $ct[4]],
            
            // Lower Six (LS) -> Zeta
            ['name' => 'Zeta 1', 'class_type_id' => $ct[5]],  // Lower Six (LS)
            ['name' => 'Zeta 2', 'class_type_id' => $ct[5]],  // Lower Six (LS)
            ['name' => 'Zeta 3', 'class_type_id' => $ct[5]],  // Lower Six (LS)
            
            // Upper Six (US) -> Theta
            ['name' => 'Theta 1', 'class_type_id' => $ct[6]],  // Upper Six (US)
            ['name' => 'Theta 2', 'class_type_id' => $ct[6]],  // Upper Six (US)
            ['name' => 'Theta 3', 'class_type_id' => $ct[6]],  // Upper Six (US)
        ];

        // Insert data into the database
        DB::table('my_classes')->insert($data);
    }
}
