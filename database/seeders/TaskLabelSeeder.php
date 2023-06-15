<?php

namespace Database\Seeders;

use App\Models\TaskLabels;
use Illuminate\Database\Seeder;

class TaskLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labels = [
            [ "title"=> "Logistics" ,"description"=>"Logistics", 'user_id'=>1, 'color'=>'success'],
            [ "title"=> "Finance" ,"description"=>"Finance", 'user_id'=>1, 'color'=>'info'],
            [ "title"=> "IT" ,"description"=>"IT", 'user_id'=>1, 'color'=>'error'],
            [ "title"=> "HR" ,"description"=>"HR", 'user_id'=>1, 'color'=>'primary'],
            [ "title"=> "Operations" ,"description"=>"Operations", 'user_id'=>1, 'color'=>'secondary']
        ];
        foreach ($labels as $label) {
            TaskLabels::create($label);
        }
    }
}
