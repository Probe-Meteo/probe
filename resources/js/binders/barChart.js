/** barChart.js
* D3 binder to visualize <dataset> data
*
* @category D3Binder
* @package  Probe
* @author   alban lopez <alban.lopez+probe@gmail.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe-meteo.com/doc
*/

    // var Day_30 = new Date();
    // Day_30.setDate(Day_30.getDate() -30);
    // var Tomorow = new Date();
    // Tomorow.setDate(Tomorow.getDate() +1);

// function include_barChart_n(container, station, sensor, XdisplaySizePxl)
// {
//     var formatDate = d3.time.format("%Y-%m-%d %H:%M");

//     // on definie notre objet au plus pres de notre besoin.
//     var barChart = timeSeriesChart_barChart()
//                         .width(XdisplaySizePxl)
//                         .height(40)
//                         .ajaxUrl("/data/cumul")
//                         // .date(function(d) { return formatDate.parse (d.date); })
//                         .dateParser("%Y-%m-%d %H:%M")
//                         .dateDomain([formatDate(Day_30), formatDate(Tomorow)])
//                         .station(station)
//                         .sensor(sensor)
//                         .onClickAction(function(d, i) { console.error (d, i); })
//                         .toHumanDate(formulaConverter ('strDate', 'ISO'))
//                         .Color()
//                         .nude(true);

//     barChart.loader(container);
// }
// function include_barChart(container, station, sensor, XdisplaySizePxl)
// {
//     var formatDate = d3.time.format("%Y-%m-%d %H:%M");

//     // on definie notre objet au plus pres de notre besoin.
//     var barChart = timeSeriesChart_barChart()
//                         .width(XdisplaySizePxl)
//                         .ajaxUrl("/data/cumul")
//                         // .date(function(d) { return formatDate.parse (d.date); })
//                         .dateParser("%Y-%m-%d %H:%M")
//                         .dateDomain([formatDate(Day_30), formatDate(Tomorow)])
//                         .station(station)
//                         .sensor(sensor)
//                         .onClickAction(function(d, i) { console.error (d, i); })
//                         .toHumanDate(formulaConverter ('strDate', 'ISO'))
//                         .Color();

//     barChart.loader(container);
// }









