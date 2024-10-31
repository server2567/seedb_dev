<style>
    #mc_code_list td:nth-child(2) {
        text-align: left;
    }

    #mc_code_list td:nth-child(3) {
        text-align: left;
    }

    #mc_code_list td:nth-child(4) {
        text-align: left;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="get">
                        <div class="col-md-3">
                            <label for="select_dp_id" class="form-label ">หน่วยงาน</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="select_dp_id" id="select_dp_id">
                                <?php
                                foreach ($dp_info as $key => $row) {
                                ?>
                                    <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="select_status_id" class="form-label ">สถานะการจับคู่</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="select_status_id" id="select_status_id">
                            <option value="all" selected>ทั้งหมด</option>
                                <option value="1" >จับคู่แล้ว</option>
                                <option value="2">ยังไม่ได้จับคู่</option>
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
                    <i class="bi-server icon-menu"></i><span> ตารางจับคู่รหัสเครื่องลงเวลาทำงาน</span><span class="badge bg-success" id="count-data"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%" id="mc_code_list">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="text-center">#</div>
                                </th>
                                <th class="text-center" scope="col">รหัสจากระบบบุคลากร</th>
                                <th class="text-center" scope="col">ชื่อ-นามกสุล</th>
                                <th class="text-center" scope="col">รหัสจากเครื่องลงเวลาทำงาน</th>
                                <th class="text-center" scope="col">สถานะการปฏิบัติงาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
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

<script>
    $(document).ready(function() {
        updateDataTable();
    });

    function updateDataTable() {
        // Initialize DataTable
        var dataTable = $('#mc_code_list').DataTable();

        var dp_id = $('#select_dp_id').val();
        var pos_status = $('#select_status_id').val()
        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_list',
            type: 'POST',
            data: {
                dp_id: dp_id,
                pos_status: pos_status
            },
            success: function(data) {
                // Clear existing DataTable data                
                data = JSON.parse(data);
                $('#count-data').html(data.length)
                dataTable.clear().draw();
                $(".summary_person").text(data.length);
                // Add new data to DataTable
                data.forEach(function(row, index) {
                    var ps_id = row.ps_id
                    var dp_id = $('#select_dp_id').val()
                    if (row.pos_status == 1) {
                        status_text = '<div class="text-center"><i class="bi-circle-fill text-success"></i> ปฏิบัติงานอยู่</div>';
                    } else {
                        status_text = '<div class="text-center"><i class="bi-circle-fill text-danger"></i> ออกจากการปฏิบัติงาน</div>';
                    }
                    var button = `
                        <div class="text-center option">
                            <button class="btn btn-warning" title="คลิกเพื่อแก้ไขข้อมูล" data-toggle="tooltip" data-placement="top" 
                                onclick="window.location.href='<?php echo site_url($controller_dir); ?>/edit/` + ps_id + '/' + dp_id + `'">
                                <i class="bi-pencil-square"></i>
                            </button>
                        </div>
                    `;
                    if(!row.mc_code){
                        row.mc_code = 'ยังไม่ถูกจับคู่'
                    }   
                    dataTable.row.add([
                        (index + 1),
                        row.pos_ps_code,
                        row.pf_name_abbr + ' ' + row.ps_fname + " " + row.ps_lname,
                        row.mc_code,
                        status_text,
                        button
                    ]).draw();
                });
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }

    // Event listeners for select dropdowns
    $('#select_dp_id, #select_status_id').on('change', function() {
        // Update DataTable when a select dropdown changes
        updateDataTable();
    });
</script>