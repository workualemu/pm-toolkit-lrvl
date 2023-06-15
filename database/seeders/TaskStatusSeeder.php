<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [ "value"=> "Not started" ,"description"=>"Not started", 'user_id'=>1, 'kanban_list_id'=>1],
            [ "value"=> "Pending" ,"description"=>"Pending", 'user_id'=>1, 'kanban_list_id'=>1],
            [ "value"=> "In progress" ,"description"=>"In progress", 'user_id'=>1, 'kanban_list_id'=>2],
            [ "value"=> "Reopened" ,"description"=>"Reopened", 'user_id'=>1, 'kanban_list_id'=>2],
            [ "value"=> "Submitted" ,"description"=>"Submitted", 'user_id'=>1, 'kanban_list_id'=>3],
            [ "value"=> "Completed" ,"description"=>"Completed", 'user_id'=>1, 'kanban_list_id'=>4],
            [ "value"=> "Archived" ,"description"=>"Archived", 'user_id'=>1, 'kanban_list_id'=>5]
        ];

        foreach ($records as $record) {
            TaskStatus::create($record);
        }
    }
}