var color=d3.scale.category20();
function timeSeriesChart_barChart() {
  var   data,
        margin = {top: 5, right: 5, bottom: 28, left: 40},
        width = 600,
        height = 160,
        station = null,
        sensor = null,
        dataheader = null,
        dateDomain = [formatDate(new Date(0)), formatDate(new Date())],
        ajaxUrl = null,
        nude = false,
        onClickAction = function(d) { console.error (d); },
        unit = false,
        md5 = false,
        darkColor = false,
        lightColor = false,
        toHumanUnit = function(SI){if (!arguments.length) return '';return +SI;},
        toHumanDate = function(SI){if (!arguments.length) return '';return +SI;},
        timeFormat = d3.time.format("%Y-%m-%dT%H:%M:%S"),
        dateParser = function(d) { return timeFormat.parse (d.date); },
        val = function(d) { return toHumanUnit(+d.val); },
        xScale = d3.time.scale().range([0, width]),
        yScale = d3.scale.linear().range([height, 0]),
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(4,6),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(4).tickSize(3,5);
        // line = d3.svg.line().x(X).y(Y);
        // circle = d3.svg.circle().


    function chart(selection) {
        md5 = MD5(station+sensor+(new Date()).getMilliseconds());
        if (!darkColor)  darkColor=color(md5+'0');
        if (!lightColor)  lightColor=color(md5+'1');
        //selection represente la liste de block ou ecire les donnees
        selection.each(function(rawdata) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = rawdata.map(function(d, i) {
                var date=dateParser.call(rawdata, d, i)
                return {
                        val:val.call(rawdata, d, i),
                        // date:dateParser.call(rawdatarawdata, d, i),
                        date:date,
                        period:[
                            new Date(date.getTime()-(60*1000*dataheader.step/2)),
                            new Date(date.getTime()+(60*1000*dataheader.step/2))
                        ]
                    };
            });
        if (nude)
            margin.right = width - margin.left - ((data.length)*4-3);

            // Update the x-scale.
            xScale
                .domain(d3.extent(data, function(d) { return d.date; }))
                .range([0, width - margin.left - margin.right]);

            // Update the y-scale.
            yScale
                .domain(d3.extent(data, function(d) {return +d.val; }))
                .range([height - margin.top - margin.bottom, 0]);

            // Select the svg element, if it exists.
            var svg = d3.select(this).selectAll("svg").data([data]);


            // Otherwise, create the skeletal chart.
            var gEnter = svg.enter()
                        .append("svg")
                            .attr("viewBox", "0 0 "+width+" "+height)
                            .attr("width", function(){return nude ? width : "100%";})
                            .attr("height", height);

            // chose the possition of x-Axis
            if (0<yScale.domain()[0])
                xPos = yScale.range()[0];
            else if (yScale.domain()[1]<0)
                xPos = yScale.range()[1];
            else
                xPos = yScale(0);

            gEnter.append("svg:clipPath")
                .attr("id", "" + md5)
                .append("svg:rect")
                .attr('width', width - margin.left - margin.right)
                .attr('height', height - margin.top - margin.bottom);

            var timeoutID=null;
            var Sensitive = svg.append("rect")
                .attr("class", "sensitive")
                .attr('log_test-truc','la_1')
                .attr('width', width - margin.left - margin.right)
                .attr('height', height - margin.top - margin.bottom)
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            var g = gEnter.append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
            // Draw stepPetalsBox block (on mouse hover point view foreach rose)
            var BarBox = g.selectAll(".BarBox")
                .data(data)
                .enter()
                .append("g")
                    .attr("class", "BarBox")
                    .attr("clip-path", "url(#" + md5 + ")")
                    .append("rect")
                        .attr("class", "bar")
                        .append("title");

            if (!nude) {
                g.append("g").attr("class", "x axis");
                g.append("g").attr("class", "y axis");

                g.updateCurve = function(){
                    yScale.domain(
                        d3.extent(
                            data.filter(function(element, index, array){
                              return (element.date>=xScale.domain()[0] && element.date<=xScale.domain()[1]);
                          }), function(d) {return d.val; }));
                    this.selectAll(".BarBox rect")
                                .attr("x",  function (d) { return X(d) -(4+1);})
                                .attr("y", Y)
                                .attr("width", 8)
                                .attr("height", function(d) {return Math.abs(xPos-Y(d));})
                                .attr("stroke", darkColor)
                                .attr("fill", lightColor)
                                .on("click", function(d) { return onClickAction(d); })
                                .on("mouseover", function(d) {
                                        legendDate.text(timeFormat(d.date,' '));
                                        legendVal.text(formatVal(d.val));
                                        // legendSum.text("∑ "+formatVal(toHumanUnit(dataheader.sum), 0));
                                    })
                                .select('title')
                                .text(function(d) {
                                        return formatVal(+d.val)+" (in "+dataheader.step+"min)\nFrom : "+toHumanDate(d.period[0])+"\nto : "+toHumanDate(d.period[1]);
                                    });
                    return this;
                }
                g.drawAxis = function() {
                    // Update the x-axis.
                    this.select(".x.axis")//.transition().duration(1000)
                        .attr("transform", "translate(-1," + (xPos+12) + ")") // axe tjrs en bas : yScale.range()[0] + ")")
                        .call(xAxis);
                    this.select(".y.axis")
                        .attr("transform", "translate(-1,0)")
                        .call(yAxis);
                    legendSum.text(Sum);
                    return this;
                }
                var legend = g.append("g")
                    .attr("class", "legend")
                    .attr("transform", "translate(0,"+(height - margin.bottom +5)+")")
                    .attr("fill", darkColor);

                var legendTitle = legend.append('text')
                    .attr("class","title")
                    .text(dataheader.sensor.SEN_HUMAN_NAME);

                var legendXleft = width - margin.left - margin.right - 4;
                var legendDate = legend.append('text')
                    .attr("class","date")
                    .attr('x', legendXleft-(formatVal(dataheader.max).length+2)*6)
                    .text('Scroll for Zoom');
                   // console.log(legendDate.getComputedTextLength());

                var legendVal = legend.append('text')
                    .attr("class","val")
                    .attr('x', legendXleft)
                    .text(formatVal(data[data.length-1].val));


                var Sum = function() {return "∑ = "+formatVal(toHumanUnit(dataheader.sum), 2);},
                    legendSum = legend.append('text')
                        .attr("class","Infos")
                        .attr('x', legendXleft/2)
                        .text(Sum);

                // Update the outer dimensions.
                svg .attr("width", width)
                    .attr("height", height);

                Sensitive.call(zm=d3.behavior.zoom().x(xScale).scaleExtent([1,1000]).on("zoom", function(){
                    window.clearTimeout(timeoutID);
                    timeoutID = window.setTimeout(function(){zoom(g)}, 400);                
                    g.updateCurve()
                     .drawAxis ();
                    // console.TimeStep('Zoom');
                }));

                g.updateCurve()
                 .drawAxis();
            }
            else {
                g.updateCurve = function(){
                    yScale.domain(
                        d3.extent(data, function(d) {return d.val; }));
                    this.selectAll(".BarBox rect")
                                .attr("x", function (d) { return X(d)+1;})
                                .attr("y", height)
                                .attr("width", 2)
                                .attr("stroke", darkColor)
                                .attr("fill", lightColor)
                                .transition().delay(function (d,i) { return i*50;}).duration(500)
                                .attr("height", function(d) {return Math.abs(xPos-Y(d));})
                                .attr("y", Y)
                                .select('title')
                                .text(function(d) {
                                        return formatVal(+d.val)+"\nFrom : "+toHumanDate(d.period[0])+"\nto : "+toHumanDate(d.period[1]);
                                    });

                    return this;
                }
                g.updateCurve();
                var legend = gEnter.append("g")
                    .attr("class", "legend")
                    .attr("transform", "translate("+(width - margin.right+2)+",0)")
                    // .attr("transform", "translate(0,"+(height - margin.bottom +5)+")")
                    .attr("fill", darkColor);

                var legendmax = legend.append('text')
                    .attr("class","legend_max")
                    .attr("y", (6))
                    .text('↑ '+formatVal(toHumanUnit(dataheader.max), 1))
                    .append('title')
                        .text('↑ max:'+formatVal(toHumanUnit(dataheader.max), 2));
                var legendavg = legend.append('text')
                    .attr("class","legend_avg")
                    .attr("y", (height+6)/2)
                    .text('↔ '+formatVal(toHumanUnit(dataheader.avg), 2))
                    .append('title')
                        .text('↔ Avg:'+formatVal(toHumanUnit(dataheader.avg), 3));
                var legendmin = legend.append('text')
                    .attr("class","legend_min")
                    .attr("y", (height-2))
                    .text("∑ "+formatVal(toHumanUnit(dataheader.sum), 0))
                    .append('title')
                        .text("∑ Sum:"+formatVal(toHumanUnit(dataheader.sum), 2));

            }
        });
    }  



    function zoom(g) {
        var ready = false,
            dataTsv = false,
            zmDomain=xScale.domain();
        console.TimeStep('Zoom');
        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        // on charge les données et on lance le tracage
        var DomBuilder = function(data2add) {
            data2add = data2add.map(function(d, i) {
                var date=dateParser.call(data2add, d, i)
                return {
                        val:val.call(data2add, d, i),
                        // date:dateParser.call(rawdatarawdata, d, i),
                        date:date,
                        period:[
                            new Date(date.getTime()-(60*1000*dataheader.step/2)),
                            new Date(date.getTime()+(60*1000*dataheader.step/2))
                        ]
                    };
            });
            
            data = data.filter(function(element, index, array){
                      return (element.date<data2add[0].date || (element.date>data2add[data2add.length-1].date && element.date<(new Date())) );
                  })

            var bars = g.selectAll(".BarBox")
                .data(data, function(d) { return d.date; });
            bars.exit().remove();
            
            data = data
               .concat(data2add)
               .sort(function (a, b) {
                   return a.date-b.date;
                  });
            bars = g.selectAll(".BarBox")
                .data(data, function(d) { return d.date; });

            bars.enter()
                .append("g")
                    .attr("class", "BarBox")
                    .attr("clip-path", "url(#" + md5 + ")")
                    .append("rect")
                        .attr("class", "bar")
                        .append("title");
        };

        d3.tsv( ajaxUrl + "?station="+ station +"&sensor=" + sensor + "&XdisplaySizePxl="+width+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1],'T'),
            function(data2add) {
                if (ready) {
                    DomBuilder(data2add);
                    g.updateCurve()
                     .drawAxis ();
                }
                ready = true;
                dataTsv = data2add;
            }
        );

        d3.json( ajaxUrl + "?station="+ station +"&sensor=" + sensor + "&XdisplaySizePxl="+width+"&infos=dataheader"+"&Since="+formatDate(zmDomain[0],'T')+"&To="+formatDate(zmDomain[1],'T'),
            function(header) {

                chart//.yDomain([header.min, header.max])
                    .dataheader(header);
                
                if (ready) {
                    DomBuilder(dataTsv);
                    g.updateCurve()
                     .drawAxis ();
                }
                ready = true;
            }
        );
    }

    // The x-accessor for the path generator; xScale ∘ dateParser.
    function X(d) {
        return xScale(d.date);
    }

    // The x-accessor for the path generator; yScale ∘ Speed.
    function Y(d) {
        return yScale(+d.val);
    }

    function formatVal(v, decimal) {
        if (arguments.length<2)
            decimal=2;
        //console.log(v, (+v).toPrecision(5));
        return (+v).toFixed(decimal) +' '+ toHumanUnit();
    }

