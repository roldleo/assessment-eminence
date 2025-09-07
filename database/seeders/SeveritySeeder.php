<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Severity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SeveritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $severities = [
          [
              'name' => 'Low',
              'color' => '#16A34A',
              'sort_order' => 1,
          ],
          [
              'name' => 'Medium',
              'color' => '#F59E0B',
              'sort_order' => 2,
          ],
          [
              'name' => 'High',
              'color' => '#DC2626',
              'sort_order' => 3,
          ],
      ];
    
      foreach ($severities as $severity) {
          Severity::updateOrCreate(
              ['name' => $severity['name']],
              [
                  'color' => $severity['color'],
                  'sort_order' => $severity['sort_order'],
              ]
          );
      }
    }
}
