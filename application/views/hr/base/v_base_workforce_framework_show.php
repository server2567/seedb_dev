<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  รายการข้อมูลชั่วโมงการปฏิบัติงาน</span><span class="badge bg-success"><?= isset($bwfw_info)? count($bwfw_info) : 0?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/hr/base/Workforce_framework/get_workforce_framework_add'"><i class="bi-plus"></i> เพิ่มข้อมูลชั่วโมงการปฏิบัติงาน </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th scope="col"><div class="text-center">#</div></th>
                                <th scope="col" class="text-center">ชื่อรูปแบบปฏิบัติงาน (ภาษาไทย)</th>
                                <th scope="col"class="text-center">ชื่อรูปแบบปฏิบัติงาน (ภาษาอังกฤษ)</th>
                                <th scope="col"class="text-center">สายงาน</th>
                                <th scope="col"class="text-center">ประเภทการทำงาน</th>
                                <th scope="col"class="text-center">จำนวนชั่วโมงปฏิบัติงาน (ชั่วโมง)</th>
                                <th scope="col"class="text-center">สถานะการใช้งาน</th>
                                <th scope="col"class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bwfw_info as $key => $item) { 
                                
                                if (empty($item)) {
                                    $bwfw_is_name = "";
                                } else {
                                    switch ($item->bwfw_is_medical) {
                                        case "M":
                                            $bwfw_is_name = "สายการแพทย์";
                                            break;
                                        case "N":
                                            $bwfw_is_name = "สายการพยาบาล";
                                            break;
                                        case "SM":
                                            $bwfw_is_name = "สายสนับสนุนทางการแพทย์";
                                            break;
                                        case "A":
                                            $bwfw_is_name = "สายบริหาร";
                                            break;
                                        default:
                                            $bwfw_is_name = "สายเทคนิคและบริการ";
                                            break;
                                    }
                                }
                            ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->bwfw_name_th; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->bwfw_name_en; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $bwfw_is_name; ?></div>
                                    </td>
                                    <td>
                                    <div class="text-start"><?php echo !empty($item) && $item->bwfw_type== 1 ? 'ปฏิบัติงานเต็มเวลา (Full Time)' : 'ปฏิบัติงานบางเวลา (Part Time)' ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item->bwfw_hour; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $item->bwfw_active  == "1" ? 'text-success' : 'text-danger'?>"></i> <?php echo $item->bwfw_active == '1' ? 'เปิดใช้งาน':'ปิดใช้งาน' ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Workforce_framework/get_workforce_framework_edit/<?php echo $item->bwfw_id?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/Workforce_framework/delete_workforce_framework/<?php echo $item->bwfw_id ?>"><i class="bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>