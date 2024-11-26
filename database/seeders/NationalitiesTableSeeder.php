<?php
namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;

class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // List of Caribbean Nationalities
        $caribbeanNationalities = [
            'Antiguan and Barbudan', 'Barbadian', 'Belizean', 'Bahamian', 'Cuban', 'Dominican', 
            'Dominican Republic', 'Grenadian', 'Guyanese', 'Haitian', 'Jamaican', 'Kittian and Nevisian', 
            'Mansion', 'Saint Lucian', 'Saint Vincentian', 'Trinidadian and Tobagonian', 'Surinamese',
            'Aruban', 'Bahamian', 'Caymanian', 'Dutch Antillean', 'Montserratian', 'Turks and Caicos Islander'
        ];

        // Loop through the array and create each nationality in the database
        foreach ($caribbeanNationalities as $nationality) {
            Nationality::create(['name' => $nationality]);
        }
    }
}
