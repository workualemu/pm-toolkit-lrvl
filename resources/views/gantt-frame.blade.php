<!DOCTYPE html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
 
    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
 
    <style type="text/css">
        html, body{
            height:100%;
            padding:0px;
            margin:0px;
            overflow: hidden;
        }

    </style>
</head>
<body>
<div style='width:100%; height:100%;'>
<div id="gantt_here" style='width:100%; height:100%;'></div>
<script type="text/javascript">


gantt.config.columns = [
    { name: "text", tree: true, width: 200, resize: true },
    { name: "start_date", align: "center", width: 80, resize: true },
    {
        name: "owner", align: "center", width: 75, label: "Owner", template: function (task) {
            if (task.type == gantt.config.types.project) {
                return "";
            }

            const store = gantt.getDatastore("resource");
            const owner = store.getItem(task.owner_id);
            if (owner) {
                return owner.text;
            } else {
                return "Unassigned";
            }
        }, resize: true
    },
    { name: "duration", width: 60, align: "center" },
    { name: "add", width: 44 }
];

const resourceConfig = {
    columns: [
        {
            name: "name", label: "Name", tree: true, template: function (resource) {
                return resource.text;
            }
        },
    ]
};


gantt.config.order_branch = true;
gantt.config.open_tree_initially = true;

gantt.config.layout = {
		css: "gantt_container",
		cols: [
			{
				width:400,
				min_width: 300,
				rows:[
					{view: "grid", scrollX: "gridScroll", scrollable: true, scrollY: "scrollVer"},
					{view: "scrollbar", id: "gridScroll", group:"horizontal"}
				]
			},
			{resizer: true, width: 1},
			{
				rows:[
					{view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer"},
					{view: "scrollbar", id: "scrollHor", group:"horizontal", height:"20px"}
				]
			},
			{view: "scrollbar", id: "scrollVer"}
		]
	};

    gantt.init("gantt_here");
    gantt.load("/api/data");
</script>
</div>
</body>