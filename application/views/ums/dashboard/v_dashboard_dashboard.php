
<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 320px;
        max-width: 700px;
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

    
    .card-icon i, #collapseCard i {
        opacity: 0.5;
    }
    .card-icon i {
        font-size: 2.5rem;
    }
    /* #collapseCard .card:hover:not(.card-icon i) {
        color: var(--bs-link-hover-color-rgb);
    } */
</style>

<!-- Chart Users -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-chart-" aria-expanded="true" aria-controls="collapse-chart-">
                    <i class="bi-bar-chart-line icon-menu"></i><span>อัตราส่วนผู้ใช้ทุกระบบ</span>
                </button>
            </h2>
            <div id="collapse-chart-" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-7 align-content-center">
                            <div id="pie-chart-users-per-system"></div>
                        </div>
                        <div class="col-md-2 text-center align-content-center">
                            <h1><i class="bi-people icon-menu text-warning" style="opacity: 0.5;"></i><span class="counter" data-target="<?php echo $rpt_count_users; ?>"></span></h1>
                            <small>จำนวนผู้ใช้ทั้งหมด</small>
                        </div>
                        <div class="col-md-3 text-center" style="max-height: 500px; overflow-y: auto;">
                            <?php foreach ($rpt_users_systems as $row) { ?>
                            <div class="card card-button" onclick="open_new_tab('<?php echo base_url().'index.php/ums/Dashboard/Dashboard_detail_group_system/'.$row['st_id']?>')">
                                <div class="card-body">
                                    <div class="text-start pb-2"><?php echo $row['st_name_th']?></div>
                                    <div class="card-icon rounded-circle float-start">
                                        <img style="width: 50px;" src="<?php echo base_url()."index.php/ums/GetFile?type=system&image=".$row['st_icon'];?>">
                                    </div>
                                    <div class="float-end">
                                        <h1><?php echo $row['user_count']?> คน</h1>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Logs -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-chart-logs" aria-expanded="true" aria-controls="collapse-chart-logs">
                    <i class="bi-bar-chart-line icon-menu"></i><span>สถิติการเข้าใช้งานระบบ</span>
                </button>
            </h2>
            <div id="collapse-chart-logs" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="display: inline;">ประจำปี </h4>
                            <select class="form-select form-control ms-2 w-15" style="display: inline;" data-placeholder="-- กรุณาเลือกปี --" name="year_search" id="year_search" onchange="get_data_logs_systems(this.value)">
                                <option value="2024" selected>2567</option>
                                <option value="2023">2566</option>
                                <option value="2022">2565</option>
                                <option value="2021">2564</option>
                                <option value="2020">2563</option>
                            </select>
                        </div>
                        <div class="col-md-9">
                            <div id="spline-chart-logs"></div>
                        </div>
                        <div id="logs_systems_by_year" class="col-md-3 text-center" style="max-height: 800px; overflow-y: auto;">
                            <?php foreach ($logs_systems_by_year as $row) { ?>
                            <div class="card card-button" onclick="open_new_tab('<?php echo base_url().'index.php/ums/Dashboard/Dashboard_detail_logs_system/'.$year.'/'.$row['st_id']?>')">
                                <div class="card-body">
                                    <div class="text-start pb-2"><?php echo $row['st_name_th']?></div>
                                    <div class="card-icon rounded-circle float-start">
                                        <img style="width: 50px;" src="<?php echo base_url()."index.php/ums/GetFile?type=system&image=".$row['st_icon'];?>">
                                    </div>
                                    <div class="float-end">
                                        <h1><?php echo $row['ums_log_count']?> ครั้ง</h1>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        var logs_systems = <?php echo !empty($logs_systems_by_month) ? json_encode($logs_systems_by_month) : json_encode([]); ?>;
        get_chart_logs_systems(logs_systems);
        var users_systems = <?php echo !empty($rpt_users_systems) ? json_encode($rpt_users_systems) : json_encode([]); ?>;
        get_chart_users_systems(users_systems);
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

        // Create Highcharts chart
        Highcharts.chart('spline-chart-logs', {
            chart: {
                type: 'spline',
                style: {
                    fontSize: '16px',
                    fontFamily: 'Sarabun'
                },
                height: 800,
                events: {
                    load: function () {
                        var chart = this;
                        // ใส่เหตุการณ์ resize เพื่อให้กราฟปรับตัวอัตโนมัติเมื่อมีการ resize หน้าจอ
                        window.addEventListener('resize', function () {
                            chart.reflow();
                        });
                    }
                }
            },
            title: {
                text: ''
            },
            legend: {
                layout: 'horizontal', // จัดเรียง Legend ในแนวนอน
                align: 'center', // จัดให้ Legend อยู่ตรงกลาง
                verticalAlign: 'bottom', // จัดให้ Legend อยู่ที่ด้านล่าง
                symbolWidth: 1, // กำหนดความกว้างของสัญลักษณ์ใน Legend
                itemStyle: {
                    fontSize: '16px', // กำหนดขนาดตัวอักษรใน Legend
                    fontFamily: 'Sarabun', // กำหนดแบบอักษรใน Legend
                    fontWeight: 'normal' // กำหนดความหนาของตัวอักษรใน Legend
                },
                itemMarginBottom: 10
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: true
            },
            subtitle: {
                text: '',
                align: 'left'
            },
            xAxis: {
                categories: categories,
                title: {
                    text: 'เดือน',
                    style: {
                        fontSize: '16px',
                        fontFamily: 'Sarabun'
                    }
                },
                labels: {
                    style: {
                        fontSize: '16px',
                        fontFamily: 'Sarabun'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'จำนวนการเข้าใช้งานระบบ',
                    style: {
                        fontSize: '16px',
                        fontFamily: 'Sarabun'
                    }
                }
            },
            tooltip: {
                valueSuffix: ' ครั้ง',
                stickOnContact: true,
                headerFormat: 'เดือน {point.x}</br>',
                style: {
                    fontSize: '16px',
                    fontFamily: 'Sarabun'
                }
            },
            plotOptions: {
                series: {
                    cursor: 'pointer',
                    lineWidth: 2,
                    marker: {
                        enabled: true,
                        symbol: 'circle',
                        radius: 4
                    }
                }
            },
            series: series
        });
    }

    function get_card_logs_systems(data, year) {
        if(data && data.length > 0 && year) {
            // Build new HTML content
            var newHtml = '';
            data.forEach(function(row) {
                const url = '<?php echo base_url().'index.php/ums/Dashboard/Dashboard_detail_logs_system/'; ?>';
                newHtml += `
                    <div class="card card-button" onclick="open_new_tab('${url}/${year}/${row.st_id}')">
                        <div class="card-body">
                            <div>${row.st_name_th}</div>
                            <div class="card-icon rounded-circle float-start">
                                <i class="bi-people text-warning"></i>
                            </div>
                            <div class="float-end">
                                <h1>${row.ums_log_count} ครั้ง</h1>
                            </div>
                        </div>
                    </div>
                `;
            });

            // Replace the existing HTML content
            $('#logs_systems_by_year').html(newHtml);
        } else {
            // Build new HTML content
            var newHtml = '';
            newHtml += `
                <div class="">
                    - ไม่มีข้อมูล -
                </div>
            `;

            // Replace the existing HTML content
            $('#logs_systems_by_year').html(newHtml);
        }
    }

    function get_data_logs_systems(year) {
        let url = '<?php echo site_url() . "/ums/Dashboard/Dashboard_get_data_logs_systems"; ?>';
        $.ajax({
            url: url, 
            type: 'POST',
            data: {
                year: year,
            },
            success: function(data) {
                data = JSON.parse(data);
                if(data) {
                    get_chart_logs_systems(data.data.logs_systems_by_month);
                    get_card_logs_systems(data.data.logs_systems_by_year, year);
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

    function get_chart_users_systems(data) {
        // For series based on log names
        const count_users = <?php echo !empty($rpt_count_users) ? $rpt_count_users : 0; ?>;
        var series = [{
                minPointSize: 10,
                innerSize: '20%',
                zMin: 0,
                name: 'countries',
                borderRadius: 5,
                data: [],
                // colors: [
                //     '#4caefe',
                //     '#3dc3e8',
                //     '#2dd9db',
                //     '#1feeaf',
                //     '#0ff3a0',
                //     '#00e887',
                //     '#23e274'
                // ]
            }];

        if(data && data.length > 0) {
            // Calculate percent = (all_users / count_users_in_system) × 100
            data.forEach(function(obj) {
                const count = parseInt(obj.user_count);
                const percent = (count / count_users) * 100;
                series[0].data.push({
                    name: obj.st_name_th,
                    y: count,
                    z: percent.toFixed(2)  // Round percentage to 2 decimal places
                });
            });
        }
        
        // Create Highcharts chart
        Highcharts.chart('pie-chart-users-per-system', {
            chart: {
                type: 'pie',
                style: {
                    fontFamily: 'Sarabun',
                    fontSize: '16px',
                }
            },
            title: {
                text: ''
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<span style="color:{point.color}">\u25CF</span> <b>{point.name}</b><br/>' +
                            'ร้อยละ: <b>{point.z}%</b> ({point.y} คน)<br/>'
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: true
            },
            series: series
        });
    }

    function open_new_tab(url) {
        window.open(url, '_blank');
    }
</script>

<script>
    function counterAnimationHandler() {
        const counters = document.querySelectorAll('.counter ')
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
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + " คน";
    }

    document.addEventListener("DOMContentLoaded", function(event) {
        counterAnimationHandler();
    });
</script>
