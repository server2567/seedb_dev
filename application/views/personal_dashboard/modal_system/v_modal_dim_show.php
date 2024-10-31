<div class="modal fade" id="dim_system_modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="dim_hidden_st_id" value="2"> <!-- Hidden input field to store st_id -->
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" title="คลิกเพื่อเข้าสู่ระบบ" data-toggle="tooltip" data-placement="top" onclick="redirect_to_gear('dim')"> <i class="bi-arrow-right-square"></i> เข้าสู่ระบบ </button>
                </div>
                <div class="card">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion-button-table" type="button">
                                    <i class="bi-bell icon-menu"></i><span>  รายการคิว</span><span class="badge bg-success"><?php echo count($notification_person['dim_system']); ?></span>
                                </button>
                            </h2>
                            <div id="collapseShow" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <table class="table datatable" width="100%">
                                        <thead>
                                            <tr>			
                                                <th class="text-center" width="5%">Visit</th>
                                                <th class="text-center" width="5%">หมายเลขคิว</th>
                                                <th class="text-center" width="5%">HN</th>
                                                <th width="15%">ชื่อ-นามสกุลผู้ป่วย</th>
                                                <th width="15%">ชื่อแพทย์เจ้าของไข้</th>
                                                <th width="15%">แผนก/หน่วยงานที่เข้ารับการรักษา</th>
                                                <th class="text-center" width="10%">วัน-เวลาที่ส่งตรวจ</th>
                                                <th width="15%">ห้อง/เครื่องมือหัตถการ</th>
                                                <th class="text-center" width="10%">สถานะ</th>
                                                <th class="text-center" width="5%">ดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;
                                                foreach ($notification_person['dim_system'] as $key=>$row) {
                                                    // if ($row->exr_status == 'Y') {
                                                    //     $status = "รอการตรวจ";
                                                        $class = "text-warning";
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $row->apm_visit; ?></td>
                                                <td class="text-center"><?php echo $row->apm_ql_code; ?></td>
                                                <td class="text-center"><?php echo $row->pt_member; ?></td>
                                                <td><?php echo $row->pt_full_name; ?></td>
                                                <td><?php echo $row->ps_full_name; ?></td>
                                                <td><?php echo $row->dp_stde_name_th; ?></td>
                                                <td class="text-center"><?php echo !empty($row->exr_inspection_time) ? convertToThaiYear($row->exr_inspection_time) : "ยังไม่ได้ทำการตรวจ"; ?></td>
                                                <td><?php echo $row->rm_eqs_name; ?></td>
                                                <td class="text-center <?php echo $class; ?>"><?php echo $row->exr_status_text; ?></td>
                                                <td class="text-center option">
                                                    <button class="btn btn-info" title="ดูรายละเอียด" onclick="redirect_to_dim_detail('<?php echo encrypt_id($row->exr_id); ?>')"><i class="bi-search"></i></button>
                                                </td>
                                            </tr>
                                            <?php 
                                                $i++; } 
                                                // }
                                            ?>
                                            
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
    function redirect_to_dim_detail(exr_id){
        var st_id = $('#dim_system_modal #dim_hidden_st_id').val();
        var url = 'dim.Import_examination_result.Import_examination_result_edit.0.' + exr_id ;
        window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id + '/' + url;
    }
</script>