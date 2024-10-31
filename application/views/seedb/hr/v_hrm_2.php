<!-- Modal for details_chart_2_modal -->
<div class="modal fade" id="details_chart_2_modal" tabindex="-1" aria-labelledby="details_chart_2_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="details_chart_2_modalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" id="details_chart_2_Tab" role="tablist">
                    
                </ul>
                <div class="tab-content mb-5 mt-5" id="details_chart_2_TabContent">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function getChartHRM_2(){
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#details_chart_2_modalLabel").text("[HRM-2] รายละเอียดจำนวนบุคลากร จำแนกตามฝ่าย "+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_2",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            renderChartHRM_2(data.chart);
            renderChartHRM_2_detail(data.chart);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_2_detail(data) {
    if (!Array.isArray(data)) {
        // console.error('Expected data to be an array but received:', data);
        return;
    }

    const columns = [
        { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
            return meta.row + 1;
        }},
        { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
        { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-start' },
        // { title: "ตำแหน่งในการบริหาร", data: 'ps_admin_name', className: 'text-start' },
        { title: "ตำแหน่งปฏิบัติงาน", data: 'ps_alp_name', className: 'text-start' },
        { title: "ตำแหน่งงานเฉพาะทาง", data: 'ps_spcl_name', className: 'text-start' },
        { title: "ฝ่าย/แผนก", data: 'stde_name_position', className: 'text-start' },
        { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' }
    ];

    // Clean up previous content in modal
    $('#details_chart_2_Tab').empty();
    $('#details_chart_2_TabContent').empty();

    data.forEach((detail, index) => {
        if (!Array.isArray(detail.chart_detail)) {
            // console.error('Expected chart_detail to be an array but received:', detail.chart_detail);
            return;
        }

        // Generate filter options based on stde_id in chart_detail
        const filterOption = detail.chart_detail.map(item => ({
            value: item.stde_id, // Use stde_id as value
            text: item.chart_name // Use chart_name as text
        }));

        // Create a unique ID for each tab and table
        const tabId = `hrm2_tab_${index}`;
        const tableId = `hrm2_table_${index}`;

        // Add a new tab for each level 3 category
        $('#details_chart_2_Tab').append(`
            <li class="nav-item">
                <a class="nav-link ${index === 0 ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="pill" href="#${tabId}" role="tab" aria-controls="${tabId}" aria-selected="${index === 0 ? 'true' : 'false'}" style="margin-right: 10px; margin-top: 10px;">
                    ${detail.chart_name}
                </a>
            </li>
        `);

        // Add the corresponding tab content
        $('#details_chart_2_TabContent').append(`
            <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                <table id="${tableId}" class="table datatable table-bordered table-hover" width="100%"></table>
            </div>
        `);

         // Flatten the structure_person arrays from each chart_detail item
         const personData = detail.chart_detail.flatMap(item => item.structure_person);

        // Initialize DataTable with the relevant data
        initializeDataTableDashboard(`#${tableId}`, personData, columns, filterOption, 'ฝ่าย');
    });
}

function renderChartHRM_2(data) {

    const colors = [ 
        '#36A2EB', // Blue
        '#FF6384', // Red
        '#4BC0C0', // Teal
        '#FF9F40', // Orange
        '#9966FF', // Purple
        '#607d8b', // Grey-Blue
        '#FFCD56', // Yellow
        '#4B0082', // Indigo
        '#00FF7F', // Spring Green
        '#FF4500'  // Orange-Red
    ];

    // Prepare data for the top level series
    const topLevelSeries = data.map((item, index) => ({
        name: item.chart_name,
        data: [{
            y: item.chart_count,
            drilldown: item.chart_id.toString(),
            color: colors[index % colors.length] // Assign a color from the colors array
        }]
    }));

    // Prepare data for drilldown series
    const drilldownSeries = data.map((item, index) => {
        const level4Data = item.chart_detail.map(subItem => ({
            name: subItem.chart_name,
            value: subItem.chart_count,
            color: colors[index % colors.length] // Use the same color for sub-items
        }));

        return {
            id: item.chart_id.toString(),
            type: 'packedbubble', // Use packed bubble for drilldown
            minSize: '20%',
            maxSize: '80%',
            zMin: 0,
            zMax: 20,
            name: item.chart_name,
            showInLegend: true, // Show in legend
            data: level4Data
        };
    });

    Highcharts.chart('hrm-chart-2', {
        chart: {
            type: 'pictorial',
            // height: 350,
            events: {
                load: function() {
                    document.getElementById('loader2').classList.add('hidden');
                    loadProcessStatus(this);

                    this.series.forEach(series => {
                        Highcharts.addEvent(series, 'legendItemClick', function() {
                            saveProcessStatus(this.chart);
                        });
                    });
                }
            }
        },
        colors: colors,
        title: {
            text: ''
        },
        accessibility: {
            screenReaderSection: {
                beforeChartFormat: '<{headingTagName}>{chartTitle}</{headingTagName}><p>{typeDescription}</p><p>{chartSubtitle}</p><p>{chartLongdesc}</p>'
            },
            point: {
                valueDescriptionFormat: '{value} คน'
            },
            series: {
                descriptionFormat: ''
            },
            landmarkVerbosity: 'one'
        },
        xAxis: {
            visible: false,
            min: 0.18
        },
        yAxis: {
            visible: false
        },
        legend: {
            align: 'right',
            floating: true,
            itemMarginTop: 5,
            itemMarginBottom: 5,
            layout: 'vertical',
            margin: 10,
            padding: 10,
            verticalAlign: 'middle',
            // This ensures the legend updates during drilldown
            labelFormatter: function() {
                return this.name;
            }
        },
        tooltip: {
            formatter: function() {
                if (this.point.drilldown) {
                    return '<span style="color:' + this.series.color + '">\u25CF</span> <b>' + this.series.name + '</b><br/>' +
                        'จำนวน: ' + Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน' +
                        '<br/>ร้อยละ: ' + (this.percentage !== undefined ? this.percentage.toFixed(1) : '0.0') + '%';
                } else {
                    return '<span style="color:' + this.point.color + '">\u25CF</span> <b>' + this.point.name + '</b><br/>' +
                        'จำนวน: ' + Highcharts.numberFormat(this.point.value, 0, '.', ',') + ' คน';
                }
            },
            style: {
                fontSize: '16px'
            }
        },
        plotOptions: {
            series: {
                pointPadding: 0,
                groupPadding: 0,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    formatter: function() {
                        if (this.point.drilldown) {
                            return Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน' + ' (' + (this.point.percentage !== undefined ? this.point.percentage.toFixed(1) : '0.0') + '%)';
                        } else {
                            return this.point.name + ': ' + Highcharts.numberFormat(this.point.value, 0, '.', ',') + ' คน';
                        }
                    },
                    style: {
                        fontSize: '14px'
                    }
                },
                stacking: 'percent',
                paths: [{
                    definition: 'M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1l32 0 0 160.4c0 35.3 28.7 64 64 64l320.4 0c35.5 0 64.2-28.8 64-64.3l-.7-160.2 32 0zM256 208c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 48 48 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-48 0 0 48c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-48-48 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16l48 0 0-48z'
                }]
            }
        },
        credits: {
            enabled: false
        },
        series: topLevelSeries, // Use the dynamically generated topLevelSeries
        drilldown: {
            activeAxisLabelStyle: {
                textDecoration: 'none'
            },
            activeDataLabelStyle: {
                textDecoration: 'none'
            },
            chart: {
                events: {
                    drillup: function() {
                        this.update({
                            xAxis: {
                                visible: false,
                                min: 0.18
                            },
                            yAxis: {
                                visible: false
                            },
                            legend: {
                                align: 'right',
                                floating: true,
                                itemMarginTop: 5,
                                itemMarginBottom: 5,
                                layout: 'vertical',
                                margin: 10,
                                padding: 10,
                                verticalAlign: 'middle'
                            },
                        });
                    }
                }
            },
            series: drilldownSeries // Use the dynamically generated drilldownSeries
        }
    });
}





</script>