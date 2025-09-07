<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
          [
              'name' => 'Waiting',
              'sort_order' => 1,
          ],
          [
              'name' => 'In Progress',
              'sort_order' => 2,
          ],
          [
              'name' => 'Pending',
              'sort_order' => 2,
          ],
          [
              'name' => 'Completed',
              'sort_order' => 3,
          ],
          [
              'name' => 'Closed',
              'sort_order' => 4,
          ],
      ];
    
      foreach ($statuses as $status) {
          Status::updateOrCreate(
              ['name' => $status['name']],
              [
                  'sort_order' => $status['sort_order'],
              ]
          );
      }
    }
}
