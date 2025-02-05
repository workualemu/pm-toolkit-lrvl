<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [ "name"=> "create project"],
            [ "name"=> "edit project"],
            [ "name"=> "view project"],
            [ "name"=> "delete project"],
            [ "name"=> "create task"],
            [ "name"=> "edit task"],
            [ "name"=> "delete task"],
            [ "name"=> "view task"],
            [ "name"=> "create activity"],
            [ "name"=> "edit activity"],
            [ "name"=> "delete activity"],
            [ "name"=> "create phase"],
            [ "name"=> "edit phase"],
            [ "name"=> "delete phase"],
            [ "name"=> "create gantt link"],
            [ "name"=> "edit gantt link"],
            [ "name"=> "delete gantt link"],
            [ "name"=> "create tag"],
            [ "name"=> "edit tag"],
            [ "name"=> "delete tag"],
            [ "name"=> "view tag"],
            [ "name"=> "create status"],
            [ "name"=> "edit status"],
            [ "name"=> "delete status"],
            [ "name"=> "view status"],
            [ "name"=> "create priority"],
            [ "name"=> "edit priority"],
            [ "name"=> "delete priority"],
            [ "name"=> "view priority"],
            [ "name"=> "create comment"],
            [ "name"=> "edit comment"],
            [ "name"=> "delete comment"],
            [ "name"=> "view comment"],
        ];
        foreach ($roles as $role) {
            Permission::create($role);
        }
    }
}
