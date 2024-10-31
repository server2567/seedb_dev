<div class="modal fade" id="que_system_modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="que_hidden_st_id" value="7"> <!-- Hidden input field to store st_id -->
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" title="คลิกเพื่อเข้าสู่ระบบ" data-toggle="tooltip" data-placement="top" onclick="redirect_to_gear('que')"> <i class="bi-arrow-right-square"></i> เข้าสู่ระบบ </button>
                </div>
                <div class="card">
                    <ul class="nav nav-tabs d-flex" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="que-register-tab" data-bs-toggle="tab" data-bs-target="#que-register" type="button" role="tab" aria-controls="que-register" aria-selected="true">ผู้ป่วยลงทะเบียน</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="triage-tab" data-bs-toggle="tab" data-bs-target="#triage" type="button" role="tab" aria-controls="triage" aria-selected="false">คัดกรองผู้ลงทะเบียน</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="insurance-tab" data-bs-toggle="tab" data-bs-target="#insurance" type="button" role="tab" aria-controls="insurance" aria-selected="false">ตรวจสอบสิทธิ์การรักษา (ประกันสังคม/ประกันสุขภาพ)</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="que-register" role="tabpanel" aria-labelledby="que-register-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button accordion-button-table" type="button">
                                                <i class="bi-bell icon-menu"></i><span>  ผู้ป่วยลงทะเบียน</span><span class="badge bg-success"><?php echo count($notification_person['que_system']['tab_1']); ?></span>
                                            </button>
                                        </h2>
                                        <div id="collapseShow" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>			
                                                            <th class="text-center" width="5%">#</th>
                                                            <th width="10%">Visit</th>
                                                            <th width="10%">หมายเลขคิว</th>
                                                            <th width="10%">HN</th>
                                                            <th width="20%">ชื่อ - นามสกุลผู้ลงทะเบียน</th>
                                                            <th width="20%">สาเหตุและอาการเบื้องต้น</th>
                                                            <!-- <th width="20%">สาเหตุที่นัดหมายแพทย์</th> -->
                                                            <th width="15%">แผนก/หน่วยงานที่เข้ารับการรักษา</th>
                                                            <th class="text-center" width="10%">วันและเวลาที่นัดหมาย</th>
                                                            <th class="text-center" width="10%">ดำเนินการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($notification_person['que_system']['tab_1'] as $key=>$row){                            
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo ($key+1); ?></td>
                                                            <td class="text-start"><?php echo $row['apm_visit']; ?></td>
                                                            <td class="text-center"><?php echo $row['apm_ql_code'] ?></td>
                                                            <td class="text-start"><?php echo $row['pt_member']; ?></td>
                                                            <td class="text-start"><?php echo $row['pt_name']; ?></td>
                                                            <td class="text-start"><?php echo $row['apm_cause'] == '' ? '- ยังไม่มีการระบุสาเหตุ':$row['apm_cause']; ?></td>
                                                            <td class="text-center"><?php echo $row['dp_name_th']. " ".$row['stde_name_th'];  ?></td>
                                                            <td class="text-center"><?php echo abbreDate2($row['apm_date']). "</br>เวลา ".$row['apm_time']. " น."; ?>
                                                            <td class="text-center option">
                                                                <button class="btn btn-info" title="ดูรายละเอียด" onclick="redirect_to_que_detail('<?php echo encrypt_id($row['apm_id']); ?>')"><i class="bi-search"></i></button>
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
                        <div class="tab-pane fade" id="triage" role="tabpanel" aria-labelledby="triage-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button accordion-button-table" type="button">
                                                <i class="bi-clock-history icon-menu"></i><span>  คัดกรองผู้ลงทะเบียน</span><span class="badge bg-success"><?php echo count($notification_person['que_system']['tab_2']); ?></span>
                                            </button>
                                        </h2>
                                        <div id="collapseShow" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>			
                                                            <th class="text-center" width="5%">#</th>
                                                            <th width="10%">Visit</th>
                                                            <th width="10%">หมายเลขคิว</th>
                                                            <th width="10%">HN</th>
                                                            <th width="20%">ชื่อ - นามสกุลผู้ลงทะเบียน</th>
                                                            <th width="20%">สาเหตุและอาการเบื้องต้น</th>
                                                            <!-- <th width="20%">สาเหตุที่นัดหมายแพทย์</th> -->
                                                            <th width="15%">แผนก/หน่วยงานที่เข้ารับการรักษา</th>
                                                            <th class="text-center" width="10%">วันและเวลาที่นัดหมาย</th>
                                                            <th class="text-center" width="10%">ดำเนินการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($notification_person['que_system']['tab_2'] as $key=>$row){                            
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo ($key+1); ?></td>
                                                            <td class="text-start"><?php echo $row['apm_visit']; ?></td>
                                                            <td class="text-center"><?php echo $row['apm_ql_code'] ?></td>
                                                            <td class="text-start"><?php echo $row['pt_member']; ?></td>
                                                            <td class="text-start"><?php echo $row['pt_name']; ?></td>
                                                            <td class="text-start"><?php echo $row['apm_cause'] == '' ? '- ยังไม่มีการระบุสาเหตุ':$row['apm_cause']; ?></td>
                                                            <td class="text-center"><?php echo $row['dp_name_th']. " ".$row['stde_name_th'];  ?></td>
                                                            <td class="text-center"><?php echo abbreDate2($row['apm_date']). "</br>เวลา ".$row['apm_time']. " น."; ?>
                                                            <td class="text-center option">
                                                                <button class="btn btn-info" title="ดูรายละเอียด" onclick="redirect_to_que_detail('<?php echo encrypt_id($row['apm_id']); ?>')"><i class="bi-search"></i></button>
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
                        <div class="tab-pane fade" id="insurance" role="tabpanel" aria-labelledby="insurance-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button accordion-button-table" type="button">
                                                <i class="bi-clock-history icon-menu"></i><span>  ตรวจสอบสิทธิ์การรักษา (ประกันสังคม/ประกันสุขภาพ)</span><span class="badge bg-success"><?php echo count($notification_person['que_system']['tab_3']); ?></span>
                                            </button>
                                        </h2>
                                        <div id="collapseShow" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <table class="table datatable" width="100%">
                                                    <thead>
                                                        <tr>			
                                                            <th class="text-center" width="5%">#</th>
                                                            <th width="10%">Visit</th>
                                                            <th width="10%">หมายเลขคิว</th>
                                                            <th width="10%">HN</th>
                                                            <th width="20%">ชื่อ - นามสกุลผู้ลงทะเบียน</th>
                                                            <th width="20%">สาเหตุและอาการเบื้องต้น</th>
                                                            <!-- <th width="20%">สาเหตุที่นัดหมายแพทย์</th> -->
                                                            <th width="15%">แผนก/หน่วยงานที่เข้ารับการรักษา</th>
                                                            <th class="text-center" width="10%">วันและเวลาที่นัดหมาย</th>
                                                            <th class="text-center" width="10%">ดำเนินการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($notification_person['que_system']['tab_3'] as $key=>$row){                            
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo ($key+1); ?></td>
                                                            <td class="text-start"><?php echo $row['apm_visit']; ?></td>
                                                            <td class="text-center"><?php echo $row['apm_ql_code'] ?></td>
                                                            <td class="text-start"><?php echo $row['pt_member']; ?></td>
                                                            <td class="text-start"><?php echo $row['pt_name']; ?></td>
                                                            <td class="text-start"><?php echo $row['apm_cause'] == '' ? '- ยังไม่มีการระบุสาเหตุ':$row['apm_cause']; ?></td>
                                                            <td class="text-center"><?php echo $row['dp_name_th']. " ".$row['stde_name_th'];  ?></td>
                                                            <td class="text-center"><?php echo abbreDate2($row['apm_date']). "</br>เวลา ".$row['apm_time']. " น."; ?>
                                                            <td class="text-center option">
                                                                <button class="btn btn-info" title="ดูรายละเอียด" onclick="redirect_to_que_detail('<?php echo encrypt_id($row['apm_id']); ?>')"><i class="bi-search"></i></button>
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
    function redirect_to_que_detail(apm_id){
        var st_id = $('#que_system_modal #que_hidden_st_id').val();
        var url = 'que.Appointment.add_appointment_step2.' + apm_id ;
        window.location.href = '<?php echo base_url(); ?>index.php/gear/set_gear/' + st_id + '/' + url;
    }
</script>