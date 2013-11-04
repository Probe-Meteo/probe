<?php
/** histoWind.php
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe-meteo.com/doc
 */


?>
<div id="resizable" class="ui-widget-content">
    <h4 class="ui-widget-header">Sum Historical Chart</h4>
    <p>
    This Year <span id="YearArrowChart">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    This Month <span id="MonthArrowChart">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    This Week <span id="WeekArrowChart">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    Today <span id="TodayArrowChart">
        <!-- d3 content should be -dynamically- placed here -->
    </span></p>
    <div id="fullSvgArea"></div>
</div>

<style>
svg {
	font-size: 10px;
}
.line {
    fill: none;
    stroke: #000;
    stroke-width: 1px;
    shape-rendering: crispEdges;
}

.axis line,.axis path {
    fill: none;
    stroke: #000;
    stroke-width: 1px;
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

/*Blue:#1F77B4 #3182bd #6baed6*/
/*Red:#E6550D*/
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

/*.marker {
    fill: #FFF;
    stroke: #3182bd;
    stroke-width: .7px;
}*/
.sensitive {
    opacity: 0;
}
</style>
<script>
    var station = '<?=$station?>';

	function probeViewer(){
        var Day_1 = new Date();
            Day_1.setDate(Day_1.getDate() -1);
        var Day_7 = new Date();
            Day_7.setDate(Day_7.getDate() -7);
        var Day_30 = new Date();
            Day_30.setDate(Day_30.getDate() -30);
        var Day_365 = new Date();
            Day_365.setDate(Day_365.getDate() -365);

        // on definie notre objet au plus pres de notre besoin.
        var chartY = timeSeriesChart_histoWind()
                            .width(52*4+50)
                            .height(60)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_365), formatDate(new Date())])
                            .station(station)
                            .onClickAction(function(d) { console.error (d); })
                            // .withAxis(false)
                            .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                            .toHumanAngle(formulaConverter ('angle', '°'))
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartY.loader("#YearArrowChart");

        var chartM = timeSeriesChart_histoWind()
                            .width(30*4+50)
                            .height(60)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_30), formatDate(new Date())])
                            .station(station)
                            .onClickAction(function(d) { console.error (d); })
                            // .withAxis(false)
                            .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                            .toHumanAngle(formulaConverter ('angle', '°'))
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartM.loader("#MonthArrowChart");

        var chartW = timeSeriesChart_histoWind()
                            .width(7*4*4+50)
                            .height(60)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_7), formatDate(new Date())])
                            .station(station)
                            .onClickAction(function(d) { console.error (d); })
                            // .withAxis(false)
                            .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                            .toHumanAngle(formulaConverter ('angle', '°'))
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartW.loader("#WeekArrowChart");

        var chartD = timeSeriesChart_histoWind()
                            .width(24*4+50)
                            .height(60)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_1), formatDate(new Date())])
                            .station(station)
                            .onClickAction(function(d) { console.error (d); })
                            // .withAxis(false)
                            .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                            .toHumanAngle(formulaConverter ('angle', '°'))
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartD.loader("#TodayArrowChart");


        var chartZoom = timeSeriesChart_histoWind()
                            .width($('#fullSvgArea').width()-16)
                            .height(200)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_365), formatDate(new Date())])
                            .station(station)
                            .onClickAction(function(d) { console.error (d); })
                            // .withAxis(false)
                            .toHumanSpeed(formulaConverter ('WindSpeed', 'km/h'))
                            .toHumanAngle(formulaConverter ('angle', '°'))
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(false);
        chartZoom.loader("#fullSvgArea");
    }
</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<!-- <script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script> -->

