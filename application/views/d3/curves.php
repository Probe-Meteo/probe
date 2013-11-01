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
    <p>teste de truc a raconter au sujet de cette courbe
        <span id="curveSvgArea01" style="width:100px">
            <!-- d3 content should be -dynamically- placed here -->
        </span> y a aussi d'autre infos
        <span id="curveSvgArea02" width:100px>
            <!-- d3 content should be -dynamically- placed here -->
        </span> et des donnees suplementaire
        <span id="curveSvgArea03" style="width:100px">
            <!-- d3 content should be -dynamically- placed here -->
        </span>
    </p>
    <span id="curveSvgArea6">
        <!-- d3 content should be -dynamically- placed here -->
    </span>
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
        include_nudecurves("#curveSvgArea01", station, sensor, 60);
        include_nudecurves("#curveSvgArea02", station, sensor, 50);
        include_nudecurves("#curveSvgArea03", station, sensor, 300);
        include_curves("#curveSvgArea6", station, sensor, $('#resizable').width()-20);

    }


</script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>

