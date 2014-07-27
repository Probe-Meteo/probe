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
    <!-- <h4 class="ui-widget-header" id="title">Average Curve Historical Chart</h4> -->
    <p>
    <div id="barSvgArea"></div></br></br>
        <b>This Year </b><span id="YearBarChar"></span>
        <b>This Month </b><span id="MonthBarChar"></span>
        <b>This Week </b><span id="WeekBarChar"></span>
        <b>Today </b><span id="TodayBarChar"></span>
    </p>
</div>

<style>
    svg {
        font-size: 0.85em;
    }
    text {
        text-shadow: 0 0.6px 1px #FFF, 0.6px 0 1px #FFF, 0 -0.6px 1px #FFF, -0.6px 0 1px #FFF,
            0.6px 0.6px 1px #FFF, 0.6px -0.6px 1px #FFF, -0.6px -0.6px 1px #FFF, -0.6px 0.6px 1px #FFF,
            0 1.5px 1px #FFF, 1.5px 0 1px #FFF, 0 -1.5px 1px #FFF, -1.5px 0 1px #FFF,
            0 1px 1px #FFF, 1px 0 1px #FFF, 0 -1px 1px #FFF, -1px 0 1px #FFF,
            1px 1px 1px #FFF, 1px -1px 1px #FFF, -1px -1px 1px #FFF, -1px 1px 1px #FFF,
            0 2px 1px #FFF, 2px 0 1px #FFF, 0 -2px 1px #FFF, -2px 0 1px #FFF;
    }
    /*    #spot:hover + .spotdetail {
        opacity: 1;
    }*/
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
        stroke-width: 7px;
    }
    .interLine {
        fill: none;
        stroke-width: 1px;        
    }
    .legend .val, .legend .date {
        text-anchor:end;
    }
    .legend .Infos {
        text-anchor:middle;
    }
    .legend .legend_min, .legend .legend_avg, .legend .legend_max { 
        font-size: 0.75em;
    }
    .spotdetail {
        /*opacity: 0;*/
    }
    .spotdetail text {
        fill:#000;
        font-size: 0.8em;
    }
    .sensitive {
        opacity: 0;
    }
    .line, .lineUp , .lineDown  {
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

        // // on definie notre objet au plus pres de notre besoin.
        // var chartY = timeSeriesChart_curves()
        //                     .width(52*4*2+50)
        //                     .height(50)
        //                     .dateParser("%Y-%m-%d %H:%M")
        //                     .dateDomain([formatDate(Day_365), formatDate(new Date())])
        //                     .station(station)
        //                     .sensor(sensor)
        //                     .toHumanDate(formulaConverter ('strDate', 'ISO'))
        //                     .Color()
        //                     .nude(true);
        // chartY.loader("#YearBarChar");

        // var chartM = timeSeriesChart_curves()
        //                     .width(30*4*2+50)
        //                     .height(50)
        //                     .dateParser("%Y-%m-%d %H:%M")
        //                     .dateDomain([formatDate(Day_30), formatDate(new Date())])
        //                     .station(station)
        //                     .sensor(sensor)
        //                     .toHumanDate(formulaConverter ('strDate', 'ISO'))
        //                     .Color()
        //                     .nude(true);
        // chartM.loader("#MonthBarChar");

        var chartW = timeSeriesChart_curves()
                            .width(7*4*4*2+50)
                            .height(50)
                            .dateParser("%Y-%m-%d %H:%M")
                            .dateDomain([formatDate(Day_7), formatDate(new Date())])
                            .station(station)
                            .sensor(sensor)
                            .toHumanDate(formulaConverter ('strDate', 'ISO'))
                            .Color()
                            .nude(true);
        chartW.loader("#WeekBarChar");

        var chartD = timeSeriesChart_curves()
                            .width(24*4*2+50)
                            .height(50)
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
                            .height(300)
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
<script src="/resources/js/libs/suncalc.js"></script>

