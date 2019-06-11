<!DOCTYPE html>
<html>
 	<head>
 		<title>Smart Waste-Bin</title>			
 		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
 		<?php require_once 'navbar.php' ?>
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/highcharts-more.js"></script>
		<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
	</head>
 	
	<body>
 		<center><h1 class="title is-1">Smart Waste-Bin</h1></center><br>
 				
		<div id="dashboard">
			
			<div class="columns">
				<div class="column">
					<!--<div style="width: 600px; height: 200px;">-->
					<div class="columns">
						<div class="column">
							<center><br><br><div id="container-tmp" style="width: 300px; height: 200px; "></div></center>
						</div>
						<div class="column">
							<center><br><br><div id="container-humid" style="width: 300px; height: 200px; "></div></center>
						</div>
					</div>
				</div>
				<div class="column">
					<center><p><div id="container-h_t" style="min-width: 300px; height: 300px; margin: 0 auto"></div></p></center>
				</div>
			</div>
			
			<div class="columns">
				<div class="column">
					<!--<div style="width: 600px; height: 200px;">-->
					<center><h1><div id="container-lvl_time" style="min-width: 300px; height: 300px; margin: 0 auto"></div></h1></center>
				</div>
				<div class="column">
					<!--<div style="width: 600px; height: 200px;">-->
					<div class="columns">
						<div class="column">
							<center><br><br><br>
						<div id="container-lvl" style="width: 300px; height: 200px; "></div></center>
						</div>
						<div class="column">		
							<center><div id="container-mois" style="min-width: 150px; max-width: 150px; height: 150px; margin: 0 auto"></div></center>
							<center><div id="container-flame" style="min-width: 150px; height: 150px; max-width: 150px; margin: 0 auto"></div></center>
						</div>
					</div>
				</div>
			</div>	
			<div class="columns">
				<div class="column">
					<center><div id="container-usage" style="min-width: 300px; height: 300px; margin: 0 auto"></div><center>
				</div>
				<div class="column">
					<center><div id="concon" style="min-width: 300px; height: 300px; margin: 0 auto"></div><center>
				</div>
			</div>
			<!--live-->
			
		</div>
	</body>
	<?php require_once 'footer.php' ?>
</html>


