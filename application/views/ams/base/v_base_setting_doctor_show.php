<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span>  รายชื่อแพทย์สำหรับตั้งค่าการแจ้งเตือน</span><span class="badge bg-success"><?php echo count($doctors); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th width="25%">ชื่อ-นามสกุล</th>
                                <th class="text-center" width="20%">แจ้งเตือนใกล้หมดเวลาพบผู้ป่วย</th>
                                <th class="text-center" width="20%">แจ้งเตือนใกล้หมดเวลาด้วยเสียงหรือไม่</th>
                                <th class="text-center" width="20%">ระยะเวลาในการพบผู้ป่วย (นาที)</th>
                                <!-- <th class="text-center">วันที่บันทึกข้อมูลล่าสุด</th>
                                <th>ผู้บันทึกข้อมูลล่าสุด</th> -->
                                <th class="text-center" width="10%">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($doctors as $row) { 
                                $id = !empty($row['usc_id']) ? $row['usc_id'] : '';

                                $id = encrypt_id($id);
                                $ps_id = encrypt_id($row['ps_id']);

                                if(!empty($id))
                                    $url = base_url().'index.php/ams/Setting_doctor/Setting_doctor_edit/'.$id;
                                else
                                    $url = base_url().'index.php/ams/Setting_doctor/Setting_doctor_new/'.$ps_id;
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td><?php echo $row['ps_name']; ?></td>
                                <td class="text-center"><i class="bi-circle-fill <?php echo $row['usc_wts_is_noti'] == 1 ? "text-success" : "text-danger"; ?>"></i> <?php echo $row['usc_wts_is_noti'] == 1 ? "เปิดการแจ้งเตือน" : "ปิดการแจ้งเตือน"; ?></td>
                                <td class="text-center"><i class="bi-circle-fill <?php echo $row['usc_wts_is_noti_sound'] == 1 ? "text-success" : "text-danger"; ?>"></i> <?php echo $row['usc_wts_is_noti_sound'] == 1 ? "เปิดการแจ้งเตือน" : "ปิดการแจ้งเตือน"; ?></td>
                                <td class="text-center"><?php echo $row['usc_ams_minute'] ?? 15; ?></td>

                                <!-- <td class="text-center"><?php echo !empty($row['usc_update_date']) ? convertToThaiYear($row['usc_update_date'], false) : (!empty($row['usc_create_date']) ? convertToThaiYear($row['usc_create_date'], false) : '-'); ?></td> -->
                                <!-- <td class="text-start"><?php echo !empty($row['update_user']) ? $row['update_user'] : (!empty($row['create_user']) ? $row['create_user'] : '-'); ?></td> -->
                                <td class="text-center option">
                                    <!-- <button class="btn btn-warning" onclick="showModal('<?php //echo $url; ?>')"><i class="bi-pencil-square"></i></button> -->
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo $url; ?>'"><i class="bi-pencil-square"></i></button>
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
                var columns = [0, 1, 2, 3]; // specify columns to export
                title = "รายการรายชื่อแพทย์สำหรับตั้งค่าการแจ้งเตือน"; // specify title of head in file

                if(config.titleAttr == "Print") { // if need setting file Print
                    config.exportOptions = { columns: columns };
                    config.title = '<h3 class="font-weight-600 text-center">รายการรายชื่อแพทย์สำหรับตั้งค่าการแจ้งเตือน</h3>';
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
                        doc.content[1].table.widths = ['10%', '35%', '20%', '35%'];
                        // doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto'];
                    };
                    // $("." + config.className).html("PDF"); // specify text and style of button
                }
            }
        });
    });
</script>