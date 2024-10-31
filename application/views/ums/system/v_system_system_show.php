<style>
    .datatable img {
        width: 40px;
    }
</style>

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลระบบ</span><span class="badge bg-success"><?php echo count($systems); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System/system_edit'"><i class="bi-plus"></i> เพิ่มข้อมูลระบบ </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th width="3%" class="text-center">#</th>
                                <th width="25%">ชื่อระบบ</th>
                                <th width="25%">System Name</th>
                                <th width="7%" class="text-center">ตัวย่อ</th>
                                <th width="5%" class="text-center">Icon</th>
                                <th width="10%" class="text-center">สถานะการใช้งาน</th>
                                <th width="13%" class="text-center">จำนวนกลุ่มผู้ใช้</th>
                                <th width="12%" class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($systems as $row) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td><?php echo $row['st_name_th']; ?></td>
                                <td><?php echo $row['st_name_en']; ?></td>
                                <td class="text-center"><?php echo $row['st_name_abbr_en']; ?></td>
                                <td class="text-center">
                                    <?php
                                        if(!empty($row['st_icon'])) { ?>
                                            <img src="<?php echo base_url()."index.php/ums/GetFile?type=system&image=".$row['st_icon'];?>">
                                    <?php } ?>
                                </td>
                                <td class="text-center"><i class="bi-circle-fill <?php echo $row['st_active'] == 1 ? "text-success" : "text-danger"; ?>"></i> <?php echo $row['st_active'] == 1 ? "เปิดใช้งาน" : "ปิดใช้งาน"; ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-info" onclick="get_modal_bg('<?php echo $row['st_id']; ?>')"><?php echo $row['bg_count']; ?> กลุ่มผู้ใช้ <i class="bi-search ps-2"></i></button></td>
                                <td class="text-center option">
                                    <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url().'index.php/ums/System/system_edit/'.$row['st_id']; ?>'"><i class="bi-pencil-square"></i></button>
                                    <button class="btn btn-success" title="จัดการเมนู" onclick="window.location.href='<?php echo base_url().'index.php/ums/System/system_menu/'.$row['st_id']; ?>'"><i class="bi-card-list"></i></button>
                                    <button class="btn btn-danger swal-delete" data-url="<?php echo base_url().'index.php/ums/System/system_delete/'.$row['st_id']; ?>"><i class="bi-trash"></i></button>
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

<!-- Modal -->
<div class="modal fade" id="modal-bg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
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
                var columns = [0, 1, 2, 3, 4]; // specify columns to export
                title = "รายการรายชื่อระบบ"; // specify title of head in file

                if(config.titleAttr == "Print") { // if need setting file Print
                    config.exportOptions = { columns: columns };
                    config.title = '<h3 class="font-weight-600 text-center">รายการรายชื่อระบบ</h3>';
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
                        doc.content[1].table.widths = ['10%', '30%', '30%', '20%', '10%'];
                        // doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto'];
                    };
                    // $("." + config.className).html("PDF"); // specify text and style of button
                }
            }
        });
    });

    function get_modal_bg(st_id) {
        $('#modal-bg .modal-content').empty();
        let url = '<?php echo base_url().'index.php/ums/System/system_get_bg/'; ?>';

        $.ajax({
            url: url,
            type: 'POST',
            data: { 'st_id': st_id },
            success: function(response) {
                $('#modal-bg .modal-content').html(response);
                $('#modal-bg').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error loading modal content:', error);
            }
        });
    }
</script>






