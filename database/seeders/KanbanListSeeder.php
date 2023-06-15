<?php

namespace Database\Seeders;

use App\Models\KanbanList;
use Illuminate\Database\Seeder;

class KanbanListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [ "value"=> "Backlog" ,"description"=>"Backlog", 'user_id'=>1, 'rank'=>1],
            [ "value"=> "In progress" ,"description"=>"In progress", 'user_id'=>1, 'rank'=>2],
            [ "value"=> "Submitted" ,"description"=>"Submitted", 'user_id'=>1, 'rank'=>3],
            [ "value"=> "Completed" ,"description"=>"Completed", 'user_id'=>1, 'rank'=>4],
            [ "value"=> "Archived" ,"description"=>"Archived", 'user_id'=>1, 'rank'=>5]
        ];
        foreach ($records as $record) {
            KanbanList::create($record);
        }
    }
}
