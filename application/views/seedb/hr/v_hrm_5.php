<!-- modal for details_chart_5_modal -->
<div class="modal fade" id="details_chart_5_modal" tabindex="-1" aria-labelledby="details_chart_5_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="details_chart_5_modalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills d-flex" id="details_chart_5_Tab" role="tablist">
                    <!-- Main tabs will be dynamically generated here -->
                </ul>
                <div class="tab-content mb-5 mt-5" id="details_chart_5_TabContent">
                    <!-- Sub-tabs and tables will be dynamically generated here -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function getChartHRM_5() {
    var dp_id = $('#hrm_select_ums_department').val();
    var year = $('#hrm_select_year').val();
    var year_type = $('#hrm_select_year_type').val();

    var hrm_select_year_type = document.querySelector('#hrm_select_year_type option:checked').text;
    var year_text = parseInt($('#hrm_select_year').val());
    year_text = parseInt(year_text + 543);
       
    $("#details_chart_5_modalLabel").text("[HRM-5] รายละเอียดรายงานจำนวนวุฒิการศึกษาของแต่ละสายงาน จำแนกตามวุฒิการศึกษา "+ hrm_select_year_type + " พ.ศ." + year_text);

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_HRM_chart_5",
        type: 'GET',
        data: {
            dp_id: dp_id,
            year: year,
            year_type: year_type
        },
        success: function(data) {
            data = JSON.parse(data);

            console.log('Original data:', data);

            renderChartHRM_chart_5(data.chart.categories, data.chart.series);
            renderChartHRM_chart_5_detail(data.detail);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


function renderChartHRM_chart_5_detail(data) {
    if (typeof data !== 'object' || data === null) {
        // console.error('Expected data to be an object but received:', data);
        return;
    }

    const columns = [
        { title: "#", data: null, className: 'text-center', render: function(data, type, row, meta) {
            return meta.row + 1;
        }},
        { title: "ชื่อ-นามสกุล", data: 'full_name', className: 'text-start' },
        { title: "ประเภทบุคลากร", data: 'ps_hire_name', className: 'text-start' },
        { title: "ตำแหน่งปฏิบัติงาน", data: 'ps_alp_name', className: 'text-start' },
        { title: "สถานะการทำงาน", data: 'ps_retire_name', className: 'text-center' },
        { title: "ระดับการศึกษา", data: 'edulv_name', className: 'text-center' },
        { title: "วุฒิการศึกษา", data: 'edudg_name', className: 'text-start' },
        { title: "สาขาวิชา", data: 'edumj_name', className: 'text-start' },
        { title: "สถานที่", data: 'place_name', className: 'text-start' },
        { title: "ประเทศ", data: 'country_name', className: 'text-center' }
    ];

    // Clean up previous content in modal
    $('#details_chart_5_Tab').empty();
    $('#details_chart_5_TabContent').empty();

    // Define the tabs for education levels
    const educationLevels = [
        "ต่ำกว่าปริญญาตรี",
        "ปริญญาตรี",
        "ปริญญาโท",
        "ปริญญาเอก"
    ];

    educationLevels.forEach((level, index) => {
        // Create a unique ID for each tab and table
        const tabId = `hrm5_tab_${index}`;
        const tableId = `hrm5_table_${index}`;

        // Add a new tab for each education level
        $('#details_chart_5_Tab').append(`
            <li class="nav-item">
                <a class="nav-link ${index === 0 ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="pill" href="#${tabId}" role="tab" aria-controls="${tabId}" aria-selected="${index === 0 ? 'true' : 'false'}" style="margin-right: 10px; margin-top: 10px;">
                    ${level}
                </a>
            </li>
        `);

        // Add the corresponding tab content
        $('#details_chart_5_TabContent').append(`
            <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                <table id="${tableId}" class="table datatable table-bordered table-hover" width="100%"></table>
            </div>
        `);

        // Prepare the data for this education level
        const personData = [];
        const filterOption = [];

        Object.keys(data).forEach(hireCategory => {
            const hireData = data[hireCategory][level];
            if (hireData && Array.isArray(hireData.person_list)) {
                personData.push(...hireData.person_list);

                // Add hire_is_medical to filterOption
                filterOption.push({
                    value: hireData.hire_is_medical,
                    text: hireCategory
                });
            }
        });

        // Initialize DataTable with the relevant data
        initializeDataTableDashboard(`#${tableId}`, personData, columns, filterOption, 'สายงาน');
    });
}


function renderChartHRM_chart_5(categories, data) {
    // // Filter categories and data that have non-zero values across all series
    const filteredCategories = categories.filter((category, index) => {
        return data.some(series => series.data[index] !== 0);
    });

    const filteredData = data.map(series => {
        return {
            ...series,
            data: series.data.filter((value, index) => filteredCategories.includes(categories[index]))
        };
    });

    setTimeout(function() {
        Highcharts.chart('hrm-chart-5', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
                style: {
                    fontSize: '16px'
                }
            },
            colors: ['#FF6384', '#36A2EB', '#4BC0C0', '#9966FF', '#607d8b'], // Bright colors
            xAxis: {
                categories: filteredCategories, // Use the filtered categories here
                labels: {
                    style: {
                        fontSize: '14px'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'จำนวนบุคลากร',
                    style: {
                        fontSize: '14px'
                    }
                },
                labels: {
                    style: {
                        fontSize: '14px'
                    }
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontSize: '14px',
                        color: (Highcharts.defaultOptions.title.style && Highcharts.defaultOptions.title.style.color) || 'gray'
                    }
                }
            },
            legend: {
                itemStyle: {
                    fontSize: '14px'
                }
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}',
                style: {
                    fontSize: '16px'
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '14px'
                        }
                    }
                }
            },
            series: filteredData
        });
    });

    // data = [{
    //     name: 'สายบริหาร',
    //     data: [5, 2, 3, 0, 3] // ตัวอย่างข้อมูลแต่ละวุฒิการศึกษา
    //   },
    //   {
    //     name: 'แพทย์เต็มเวลา / แพทย์บางเวลา',
    //     data: [3, 2, 4, 0, 0]
    //   },
    //   {
    //     name: 'สายการพยาบาล',
    //     data: [4, 3, 4, 0, 4]
    //   },
    //   {
    //     name: 'สายสนับสนุนทางการแพทย์',
    //     data: [7, 2, 2, 0, 4]
    //   },
    //   {
    //     name: 'สายเทคนิคและบริการ',
    //     data: [2, 1, 5, 0, 3]
    //   }
    // ];

    // categories = ['ต่ำกว่าปริญญาตรี', 'ปริญญาตรี', 'ปริญญาโท', 'ปริญญาเอก', 'เฉพาะทาง'];

    // // ตรวจสอบและกรองข้อมูลที่เป็น 0 ทั้งหมด
    // const filteredCategories = categories.filter((category, index) => {
    //   return data.some(series => series.data[index] !== 0);
    // });

    // const filteredData = data.map(series => {
    //   return {
    //     ...series,
    //     data: series.data.filter((value, index) => filteredCategories.includes(categories[index]))
    //   };
    // });

    // setTimeout(function() {
    //   Highcharts.chart('hrm-chart-5', {
    //     chart: {
    //       type: 'column'
    //     },
    //     title: {
    //       text: '',
    //       style: {
    //         fontSize: '16px'
    //       }
    //     },
    //     colors: ['#FF6384', '#36A2EB', '#4BC0C0', '#9966FF', '#607d8b'], // สีสดใส
    //     xAxis: {
    //       categories: categories,
    //       labels: {
    //         style: {
    //           fontSize: '14px'
    //         }
    //       }
    //     },
    //     yAxis: {
    //       min: 0,
    //       title: {
    //         text: 'จำนวนบุคลากร',
    //         style: {
    //           fontSize: '14px'
    //         }
    //       },
    //       labels: {
    //         style: {
    //           fontSize: '14px'
    //         }
    //       },
    //       stackLabels: {
    //         enabled: true,
    //         style: {
    //           fontSize: '14px',
    //           color: (Highcharts.defaultOptions.title.style && Highcharts.defaultOptions.title.style.color) || 'gray'
    //         }
    //       }
    //     },
    //     legend: {
    //       itemStyle: {
    //         fontSize: '14px'
    //       }
    //     },
    //     tooltip: {
    //       headerFormat: '<b>{point.x}</b><br/>',
    //       pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}',
    //       style: {
    //         fontSize: '16px'
    //       }
    //     },
    //     plotOptions: {
    //       column: {
    //         stacking: 'normal',
    //         dataLabels: {
    //           enabled: true,
    //           style: {
    //             fontSize: '14px'
    //           }
    //         }
    //       }
    //     },
    //     series: filteredData
    //   });
    // });

}


</script>