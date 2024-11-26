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

        // Fetch all class type ids from the ClassType model
        $ct = ClassType::pluck('id')->all();

        // Define the subject names and their corresponding class type IDs
        $data = [
            // Lower Forms (F1, F2, F3)
            ['name' => 'Mathematics', 'class_type_id' => $ct[0]],  // First Form (F1)
            ['name' => 'English Language', 'class_type_id' => $ct[0]], // First Form (F1)
            ['name' => 'Social Studies', 'class_type_id' => $ct[1]],  // Second Form (F2)
            ['name' => 'Geography', 'class_type_id' => $ct[1]],       // Second Form (F2)
            ['name' => 'History', 'class_type_id' => $ct[2]],         // Third Form (F3)
            ['name' => 'Science', 'class_type_id' => $ct[2]],         // Third Form (F3)
            
            // Upper Forms (F4, F5)
            ['name' => 'Physics', 'class_type_id' => $ct[3]],         // Fourth Form (F4)
            ['name' => 'Chemistry', 'class_type_id' => $ct[3]],       // Fourth Form (F4)
            ['name' => 'Biology', 'class_type_id' => $ct[4]],         // Fifth Form (F5)
            ['name' => 'Principles of Business (POB)', 'class_type_id' => $ct[4]],  // Fifth Form (F5)
            ['name' => 'Accounting', 'class_type_id' => $ct[4]],      // Fifth Form (F5)
            ['name' => 'Economics', 'class_type_id' => $ct[4]],       // Fifth Form (F5)
            
            // Sixth Form (LS and US)
            ['name' => 'Caribbean Studies', 'class_type_id' => $ct[5]], // Lower Six (LS)
            ['name' => 'Information Technology (IT)', 'class_type_id' => $ct[5]], // Lower Six (LS)
            ['name' => 'Spanish', 'class_type_id' => $ct[5]],        // Lower Six (LS)
            ['name' => 'French', 'class_type_id' => $ct[5]],         // Lower Six (LS)
            ['name' => 'Building Technology', 'class_type_id' => $ct[5]],  // Lower Six (LS)
            ['name' => 'Visual Arts', 'class_type_id' => $ct[5]],      // Lower Six (LS)
            ['name' => 'Music', 'class_type_id' => $ct[5]],           // Lower Six (LS)
            ['name' => 'Physics', 'class_type_id' => $ct[6]],         // Upper Six (US)
            ['name' => 'Chemistry', 'class_type_id' => $ct[6]],       // Upper Six (US)
            ['name' => 'Biology', 'class_type_id' => $ct[6]],         // Upper Six (US)
            ['name' => 'Mathematics', 'class_type_id' => $ct[6]],     // Upper Six (US)
        ];

        // Insert subjects into the database
        DB::table('my_classes')->insert($data);
    }
}
