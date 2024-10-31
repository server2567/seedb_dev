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
	<div class="real-data">JS Data</div>
	<figure class="highcharts-figure">
		<div id="container"></div>
		<!-- <p class="highcharts-description">
			Chart showing stacked columns for comparing quantities. Stacked charts
			are often used to visualize data that accumulates to a sum. This chart
			is showing data labels for each individual section of the stack.
		</p> -->
	</figure>
	<script>
			// Data retrieved from:
			// - https://en.as.com/soccer/which-teams-have-won-the-premier-league-the-most-times-n/
			// - https://www.statista.com/statistics/383679/fa-cup-wins-by-team/
			// - https://www.uefa.com/uefachampionsleague/history/winners/
			
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
				series: [
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
					name: 'สายเทคนิคและบริการ',
					data: [0, 0]
				}
				// {
				// 	name: 'BPL',
				// 	data: [3, 5, 1, 13]
				// }, {
				// 	name: 'FA Cup',
				// 	data: [14, 8, 8, 12]
				// }, {
				// 	name: 'CL',
				// 	data: [0, 2, 6, 3]
				// }
			
			]
			});

	</script>
</body>
</html>

<!-- https://www.highcharts.com/demo/highcharts/column-basic -->
<!-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	< src="https://code.highcharts.com/highcharts.js"></>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<style>
		.highcharts-figure,
		.highcharts-data-table table {
			min-width: 310px;
			max-width: 800px;
			margin: 1em auto;
		}

		#container {
			height: 400px;
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
	<figure class="highcharts-figure">
		<div id="container"></div>
		<p class="highcharts-description">
			A basic column chart comparing estimated corn and wheat production
			in some countries.

			The chart is making use of the axis crosshair feature, to highlight
			the hovered country.
		</p>
	</figure>
	<script>
		Highcharts.chart('container', {
		chart: {
			type: 'column'
		},
		title: {
			text: 'รายงานจำนวนวุฒิการศึกษาของแต่ละสายงาน จำแนกตามวุฒิการศึกษา',
			align: 'left'
		},
		subtitle: {
			text:
				'Source: <a target="_blank" ' +
				'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>',
			align: 'left'
		},
		xAxis: {
			categories: ['USA', 'China'],
			crosshair: true,
			accessibility: {
				description: 'Countries'
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'จำนวนบุคลากร'
			}
		},
		tooltip: {
			valueSuffix: ' (1000 MT)'
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [
			{
				name: 'Corn',
				data: [387749, 280000]
			},
			{
				name: 'Wheat',
				data: [45321, 140000]
			}
		]
	});

	</script>
	<script>
		let data = {
		"chart": {
			"categories": [
			"ต่ำกว่าปริญญาตรี",
			"ปริญญาตรี",
			"ปริญญาโท",
			"ปริญญาเอก",
			"เฉพาะทาง"
			],
			"series": [
			{
				"id": "A",
				"name": "สายบริหาร",
				"data": [
				0,
				0,
				0,
				0,
				0
				]
			},
			{
				"id": "M",
				"name": "สายแพทย์",
				"data": [
				5,
				1,
				0,
				0,
				0
				]
			},
			{
				"id": "N",
				"name": "สายการพยาบาล",
				"data": [
				0,
				0,
				0,
				0,
				0
				]
			},
			{
				"id": "SM",
				"name": "สายสนับสนุนทางการแพทย์",
				"data": [
				0,
				0,
				0,
				0,
				0
				]
			},
			{
				"id": "T",
				"name": "สายเทคนิคและบริการ",
				"data": [
				0,
				0,
				0,
				0,
				0
				]
			}
			]
		},
		"detail": {
			"สายบริหาร": {
			"ต่ำกว่าปริญญาตรี": {
				"hire_is_medical": "A",
				"person_list": []
			},
			"ปริญญาตรี": {
				"hire_is_medical": "A",
				"person_list": []
			},
			"ปริญญาโท": {
				"hire_is_medical": "A",
				"person_list": []
			},
			"ปริญญาเอก": {
				"hire_is_medical": "A",
				"person_list": []
			},
			"เฉพาะทาง": {
				"hire_is_medical": "A",
				"person_list": []
			}
			},
			"สายแพทย์": {
			"ต่ำกว่าปริญญาตรี": {
				"hire_is_medical": "M",
				"person_list": [
				{
					"hipos_ps_id": "1",
					"full_name": "<a href=\"https://dev-seedb.aos.in.th/index.php/hr/profile/Profile_summary/get_profile_summary/1\" target=\"_blank\">นายแพทย์บรรยง ชินกุลกิจนิวัฒน์</a><br><span style=\"font-size:12px; color:#7d7878;\">ผู้บริหาร, ผู้อำนวยการโรงพยาบาล</span>",
					"ps_hire_name": "จักษุแพทย์ปฏิบัติงานเต็มเวลา",
					"ps_admin_name": "ผู้บริหาร, ผู้อำนวยการโรงพยาบาล",
					"ps_spcl_name": "การผ่าตัดต้อกระจก",
					"ps_alp_name": "แพทย์",
					"ps_retire_name": "ปกติ / ปฏิบัติงาน",
					"hipos_pos_work_start_date": "2020-08-01",
					"hipos_pos_work_end_date": null,
					"hire_type": "1",
					"hire_type_label": "เต็มเวลา (Full-Time)",
					"hire_is_medical": "M",
					"hire_is_medical_label": "สายแพทย์",
					"edulv_name": "ประกาศนียบัตรแพทย์เฉพาะทาง",
					"edudg_name": "วุฒิบัตรผู้เชี่ยวชาญ",
					"edumj_name": "จักษุวิทยา",
					"place_name": "คณะแพทย์ศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล",
					"country_name": "ไทย",
					"hire_id": "1"
				},
				{
					"hipos_ps_id": "2",
					"full_name": "<a href=\"https://dev-seedb.aos.in.th/index.php/hr/profile/Profile_summary/get_profile_summary/2\" target=\"_blank\">แพทย์หญิงวิมล ชินกุลกิจนิวัฒน์</a><br><span style=\"font-size:12px; color:#7d7878;\">ผู้บริหาร, รองผู้อำนวยการโรงพยาบาล</span>",
					"ps_hire_name": "รังสีแพทย์ปฏิบัติงานเต็มเวลา",
					"ps_admin_name": "ผู้บริหาร, รองผู้อำนวยการโรงพยาบาล",
					"ps_spcl_name": "รังสีวิทยาทั่วไป",
					"ps_alp_name": "แพทย์",
					"ps_retire_name": "ปกติ / ปฏิบัติงาน",
					"hipos_pos_work_start_date": "2024-01-01",
					"hipos_pos_work_end_date": null,
					"hire_type": "1",
					"hire_type_label": "เต็มเวลา (Full-Time)",
					"hire_is_medical": "M",
					"hire_is_medical_label": "สายแพทย์",
					"edulv_name": "ประกาศนียบัตรแพทย์เฉพาะทาง",
					"edudg_name": "วุฒิบัตรผู้เชี่ยวชาญ",
					"edumj_name": "รังสีวิทยา",
					"place_name": "คณะแพทย์ศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล",
					"country_name": "ไทย",
					"hire_id": "1"
				},
				{
					"hipos_ps_id": "3",
					"full_name": "<a href=\"https://dev-seedb.aos.in.th/index.php/hr/profile/Profile_summary/get_profile_summary/3\" target=\"_blank\">แพทย์หญิงบัวขวัญ ชินกุลกิจนิวัฒน์</a><br><span style=\"font-size:12px; color:#7d7878;\">ผู้บริหาร, รองผู้อำนวยการโรงพยาบาล</span>",
					"ps_hire_name": "จักษุแพทย์ปฏิบัติงานเต็มเวลา",
					"ps_admin_name": "ผู้บริหาร, รองผู้อำนวยการโรงพยาบาล",
					"ps_spcl_name": "โรคกระจกตา",
					"ps_alp_name": "แพทย์",
					"ps_retire_name": "ปกติ / ปฏิบัติงาน",
					"hipos_pos_work_start_date": "2024-01-01",
					"hipos_pos_work_end_date": null,
					"hire_type": "1",
					"hire_type_label": "เต็มเวลา (Full-Time)",
					"hire_is_medical": "M",
					"hire_is_medical_label": "สายแพทย์",
					"edulv_name": "ประกาศนียบัตรแพทย์เฉพาะทาง",
					"edudg_name": "วุฒิบัตรผู้เชี่ยวชาญ",
					"edumj_name": "จักษุวิทยา",
					"place_name": "คณะแพทย์ศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล",
					"country_name": "ไทย",
					"hire_id": "1"
				},
				{
					"hipos_ps_id": "4",
					"full_name": "<a href=\"https://dev-seedb.aos.in.th/index.php/hr/profile/Profile_summary/get_profile_summary/4\" target=\"_blank\">แพทย์หญิงบุณยดา ชินกุลกิจนิวัฒน์</a><br><span style=\"font-size:12px; color:#7d7878;\">ผู้บริหาร, รองผู้อำนวยการโรงพยาบาล</span>",
					"ps_hire_name": "จักษุแพทย์ปฏิบัติงานบางเวลา",
					"ps_admin_name": "ผู้บริหาร, รองผู้อำนวยการโรงพยาบาล",
					"ps_spcl_name": "โรคเส้นประสาทตา",
					"ps_alp_name": "แพทย์",
					"ps_retire_name": "ปกติ / ปฏิบัติงาน",
					"hipos_pos_work_start_date": "2024-01-01",
					"hipos_pos_work_end_date": null,
					"hire_type": "2",
					"hire_type_label": "บางเวลา (Part-Time)",
					"hire_is_medical": "M",
					"hire_is_medical_label": "สายแพทย์",
					"edulv_name": "ประกาศนียบัตรแพทย์เฉพาะทาง",
					"edudg_name": "วุฒิบัตรผู้เชี่ยวชาญ",
					"edumj_name": "เส้นประสาทตาและขั้วประสาทตา",
					"place_name": "คณะแพทย์ศาสตร์ จุฬาลงกรณ์มหาวิทยาลัย",
					"country_name": "ไทย",
					"hire_id": "1"
				},
				{
					"hipos_ps_id": "3",
					"full_name": "<a href=\"https://dev-seedb.aos.in.th/index.php/hr/profile/Profile_summary/get_profile_summary/3\" target=\"_blank\">แพทย์หญิงบัวขวัญ ชินกุลกิจนิวัฒน์</a><br><span style=\"font-size:12px; color:#7d7878;\">ผู้บริหาร, รองผู้อำนวยการโรงพยาบาล</span>",
					"ps_hire_name": "จักษุแพทย์ปฏิบัติงานเต็มเวลา",
					"ps_admin_name": "ผู้บริหาร, รองผู้อำนวยการโรงพยาบาล",
					"ps_spcl_name": "โรคกระจกตา",
					"ps_alp_name": "แพทย์",
					"ps_retire_name": "ปกติ / ปฏิบัติงาน",
					"hipos_pos_work_start_date": "2024-01-01",
					"hipos_pos_work_end_date": null,
					"hire_type": "1",
					"hire_type_label": "เต็มเวลา (Full-Time)",
					"hire_is_medical": "M",
					"hire_is_medical_label": "สายแพทย์",
					"edulv_name": "ประกาศนียบัตรแพทย์เฉพาะทาง",
					"edudg_name": "วุฒิบัตรผู้เชี่ยวชาญ",
					"edumj_name": "อนุสาขากระจกตาและการผ่าตัดรักษาภาวะสายตาผิดปกติ",
					"place_name": "คณะแพทย์ศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล",
					"country_name": "ไทย",
					"hire_id": "1"
				},
				{
					"hipos_ps_id": "6",
					"full_name": "<a href=\"https://dev-seedb.aos.in.th/index.php/hr/profile/Profile_summary/get_profile_summary/6\" target=\"_blank\">แพทย์หญิงบุญพิสุทธิ์ ชินกุลกิจนิวัฒน์</a><br><span style=\"font-size:12px; color:#7d7878;\">ผู้บริหาร</span>",
					"ps_hire_name": "จักษุแพทย์ปฏิบัติงานบางเวลา",
					"ps_admin_name": "ผู้บริหาร",
					"ps_spcl_name": null,
					"ps_alp_name": "แพทย์",
					"ps_retire_name": "ปกติ / ปฏิบัติงาน",
					"hipos_pos_work_start_date": "2024-01-01",
					"hipos_pos_work_end_date": null,
					"hire_type": "2",
					"hire_type_label": "บางเวลา (Part-Time)",
					"hire_is_medical": "M",
					"hire_is_medical_label": "สายแพทย์",
					"edulv_name": "ประกาศนียบัตรแพทย์เฉพาะทาง",
					"edudg_name": "ประกาศนียบัตรบัณฑิตทางวิทยาศาสตร์การแพทย์คลินิก",
					"edumj_name": "อนุสาขาจอตาวุ้นตา",
					"place_name": "คณะแพทย์ศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล",
					"country_name": "ไทย",
					"hire_id": "1"
				}
				]
			},
			"ปริญญาตรี": {
				"hire_is_medical": "M",
				"person_list": [
				{
					"hipos_ps_id": "7",
					"full_name": "<a href=\"https://dev-seedb.aos.in.th/index.php/hr/profile/Profile_summary/get_profile_summary/7\" target=\"_blank\">แพทย์หญิงบวรพร  ชินกุลกิจนิวัฒน์</a><br><span style=\"font-size:12px; color:#7d7878;\">ผู้บริหาร</span>",
					"ps_hire_name": "จักษุแพทย์ปฏิบัติงานเต็มเวลา",
					"ps_admin_name": "ผู้บริหาร",
					"ps_spcl_name": "โรคเส้นประสาทตา",
					"ps_alp_name": "แพทย์",
					"ps_retire_name": "ปกติ / ปฏิบัติงาน",
					"hipos_pos_work_start_date": "2024-01-01",
					"hipos_pos_work_end_date": null,
					"hire_type": "1",
					"hire_type_label": "เต็มเวลา (Full-Time)",
					"hire_is_medical": "M",
					"hire_is_medical_label": "สายแพทย์",
					"edulv_name": "ปริญญาตรี",
					"edudg_name": "แพทยศาสตรบัณฑิต",
					"edumj_name": "แพทยศาสตร์",
					"place_name": "Carol Davila University",
					"country_name": "โรมาเนีย",
					"hire_id": "1"
				}
				]
			},
			"ปริญญาโท": {
				"hire_is_medical": "M",
				"person_list": []
			},
			"ปริญญาเอก": {
				"hire_is_medical": "M",
				"person_list": []
			},
			"เฉพาะทาง": {
				"hire_is_medical": "M",
				"person_list": []
			}
			},
			"สายการพยาบาล": {
			"ต่ำกว่าปริญญาตรี": {
				"hire_is_medical": "N",
				"person_list": []
			},
			"ปริญญาตรี": {
				"hire_is_medical": "N",
				"person_list": []
			},
			"ปริญญาโท": {
				"hire_is_medical": "N",
				"person_list": []
			},
			"ปริญญาเอก": {
				"hire_is_medical": "N",
				"person_list": []
			},
			"เฉพาะทาง": {
				"hire_is_medical": "N",
				"person_list": []
			}
			},
			"สายสนับสนุนทางการแพทย์": {
			"ต่ำกว่าปริญญาตรี": {
				"hire_is_medical": "SM",
				"person_list": []
			},
			"ปริญญาตรี": {
				"hire_is_medical": "SM",
				"person_list": []
			},
			"ปริญญาโท": {
				"hire_is_medical": "SM",
				"person_list": []
			},
			"ปริญญาเอก": {
				"hire_is_medical": "SM",
				"person_list": []
			},
			"เฉพาะทาง": {
				"hire_is_medical": "SM",
				"person_list": []
			}
			},
			"สายเทคนิคและบริการ": {
			"ต่ำกว่าปริญญาตรี": {
				"hire_is_medical": "T",
				"person_list": []
			},
			"ปริญญาตรี": {
				"hire_is_medical": "T",
				"person_list": []
			},
			"ปริญญาโท": {
				"hire_is_medical": "T",
				"person_list": []
			},
			"ปริญญาเอก": {
				"hire_is_medical": "T",
				"person_list": []
			},
			"เฉพาะทาง": {
				"hire_is_medical": "T",
				"person_list": []
			}
			}
		}
		};
		console.log('original data from v_hrm_5.php', data);
	</script>
	
</body>
</html> -->





<!-- https://www.highcharts.com/demo/highcharts/column-stacked-and-grouped -->
<!-- <html>
    <head>
		<script src="https://code.highcharts.com/highcharts.js"></>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<script src="https://code.highcharts.com/modules/accessibility.js"></script>

		<style>
			.highcharts-figure,
			.highcharts-data-table table {
				min-width: 310px;
				max-width: 800px;
				margin: 1em auto;
			}

			#container {
				height: 400px;
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
		<figure class="highcharts-figure">
			<div id="container"></div>
			<p class="highcharts-description">
				Chart showing stacked columns with grouping, allowing specific series to
				be stacked on the same column. Stacking is often used to visualize
				data that accumulates to a sum.
			</p>
		</figure>

		<script>
			// Data retrieved from https://en.wikipedia.org/wiki/Winter_Olympic_Games
			Highcharts.chart('container', {

				chart: {
					type: 'column'
				},

				title: {
					text: 'Olympic Games all-time medal table, grouped by continent',
					align: 'left'
				},

				xAxis: {
					categories: ['Gold', 'Silver', 'Bronze']
				},

				yAxis: {
					allowDecimals: false,
					min: 0,
					title: {
						text: 'Count medals'
					}
				},

				tooltip: {
					format: '<b>{key}</b><br/>{series.name}: {y}<br/>' +
						'Total: {point.stackTotal}'
				},

				plotOptions: {
					column: {
						stacking: 'normal'
					}
				},

				series: [{
					name: 'Norway',
					data: [148, 133, 124],
					stack: 'Europe'
				}, {
					name: 'Germany',
					data: [102, 98, 65],
					stack: 'Europe'
				}, {
					name: 'United States',
					data: [113, 122, 95],
					stack: 'North America'
				}, {
					name: 'Canada',
					data: [77, 72, 80],
					stack: 'North America'
				}]
			});

		</script>
	</body>
</html> -->