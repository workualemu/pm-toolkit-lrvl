<?php

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [ "value"=> "Phase" ,"description"=>"Phase", 'user_id'=>1],
            [ "value"=> "Activity" ,"description"=>"Activity", 'user_id'=>1],
            [ "value"=> "Task" ,"description"=>"Task", 'user_id'=>1]
        ];
        foreach ($records as $record) {
            TaskType::create($record);
        }
    }
}
