<!-- Stacked column -->
<!-- https://www.highcharts.com/demo/highcharts/column-stacked -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<!-- ajax -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/th.js"></script>


	<style>
		#container {
			height: 400px;
		}

		.highcharts-figure,
		.highcharts-data-table table {
			min-width: 310px;
			max-width: 800px;
			margin: 1em auto;
		}

		.highcharts-data-table table {
			font-family: Verdana, sans-serif;
			border-collapse: collapse;
			border: 1px solid #ebebeb;
			margin: 10px auto;
			text-align: center;
			width: 100%;
			max-width: 500px;
		}

		.highcharts-data-table caption {
			padding: 1em 0;
			font-size: 1.2em;
			color: #555;
		}

		.highcharts-data-table th {
			font-weight: 600;
			padding: 0.5em;
		}

		.highcharts-data-table td,
		.highcharts-data-table th,
		.highcharts-data-table caption {
			padding: 0.5em;
		}

		.highcharts-data-table thead tr,
		.highcharts-data-table tr:nth-child(even) {
			background: #f8f8f8;
		}

		.highcharts-data-table tr:hover {
			background: #f1f7ff;
		}

	</style>
</head>
<body>
	<script>
		<?php
			$controller_dir = 'seedb/hr/';
		?>
		let data = null;
		$.ajax({
			// url: '<?php // echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_5",
			url: '<?php echo site_url() ?>' + "/seedb/hr/Personal_dashboard/get_HRM_chart_5",
			type: 'GET',
			data: {
				dp_id: 1,
				year: 2567,
				year_type: 1
			},
			success: function(data) {
				// data = JSON.parse(data);
				// document.getElementsByClassName("real-data").innerHTML += "<br>" + data.toString();
				console.log('<?php echo site_url() ?>' + "/seedb/hr/Personal_dashboard/get_HRM_chart_5");
				console.log(JSON.parse(data));
			},
			error: function(xhr, status, error) {
				console.log(error);
				// dialog_error({
				// 	'header': text_toast_default_error_header,
				// 	'body': text_toast_default_error_body
				// });
			}
		});
	</script>
	<div class="real-data">DB Data <?php echo site_url() . "/" . $controller_dir; ?></div>
	<figure class="highcharts-figure">
		<div id="container"></div>
	</figure>
	<script>
			let mySeries = [
					{
						name: 'สายบริหาร',
						data: [1, 1]
					},
					{
						name: 'สายแพทย์',
						data: [5, 1]
					},
					{
						name: 'สายการพยาบาล',
						data: [1, 1]
					},
					{
						name: 'สายสนับสนุนทางการแพทย์',
						data: [0, 0]
					},
					{
						name: 'สายสนับสนุน',
						data: [0, 0]
					},
					{
						name: 'สายเทคนิคและบริการ',
						data: [0, 0]
					}
				
			]
			function getChart1() {
				// alert('<?php // echo site_url() . "/seedb/TestChartController/getChart1API" ?>');

				var dp_id = $('#hrm_select_ums_department').val();
    			var year = $('#hrm_select_year').val();
				var year_text = parseInt($('#hrm_select_year').val());
    			year_text = parseInt(year_text + 543);

				$.ajax({
					url: '<?php echo site_url() . "/seedb/TestChartController/getChart1API" ?>' ,
					type: 'GET',
					data: {
						dp_id: dp_id,
						year: year
					},
					success: function(dataResponse) {
						// data = JSON.parse(data);
						console.log(dataResponse);

						// data[1].forEach((key, value) => {
						let data = JSON.parse(dataResponse);
						let obj = data[1];
						console.log('obj: ',obj);

						Object.keys(obj).forEach(key => {
							console.log(`${key}: `, obj[key]);
							if (key === 'A') { //สายบริหาร	(mySeries[0])
								mySeries[0].data[0] = obj[key].countUngratuatedBachelor;
								mySeries[0].data[1] = obj[key].countGratuatedBachelor;
							} else if (key === 'M') { //สายการแพทย์	(mySeries[1])
								mySeries[1].data[0] = obj[key].countUngratuatedBachelor;
								mySeries[1].data[1] = obj[key].countGratuatedBachelor;
							} else if (key === 'N') { //สายพยาบาล	(mySeries[2])
								mySeries[2].data[0] = obj[key].countUngratuatedBachelor;
								mySeries[2].data[1] = obj[key].countGratuatedBachelor;
							} else if (key === 'SM') { //สายสนับสนุนทางการแพทย์	(mySeries[3])
								mySeries[3].data[0] = obj[key].countUngratuatedBachelor;
								mySeries[3].data[1] = obj[key].countGratuatedBachelor;
							} else if (key === 'S') { //สายสนับสนุน	(mySeries[4])
								mySeries[4].data[0] = obj[key].countUngratuatedBachelor;
								mySeries[4].data[1] = obj[key].countGratuatedBachelor;
							} else if (key === 'T') { //สายเทคนิคและบริการ	(mySeries[5])
								mySeries[5].data[0] = obj[key].countUngratuatedBachelor;
								mySeries[5].data[1] = obj[key].countGratuatedBachelor;
							}
						});

						console.log(mySeries);

						// mySeries[0].data[0] += 5;
						// mySeries = [
						// 	{
						// 		name: 'สายบริหาร',
						// 		data: [5, 5]
						// 	{
						// 		name: 'สายแพทย์',
						// 		data: [5, 1]
						// 	},
						// 	},
						// 	{
						// 		name: 'สายการพยาบาล',
						// 		data: [1, 1]
						// 	},
						// 	{
						// 		name: 'สายสนับสนุนทางการแพทย์',
						// 		data: [0, 0]
						// 	},
						// 	{
						// 		name: 'สายเทคนิคและบริการ',
						// 		data: [0, 0]
						// 	}
						
						// ]
						reRender();
					},
					error: function(xhr, status, error) {
						dialog_error({
							'header': text_toast_default_error_header,
							'body': text_toast_default_error_body
						});
						reRender();
					}
				});
			}

			function reRender() {
				// ***** Mock Data Version *****
				Highcharts.chart('container', {
					chart: {
						type: 'column'
					},
					title: {
						// text: 'Major trophies for some English teams',
						text: 'รายงานจำนวนวุฒิการศึกษาของแต่ละสายงาน จำแนกตามวุฒิการศึกษา',
						align: 'left'
					},
					xAxis: {
						// categories: ['Arsenal', 'Chelsea', 'Liverpool', 'Manchester United']
						categories: ['ต่ำกว่าปริญญาตรี', 'ปริญญาตรี']
					},
					yAxis: {
						min: 0,
						title: {
							text: 'จำนวนบุคลากร'
						},
						stackLabels: {
							enabled: true
						}
					},
					legend: {
						align: 'center',
						// x: 70,
						verticalAlign: 'bottom',
						// y: 70,
						// floating: true,
						floating: false,
						backgroundColor:
							Highcharts.defaultOptions.legend.backgroundColor || 'white',
						borderColor: '#CCC',
						borderWidth: 1,
						shadow: false
					},
					tooltip: {
						headerFormat: '<b>{point.x}</b><br/>',
						pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: true
							}
						}
					},
					series: mySeries
					// series: [
					// 	{
					// 		name: 'สายบริหาร',
					// 		data: [1, 1]
					// 	},
					// 	{
					// 		name: 'สายแพทย์',
					// 		data: [5, 1]
					// 	},
					// 	{
					// 		name: 'สายการพยาบาล',
					// 		data: [1, 1]
					// 	},
					// 	{
					// 		name: 'สายสนับสนุนทางการแพทย์',
					// 		data: [0, 0]
					// 	},
					// 	{
					// 		name: 'สายเทคนิคและบริการ',
					// 		data: [0, 0]
					// 	}
					
					// ]
				});
			}
			
	</script>
</body>
</html>