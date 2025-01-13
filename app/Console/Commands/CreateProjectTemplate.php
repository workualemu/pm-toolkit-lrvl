<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use App\Models\Tag;
use App\Models\TaskPriority;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class CreateProjectTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cpm:create-project-template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a template census project and associated tasks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating census template project...');
        $user =  User::all()->first();
        if(!$user){
            $this->error('No user found. Please adminify command to create a user.');
            return Command::FAILURE;
        }

        // if (!Storage::exists('template_project.json')) {
        //     $this->error('File not found: template_project.json');
        //     return Command::FAILURE;
        // }
        // $json = file_get_contents(base_path('storage/app/template_project.json'));
        // // $json = Storage::get('template_project.json');
        
        // $data = json_decode($json, true);
        // logger("json data is loaded");
        try {
            DB::beginTransaction();
            $json = file_get_contents(base_path('storage/app/template_project.json'));
            $data = json_decode($json, true);
            logger($data);
            if (!$data) {
                $this->error('Invalid JSON data. Please check the file.');
                return Command::FAILURE;
            }

            $project = Project::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => $data['status'],
                'user_id' => $user->id,
                'is_template' => true
            ]);

            $this->info("Project template '{$project->title}' created successfully.");

            $taskStatusMap = [];
            foreach ($data['task_statuses'] as $status) {
                $taskStatus = TaskStatus::create([
                    'value' => $status['value'],
                    'description' => $status['description'],
                    'color' => $status['color'],
                    'kanban_list_rank' => $status['kanban_list_rank'],
                    'user_id' => $user->id,
                    'project_id' => $project->id
                ]);

                $taskStatusMap[$status['value']] = $taskStatus->id;
            }

            foreach ($data['tags'] as $tag) {
                $tag = Tag::create([
                    'label' => $tag['label'],
                    'description' => $tag['description'],
                    'color' => $tag['color'],
                    'user_id' => $user->id,
                    'project_id' => $project->id
                ]);
            }

            $taskPriorityMap = [];
            foreach ($data['task_priorities'] as $priority) {
                $taskPriority = TaskPriority::create([
                    'value' => $priority['value'],
                    'description' => $priority['description'],
                    'color' => $priority['color'],
                    'user_id' => $user->id,
                    'project_id' => $project->id
                ]);

                $taskPriorityMap[$priority['value']] = $taskPriority->id;
            }


            $this->info("Statuses, tags, and priority labels are created successfully for project {$project->id} - '{$project->title}'.");

            foreach ($data['phases'] as $phase) {
                $taskStatusId = $taskStatusMap[$phase['task_status']] ?? null;
                $taskPriorityId = $taskPriorityMap[$phase['task_priority']] ?? null;

                if (!$taskStatusId) {
                    $this->error("Task status '{$phase['task_status']}' not found for task '{$phase['title']}'. Skipping task.");
                    continue;
                }

                if (!$taskPriorityId) {
                    $this->error("Task priority '{$phase['task_priority']}' not found for task '{$phase['title']}'. Skipping task.");
                    continue;
                }

                $newPhase = Task::create([
                    'title' => $phase['title'],
                    'description' => $phase['description'],
                    'start_date' => $phase['start_date'],
                    'end_date' => $phase['end_date'],
                    'task_status' => $taskStatusId,
                    'task_priority' => $taskPriorityId,
                    'level' => 0,
                    'user_id' => $user->id,
                    'project_id' => $project->id
                ]);

                $phasePath = $newPhase->id;
                $newPhase->path = $phasePath;
                $newPhase->original_id = $newPhase->id;
                $newPhase->save();

                foreach ($phase['activities'] as $activity) {
                    $taskStatusId = $taskStatusMap[$activity['task_status']] ?? null;
                    $taskPriorityId = $taskPriorityMap[$activity['task_priority']] ?? null;
    
                    if (!$taskStatusId) {
                        $this->error("Task status '{$activity['task_status']}' not found for task '{$activity['title']}'. Skipping task.");
                        continue;
                    }
    
                    if (!$taskPriorityId) {
                        $this->error("Task priority '{$activity['task_priority']}' not found for task '{$activity['title']}'. Skipping task.");
                        continue;
                    }

                    $newActivity = Task::create([
                        'title' => $activity['title'],
                        'description' => $activity['description'],
                        'start_date' => $activity['start_date'],
                        'end_date' => $activity['end_date'],
                        'task_status' => $taskStatusId,
                        'task_priority' => $taskPriorityId,
                        'level' => 1,
                        'user_id' => $user->id,
                        'project_id' => $project->id,
                        'parent' => $newPhase->id
                    ]);
    
                    $activityPath = "{$phasePath}.{$newActivity->id}";
                    $newActivity->path = $activityPath;
                    $newActivity->original_id = $newActivity->id;
                    $newActivity->save();

                    foreach ($activity['tasks'] as $task) {
                        $taskStatusId = $taskStatusMap[$task['task_status']] ?? null;
                        $taskPriorityId = $taskPriorityMap[$task['task_priority']] ?? null;
        
                        if (!$taskStatusId) {
                            $this->error("Task status '{$task['task_status']}' not found for task '{$task['title']}'. Skipping task.");
                            continue;
                        }
        
                        if (!$taskPriorityId) {
                            $this->error("Task priority '{$task['task_priority']}' not found for task '{$task['title']}'. Skipping task.");
                            continue;
                        }
    
                        $newTask = Task::create([
                            'title' => $task['title'],
                            'description' => $task['description'],
                            'start_date' => $task['start_date'],
                            'end_date' => $task['end_date'],
                            'task_status' => $taskStatusId,
                            'task_priority' => $taskPriorityId,
                            'level' => 2,
                            'user_id' => $user->id,
                            'project_id' => $project->id,
                            'parent' => $newActivity->id
                        ]);
        
                        $taskPath = "{$activityPath}.{$newTask->id}";
                        $newTask->path = $taskPath;
                        $newTask->original_id = $newTask->id;
                        $newTask->save();
                    }
                }
            }

            $this->info("All tasks for project '{$project->name}' created successfully.");

            DB::commit();
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("An error occurred: {$e->getMessage()}");
            DB::rollBack();
            return Command::FAILURE;
        }
    }
}
