<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $divisions = [
            'Mobile Apps',
            'QA',
            'Full Stack',
            'Backend',
            'Frontend',
            'UI/UX Designer',
        ];

        foreach ($divisions as $division) {
            Division::create([
                'name' => $division,
            ]);
        }
    }
}
