<?php
/**
* List available viewer template
*
* @category Template
* @package  Probe
* @author   Alban Lopez
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
// $station="VP2_GTD";
?>
<style>
.main_loader{
    position:relative;
    width:48px;
    height:48px;
}
</style>


<div style='display:none'>
    <div id="main_loader" class='main_loader'>
    </div>
</div>

<style>
    /* Bootstrap style */
    .row-fluid > .sidebar-nav {
        position: relative;
        top: 0;
        left:auto;
        width: 220px;
        padding: 9px 0;
    }
    .left {
        float:left;
    }
    .right {
        float:right;
    }
    .line {
        fill: none;
        stroke-width: 1px;
    }
    h4, hr, br {
        width:100%;
    }
    .fixed-fixed {
        margin-left: 240px;
    }
    .legend .val, .legend .date {
        text-anchor:end;
    }
    .legend .Infos {
        text-anchor:middle;
    }
    .legend .legend_min, .legend .legend_avg, .legend .legend_max, .legend .legend_sum { 
        font-size: 8px;
    }
    .bar {
        stroke-width: 1px;
        shape-rendering: crispEdges;
        }
    .bar:hover, .sensitive:hover > .bar {
        stroke-width: 2px;
        shape-rendering: crispEdges;
        }

    .arrow, .arrow>.hair {
    	stroke-width: 1px;
	}
	.arrow:hover, .arrow:hover>.hair {
	    stroke-width: 2px;
	}
	.arrow:hover>.hair2 {
	    stroke-width: 10px;
	}
	.hair {
	    fill: none;
	}
	.hair2 {
	    fill: none;
	    stroke: #3182bd;
	    stroke-width: 5px;
	    stroke-opacity: 0;
	}
	marker polygon {
	    fill:#FFF;
	}
	
    .sensitive {
        opacity: 0;
    }
</style>
<script type="text/javascript">
    var station = '<?=$station?>';
</script>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="well sidebar-nav left">
        		<ul class="nav nav-tabs">
                    <li>
                        <h3 class="nav-header"><?=i18n('configuration-stations.list.header')?></h3>
                    </li>
                    <li>
                        <h2 ><?=$station?></h3>
                            <ul id="list-viewer">
							    <?php
							    foreach ($list as $key => $file): ?>
							        <li>
							            <a href="/viewer/<?=$file;?>"><?=$file;?></a>
							        </li>
							    <?php endforeach ?>
							</ul>
                    </li>
                    <?php
                    foreach ($stations as $key => $name) {
                        if ($name<>$station) {
                        	?>
	                        <li>
	                            <a href="/dashboard/global/<?=$name?>">
	                                <?=$name?>
	                            </a>
	                        </li>
	                        <?php
                    	}
                    }
                    ?>
                </ul>

        </div>


        <div id="middleChartsArea" class="content fixed-fixed">
			<style type="text/css">
			.tg-table-light { border-collapse: collapse; border-spacing: 0;  border: 1.5px #bbb solid;}
            .tg-table-light td { height:46px; padding: 5px;}
            .tg-table-light th {padding: 10px;}
			.tg-table-light td, .tg-table-light th { background-color: #fff; border-bottom: 1px #bbb solid; color: #333; font-family: sans-serif; font-size: 100%; vertical-align: top; }
			.tg-table-light .Day, .tg-table-light .Week, .tg-table-light .Month { width: 155px; }
			.tg-table-light .tg-even td  { background-color: #eee; }
			.tg-table-light th  { background-color: #ddd; color: #333; font-size: 110%; font-weight: bold; }
			.tg-table-light tr:hover td, .tg-table-light tr.even:hover td  { color: #222; background-color: #FCFBE3; }
			.tg-bf { font-weight: bold; } .tg-it { font-style: italic; }
			.tg-left { text-align: left; } .tg-right { text-align: right; } .tg-center { text-align: center; }
			</style>

			<table id="global-table" class="tg-table-light">
				<tr>
					<th class="tg-center">Sensor</th>
					<th class="tg-center tg-bf">Current</th>
					<th class="tg-center Month">Month</th>
					<th class="tg-center Week">Week</th>
					<th class="tg-center Day">Day</th>
				</tr>
				<tboby>
				</tboby>
			</table>
        </div>
    </div>
</div>
<script>

</script>
<script src="/resources/js/libs/d3.v3.js"></script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/binders/curve.js"></script>
<script src="/resources/js/binders/barChart.js"></script>
<script src="/resources/js/binders/histoWind.js"></script>
<script src="/resources/js/libs/suncalc.js"></script>
