<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = Division::all();

        Employee::factory()->count(17)->create([
            'division_id' => fn() => $divisions->random()->id,
        ]);
    }
}
