<?php

namespace Database\Seeders;

use App\Models\TaskPrioritys;
use Illuminate\Database\Seeder;

class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [ "value"=> "Urgent" ,"description"=>"Urgent", 'user_id'=>1],
            [ "value"=> "High" ,"description"=>"High", 'user_id'=>1],
            [ "value"=> "Midium" ,"description"=>"Midium", 'user_id'=>1],
            [ "value"=> "Low" ,"description"=>"Low", 'user_id'=>1]
        ];
        foreach ($records as $record) {
            TaskPrioritys::create($record);
        }
    }
}
