<div class="modal fade" id="ams_system_modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ams_hidden_st_id" value=""> <!-- Hidden input field to store st_id -->
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" title="คลิกเพื่อเข้าสู่ระบบ" data-toggle="tooltip" data-placement="top" onclick="redirect_to_gear('ams')"> <i class="bi-arrow-right-square"></i> เข้าสู่ระบบ </button>
                </div>
                <div class="card">
                    <ul class="nav nav-tabs d-flex" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="ams-noti-tab" data-bs-toggle="tab" data-bs-target="#ams-noti" type="button" role="tab" aria-controls="ams-noti" aria-selected="true">แจ้งเตือนการนัดหมาย</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="ams-his-tab" data-bs-toggle="tab" data-bs-target="#ams-his" type="button" role="tab" aria-controls="ams-his" aria-selected="false">แจ้งเตือนผลการตรวจจากห้องปฏิบัติการทางการแพทย์</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="ams-noti" role="tabpanel" aria-labelledby="ams-noti-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button accordion-button-table" type="button">
                                                <i class="bi-bell icon-menu"></i><span>  รายการแจ้งเตือนการนัดหมาย</span><span class="badge bg-success"><?php echo count($notification_person['ams_system']['tab_1']); ?></span>
                                            </button>
                                        </h2>
                                        <div id="collapseShow" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>			
                                                            <th class="text-center" width="5%">#</th>
                                                            <th width="15%">ชื่อ - นามสกุลผู้ป่วย</th>
                                                            <th width="15%">รายละเอียด</th>
                                                            <th class="text-center" width="15%">วันเวลาที่นัดหมาย</th>
                                                            <th width="10%">ห้องปฏิบัติการทางการแพทย์</th>
                                                            <th class="text-center" width="10%">ช่องทางแจ้งเตือนผู้ป่วย</th>
                                                            <th class="text-center" width="10%">สถานะ</th>
                                                            <th class="text-center" width="10%">ดำเนินการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($notification_person['ams_system']['tab_1'] as $key=>$row){                            
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo ($key+1); ?></td>
                                                            <td class="text-center"><?php echo $row->pf_name.$row->ps_fname." ".$row->ps_lname; ?></td>
                                                            <td class="text-start"><?php echo $row->apm_cause; ?></td>
                                                            <td class="text-center"><?php echo isset($row->exr_inspection_time) ? abbreDate4($row->exr_inspection_time) : ""; ?>
                                                            <td class="text-start"><?php echo "(".$row->rm_no.") ".$row->rm_name; ?></td>
                                                            <td class="text-center"><?php echo $row->ntf_name;  ?></td>
                                                            <td class="text-center"><?php echo $row->ast_name;  ?></td>
                                                            
                                                            <td class="text-center option">
                                                                <button class="btn btn-info" title="ดูรายละเอียด" onclick="redirect_to_que_detail('<?php echo encrypt_id($row->apm_id); ?>')"><i class="bi-search"></i></button>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                            }                         
                                                        ?>
                                                    </tbody>
                                                   
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ams-his" role="tabpanel" aria-labelledby="ams-his-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button accordion-button-table" type="button">
                                                <i class="bi-clock-history icon-menu"></i><span>  รายการแจ้งเตือนผลการตรวจจากห้องปฏิบัติการทางการแพทย์</span><span class="badge bg-success"><?php echo count($notification_person['ams_system']['tab_2']); ?></span>
                                            </button>
                                        </h2>
                                        <div id="collapseShow" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>			
                                                            <th class="text-center" width="3%">#</th>
                                                            <th width="15%">ชื่อ - นามสกุลผู้ป่วย</th>
                                                            <th width="15%">รายละเอียด</th>
                                                            <th width="10%">เครื่องมือหัตถการ</th>
                                                            <th width="15%">ห้องปฏิบัติการทางการแพทย์</th>
                                                            <th width="15%">วันที่ เวลาที่ตรวจ</th>
                                                            <th class="text-center" width="10%">ดำเนินการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($notification_person['ams_system']['tab_2'] as $key=>$row){                            
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo ($key+1); ?></td>
                                                            <td class="text-center"><?php echo $row->pf_name.$row->ps_fname." ".$row->ps_lname; ?></td>
                                                            <td class="text-center"><?php echo $row->ntr_detail_lab; ?>
                                                            <td class="text-start"><?php echo $row->eqs_name; ?></td>
                                                            <td class="text-start"><?php echo "(".$row->rm_no.") ".$row->rm_name; ?></td>
                                                            <td class="text-center"><?php echo $row->exr_inspection_time ? abbreDate4($row->exr_inspection_time) : "-"; ?>
                                                            
                                                            <td class="text-center option">
                                                                <button class="btn btn-info" title="ดูรายละเอียด" onclick="redirect_to_que_detail('<?php echo encrypt_id($row->apm_id); ?>')"><i class="bi-search"></i></button>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                            }                         
                                                        ?>
                                                    </tbody>
                                                    <!-- <tbody>
                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td>อารีรัตน์ ผ่องอุไร</td>
                                                            <td>ผลตรวจวัดเลนส์แก้วตาเทียม</td>
                                                            <td class="text-center"><a href="#"><i class="bi-file-earmark-fill"></i></a></td>
                                                            <td>เครื่อง IOL master 700</td>
                                                            <td>ห้องเครื่องมือพิเศษ</td>
                                                            <td>1 พฤษภาคม พ.ศ.2567 15.00 น.</td>
                                                            <td class="text-center option">
                                                                <button class="btn btn-info" title="ดูรายละเอียด"><i class="bi-search"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody> -->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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
    function redirect_to_ams_detail(apm_id){
        var st_id = $('#ams_system_modal #_hidden_st_id').val();
        var url = 'wts.Manage_queue.form_info.' + apm_id ;
        window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id + '/' + url;
    }
</script>