<?php
/** barChart.php
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

//http://probe.dev/viewer/dotChart/VP2_GTD

?>
<div id="resizable" class="ui-widget-content">
    <h4 class="ui-widget-header">Sum Historical Chart</h4>
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

<style>
    svg {
    	font-size: 10px;
        }

    .Barbox {
        /*clip-path:url(#8b65a37af5cb476adf3e0e0e623b1896);*/
    }
    .bar {
        /*fill: #aec7e8;*/
        /*stroke: #1F77B4;*/
        stroke-width: 1px;
        shape-rendering: crispEdges;
        }

    .bar:hover, .sensitive:hover > .bar {
        /*stroke: #E6550D;*/
        stroke-width: 2px;
        shape-rendering: crispEdges;
        }

    .axis line,.axis path {
        fill: none;
        stroke: #2C3539;
        stroke-width: 1px;
        shape-rendering: crispEdges;
    }
    .sensitive {
        opacity: 0;
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
    </style>

<script>
    var station = '<?=$station?>';
    var sensor = '<?=$sensor?>';

function probeViewer() {
    var Day_1 = new Date();
    Day_1.setDate(Day_1.getDate() -1);
    var Day_7 = new Date();
    Day_7.setDate(Day_7.getDate() -7);
    var Day_30 = new Date();
    Day_30.setDate(Day_30.getDate() -30);
    var Day_365 = new Date();
    Day_365.setDate(Day_365.getDate() -365);

    // on definie notre objet au plus pres de notre besoin.
    var barChartY = timeSeriesChart_barChart()
                        .width(52*4+50)
                        .height(40)
                        .ajaxUrl("/data/cumul")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(Day_365), formatDate(new Date())])
                        .station(station)
                        .sensor(sensor)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'))
                        .Color(1)
                        .nude(true);
    barChartY.loader("#YearBarChar");

    var barChartM = timeSeriesChart_barChart()
                        .width(30*4+50)
                        .height(40)
                        .ajaxUrl("/data/cumul")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(Day_30), formatDate(new Date())])
                        .station(station)
                        .sensor(sensor)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'))
                        .Color(2)
                        .nude(true);
    barChartM.loader("#MonthBarChar");

    var barChartW = timeSeriesChart_barChart()
                        .width(7*4*4+50)
                        .height(40)
                        .ajaxUrl("/data/cumul")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(Day_7), formatDate(new Date())])
                        .station(station)
                        .sensor(sensor)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'))
                        .Color(3)
                        .nude(true);
    barChartW.loader("#WeekBarChar");

    var barChartD = timeSeriesChart_barChart()
                        .width(24*4+50)
                        .height(40)
                        .ajaxUrl("/data/cumul")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(Day_1), formatDate(new Date())])
                        .station(station)
                        .sensor(sensor)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'))
                        .Color(4)
                        .nude(true);
    barChartD.loader("#TodayBarChar");



    var barChartZoom = timeSeriesChart_barChart()
                        .width($('#barSvgArea').width()-16)
                        .height(200)
                        .ajaxUrl("/data/cumul")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(Day_365), formatDate(new Date())])
                        .station(station)
                        .sensor(sensor)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'))
                        .Color(6)
                        .nude(false);
    barChartZoom.loader("#barSvgArea");

  }
  </script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<!-- <script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script> -->