// ================= Property of chart =================

    chart.loader = function(container) {
        var ready = false,
            dataTsv = false,
            w = (width - margin.left - margin.right) * (nude*2+1);

        // on demande les infos importante au sujet de notre futur tracé
        // ces infos permettent de finir le parametrage de notre "Chart"
        // on charge les données et on lance le tracage
        d3.tsv( ajaxUrl + "?station="+ station +"&sensor="+ sensor +"&XdisplaySizePxl="+w+"&Since="+dateDomain[0]+"&To="+dateDomain[1],
            function(data) {
                // console.TimeStep('load Data');
                // console.log(data);
                if (ready) {
                    d3.select(container)
                        .datum(data)
                        .call(chart);
                }
                ready = true;
                dataTsv = data;
            }
        );

        d3.json( ajaxUrl + "?station="+ station +"&sensor="+ sensor +"&XdisplaySizePxl="+w+"&infos=dataheader"+"&Since="+dateDomain[0]+"&To="+dateDomain[1],
            function(data) {
                // console.TimeStep('load Header');
                // console.log(data);
                chart
                    .dataheader(data)
                    .toHumanUnit(formulaConverter (data.sensor.SEN_MAGNITUDE, data.sensor.SEN_USER_UNIT));

                if (ready) {
                    // console.log(data);
                    d3.select(container)
                        .datum(dataTsv)
                        .call(chart);
                }
                ready = true;
            }
        );
        return chart;
    }

