<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-window-dock icon-menu"></i><span>  กรุณาเลือกระบบที่ต้องการ</span><span class="badge bg-success">10</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">หน้าที่</th>
                                <th scope="col">ชื่อระบบ (ท)</th>
                                <th scope="col">ชื่อระบบ (อ)</th>
                                <th scope="col">แก้ไขสิทธิ์</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($usergroups as $row) { ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td><?php echo $row['gp_name_th']; ?></td>
                                <td><?php echo $row['st_name_th'] . (!empty($row['st_name_abbr_th']) ? " (" . $row['st_name_abbr_th'] . ")" : ""); ?></td>
                                <td><?php echo $row['st_name_en'] . (!empty($row['st_name_abbr_en']) ? " (" . $row['st_name_abbr_en'] . ")" : ""); ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-success" title="แก้ไขสิทธิ์" onclick="window.location.href='<?php echo base_url().'index.php/ums/User/user_usergroup_edit/'.$us_id.'/'.$row['ug_gp_id']; ?>'"><i class="bi-card-list"></i></button>
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
                title = "รายการกลุ่มระบบงานของผู้ใช้"; // specify title of head in file

                if(config.titleAttr == "Print") { // if need setting file Print
                    config.exportOptions = { columns: columns };
                    config.title = '<h3 class="font-weight-600 text-center">รายการกลุ่มระบบงานของผู้ใช้</h3>';
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
                        doc.content[1].table.widths = ['10%', '20%', '35%', '35%'];
                        // doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto'];
                    };
                    // $("." + config.className).html("PDF"); // specify text and style of button
                }
            }
        });
    });
</script>