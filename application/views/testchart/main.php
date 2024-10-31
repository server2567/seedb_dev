<div id="searchSection">
        <div class="row">
			<div class="col-md-4">
				<div class="form-floating mb-4">
				<select class="form-select mb-4" id="hrm_select_ums_department" name="hrm_select_ums_department" onchange="filterHRM()">
					<?php
					foreach ($ums_department_list as $key => $row) {
					if ($key == 0) {
						echo '<option value="' . $row->dp_id . '" selected>' . $row->dp_name_th . '</option>';
					} else {
						echo '<option value="' . $row->dp_id . '">' . $row->dp_name_th . '</option>';
					}
					}
					?>
				</select>
				<label for="ums_department">หน่วยงาน</label>
				</div>
			</div>
			<div class="col-md-4" id="filter_hrm_select_year_type">
				<div class="form-floating mb-3">
				<select class="form-select mb-3" id="hrm_select_year_type" name="hrm_select_year_type" onchange="filterHRM()">
					<option value="1" selected>ปีปฏิทิน</option>
				</select>
				<label for="hrm_select_year_type">ประเภทปี</label>
				</div>
			</div>
			<div class="col-md-4" id="filter_hrm_select_year">
				<div class="form-floating mb-3">
				<select class="form-select mb-3" id="hrm_select_year" name="hrm_select_year" onchange="filterHRM()">
					<?php
					$i = 0;
					foreach ($default_year_list as $year) {
					// Get current date
					if ($year == getNowYearTh())
						echo '<option value="' . ($year - 543) . '" selected>' . $year . '</option>';
					else
						echo '<option value="' . ($year - 543) . '">' . $year . '</option>';
					$i++;
					}
					?>
				</select>
				<label for="hrm_select_year">ปีพ.ศ.</label>
				</div>
			</div>
        </div>
    </div>
<?php 
	$data = null;
	// echo $this->load->view('testchart/1_stack_chart', $data, true);
	// echo $this->load->view('testchart/1_stack_chart_mock', $data, true);

	// echo $this->load->view('testchart/2_donut_chart', $data, true);
	/*
		secure link:   https://assets.highcharts.com/errors/16/

		Highcharts already defined in the page

		This error happens if the Highcharts namespace already exists when loading Highcharts or Highstock.

		This is caused by including Highcharts or Highstock more than once.

		Keep in mind that the Highcharts.Chart constructor and all features of Highcharts are included in Highstock, so if using the Chart and StockChart constructors in combination, only the highstock.js file is required.
	*/

	echo $this->load->view('testchart/1_stack_chart_refresh', $data, true);
	echo $this->load->view('testchart/2_donut_chart_refresh', $data, true);
?>

<script>
	$(document).ready(function() {
		filterHRM();
	});

	function filterHRM() {
		getChart1();
		// getChart2();
	}
</script>