// ================= Accesseurs =====================


    chart.nude = function(_) {
        if (!arguments.length) return nude;
        nude = _;
        if (_) {
            margin = {top: 1, left: 2, bottom: 1, right: 55};
        }
        return chart;
    };
    chart.dateParser = function(_) { // genere la fonction de conversion du champ [string]:date en [date]:date
        if (!arguments.length) return dateParser;
        if (typeof _ === "string") {
            timeFormat = d3.time.format(_);
            dateParser = function(d) { return timeFormat.parse (d.date); };
        } else dateParser = _;
        return chart;
    };
    chart.dateDomain = function(_) {
        if (!arguments.length) return dateDomain;
        dateDomain = _;
        return chart;
    };
    chart.Color = function(_) {
        if (/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(_)) {
            darkColor = _;
            lightColor = '#c7c7c7';
        } else {
            darkColor = color(_+'1');
            lightColor = color(_+'2');
        }
        return chart;
    };
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
    chart.date = function(_) {
        if (!arguments.length) return dateParser;
        dateParser = _;
        return chart;
    };
    chart.val = function(_) {
        if (!arguments.length) return val;
        val = _;
        return chart;
    };
    chart.ajaxUrl = function(_) {
        if (!arguments.length) return ajaxUrl;
        ajaxUrl = _;
        return chart;
    };
    chart.station = function(_) {
        if (!arguments.length) return station;
        station = _;
        return chart;
    };
    chart.sensor = function(_) {
        if (!arguments.length) return sensor;
        sensor = _;
        return chart;
    };
    chart.onClickAction = function(_) {
        if (!arguments.length) return onClickAction;
        onClickAction = _;
        return chart;
    };
    chart.dataheader = function(_) {
        if (!arguments.length) return dataheader;
        dataheader = _;
        return chart;
    };
    chart.sensor = function(_) {
        if (!arguments.length) return sensor;
        sensor = _;
        return chart;
    };
    chart.toHumanUnit = function(_) {
        if (!arguments.length) return toHumanUnit;
        toHumanUnit = _;
        return chart;
    };
    chart.toHumanDate = function(_) {
        if (!arguments.length) return toHumanDate;
        toHumanDate = _;
        return chart;
    };

  return chart;
}