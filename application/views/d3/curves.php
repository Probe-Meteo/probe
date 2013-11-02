<?php
/** histoWind.php
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

//http://probe.dev/viewer/histoWind/VP2_GTD

?>
<div id="resizable" class="ui-widget-content">
    <h4 class="ui-widget-header">Average Curve Historical Chart</h4>
    <p>
    This Year <span id="YearBarChar">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    This Month <span id="MonthBarChar">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    This Week <span id="WeekBarChar">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
    Today <span id="TodayBarChar">
        <!-- d3 content should be -dynamically- placed here -->
    </span></p>
    <div id="barSvgArea"></div>
</div>

<style>
    svg {
        font-size: 10px;
    }
    #spot {
        
    }
    .spot {
        fill: none;
        stroke-width: 1px;
    }
    .Dot {
        fill: none;
        stroke-width: 1px;
    }
    .spotCircle {
        fill: none;
        stroke-opacity: .3;
        stroke-width: 6px;
    }
    .legend text {
        /*fill: #1F77B4;*/
        /*fill-width: 5px;*/
        /*font-weight:bold;*/
        /*fill-opacity: .2;*/
        /*stroke: #fff;*/
        /*stroke-width: .5px;*/
        /*stroke-position:2;*/
        /*stroke-opacity: .8;*/
    }
    .legend .val, .legend .date {
        text-anchor:end;
    }
    .legend .Infos {
        text-anchor:middle;
    }
    .legend .legend_min, .legend .legend_avg, .legend .legend_max { 
        font-size: 8px;
    }

    .sensitive {
        opacity: 0;
    }
    .line {
        fill: none;
        stroke-width: 1px;
    }

    .axis line,.axis path {
        fill: none;
        stroke: #000;
        stroke-width: 1px;
        shape-rendering: crispEdges;
    }

</style>
<script>
    var station = '<?=$station?>';
    var sensor = '<?=$sensor?>';

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
        var chartY = timeSeriesChart_curves()
                            .width(52*4+50)
                            .height(40)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_365), formatDate(new Date())])
                            .station(station)
                            .sensor(sensor)
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartY.loader("#YearBarChar");

        var chartM = timeSeriesChart_curves()
                            .width(30*4+50)
                            .height(40)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_30), formatDate(new Date())])
                            .station(station)
                            .sensor(sensor)
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartM.loader("#MonthBarChar");

        var chartW = timeSeriesChart_curves()
                            .width(7*4*4+50)
                            .height(40)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_7), formatDate(new Date())])
                            .station(station)
                            .sensor(sensor)
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartW.loader("#WeekBarChar");

        var chartD = timeSeriesChart_curves()
                            .width(24*4+50)
                            .height(40)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_1), formatDate(new Date())])
                            .station(station)
                            .sensor(sensor)
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartD.loader("#TodayBarChar");


        var chartZoom = timeSeriesChart_curves()
                            .width($('#barSvgArea').width()-16)
                            .height(200)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_365), formatDate(new Date())])
                            .station(station)
                            .sensor(sensor)
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(false);
        chartZoom.loader("#barSvgArea");
    }


</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>

