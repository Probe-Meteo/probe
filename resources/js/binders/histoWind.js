/** SmartChart.js
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
*/


function timeSeriesChart() {
	var margin = {top: 20, right: 20, bottom: 20, left: 20},
		width = 760,
		height = 120,
		xValue = function(d) { return d[0]; },
		yValue = function(d) { return d[1]; },
		xScale = d3.time.scale(),
		yScale = d3.scale.linear(),
		xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(6, 0),
		// area = d3.svg.area().x(X).y1(Y),
		line = d3.svg.line().x(X).y(Y);
	var parse = d3.time.format("%Y-%m-%d %H:%M").parse
	var color = d3.scale.category20();


	function hair(selection) {

	}
	
	function chart(selection) {


		// Update the x-scale.
		xScale
		  .domain(d3.extent(data.map(function(d) { return d.date; })))
		  .range([0, width - margin.left - margin.right]);


		// Select the svg element, if it exists.
		var svg = d3.select(this).selectAll("svg").data([data]);

		// Otherwise, create the skeletal chart.
		var gEnter = svg.enter().append("svg").append("g");
		// gEnter.append("path").attr("class", "area");
		gEnter.append("path").attr("class", "line");
		gEnter.append("g").attr("class", "x axis");

		// Update the outer dimensions.
		svg .attr("width", width)
		  .attr("height", height);

		// Update the inner dimensions.
		var g = svg.select("g")
		  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

		// Update the area path.
		// g.select(".area")
		  // .attr("d", area.y0(yScale.range()[0]));

		// Update the line path.
		g.select(".line")
		  .attr("d", line);

		// Update the x-axis.
		g.select(".x.axis")
		  .attr("transform", "translate(0," + yScale.range()[0] + ")")
		  .call(xAxis);
		});
	}











  // The x-accessor for the path generator; xScale ∘ xValue.
  function X(d) {
    return xScale(d[0]);
  }

  // The x-accessor for the path generator; yScale ∘ yValue.
  function Y(d) {
    return yScale(d[1]);
  }

  chart.margin = function(_) {
    if (!arguments.length) return margin;
    margin = _;
    return chart;
  };

  chart.width = function(_) {
    if (!arguments.length) return width;
    width = _;
    return chart;
  };

  chart.height = function(_) {
    if (!arguments.length) return height;
    height = _;
    return chart;
  };

  chart.x = function(_) {
    if (!arguments.length) return xValue;
    xValue =_;
    return chart;
  };

  chart.y = function(_) {
    if (!arguments.length) return yValue;
    yValue = _;
    return chart;
  };

  return chart;
}