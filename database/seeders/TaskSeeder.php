<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $header = true;

        if (($handle = fopen(database_path("seeders/task.csv"), "r")) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($header) {
                    $header = false;

                    continue;
                }

                Task::updateOrCreate([
                    'uuid' => md5(data_get($data, '0') . data_get($data, '1')),
                    'name' => data_get($data, '1'),
                    'done' => data_get($data, '2'),
                ]);
            }

            fclose($handle);
        }
    }
}
