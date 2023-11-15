<div>
    <main class="main-content kanban-app w-full">
    @if($project == null)
      <div class="text-center text-error">
          <div class="mt-4">
              <p class="text-error dark:text-navy-300">
                  Please select a project
              </p>
          </div>
      </div>
    @else
        <p class="mt-1 text-xs text-info">
          <span>{{ $project->title }}</span>
        </p>
        <div
            class="flex items-center justify-between space-x-2 px-[var(--margin-x)] py-5 transition-all duration-[.25s]">
            <div class="flex items-center space-x-1">
                <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    Gantt chart
                </h3>
            </div>
            <label class="relative hidden w-full max-w-[16rem] sm:flex">
                <input
                    class="form-input peer h-8 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Search on boards" type="text" />
                <span
                    class="pointer-events-none absolute flex h-full w-9 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                    </svg>
                </span>
            </label>
            <div class="flex space-x-1">
                <div class="flex -space-x-2">
                    <div class="avatar h-6 w-6 hover:z-10 sm:h-8 sm:w-8">
                        <img class="rounded-full border-2 border-slate-50 dark:border-navy-900"
                            src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <div class="avatar h-6 w-6 hover:z-10 sm:h-8 sm:w-8">
                        <img class="rounded-full border-2 border-slate-50 dark:border-navy-900"
                            src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <div class="avatar h-6 w-6 hover:z-10 sm:h-8 sm:w-8">
                        <img class="rounded-full border-2 border-slate-50 dark:border-navy-900"
                            src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <div class="avatar hidden h-6 w-6 hover:z-10 sm:inline-flex sm:h-8 sm:w-8">
                        <img class="rounded-full border-2 border-slate-50 dark:border-navy-900"
                            src="{{asset('images/200x200.png')}}" alt="avatar" />
                    </div>
                    <div class="avatar h-6 w-6 sm:h-8 sm:w-8">
                        <div
                            class="is-initial rounded-full border-2 border-slate-50 bg-info text-xs uppercase text-white dark:border-navy-900">
                            +5
                        </div>
                    </div>
                </div>
                <button
                    class="btn h-6 w-6 rounded-full p-0 font-medium text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25 sm:h-8 sm:w-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                    </svg>
                </button>
                <div class="my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
                <div class="flex">
                    <button
                        class="btn h-6 w-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:hidden sm:h-8 sm:w-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <button
                        class="btn h-6 w-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-8 sm:w-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </button>

                    <button x-data="{ isImportant: true }" @click="isImportant =! isImportant"
                        class="btn hidden h-6 w-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:inline-flex sm:h-8 sm:w-8">
                        <svg x-show="!isImportant" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <svg x-show="isImportant" xmlns="http://www.w3.org/2000/svg"
                            class="h-5.5 w-5.5 text-primary dark:text-accent" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </button>

                    <button @click="$dispatch('show-drawer', { drawerId: 'kanban-setting-drawer' })"
                        class="btn h-6 w-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-8 sm:w-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class='h-screen'>
            <div class="gantt_control" >
                <button id='default' onclick="toggleGrid();" 
                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Grid
                </button>
                <button id='default' onclick="toggleChart();" 
                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Timeline
                </button>
                <button id='default' onclick="gantt.ext.zoom.zoomIn();" 
                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Zoom in
                </button>
                <button id='default' onclick="gantt.ext.zoom.zoomOut();" 
                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    Zoom out
                </button>	
            </div>

            <div id="gantt_here" style='width:100%; height:100%;' wire:ignore></div>
            <script type="text/javascript">
                function toggleChart(){
                    gantt.config.show_chart = !gantt.config.show_chart;
                    gantt.render()
                }

                function toggleGrid(){
                    gantt.config.show_grid = !gantt.config.show_grid;
                    gantt.render()
                }

                var zoomConfig = {
                    levels: [
                        {
                            name: "day",
                            scale_height: 27,
                            min_column_width: 80,
                            scales: [
                                { unit: "day", step: 1, format: "%d %M" }
                            ]
                        },
                        {
                            name: "week",
                            scale_height: 50,
                            min_column_width: 50,
                            scales: [
                                {
                                    unit: "week", step: 1, format: function (date) {
                                        var dateToStr = gantt.date.date_to_str("%d %M");
                                        var endDate = gantt.date.add(date, -6, "day");
                                        var weekNum = gantt.date.date_to_str("%W")(date);
                                        return "#" + weekNum + ", " + dateToStr(date) + " - " + dateToStr(endDate);
                                    }
                                },
                                { unit: "day", step: 1, format: "%j %D" }
                            ]
                        },
                        {
                            name: "month",
                            scale_height: 50,
                            min_column_width: 120,
                            scales: [
                                { unit: "month", format: "%F, %Y" },
                                { unit: "week", format: "Week #%W" }
                            ]
                        },
                        {
                            name: "quarter",
                            height: 50,
                            min_column_width: 90,
                            scales: [
                                { unit: "month", step: 1, format: "%M" },
                                {
                                    unit: "quarter", step: 1, format: function (date) {
                                        var dateToStr = gantt.date.date_to_str("%M");
                                        var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day");
                                        return dateToStr(date) + " - " + dateToStr(endDate);
                                    }
                                }
                            ]
                        },
                        {
                            name: "year",
                            scale_height: 50,
                            min_column_width: 30,
                            scales: [
                                { unit: "year", step: 1, format: "%Y" }
                            ]
                        }
                    ]
                };

                gantt.ext.zoom.init(zoomConfig);
                gantt.ext.zoom.setLevel("week");

                function zoomIn() {
                    gantt.ext.zoom.zoomIn();
                }
                function zoomOut() {
                    gantt.ext.zoom.zoomOut()
                }


                var resourceConfig = {
                    columns: [
                        {
                            name: "name", label: "Name", tree: true, template: function (resource) {
                                return resource.text;
                            }
                        },
                        {
                            name: "workload", label: "Workload", template: function (resource) {
                                var tasks;
                                var store = gantt.getDatastore(gantt.config.resource_store),
                                    field = gantt.config.resource_property;

                                if (store.hasChild(resource.id)) {
                                    tasks = gantt.getTaskBy(field, store.getChildren(resource.id));
                                } else {
                                    tasks = gantt.getTaskBy(field, resource.id);
                                }

                                var totalDuration = 0;
                                for (var i = 0; i < tasks.length; i++) {
                                    totalDuration += tasks[i].duration;
                                }

                                return (totalDuration || 0) * 8 + "h";
                            }
                        }
                    ],
                };

                gantt.templates.resource_cell_class = function (start_date, end_date, resource, tasks) {
                    var css = [];
                    css.push("resource_marker");
                    if (tasks.length <= 1) {
                        css.push("workday_ok");
                    } else {
                        css.push("workday_over");
                    }
                    return css.join(" ");
                };

                gantt.templates.resource_cell_value = function (start_date, end_date, resource, tasks) {
                    var cell_duration = gantt.calculateDuration({ start_date: start_date, end_date: end_date });

                    var result = 0;
                    tasks.forEach(function (item) {
                        var assignments = gantt.getResourceAssignments(resource.id, item.id);
                        assignments.forEach(function (assignment) {
                            var task = gantt.getTask(assignment.task_id);
                            var hours_amount = 0;

                            if (+task.start_date <= +start_date && +task.end_date >= +end_date) {
                                hours_amount += cell_duration;
                            }
                            //the task is in the left part
                            else if (+task.start_date <= +start_date && +task.end_date >= +start_date && +task.end_date < +end_date) {
                                var left_duration = gantt.calculateDuration({ start_date: start_date, end_date: task.end_date });
                                hours_amount += left_duration;
                            }
                            //the task is in the right part
                            else if (+task.end_date >= +end_date && +task.start_date >= +start_date && +task.start_date < +end_date) {
                                var right_duration = gantt.calculateDuration({ start_date: task.start_date, end_date: end_date });
                                hours_amount += right_duration;
                            }
                            //the task is inside cell
                            else if (+task.start_date >= +start_date && +task.end_date <= +end_date) {
                                var task_duration = gantt.calculateDuration({ start_date: task.start_date, end_date: task.end_date });
                                hours_amount += task_duration;
                            }

                            result += assignment.value * hours_amount;
                        });
                    });

                    if (result % 1) {
                        result = Math.round(result * 10) / 10;
                    }
                    return "<div>" + result + "</div>";
                };

                gantt.config.columns = [
                    { name: "text", tree: true, width: 320, resize: true, sort: false },
                    { name: "list_order", label: 'list_order', width: 30, align: "center"},
                    { name: "start_date", align: "center", width: 80, resize: true, sort: false },
                    {
                        name: "resources", align: "center", width: 80, label: "Resources", resize: true,
                        template: function (task) {
                            if (task.type == gantt.config.types.project) {
                                return "";
                            }

                            var result = "";
                            var store = gantt.getDatastore("resource");
                            var assignments = task[gantt.config.resource_property];

                            if (!assignments || !assignments.length) {
                                return "";
                            }

                            if (assignments.length == 1) {
                                return store.getItem(assignments[0].resource_id).text.split(",")[0];
                            }

                            assignments.forEach(function (assignment) {
                                var resource = store.getItem(assignment.resource_id);
                                if (!resource)
                                    return;
                                result += "<div class='owner-label' title='" + resource.text + "'>" + resource.text.substr(0, 1) + "</div>";

                            });

                            return result;
                        }
                    },
                    { name: "duration", width: 60, align: "center", resize: true, sort: false },
                    { name: "add", width: 44 }
                ];

                // gantt.locale.labels.section_owner = "Owner";
                gantt.config.lightbox.sections = [
                    { name: "description", height: 38, map_to: "text", type: "textarea", focus: true },
                    {
                        name: "resources", type: "resources", map_to: "owner", options: gantt.serverList("people"), default_value: 8
                    },
                    { name: "time", type: "duration", map_to: "auto" }
                ];

                // gantt.config.resource_store = "resource";
                // gantt.config.resource_property = "owner";
                gantt.config.sort = false;
                gantt.config.order_branch = true;
                gantt.config.open_tree_initially = true;

                gantt.config.layout = {
                    css: "gantt_container",
                    rows: [
                        {
                            cols: [
                                { view: "grid", group: "grids", scrollY: "scrollVer" },
                                { resizer: true, width: 1 },
                                { view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer" },
                                { view: "scrollbar", id: "scrollVer", group: "vertical" }
                            ],
                            gravity: 2
                        },
                        { resizer: true, width: 1 },
                        // {
                        //     config: resourceConfig,
                        //     cols: [
                        //         { view: "resourceGrid", group: "grids", width: 435, scrollY: "resourceVScroll" },
                        //         { resizer: true, width: 1 },
                        //         { view: "resourceTimeline", scrollX: "scrollHor", scrollY: "resourceVScroll" },
                        //         { view: "scrollbar", id: "resourceVScroll", group: "vertical" }
                        //     ],
                        //     gravity: 1
                        // },
                        { view: "scrollbar", id: "scrollHor" }
                    ]
                };

                var resourcesStore = gantt.createDatastore({
                    name: gantt.config.resource_store,
                    type: "treeDatastore",
                    initItem: function (item) {
                        item.parent = item.parent || gantt.config.root_id;
                        item[gantt.config.resource_property] = item.parent;
                        item.open = true;
                        return item;
                    }
                });
                

                gantt.attachEvent("onAfterTaskAdd", function(id, task){
                    Livewire.emit('gantt-task-added', task);
                });

                gantt.attachEvent("onAfterTaskDrag", function(id, mode, e){
                    task = gantt.getTask(id);
                    Livewire.emit('gantt-task-dragged', id, mode, task);
                });
                
                gantt.attachEvent("onAfterTaskUpdate", function(id, task){
                    Livewire.emit('gantt-task-updated', id, task);
                });

                gantt.attachEvent("onAfterTaskDelete", function(id, task){
                    Livewire.emit('gantt-task-deleted', id);
                });

                gantt.attachEvent("onAfterLinkAdd", function(id, item){
                    Livewire.emit('gantt-link-added', id, item);
                });

                gantt.attachEvent("onAfterLinkDelete", function(id, item){
                    Livewire.emit('gantt-link-deleted', id, item);
                });

                gantt.attachEvent("onAfterTaskMove", function(id, parent, tindex){
                    Livewire.emit('gantt-task-vertical_moved', id, parent, tindex);
                });

                gantt.attachEvent("onBeforeRowDragMove", function(id, parent, tindex){
                    Livewire.emit('gantt-before-row-drag-move', id, parent, tindex);
                });

                gantt.attachEvent("onBeforeRowDragEnd", function(id, parent, tindex){
                    Livewire.emit('gantt-before-row-drag-end', id, parent, tindex);
                });

                resourcesStore.attachEvent("onParse", function () {
                    var people = [];
                    resourcesStore.eachItem(function (res) {
                        if (!resourcesStore.hasChild(res.id)) {
                            var copy = gantt.copy(res);
                            copy.key = res.id;
                            copy.label = res.text;
                            people.push(copy);
                        }
                    });
                    gantt.updateCollection("people", people);
                });

                resourcesStore.parse([
                    { id: 1, text: "QA", parent: null },
                    { id: 2, text: "Development", parent: null },
                    { id: 3, text: "Sales", parent: null },
                    { id: 4, text: "Other", parent: null },
                    { id: 5, text: "Unassigned", parent: 4 },
                    { id: 6, text: "John", parent: 1 },
                    { id: 7, text: "Mike", parent: 2 },
                    { id: 8, text: "Anna", parent: 2 },
                    { id: 9, text: "Bill", parent: 3 },
                    { id: 10, text: "Floe", parent: 3 }
                ]);

	            gantt.init("gantt_here");
                gantt.load("/api/data");

                // alert(data);
                // gantt.load(data);
                // gantt.parse({"tasks":[{"id":19,"user_id":1,"description":"finalize HR recruitment","created_at":"2023-06-19T12:37:55.000000Z","updated_at":"2023-07-06T03:34:57.000000Z","title":"finalize HR recruitment","start_date":"19-06-2023","planned_end_date":"2023-06-19 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":1,"report_by":2,"task_type_id":1,"task_status_id":4,"task_priority_id":4,"kanban_list_rank":1,"duration":0,"progress":"0","parent":8,"text":"finalize HR recruitment","type":"milestone"},{"id":11,"user_id":1,"description":null,"created_at":"2023-06-17T20:30:37.000000Z","updated_at":"2023-07-06T13:00:07.000000Z","title":"some normal","start_date":"07-06-2023","planned_end_date":"2023-06-19 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":1,"report_by":1,"task_type_id":1,"task_status_id":4,"task_priority_id":4,"kanban_list_rank":14,"duration":12,"progress":"0","parent":6,"text":"some normal","type":"task"},{"id":16,"user_id":1,"description":null,"created_at":"2023-06-19T11:16:54.000000Z","updated_at":"2023-07-06T13:00:32.000000Z","title":"This is new","start_date":"07-06-2023","planned_end_date":"2023-06-17 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":2,"report_by":2,"task_type_id":1,"task_status_id":2,"task_priority_id":2,"kanban_list_rank":1,"duration":10,"progress":"0.36948529411765","parent":7,"text":"This is new","type":"task"},{"id":7,"user_id":1,"description":null,"created_at":"2023-06-17T17:55:46.000000Z","updated_at":"2023-07-06T13:00:32.000000Z","title":"Another correction1","start_date":"07-06-2023","planned_end_date":"2023-06-20 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":2,"report_by":1,"task_type_id":1,"task_status_id":3,"task_priority_id":1,"kanban_list_rank":0,"duration":13,"progress":"0","parent":0,"text":"Another correction1","type":"project"},{"id":6,"user_id":1,"description":null,"created_at":"2023-06-17T17:24:57.000000Z","updated_at":"2023-07-06T13:10:59.000000Z","title":"Test98","start_date":"03-06-2023","planned_end_date":"2023-06-21 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":2,"report_by":2,"task_type_id":1,"task_status_id":1,"task_priority_id":2,"kanban_list_rank":0,"duration":18,"progress":"0","parent":0,"text":"Test98","type":"project"},{"id":10,"user_id":1,"description":null,"created_at":"2023-06-17T20:26:31.000000Z","updated_at":"2023-07-06T13:11:43.000000Z","title":"next12300","start_date":"03-06-2023","planned_end_date":"2023-06-15 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":2,"report_by":1,"task_type_id":1,"task_status_id":5,"task_priority_id":1,"kanban_list_rank":0,"duration":12,"progress":"0.57215189873418","parent":6,"text":"next12300","type":"task"},{"id":9,"user_id":1,"description":null,"created_at":"2023-06-17T20:21:18.000000Z","updated_at":"2023-07-06T13:11:58.000000Z","title":"correct","start_date":"03-06-2023","planned_end_date":"2023-06-13 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":1,"report_by":2,"task_type_id":1,"task_status_id":4,"task_priority_id":1,"kanban_list_rank":0,"duration":10,"progress":"0.33738601823708","parent":6,"text":"correct","type":"task"},{"id":18,"user_id":1,"description":null,"created_at":"2023-06-19T12:26:27.000000Z","updated_at":"2023-07-06T10:43:28.000000Z","title":"testing13234","start_date":"10-06-2023","planned_end_date":"2023-06-21 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":1,"report_by":1,"task_type_id":1,"task_status_id":2,"task_priority_id":4,"kanban_list_rank":0,"duration":11,"progress":"0","parent":8,"text":"testing13234","type":"task"},{"id":8,"user_id":1,"description":null,"created_at":"2023-06-17T20:13:05.000000Z","updated_at":"2023-07-06T10:43:28.000000Z","title":"task planned date","start_date":"10-06-2023","planned_end_date":"2023-06-22 21:00:00","actual_start_date":null,"actual_end_date":null,"budget":"0","expense":"0","project_id":1,"assigned_to":2,"report_by":1,"task_type_id":1,"task_status_id":3,"task_priority_id":4,"kanban_list_rank":1,"duration":12,"progress":"0","parent":0,"text":"task planned date","type":"project"}],"links":[]} )
            </script>
        </div>
    @endif
    </main>
</div>
