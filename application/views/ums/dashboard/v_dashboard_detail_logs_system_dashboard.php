<?php
    $currentYear = date('Y');
    $monthsArray = [];
    
    for ($i = 1; $i <= 12; $i++) {
        $monthsArray[] = date("M", mktime(0, 0, 0, $i, 1, $currentYear));
    }
    
    // ddl year
    $currentYear = date('Y'); // Get the current year
    $startYear = $currentYear - 5; // Calculate the start year (5 years ago)
?>

<style>
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

    
    .accordion-body button.accordion-button:not(.collapsed) {
        background-color: transparent;
    }
</style>

<!-- Counting Chart -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGraph" aria-expanded="true" aria-controls="collapseGraph">
                    <i class="bi-bar-chart-line icon-menu"></i><span>จำนวนการเข้าใช้งาน</span>
                </button>
            </h2>
            <div id="collapseGraph" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="display: inline;">ประจำปี </h4>
                            <select class="form-select form-control ms-2 w-15" style="display: inline;" data-placeholder="-- กรุณาเลือกปี --" name="year_search" id="year_search" onchange="get_data_logs_system(this.value)">
                                <?php
                                    for ($y = $currentYear; $y >= $startYear; $y--) {
                                        echo '<option value="' . $y . '" ' . ($year == $y ? 'selected' : '') . '>' . ($y+543) . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-9">
                            <div id="bar-chart-log-system"></div>
                        </div>
                        <div class="col-md-3 text-center align-content-center">
                            <h1><i class="bi-people icon-menu text-warning" style="opacity: 0.5;"></i><span class="counter" data-target="<?php echo (int)$logs_systems_by_year[0]['ums_log_count']; ?>"></span></h1>
                            <small>จำนวนการเข้าใช้ระบบ</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetail" aria-expanded="true" aria-controls="collapseDetail">
                    <i class="bi-window-dock icon-menu"></i><span>ตารางแสดงรายละเอียดการเข้าใช้งานระบบ</span>
                </button>
            </h2>
            <div id="collapseDetail" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="accordion accordion-flush">
                        <?php for($j=1; $j<=12; $j++){ 
                            $logs = [];
                            $count = 0;
                            foreach ($logs_detail_by_year as $row) {
                                if($row['log_month'] == $j) {
                                    $logs[] = $row;
                                    $count++;
                                }
                            } 
                        ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-heading-<?php echo $j+1;?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-<?php echo $j+1;?>" aria-expanded="false" aria-controls="flush-collapse-<?php echo $j+1;?>">
                                    <?php echo $monthsArray[($j-1)]." (".$count.")" ?>
                                </button>
                            </h2>
                            <div id="flush-collapse-<?php echo $j+1;?>" class="accordion-collapse collapse" aria-labelledby="flush-heading-<?php echo $j+1;?>" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <table class="table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>ชื่อ - นามสกุล</th>
                                                <th>รายละเอียด</th>
                                                <th class="text-center">วันที่</th>
                                                <th class="text-center">IP</th>
                                                <th class="text-center">ช่องทาง</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(!empty($logs)) {
                                                    $i = 0;
                                                    foreach ($logs as $row) {?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i+1; ?></td>
                                                    <td><?php echo $row['us_name']; ?></td>
                                                    <td><?php echo $row['ml_changed']; ?></td>
                                                    <td class="text-center"><?php echo $row['ml_date']; ?></td>
                                                    <td class="text-center"><?php echo $row['ml_ip']; ?></td>
                                                    <td class="text-center"><?php echo $row['ml_agent']; ?></td>
                                                </tr>
                                            <?php $i++; }} else { ?>
                                                <tr>
                                                    <td class="text-center" colspan="6">ไม่มีรายการข้อมูล</td>
                                                </tr>
                                            <?php }
                                             ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button -->
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Dashboard'">ย้อนกลับ</button>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<!-- declare variable -->
<script>
    // Initialize arrays to hold categories and series data
    const categories = [
        'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
        'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'
    ]; // For xAxis categories (abbreviated Thai names)
</script>

<!-- document ready -->
<script>
    $(document).ready(function() {
        var logs_system = <?php echo !empty($logs_systems_by_month) ? json_encode($logs_systems_by_month) : json_encode([]); ?>;
        get_chart_logs_systems(logs_system);

        counter_total_logs();
    });
</script>

<!-- function -->
<script>
    function get_chart_logs_systems(data) {
        var series = []; // For series based on log names

        if(data && data.length > 0) {
            series = data;
        } else {
            // If data is null or empty, provide a default series
            series.push({
                name: '',
                data: Array(12).fill(null), // 12 months with no data
                visible: true,
                showInLegend: false // Hide this series in the legend
            });
        }
        
        Highcharts.chart('bar-chart-log-system', {
            chart: {
                type: 'column',
                style: {
                    "fontFamily": "Sarabun",
                    "fontSize": "16px",
                }
            },
            title: {
                text: '',
                align: 'center'
            },
            subtitle: {
                text: '',
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: true
            },
            xAxis: {
                categories: categories,
                crosshair: true,
                accessibility: {
                    description: 'เดือน'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'จำนวนครั้งที่เข้าใช้ระบบ'
                }
            },
            tooltip: {
                headerFormat: '',
                formatter: function () {
                    var tooltip = '<b>' + this.x + '</b> : ' + this.y + ' ครั้ง';
                    return tooltip;
                },
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: series,
        });
    }

    function get_data_logs_system(year) {
        let st_id = '<?php echo $st_id; ?>';
        let url = '<?php echo site_url() . "/ums/Dashboard/Dashboard_get_data_logs_systems"; ?>';
        $.ajax({
            url: url, 
            type: 'POST',
            data: {
                year: year,
                st_id: st_id,
            },
            success: function(data) {
                data = JSON.parse(data);
                if(data) {
                    get_chart_logs_systems(data.data.logs_systems_by_month);
                    counter_total_logs(data.data.logs_systems_by_year);
                }
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }
    
    function counter_total_logs(data) {
        if (data) {
            if (data.length > 0)
                $('.counter').attr('data-target', data[0]['ums_log_count']);
            else 
                $('.counter').attr('data-target', '0');
        }

        const counters = document.querySelectorAll('.counter')
        counters.forEach(counter => {
            counter.innerText = '0'
            counter.dataset.count = 0;
            const updateCounter = () => {
                const target = +counter.getAttribute('data-target') //define increase couter to it's data-target
                const count = +counter.dataset.count //define increase couter on innerText

                const increment = target / 200 // define increment as counter increase value / speed

                if (count < target) {
                    const newCount = Math.ceil(count + increment);
                    counter.dataset.count = newCount;
                    counter.innerText = numberWithCommas(newCount);
                    setTimeout(updateCounter, 1);
                } else {
                    counter.innerText = numberWithCommas(target); //if default value is bigger that date-target, show data-target
                }
            }

            updateCounter() //call the function event
        })
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + " ครั้ง";
    }
</script>