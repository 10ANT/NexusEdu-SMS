<?php
namespace Database\Seeders;


use App\Models\Parish;
use Illuminate\Database\Seeder;

class ParishesTableSeeder extends Seeder
{
    public function run()
    {
        // Truncate the table to clear any existing records (safer and more efficient than delete())
        Parish::truncate();

        // List of Jamaican Parishes
        $parishes = [
            "Kingston",
            "Saint Andrew",
            "Saint Thomas",
            "Portland",
            "Saint Mary",
            "Saint Ann",
            "Trelawny",
            "Saint James",
            "Hanover",
            "Westmoreland",
            "Saint Elizabeth",
            "Manchester",
            "Clarendon",
            "Saint Catherine",
            "Surrey",
            "Middlesex",
            "Cornwall"
        ];

        // Insert parishes into the parishes table
        foreach ($parishes as $parish) {
            Parish::create([  // Use the Parish model to insert the records
                'name' => $parish,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
