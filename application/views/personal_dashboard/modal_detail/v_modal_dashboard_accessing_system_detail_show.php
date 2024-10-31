<style>
    .hidden {
        display: none;
    }
</style>
<?php
    setlocale(LC_TIME, 'th_TH.utf8');
    // Array of Thai month names
    $thaiMonths = array(
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    );

    $currentYear = date("Y"); // Get the current year
    $adjustedYears = []; // Initialize an array to store adjusted years
    for ($i = 0; $i <= 4; $i++) {
        $adjustedYear = ($currentYear - $i) + 543;
        $adjustedYears[] = $adjustedYear; // Add the adjusted year to the array
    }
    $default_year_list = $adjustedYears;
?>
<input type="hidden" id="system-id-log-dashboard-ums-log-card-detail-modal" name="system-id-log-dashboard-ums-log-card-detail-modal">
<div class="modal fade" id="dashboard-accessing-system-detail-modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-dashboard-ums-log-card-detail-modal"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                    <i class="bi-search icon-menu"></i><span> ค้นหารายการ</span>
                                </button>
                            </h2>
                            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                                <div class="accordion-body">
                                    <form class="row g-3" method="get">
                                        <div class="col-md-4">
                                            <label for="select_type_accessing" class="form-label required">ช่วงเวลา</label>
                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกช่วงเวลา --" name="select_type_accessing" id="select_type_accessing">
                                                <option value="weekly" selected>7 วันย้อนหลัง</option>
                                                <option value="monthly">รายเดือน</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="month_container">
                                            <label for="select_month" class="form-label required">เดือน</label>
                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกเดือน --" name="select_month" id="select_month">
                                            <?php 
                                                $i=0;
                                                foreach ($thaiMonths as $row) { 
                                                    // Get current date
                                                    if((date('n') - 1) == $i)
                                                        echo '<option value="'.($i+1).'" selected>'.$row.'</option>';
                                                    else 
                                                        echo '<option value="'.($i+1).'">'.$row.'</option>';
                                                    $i++;
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="year_container">
                                            <label for="select_year" class="form-label">ปี</label>
                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกปี --" name="select_year" id="select_year">
                                                <?php 
                                                    $i=0;
                                                    foreach ($default_year_list as $year) { 
                                                        // Get current date
                                                        if($year == getNowYearTh())
                                                            echo '<option value="'.($year-543).'" selected>'.$year.'</option>';
                                                        else 
                                                            echo '<option value="'.($year-543).'">'.$year.'</option>';
                                                        $i++;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-clock-history icon-menu"></i><span>  รายการการเข้าใช้งาน</span><span class="badge bg-success" id="summary-dashboard-ums-log-card-detail-modal"></span> <span class="badge bg-primary" id="summary2-dashboard-ums-log-card-detail-modal"></span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <table class="table datatable" id="table-dashboard-ums-log-card-detail-modal" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="10%" scope="col" class="text-center">#</th>
                                                <th width="35%" scope="col">รายละเอียด</th>
                                                <th width="25%" scope="col">วันที่</th>
                                                <th width="15%" scope="col">IP</th>
                                                <th width="15%" scope="col">ช่องทาง</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="คลิกเพื่อปิด" data-toggle="tooltip" data-placement="top">ปิด</button>
            </div>
        </div>
    </div>
</div>
<script>

$(document).ready(function() {
    // Initial call to set visibility based on the default value
    toggleVisibility();

    // Attach change event to select_type_accessing
    $('#select_type_accessing').change(function() {
        toggleVisibility();
    });

    // Event listeners for select dropdowns
    $('#select_type_accessing, #select_month, #select_year').on('change', function() {
        // Update DataTable when a select dropdown changes
        updateDataAccessingTable();
    });

});

function toggleVisibility() {
    if ($('#select_type_accessing').val() === 'weekly') {
        $('#month_container').addClass('hidden');
        $('#year_container').addClass('hidden');
    } else {
        $('#month_container').removeClass('hidden');
        $('#year_container').removeClass('hidden');
    }
}

// Function to update DataTable based on select dropdown values
function updateDataAccessingTable() {
    var type = "ums-log-card";
    var type_select = $('#select_type_accessing').val();
    var month = $('#select_month').val();
    var year = $('#select_year').val();
    var log_id = $('#system-id-log-dashboard-ums-log-card-detail-modal').val();

    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>'+"get_weekly_ums_dashboard",
        type: 'POST',
        data: { 
            isAction : 'detail',
            type: type_select,
            month: month,
            year: year,
            system_log_id: log_id,
        },
        success: function(data) {
            data = JSON.parse(data);
            
            $('#summary-dashboard-'+type+'-detail-modal').text(data.log_ums_type_card.length);
            var dataTable = $('#table-dashboard-'+type+'-detail-modal').DataTable();
            dataTable.clear().draw();

            data.log_ums_type_card.forEach(function(row, index) {
                dataTable.row.add([
                    '<div class="text-center">' + (index+1) + '</div>',
                    '<div class="text-start">' + row.log_detail + '</div>',
                    '<div class="text-center">' + row.log_date + '</div>',
                    '<div class="text-center">' + row.log_ip + '</div>',
                    '<div class="text-center">' + row.log_agent + '</div>'
                ]).draw();
            });
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(xhr, status, error) {
            // dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
}


</script>