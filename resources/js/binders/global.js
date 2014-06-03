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
                    .append('a')
                    .append('span')
                        .attr('id',function(d) { return str2id(d.SEN_NAME)+'_Month';})
                        .attr('class','Month');
                lst.append('td')
                    .append('a')
                    .append('span')
                        .attr('id',function(d) { return str2id(d.SEN_NAME)+'_Week';})
                        .attr('class','Week');
                lst.append('td')
                    .append('a')
                    .append('span')
                        .attr('id',function(d) { return str2id(d.SEN_NAME)+'_Day';})
                        .attr('class','Day');

                var curveMode = function (d, type, load) {
                    if (load >= 30) {
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
                    }
                    if (load >= 7)
                    {
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
                    } else {
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
                }

                var cumulMode = function (d, type, load) {
                    if (load >= 30) {
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
                    }
                    if (load >= 7)
                    {
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
                    } else {
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
                }

                var histoWindMode =function (d, type, load) {
                    if (load >= 30) {
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
                    }
                    if (load >= 7)
                    {
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
                    } else {
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
                }

                console.log(lst);
                lst.each(function(d,i) {
                    // on definie notre objet au plus pres de notre besoin.
                    window.setTimeout(function (){
                        var linkMode;
                        var id=str2id(d.SEN_NAME);
                        var row=d3.select('#'+id);
                        switch (d.SEN_DEF_PLOT) {
                        // switch (d.SEN_MAGNITUDE) {
                            case "barChart":
                                linker = row.selectAll('td > a')
                                    .attr('href', "/viewer/barChart/"+station+'/'+(d.SEN_NAME));
                                cumulMode(d, 1, 1);
                                row.on('mouseover',function(d) {
                                    cumulMode(d, 1, 30);
                                    // $('#circular3dG').clone().appendTo('#'+id+'_Month').attr('id', id+'_load');
                                    row.on('mouseover',null);
                                });
                                break;
                            case "wind":
                                linker = row.selectAll('td > a')
                                    .attr('href', "/viewer/wind/"+station);
                                histoWindMode(d, 2, 1);
                                row.on('mouseover',function(d) {
                                    histoWindMode(d, 2, 30);
                                    // $('#circular3dG').clone().appendTo('#'+id+'_Month').attr('id', id+'_load');
                                    row.on('mouseover',null);
                                });
                                break;
                            case "curves":
                                linker = row.selectAll('td > a')
                                    .attr('href', "/viewer/curves/"+station+'/'+(d.SEN_NAME));
                                curveMode(d, 4, 1);
                                row.on('mouseover',function(d) {
                                    curveMode(d, 4, 30);
                                    // $('#circular3dG').clone().appendTo('#'+id+'_Month').attr('id', id+'_load');
                                    row.on('mouseover',null);
                                });
                                break;
                            default:
                                linker = row.selectAll('td > a')
                                    .attr('href', "/viewer/curve/"+station+'/'+(d.SEN_NAME));
                                curveMode(d, 4, 1);
                                row.on('mouseover',function(d) {
                                    curveMode(d, 4, 30);
                                    // $('#circular3dG').clone().appendTo('#'+id+'_Month').attr('id', id+'_load');
                                    row.on('mouseover',null);
                                });
                        }
                    }
                    , (i-1)*200);
                })
            }
            );
}
function str2id (str)
{
    return 'X'+MD5(str);
}