<script type="text/javascript">					
	var gaugeOptions = {
		chart: {
		type: 'solidgauge'
		},
	title: null,
	pane: {
		center: ['50%', '85%'],
		size: '150%',
		startAngle: -90,
		endAngle: 90,
		background: {
			backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
			innerRadius: '60%',
			outerRadius: '100%',
			shape: 'arc'
			}
		},
	tooltip: {
		enabled: false
		},
					
	// the value axis
	yAxis: {
		stops: [
		[0.1, '#82daff'], // blue
		[0.5, '#9483ff'], // purple
		[0.9, '#ca74ff']  // violet
		],
		lineWidth: 0,
		minorTickInterval: null,
		tickAmount: 2,
		title: {
			y: -70
			},
		labels: {
			y: 16
			}
		},
	plotOptions: {
		solidgauge: {
			dataLabels: {
				y: 5,
				borderWidth: 0,
				useHTML: true
				}
			}
		}
	};
		
	// The Temperature gauge
	var chartTmp = Highcharts.chart('container-tmp', Highcharts.merge(gaugeOptions, {
		yAxis: {
			min: 0,
			max: 80,
			title: {
				text: 'Temperature'
				}
			},
						
		credits: {
			enabled: false
			},
						
		series: [{
			name: 'Temperature',
			data: [0],
			dataLabels: {
				format: '<div style="text-align:center"><span style="font-size:25px;color:' +
				((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
				'<span style="font-size:12px;color:gray">°C</span></div>'
				},
			tooltip: {
				valueSuffix: ' revolutions/min'
				}
			}]
					
		}));
						
	// The Humudity gauge
	var chartHumid = Highcharts.chart('container-humid', Highcharts.merge(gaugeOptions, {
		yAxis: {
			min: 0,
			max: 100,
			title: {
				text: 'Humidity'
				}
			},
		credits: {
			enabled: false
			},

		series: [{
			name: 'Humidity',
			data: [0],
			dataLabels: {
				format: '<div style="text-align:center"><span style="font-size:25px;color:' +
				((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
				'<span style="font-size:12px;color:gray">%</span></div>'
				},
			tooltip: {
				valueSuffix: ' revolutions/min'
				}
			}]
		}));
								
	// The Level gauge
	var chartLvl = Highcharts.chart('container-lvl', Highcharts.merge(gaugeOptions, {
		yAxis: {
			min: 0,
			max: 100,
			title: {
			text: 'Level'
				}
			},
		credits: {
			enabled: false
			},

		series: [{
			name: 'Level',
			data: [0],
			dataLabels: {
				format: '<div style="text-align:center"><span style="font-size:25px;color:' +
				((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
				'<span style="font-size:12px;color:gray">%</span></div>'
				},
			tooltip: {
			valueSuffix: ' km/hr'
				}
			}]
		}));
								
	//Chart Humidity & Temperature
	var chartHuTe =  Highcharts.chart('container-h_t', {
		chart: {
			type: 'line'
		},
		title: {
			text: 'Temperature&Humidity of the bin in each hour'
		},
		xAxis: {
			//Timestamp
			categories: ['10.00', '11.00','12.00', '13.00','14.00', '15.00','16.00', '17.00','18.00', '19.00','20.00', '21.00']
		},
		yAxis: {
			title: {
            text: 'Temperature(°C) Humidity(%)'
			}
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
			}
		},
		credits: {
			enabled: false
			},
		series: [{
			name: 'Humidity', //HumidData
			data: [29,32,32,16,18,16,18,15,18,36,42,42]
		}, {
			name: 'Temperature', //TempData
			data: [28,26,28,29,32,31,28,29,24,25,27,26]
		}]
	});
		
	var chartMoi = Highcharts.chart('container-mois', {

		chart: {
			type: 'gauge',
			plotBackgroundColor: null,
			plotBackgroundImage: null,
			plotBorderWidth: 0,
			plotShadow: false
		},

		title: {
			text: 'Moisture'
		},
		
		credits: {
			enabled: false
			},

		pane: {
			startAngle: -150,
			endAngle: 150,
			background: [{
				backgroundColor: {
					linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					stops: [
						[0, '#FFF'],
						[1, '#FFF']
					]
				},
				borderWidth: 0,
				outerRadius: '109%'
			}, {
				backgroundColor: {
					linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					stops: [
						[0, '#FFF'],
						[1, '#FFF']
					]
				},
				borderWidth: 1,
				outerRadius: '107%'
			}, {
				backgroundColor: '#000',
				borderWidth: 0,
				outerRadius: '105%',
				innerRadius: '103%'
			}]
		},

		// the value axis
		yAxis: {
			min: 0,
			max: 6,

			minorTickInterval: 'auto',
			minorTickWidth: 0,
			minorTickLength: 8,
			minorTickPosition: 'inside',
			minorTickColor: '#666',

			tickPixelInterval: 30,
			tickWidth: 0,
			tickPosition: 'inside',
			tickLength: 10,
			tickColor: '#666',
			labels: {
				step: 2,
				rotation: 'auto'
			},
			title: {
				text: ''
			},
			
			
			plotBands: [{
				from: 0,
				to: 1,
				color: '#ca74ff' 
			}, {
				from: 1,
				to: 2,
				color: '#58ACFA' // purple
			}, {
				from: 2,
				to: 3,
				color: '#82daff' // Blue
			}, {
				from: 3,
				to: 4,
				color: '#82daff' // Blue
			}, {
				from: 4,
				to: 5,
				color: '#58ACFA' // violet
			}, {
				from: 5,
				to: 6,
				color: '#ca74ff' // violet
			}]
		},

		series: [{
			name: 'Moiture',
			data: [0],
			tooltip: {
				valueSuffix: '%'
			}
		}]

	});

	var chartUsage = Highcharts.chart('container-usage', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: 'Usage of the bin in each hour'
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    xAxis: {
        categories: [
            '10.00',
            '11.00',
            '12.00',
            '13.00',
            '14.00',
            '15.00',
            '16.00',
			'17.00',
            '18.00',
            '19.00',
            '20.00',
			'21.00'
        ],
        plotBands: [{ // visualize the weekend
            from: 10.5,
            to: 12,
            color: 'rgba(68, 170, 213, .2)'
        }]
    },
    yAxis: {
        title: {
            text: 'Usage(time)'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' Times'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    series: [{
        name: 'Bin1',
        data: [4, 6, 12, 11, 14, 12, 8,9,7,2,1,2]
    }]
});
	
	// Bring life to the dials
	setInterval(function () {
		var point,
		newVal,
		inc,
		i;
		
		// Temperature
		if (chartTmp) {
			$.getJSON('/php/newdata.php',function(data)
				{
				point = chartTmp.series[0].points[0];
				point.y = data[0].temp;
				newVal = point.y - 0;		
				point.update(newVal);
				});
			}
						
		// Humidity
		if (chartHumid) {
			$.getJSON('/php/newdata.php',function(data)
			{
				point = chartHumid.series[0].points[0];
				point.y = data[0].humid;
				newVal = point.y - 0;		
				point.update(newVal);
				});
			}
		
		// Level
		if (chartLvl) {
			$.getJSON('/php/newdata.php',function(data)
			{
				point = chartLvl.series[0].points[0];
				point.y = data[0].lvl;
				newVal = point.y - 0;		
				point.update(newVal);
				});
			}

		// Moisture
		if (chartMoi) {
			$.getJSON('/php/newdata.php',function(data)
			{
				point = chartMoi.series[0].points[0];
				point.y = data[0].mois;
				newVal = point.y - 0;		
				point.update(newVal);
				});
			}
			
		}, 3000);
		
	//Chart Level:Time	
	var chartLvlTime = Highcharts.chart('container-lvl_time', {
		chart: {
			type: 'line'
		},
		title: {
			text: 'Level of grabage in the bin in each hour'
		},
		xAxis: {
			//Timestamp
			categories: ['10.00', '11.00','12.00', '13.00','14.00', '15.00','16.00', '17.00','18.00', '19.00','20.00', '21.00']
		},
		yAxis: {
			title: {
            text: 'Level (%)'
			}
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
			}
		},
		credits: {
			enabled: false
			},
		series: [{
			name: 'Level', //HumidData
			data: [33,42,42,56,74,82,0,12,29,48,61,78]
		}]
	});
	
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});

	Highcharts.chart('concon', {
		chart: {
			type: 'spline',
			animation: Highcharts.svg, // don't animate in old IE
			marginRight: 10,
			events: {
				load: function () {

					// set up the updating of the chart each second
					var series = this.series;
					
					setInterval(function () {
						$.getJSON('/php/newdata.php',function(data){
							var x = (new Date()).getTime(), // current time
							 temp = parseInt(data[0].temp);
							var humid = parseInt(data[0].humid),
							y=temp,
							z=humid;
							series[0].addPoint([x, y], true);
							series[1].addPoint([x, z], true);
							});
						
			 
					}, 3000);
				}
			}
		},
		title: {
			text: 'Live Temperature&Humidity'
		},
		xAxis: {
			type: 'datetime',
			tickPixelInterval: 150
		},
		yAxis: {
			title: {
				text: 'Temperature(°C) Humidity(%)'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		tooltip: {
			formatter: function () {
				return '<b>' + this.series.name + '</b><br/>' +
					Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
					Highcharts.numberFormat(this.y, 2);
			}
		},
		legend: {
			enabled: true
		},
		exporting: {
			enabled: false
		},
		credits: {
			enabled: false
			},
		series: [{
			name: 'Temp',
			data: [],
			color: '#222f3e'
		},{
			name: 'Humid',
			data: [],
			color: '#10ac84'
		}]
	});

	// Radialize the colors
	Highcharts.setOptions({
		colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
			return {
				radialGradient: {
					cx: 0.5,
					cy: 0.3,
					r: 0.7
				},
				stops: [
					[0, color],
					[1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
				]
			};
		})
	});

	setInterval(function () {
		$.getJSON('/php/firedata.php',function(data)
			{
			fme = data[0].fire;
			//console.log(data[0].fire);
			if(fme == 1)
				{
				// Flame
					Highcharts.chart('container-flame', {
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false,
							type: 'pie'
						},
						title: {
							text: 'Flame'
						},
						tooltip: {
							pointFormat: '' /*'{series.data}' : <b>{point.percentage:.1f}%</b>'*/
						},
						plotOptions: {
							pie: {
								animation: false,
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: false,
									format: '<b>{point.name}</b>: {point.percentage:.1f} %',
									style: {
										color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
									},
									connectorColor: 'silver'
								}
							}
						},
						credits: {
								enabled: false
								},
						
						series: [{
						name: 'Fire',
						data: [
								{ name: 'x', y: 0 },
								{ name: 'x', y: 0 },
								{ name: 'x', y: 0 },
								{ name: 'x', y: 0 },
								{ name: 'x', y: 0 },
								{ name: 'Fire', y: 1 }
							]
						}]
						
						
					});	
				}
			if(fme == 2)
				{
					// Near Flame
					Highcharts.chart('container-flame', {
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false,
							type: 'pie'
						},
						title: {
							text: 'Flame'
						},
						tooltip: {
							pointFormat: '' /*'{series.data}' : <b>{point.percentage:.1f}%</b>'*/
						},
						plotOptions: {
							pie: {
								animation: false,
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: false,
									format: '<b>{point.name}</b>: {point.percentage:.1f} %',
									style: {
										color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
									},
									connectorColor: 'silver'
								}
							}
						},
						credits: {
								enabled: false
								},
						
						series: [{
						name: 'Maybe Fire',
						data: [
								{ name: 'x', y: 0 },
								{ name: 'x', y: 0 },
								{ name: 'x', y: 0 },
								{ name: 'Maybe Fire', y: 1 }
							]
						}]
						
						
					});	
				}
			if(fme == 3)
				{
					// No Flame
					Highcharts.chart('container-flame', {
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false,
							type: 'pie'
						},
						title: {
							text: 'Flame'
						},
						tooltip: {
							pointFormat: '' /*'{series.data}' : <b>{point.percentage:.1f}%</b>'*/
						},
						plotOptions: {
							pie: {
								animation: false,
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: false,
									format: '<b>{point.name}</b>: {point.percentage:.1f} %',
									style: {
										color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
									},
									connectorColor: 'silver'
								}
							}
						},
						credits: {
								enabled: false
								},
						
						series: [{
						name: 'No Flame',
						data: [
								{ name: 'x', y: 0 },
								{ name: 'x', y: 0 },
								{ name: 'No Flame', y: 1 }
							]
						}]
						
						
					});	
				}
			});
		}, 2000);



</script>

