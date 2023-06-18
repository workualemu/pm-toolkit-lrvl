<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [ "label"=> "Logistics" ,"description"=>"Logistics", 'user_id'=>1, 'color'=>'success'],
            [ "label"=> "Finance" ,"description"=>"Finance", 'user_id'=>1, 'color'=>'info'],
            [ "label"=> "IT" ,"description"=>"IT", 'user_id'=>1, 'color'=>'error'],
            [ "label"=> "HR" ,"description"=>"HR", 'user_id'=>1, 'color'=>'primary'],
            [ "label"=> "Operations" ,"description"=>"Operations", 'user_id'=>1, 'color'=>'warning']
        ];
        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
