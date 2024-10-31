<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>  รายชื่อผู้ใช้</span><span class="badge bg-success"><?php echo count($users); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/ums/User/user_edit'"><i class="bi-plus"></i> เพิ่มรายชื่อผู้ใช้งาน </button>
                    </div>
                    <table class="table datatable" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>ชื่อเข้าใช้ระบบ</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($users as $row) { ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td><?php echo $row['us_name']; ?></td>
                                <td><?php echo $row['us_username']; ?></td>
                                <td class="text-center"><i class="bi-circle-fill <?php echo $row['us_active'] == 1 ? "text-success" : "text-danger"; ?>"></i> <?php echo $row['us_active'] == 1 ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url().'index.php/ums/User/user_edit/'.$row['us_id']; ?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-success" title="จัดการสิทธิ์" onclick="window.location.href='<?php echo base_url().'index.php/ums/User/user_usergroup/'.$row['us_id']; ?>'"><i class="bi-card-list"></i></button>
                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url().'index.php/ums/User/user_delete/'.$row['us_id']; ?>"><i class="bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php 
                                $i++; } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Setting Export Datatable.js
        var table = $('.datatable').DataTable();
        var buttons = table.buttons();

        buttons.each(function(button, buttonIdx) {
            if (button) {
                // get config
                var config = button.inst.s.buttons[buttonIdx].conf;
                // console.log(config)
                // specify some config
                var columns = [0, 1, 2]; // specify columns to export
                title = "รายการรายชื่อผู้ใช้"; // specify title of head in file

                if(config.titleAttr == "Print") { // if need setting file Print
                    config.exportOptions = { columns: columns };
                    config.title = '<h3 class="font-weight-600 text-center">รายการรายชื่อผู้ใช้</h3>';
                    // $("." + config.className).html("Print"); // specify text and style of button
                }
                if(config.titleAttr == "Excel") { // if need setting file Excel
                    config.exportOptions = { columns: columns };
                    config.title = title;
                    // $("." + config.className).html("Excel"); // specify text and style of button
                }
                if(config.titleAttr == "PDF") { // if need setting file PDF
                    config.exportOptions = { columns: columns };
                    config.title = title;
                    config.customize = function (doc) {
                        doc.defaultStyle = { font: 'THSarabun' };
                        doc.content[1].table.widths = ['10%', '35%', '35%', '20%'];
                        // doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto'];
                    };
                    // $("." + config.className).html("PDF"); // specify text and style of button
                }
            }
        });
    });
</script>