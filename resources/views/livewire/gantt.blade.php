<main class="w-full px-2 pt-16 mb-[60px] md:ml-[var(--main-sidebar-width)] ">
    <div
        class="flex justify-between space-x-2 py-2 transition-all duration-[.25s]">
        <div class="flex items-center space-x-1">
            <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                {{ __('Gantt chart') }}
            </h3>
        </div>
        <div class="flex items-center space-x-1">
            <label class="relative w-full max-w-[16rem] flex">
                <input
                    class="form-input peer h-8 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Search task" type="text" />
                <span
                    class="pointer-events-none absolute flex h-full w-9 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                    </svg>
                </span>
            </label>
            <button x-tooltip="'Filter'"
                class="btn h-6 w-6 rounded-full p-0 text-info hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-8 sm:w-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </button>
        </div>
        <div class="flex items-center space-x-1">
            <button x-tooltip="'Zoom out'" onclick="gantt.ext.zoom.zoomOut();" 
                class="btn h-6 w-6 rounded-full p-0 text-info hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-8 sm:w-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 sm:h-5 sm:w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM13.5 10.5h-6" />
                </svg>
            </button>
            <button x-tooltip="'Zoom in'" onclick="gantt.ext.zoom.zoomIn();" 
                class="btn h-6 w-6 rounded-full p-0 text-info hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-8 sm:w-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 sm:h-5 sm:w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                </svg>
            </button>
        </div>
    </div>
    <div class="w-full h-full">
        <div id="gantt_here"  class="w-full h-full"  style="width:100%; height:100%;" wire:ignore></div>
    </div>
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
                                return "#" + weekNum + ", " + dateToStr(endDate) + " - " + dateToStr(date);
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

        function zoomIn() {
            gantt.ext.zoom.zoomIn();
        }
        function zoomOut() {
            gantt.ext.zoom.zoomOut()
        }


        // var resourceConfig = {
        //     columns: [
        //         {
        //             name: "name", label: "Name", tree: true, template: function (resource) {
        //                 return resource.text;
        //             }
        //         },
        //         {
        //             name: "workload", label: "Workload", template: function (resource) {
        //                 var tasks;
        //                 var store = gantt.getDatastore(gantt.config.resource_store),
        //                     field = gantt.config.resource_property;

        //                 if (store.hasChild(resource.id)) {
        //                     tasks = gantt.getTaskBy(field, store.getChildren(resource.id));
        //                 } else {
        //                     tasks = gantt.getTaskBy(field, resource.id);
        //                 }

        //                 var totalDuration = 0;
        //                 for (var i = 0; i < tasks.length; i++) {
        //                     totalDuration += tasks[i].duration;
        //                 }

        //                 return (totalDuration || 0) * 8 + "h";
        //             }
        //         }
        //     ],
        // };

        gantt.config.columns = [
            { name: "text", tree: true, width: 220, resize: true, sort: true },
            { name: "start_date", align: "center", width: 150, resize: true, sort: true },
            { name: "duration", width: 60, align: "center", resize: true, sort: false },
            { name: "add", width: 44 }
        ];

        gantt.config.layout = {
            css: "gantt_container",
            cols: [
                {
                    width:400,
                    minWidth: 200,
                    maxWidth: 600,
                    rows:[
                        {view: "grid", scrollX: "gridScroll", scrollable: true, scrollY: "scrollVer"}, 
                        {view: "scrollbar", id: "gridScroll"}  
                    ]
                },
                {resizer: true, width: 1},
                {
                    rows:[
                        {view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer"},
                        {view: "scrollbar", id: "scrollHor", group:"horizontal"}
                    ]
                },
                {view: "scrollbar", id: "scrollVer"}
            ]
        };

        var resourcesStore = gantt.createDatastore({
            name: gantt.config.resource_store,
            type: "treeDatastore",
            initItem: function (item) {
                item.task_id = item.task_id || gantt.config.root_id;
                item[gantt.config.resource_property] = item.task_id;
                item.open = true;
                return item;
            }
        });
        
        gantt.attachEvent("onAfterTaskAdd", function(id, task){
            window.Livewire.dispatch('ganttTaskAdded', { task });
        });

        gantt.attachEvent("onAfterTaskDrag", function(id, mode, e){
            task = gantt.getTask(id);
            window.Livewire.dispatch('ganttTaskDragged', {id, mode, task});
        });
        
        gantt.attachEvent("onAfterTaskUpdate", function(id, task){
            window.Livewire.dispatch('ganttTaskUpdated', {id, task});
        });

        gantt.attachEvent("onAfterTaskDelete", function(id, task){
            window.Livewire.dispatch('ganttTaskDeleted', {id});
        });

        gantt.attachEvent("onAfterLinkAdd", function(id, item){
            if (window.Livewire && typeof window.Livewire.dispatch === "function") {
                window.Livewire.dispatch('ganttLinkAdded', { id, item });
            } else {
                console.error("Livewire is not loaded or dispatch() is unavailable.");
            }
        });

        // gantt.attachEvent("onAfterLinkAdd", function(id, item){
        //     $wire.dispatch()('ganttLinkAdded', id, item);
        // });

        gantt.attachEvent("onAfterLinkDelete", function(id, item){
            window.Livewire.dispatch('ganttLinkDeleted', { id, item });
        });

        gantt.attachEvent("onAfterTaskMove", function(id, parent, tindex){
            window.Livewire.dispatch('ganttTaskVerticalMoved', {id, parent, tindex});
        });

        gantt.attachEvent("onBeforeRowDragMove", function(id, parent, tindex){
            window.Livewire.dispatch('ganttBeforeRowDragMove', {id, parent, tindex});
        });

        gantt.attachEvent("onBeforeRowDragEnd", function(id, parent, tindex){
            window.Livewire.dispatch('ganttBeforeRowDragEnd', {id, parent, tindex});
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

        gantt.config.open_tree_initially = true;
        gantt.ext.zoom.init(zoomConfig);
        gantt.ext.zoom.setLevel("week");
        gantt.config.sort = false;
        gantt.config.order_branch = true;

        gantt.config.resource_store = "resource";
        // gantt.config.resource_property = "owner";
        gantt.config.autofit = true;
        gantt.config.grid_width = 500;
        // gantt.config.autosize = "xy";
        // gantt.config.scale_height = 30; // Ensure a consistent scale height
        // gantt.render(); // Refresh Gantt

        gantt.templates.drag_link = function(from, from_start, to, to_start) {
            const sourceTask = gantt.getTask(from);
        
            let text = `From:<b> ${sourceTask.text}</b> ${(from_start?"Start":"End")}<br/>`;
            if(to){
                const targetTask = gantt.getTask(to);
                text += `To:<b> ${targetTask.text}</b> ${(to_start?"Start":"End")}<br/>`;
            }
            return text;
        };

        gantt.templates.task_text = function (start, end, task) {
            return ""; 
        };

        gantt.config.xml_date = "%d-%M-%Y";
        gantt.init("gantt_here");
        gantt.load("gantt/data/{{$project->id}}");
    </script>
</main>
