<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-folder2-open icon-menu"></i><span>  ข้อมูลเครื่องมือหัตถการของแต่ละแผนก</span><span class="badge bg-success"><?php echo count($stdes); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center">#</th>
                                <th width="50%">ชื่อแผนก</th>
                                <th width="20%">จำนวนโรคที่รักษาในแผนก</th>
                                <th width="20%" class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($stdes as $row) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td><?php echo $row['stde_name_th']; ?></td>
                                <td class="text-center"><?php echo $row['ds_amount']; ?></td>
                                <td class="text-center option">
                                    <button class="btn btn-success" title="จัดการเครื่องมือหัตถการ" onclick="window.location.href='<?php echo base_url().'index.php/wts/Manage_tool/Manage_tool_edit/'.$row['ds_stde_id']; ?>'"><i class="bi-card-list"></i></button>
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
                var columns = [0, 1]; // specify columns to export
                title = "รายการเครื่องมือหัตถการของแต่ละแผนก"; // specify title of head in file

                if(config.titleAttr == "Print") { // if need setting file Print
                    config.exportOptions = { columns: columns };
                    config.title = '<h3 class="font-weight-600 text-center">รายการเครื่องมือหัตถการของแต่ละแผนก</h3>';
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
                        doc.content[1].table.widths = ['10%', '90%'];
                        // doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto'];
                    };
                    // $("." + config.className).html("PDF"); // specify text and style of button
                }
            }
        });
    });
</script>






