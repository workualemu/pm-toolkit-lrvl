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
use App\Models\Report;
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

    private $taskPriorityMap = [];
    private $taskStatusMap = [];

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

        try {
            DB::beginTransaction();
            $json = file_get_contents(base_path('storage/app/template_project.json'));
            $data = json_decode($json, true);
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

            $this->info("Project template '{$project->title}' has been created successfully.");

            if (isset($data['task_statuses'])) {
                $this->createStatuses($data['task_statuses'], $project->id, $user->id);
            }

            if (isset($data['tags'])) {
                $this->createTags($data['tags'], $project->id, $user->id);
            }

            if (isset($data['task_priorities'])) {
                $this->createPriorities($data['task_priorities'], $project->id, $user->id);
            }

            $this->info("Statuses, tags, and priority labels have been created successfully for project '{$project->title}'.");

            if (isset($data['phases'])) {
                $this->createTasks($data['phases'], null, "", 0,
                    $project->id, $user->id);
            }

            $this->info("All tasks have been created successfully for project '{$project->title}'.");

            if (isset($data['reports'])) {
                $this->createReports($data['reports'], $project->id, $user->id);
                $this->info("All reports have been created successfully for project '{$project->title}'.");
            }

            DB::commit();
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("An error occurred: {$e->getMessage()}");
            DB::rollBack();
            return Command::FAILURE;
        }
    }
   
    private function createStatuses($statuses, $project_id, $user_id)
    {
        foreach ($statuses as $status) {
            $taskStatus = TaskStatus::create([
                'value' => $status['value'],
                'description' => $status['description'],
                'color' => $status['color'],
                'kanban_list_rank' => $status['kanban_list_rank'],
                'user_id' => $user_id,
                'project_id' => $project_id
            ]);

            $this->taskStatusMap[$status['value']] = $taskStatus->id;
        }
    }

    private function createTags($tags, $project_id, $user_id)
    {
        foreach ($tags as $tag) {
            $tag = Tag::create([
                'label' => $tag['label'],
                'description' => $tag['description'],
                'color' => $tag['color'],
                'user_id' => $user_id,
                'project_id' => $project_id
            ]);
        }
    }

    private function createPriorities($priorities, $project_id, $user_id)
    {
        foreach ($priorities as $priority) {
            $taskPriority = TaskPriority::create([
                'value' => $priority['value'],
                'description' => $priority['description'],
                'color' => $priority['color'],
                'user_id' => $user_id,
                'project_id' => $project_id
            ]);

            $this->taskPriorityMap[$priority['value']] = $taskPriority->id;
        }
    }

    private function createReports($reports, $project_id, $user_id)
    {
        foreach ($reports as $item) {
            $report = Report::create([
                'title' => $item['title'],
                'description' => $item['description'],
                'select_clause' => $item['select_clause'],
                'from_clause' => $item['from_clause'],
                'where_clause' => $item['where_clause'],
                'order_clause' => $item['order_clause'],
                'groupby_clause' => $item['groupby_clause'],
                'having_clause' => $item['having_clause'],
                'published' => $item['published'],
                'user_id' => $user_id,
                'project_id' => $project_id
            ]);
            
        }
    }

    private function createTasks($tasks, $parent_id, $parentPath, $level, 
        $project_id, $user_id)
    {
        foreach ($tasks as $task) {
            $taskStatusId = $this->taskStatusMap[$task['task_status']] ?? null;
            $taskPriorityId = $this->taskPriorityMap[$task['task_priority']] ?? null;
    
            $newTask = Task::create([
                'title' => $task['title'],
                'description' => $task['description'],
                'start_date' => $task['start_date'],
                'end_date' => $task['end_date'],
                'task_status_id' => $taskStatusId,
                'task_priority_id' => $taskPriorityId,
                'level' => $level,
                'user_id' => $user_id,
                'project_id' => $project_id,
                'parent' => $parent_id
            ]);
    
            $taskPath = $level == 0 ? $newTask->id : "{$parentPath}.{$newTask->id}";
            $newTask->path = $taskPath;
            $newTask->original_id = $newTask->id;
            $newTask->save();

            if ($level==0 && isset($task['activities'])) {
                $this->createTasks($task['activities'], $newTask->id, $taskPath, $level + 1,
                    $project_id, $user_id);
            } elseif ($level==1 && isset($task['tasks'])) {
                $this->createTasks($task['tasks'], $newTask->id, $taskPath, $level + 1,
                    $project_id, $user_id);
            }
        }
    }
}
