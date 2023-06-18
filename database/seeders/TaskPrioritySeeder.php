<?php

namespace Database\Seeders;

use App\Models\TaskPriority;
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
            [ "value"=> "Urgent" ,"description"=>"Urgent", 'user_id'=>1, "color"=>"error"],
            [ "value"=> "High" ,"description"=>"High", 'user_id'=>1, "color"=>"warning"],
            [ "value"=> "Midium" ,"description"=>"Midium", 'user_id'=>1, "color"=>"info"],
            [ "value"=> "Low" ,"description"=>"Low", 'user_id'=>1, "color"=>"success"]
        ];
        foreach ($records as $record) {
            TaskPriority::create($record);
        }
    }
}
