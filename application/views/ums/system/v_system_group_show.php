<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลสิทธิ์รายระบบ</span><span class="badge bg-success"><?php echo count($groups); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System_group/system_group_edit'"><i class="bi-plus"></i> เพิ่มข้อมูลสิทธิ์รายระบบ </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="30%">ชื่อระบบ</th>
                                <th width="20%">ชื่อสิทธิ์การใช้งาน(ท)</th>
                                <th width="20%">ชื่อสิทธิ์การใช้งาน(E)</th>
                                <th width="10%" class="text-center">สถานะการใช้งาน</th>
                                <th width="15%" class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($groups as $row) {
                            ?>
                            <tr>
                                <td scope="row" class="text-center"><?php echo $i+1; ?></td>
                                <td><?php echo $row['st_name_th']; ?></td>
                                <td><?php echo $row['gp_name_th']; ?></td>
                                <td><?php echo $row['gp_name_en']; ?></td>
                                <td class="text-center"><i class="bi-circle-fill <?php echo $row['gp_active'] == 1 ? "text-success" : "text-danger"; ?>"></i> <?php echo $row['gp_active'] == 1 ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url().'index.php/ums/System_group/system_group_edit/'.$row['gp_id']; ?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-success" title="กำหนดสิทธิ์" onclick="window.location.href='<?php echo base_url().'index.php/ums/System_group/system_group_permission/'.$row['gp_id']; ?>'"><i class="bi-card-list"></i></button>
                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url().'index.php/ums/System_group/system_group_delete/'.$row['gp_id']; ?>"><i class="bi-trash"></i></button>
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
                title = "รายการข้อมูลสิทธิ์รายระบบ"; // specify title of head in file

                if(config.titleAttr == "Print") { // if need setting file Print
                    config.exportOptions = { columns: columns };
                    config.title = '<h3 class="font-weight-600 text-center">' + title + '</h3>';
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