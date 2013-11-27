function probeViewer(){
    var Day_1 = new Date();
    Day_1.setDate(Day_1.getDate() -1);
    var Day_7 = new Date();
    Day_7.setDate(Day_7.getDate() -7);
    var Day_30 = new Date();
    Day_30.setDate(Day_30.getDate() -30);
    
    var ajaxUrl="/data/index";
    d3.json( ajaxUrl + "?station="+ station ,
            function(json) {
                var lst = d3.select("#global-table tbody")
                    .selectAll('tr + tr')
                    .data( json.data.filter(
                        function(element, index, array) {
                            return (element.SEN_DISPLAY_LEVEL & 1);
                        }) )
                    .enter()
                        .append('tr')
                        .attr('id',function(d) { console.log(d.SEN_NAME); return str2id(d.SEN_NAME);})
                        .attr('class',function(d,i) { return i%2 ? 'tg-even' : '';});

                lst.append('td')
                    .attr('class','tg-bf')
                    .attr('title',function(d) { return d.SEN_DESCRIPTIF; })
                    .text(function(d) { return d.SEN_HUMAN_NAME; });
                var current = lst.append('td')
                    .attr('class','current');

                current.append('span')
                        .attr('id',function(d) { return str2id(d.SEN_NAME)+'_Current';});

                // current.append('span')
                //     .text(function(d) { return d.SEN_USER_UNIT; });


                lst.append('td')
                    .append('span')
                        .attr('id',function(d) { return str2id(d.SEN_NAME)+'_Month';})
                        .attr('class','Month');
                lst.append('td')
                    .append('span')
                        .attr('id',function(d) { return str2id(d.SEN_NAME)+'_Week';})
                        .attr('class','Week');
                lst.append('td')
                    .append('span')
                        .attr('id',function(d) { return str2id(d.SEN_NAME)+'_Day';})
                        .attr('class','Day');

                var curveMode = function (d, type) {
                    var curves30 = timeSeriesChart_curves()
                                       .width(30*4+50)
                                       .height(40)
                                       .dateParser("%Y-%m-%d %H:%M")
                                       .dateDomain([formatDate(Day_30, ' '), formatDate(new Date(), ' ')])
                                       .station(station)
                                       .sensor(d.SEN_NAME)
                                       .Color(type)
                                       .nude(true)
                                       .toHumanDate(formulaConverter ('strDate', 'ISO'));
                    curves30.loader("#"+str2id(d.SEN_NAME)+'_Month');

                    var curves7 = timeSeriesChart_curves()
                                       .width(7*4*4+50)
                                       .height(40)
                                       .dateParser("%Y-%m-%d %H:%M")
                                       .dateDomain([formatDate(Day_7, ' '), formatDate(new Date(), ' ')])
                                       .station(station)
                                       .sensor(d.SEN_NAME)
                                       .Color(type)
                                       .nude(true)
                                       .toHumanDate(formulaConverter ('strDate', 'ISO'));
                    curves7.loader("#"+str2id(d.SEN_NAME)+'_Week');

                    var curves1 = timeSeriesChart_curves()
                                       .width(24*4+50)
                                       .height(40)
                                       .dateParser("%Y-%m-%d %H:%M")
                                       .dateDomain([formatDate(Day_1, ' '), formatDate(new Date(), ' ')])
                                       .station(station)
                                       .sensor(d.SEN_NAME)
                                       .Color(type)
                                       .nude(true)
                                       .toHumanDate(formulaConverter ('strDate', 'ISO'));
                    curves1.loader("#"+str2id(d.SEN_NAME)+'_Day');
                }

                var cumulMode = function (d, type) {
                    var barChartM = timeSeriesChart_barChart()
                        .width(30*4+50)
                        .height(40)
                        .ajaxUrl("/data/cumul")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(Day_30), formatDate(new Date())])
                        .station(station)
                        .sensor(d.SEN_NAME)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'))
                        .Color(type)
                        .nude(true);
                    barChartM.loader("#"+str2id(d.SEN_NAME)+'_Month');

                    var barChartW = timeSeriesChart_barChart()
                        .width(7*4*4+50)
                        .height(40)
                        .ajaxUrl("/data/cumul")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(Day_7), formatDate(new Date())])
                        .station(station)
                        .sensor(d.SEN_NAME)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'))
                        .Color(type)
                        .nude(true);
                    barChartW.loader("#"+str2id(d.SEN_NAME)+'_Week');

                    var barChartD = timeSeriesChart_barChart()
                        .width(24*4+50)
                        .height(40)
                        .ajaxUrl("/data/cumul")
                        .dateParser("%Y-%m-%d %H:%M")
                        .dateDomain([formatDate(Day_1), formatDate(new Date())])
                        .station(station)
                        .sensor(d.SEN_NAME)
                        .onClickAction(function(d, i) { console.error (d, i); })
                        .toHumanDate(formulaConverter ('strDate', 'ISO'))
                        .Color(type)
                        .nude(true);
                    barChartD.loader("#"+str2id(d.SEN_NAME)+'_Day');
                }

                var histoWindMode =function (d, type) {

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
                                        .Color(type)
                                        .nude(true);
                    chartM.loader("#"+str2id(d.SEN_NAME)+'_Month');

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
                                        .Color(type)
                                        .nude(true);
                    chartW.loader("#"+str2id(d.SEN_NAME)+'_Week');

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
                                        .Color(type)
                                        .nude(true);
                    chartD.loader("#"+str2id(d.SEN_NAME)+'_Day');
                        }

                console.log(lst);
                lst.each(function(d,i) {
                    // on definie notre objet au plus pres de notre besoin.
                    window.setTimeout(function (){
                        var linkMode;
                        switch (d.SEN_DEF_PLOT) {
                        // switch (d.SEN_MAGNITUDE) {
                            case "barChart":
                                d3.select('#'+str2id(d.SEN_NAME))
                                    .attr('onclick',function(d) { return "javascript:location.href='/viewer/barChart/"+station+'/'+(d.SEN_NAME)+"'; return false;";})
                                cumulMode(d,1);
                                break;
                            case "wind":
                                d3.select('#'+str2id(d.SEN_NAME))
                                    .attr('onclick',function(d) { return "javascript:location.href='/viewer/wind/"+station+"'; return false;";})
                                histoWindMode(d,2);
                                break;
                            case "curves":
                                d3.select('#'+str2id(d.SEN_NAME))
                                    .attr('onclick',function(d) { return "javascript:location.href='/viewer/curves/"+station+"'; return false;";})
                                curvesMode(d,3);
                                break;
                            default:
                                d3.select('#'+str2id(d.SEN_NAME))
                                    .attr('onclick',function(d) { return "javascript:location.href='/viewer/curve/"+station+'/'+(d.SEN_NAME)+"'; return false;";})
                                curveMode(d,4);
                        }
                    }
                    , (i-1)*1000);
                })
            }
            );
}
function str2id (str)
{
    return 'X'+MD5(str);
}