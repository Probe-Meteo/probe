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
    <p>tesr<span id="barSvgArea">
        <!-- d3 content should be -dynamically- placed here -->
    </span> truc <span id="barSvgArea0">
        <!-- d3 content should be -dynamically- placed here -->
    </span>sdf <span id="barSvgArea1">
        <!-- d3 content should be -dynamically- placed here -->
    </span>sdf <span id="barSvgArea2">
        <!-- d3 content should be -dynamically- placed here -->
    </span>sdf <span id="barSvgArea3">
        <!-- d3 content should be -dynamically- placed here -->
    </span>sdf <span id="barSvgArea4">
        <!-- d3 content should be -dynamically- placed here -->
    </span>dsfh <span id="barSvgArea5">
        <!-- d3 content should be -dynamically- placed here -->
    </span></p>
    <div id="barSvgArea99" style='height:160px;'>
        <!-- d3 content should be -dynamically- placed here -->
    </div></div>

<style>
    svg {
    	font-size: 10px;
        }

    .Barbox {
        /*clip-path:url(#8b65a37af5cb476adf3e0e0e623b1896);*/
    }
    .bar {
        fill: #aec7e8;
        stroke: #1F77B4;
        stroke-width: 1px;
        shape-rendering: crispEdges;
        }

    .bar:hover, .sensitive:hover > .bar {
        stroke: #E6550D;
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
    .Infos {
        text-anchor:middle;
    }
    .legend .legend_min, .legend .legend_avg, .legend .legend_max, .legend .legend_sum { 
        font-size: 8px;
    }
    </style>

<script>
  function probeViewer(){
    include_barChart_n("#barSvgArea", '<?=$station?>', '<?=$sensor?>', 141);
    include_barChart_n("#barSvgArea0", '<?=$station?>', '<?=$sensor?>', 153);
    include_barChart_n("#barSvgArea1", '<?=$station?>', '<?=$sensor?>', 161);
    include_barChart_n("#barSvgArea2", '<?=$station?>', '<?=$sensor?>', 162);
    include_barChart_n("#barSvgArea2", '<?=$station?>', '<?=$sensor?>', 163);
    include_barChart_n("#barSvgArea4", '<?=$station?>', '<?=$sensor?>', 164);
    include_barChart_n("#barSvgArea5", '<?=$station?>', '<?=$sensor?>', 165);
    include_barChart("#barSvgArea99", '<?=$station?>', '<?=$sensor?>', 1900);
  }
  </script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<!-- <script src="/resources/js/libs/jquery-ui-1.10.2.custom.js"></script> -->

