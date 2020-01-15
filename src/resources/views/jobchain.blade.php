<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
	<title> Chart emulation </title>
	<style>
            .Treant { position: relative; overflow: hidden; padding: 0 !important; }
            .Treant > .node,
            .Treant > .pseudo { position: absolute; display: block; visibility: hidden; }
            .Treant.loaded .node,
            .Treant.loaded .pseudo { visibility: visible; }
            .Treant > .pseudo { width: 0; height: 0; border: none; padding: 0; }
            .Treant .collapse-switch { width: 3px; height: 3px; display: block; border: 1px solid black; position: absolute; top: 1px; right: 1px; cursor: pointer; }
            .Treant .collapsed .collapse-switch { background-color: #868DEE; }
            .Treant > .node img {	border: none; float: left; }

            body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { margin:0; padding:0; }

            body { background: #fff; }

            /* optional Container STYLES */
            .chart { height: 400px; width: 900px; margin: 5px; margin: 5px auto; border: 3px solid #DDD; border-radius: 3px; }
            .node { color: #9CB5ED; border: 2px solid #C8C8C8; border-radius: 3px; background: #fff; transition: background 0.7s, color 0.7s; }
            .node p { font-size: 17px; line-height: 20px; height: 20px; font-weight: bold; padding: 3px; margin: 0; }

            .node.main-date { width: 10px; height: 10px; border-radius: 50%; }
            .node.main-date p.node-name { top: -15px; font-size: 15px; position: absolute; opacity: 0; z-index: -1; left: -30px; transition: top 1s, opacity 1s; }
            .node.main-date:hover p.node-name { opacity: 1; top: -25px; }

            .Treant .collapse-switch { width: 100%; height: 100%; border: none; }
            .Treant .node.collapsed { background-color: #D7F5FF; color: #827A7A; }
            .Treant .node.collapsed .collapse-switch { background: none; }

            .timeline .node-desc { position: absolute; left: -999px; width: 2000px; background: #665B57; height: 3px; padding: 0; z-index: -1; top: 3px; }
    </style>
</head>
<body>
	<div class="chart" id="OrganiseChart-simple">
	</div>

    <script src="https://fperucic.github.io/treant-js/vendor/jquery.min.js"></script>
    <script src="https://fperucic.github.io/treant-js/vendor/jquery.easing.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.8/raphael.js"></script>
    <script src="https://fperucic.github.io/treant-js/Treant.js"></script>

	<script>
        var rootNodeStructure = {text: { name: "Parent node" }  , children : []} ;
        var jobs = {!! $jobs->toJson() !!} ;
        function structureJob(jobs){
            var structure = [];
            for(var i =0 ; i < jobs.length ; i ++ ) {
                structure.push({
                    text : { name: jobs[i].type} ,
                    children : structureJob(jobs[i].all_children)
                }) ;
            }
            return structure  ;

        }
        for(var i = 0  ; i < jobs.length ; i++){
            var elem = {
                HTMLclass: ( (i == 0 ) ? "timeline" : "" ) +  " main-date",
                text: {name: jobs[i].started_at },
                children: structureJob(jobs[i].all_children)
            } ;
            if(i == 0 ){
                elem.text.desc = "" ;
            }
            rootNodeStructure.children.push(elem) ;
        }

        var simple_chart_config = {
            chart: {
                container: "#OrganiseChart-simple",
                hideRootNode: true,
                connectors: {
                    type: 'step',
                    style: {
                        "arrow-end": "classic-wide-long",
                        "stroke-width": 1,
                        "stroke": "#665B57"
                    }
                },
                node: {
                    collapsable: true
                },
                animation: {
                    nodeAnimation: "easeInSine",
                    nodeSpeed: 200,
                    connectorsAnimation: "easeInSine",
                    connectorsSpeed: 200
                }
            },
            nodeStructure: rootNodeStructure
        };
        new Treant( simple_chart_config );


	</script>

</body>
</html>

