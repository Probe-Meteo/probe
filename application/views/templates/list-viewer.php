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
$station="VP2_GTD";
?>
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
    /*.fixed-fluid {
        margin-left: 240px;
    }
    .fluid-fixed {
        margin-right: 240px;
        margin-left:auto !important;
    }*/
    .fixed-fixed {
        margin-left: 240px;
    }
</style>
<script type="text/javascript">
    var station = '<?=$station?>';
</script>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="well sidebar-nav left">
        	<ul id="list-viewer">
			    <?php foreach ($list as $key => $file): ?>
			        <li>
			            <a href="/viewer/<?=$file;?>"><?=$file;?></a>
			        </li>
			    <?php endforeach ?>
			</ul>
        </div>


        <div id="middleChartsArea" class="content fixed-fixed">
			<style type="text/css">
			.tg-table-light { border-collapse: collapse; border-spacing: 0;  border: 1.5px #bbb solid;}
			.tg-table-light td, .tg-table-light th { background-color: #fff; border-bottom: 1px #bbb solid; color: #333; font-family: sans-serif; font-size: 100%; padding: 10px; vertical-align: top; }
			.tg-table-light .tg-even td  { background-color: #eee; }
			.tg-table-light th  { background-color: #ddd; color: #333; font-size: 110%; font-weight: bold; }
			.tg-table-light tr:hover td, .tg-table-light tr.even:hover td  { color: #222; background-color: #FCFBE3; }
			.tg-bf { font-weight: bold; } .tg-it { font-style: italic; }
			.tg-left { text-align: left; } .tg-right { text-align: right; } .tg-center { text-align: center; }
			</style>

			<table class="tg-table-light">
			  <tr>
			    <th class="tg-center">Sensor</th>
			    <th class="tg-center tg-bf">Current</th>
			    <th class="tg-center">24h Curve</th>
			    <th class="tg-center">7j Curve</th>
			  </tr>
			  <tr class="tg-even">
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_1" class="SmallCurve24h" style="width:100px">

					</span>
		        </td>
			    <td>
					<span id="SvgSC_1b" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr>
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_2" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_2b" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr class="tg-even">
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr>
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr class="tg-even">
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr>
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr class="tg-even">
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr>
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr class="tg-even">
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr>
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr class="tg-even">
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr>
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr class="tg-even">
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			  <tr>
			    <td class="tg-bf"></td>
			    <td></td>
			    <td class="tg-center">
					<span id="SvgSC_xyz" class="SmallCurve24h" style="width:100px">

					</span>
				</td>
			    <td>
					<span id="SvgSC_xyz" class="SmallCurve7j" style="width:100px">

					</span>
				</td>
			  </tr>
			</table>
        </div>
    </div>
</div>
<script>
    function probeViewer(){

	var someDate1 = new Date();
	var someDate7 = new Date();
	someDate1.setDate(someDate1.getDate() -1);
	someDate7.setDate(someDate7.getDate() -7);

    // on definie notre objet au plus pres de notre besoin.
    var curves = timeSeriesChart_curves()
                        .width(120)
                        .height(40)
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(someDate7, ' '), formatDate(new Date(), ' ')])
                        .station(station)
                        .sensor('TA:Arch:Hum:In:Current')
                        .Color(1)
                        .nude(true)
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));
    curves.loader("#SvgSC_1b");

    var curves = timeSeriesChart_curves()
                        .width(120)
                        .height(40)
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(someDate1, ' '), formatDate(new Date(), ' ')])
                        .station(station)
                        .sensor('TA:Arch:Hum:In:Current')
                        .Color(1)
                        .nude(true)
                        .toHumanDate(formulaConverter ('strDate', 'ISO'));
    curves.loader("#SvgSC_1");
   }
</script>
<script src="/resources/js/libs/d3.v3.js"></script>
<script src="/resources/js/ProbeTools.js"></script>
<script src="/resources/js/libs/base64.js"></script>
<script src="/resources/js/binders/curves.js"></script>

