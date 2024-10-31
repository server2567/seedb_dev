<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลประเภทบุคลากร</span><span class="badge bg-success"><?= isset($hire_info)? count($hire_info) : 0?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/hr/base/hire/get_hire_add'"><i class="bi-plus"></i> เพิ่มข้อมูลประเภทบุคลากร </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th scope="col"><div class="text-center">#</div></th>
                                <th scope="col" class="text-center">ชื่อประเภทบุคลากร (ภาษาไทย)</th>
                                <th scope="col"class="text-center">ชื่อย่อประเภทพนักงาน</th>
                                <th scope="col" class="text-center">ประเภทการปฏิบัติงาน</th>
                                <th scope="col" class="text-center">ฝ่ายบุคลากร</th>
                                <th scope="col"class="text-center">สถานะการใช้งาน</th>
                                <th scope="col"class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hire_info as $key => $item) { 
                                    if (empty($item)) {
                                        $hire_is_name = "";
                                    } else {
                                        switch ($item->hire_is_medical) {
                                            case "M":
                                                $hire_is_name = "สายการแพทย์";
                                                break;
                                            case "N":
                                                $hire_is_name = "สายการพยาบาล";
                                                break;
                                            case "SM":
                                                $hire_is_name = "สายสนับสนุนทางการแพทย์";
                                                break;
                                            case "A":
                                                $hire_is_name = "สายบริหาร";
                                                break;
                                            default:
                                                $hire_is_name = "สายเทคนิคและบริการ";
                                                break;
                                        }
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->hire_name ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->hire_abbr?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo !empty($item) && $item->hire_type== 1 ? 'ปฏิบัติงานเต็มเวลา (Full Time)' : 'ปฏิบัติงานบางเวลา (Part Time)' ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $hire_is_name; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $item->hire_active  == "1" ? 'text-success' : 'text-danger'?>"></i> <?php echo $item->hire_active == '1' ? 'เปิดใช้งาน':'ปิดใช้งาน' ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/hire/get_hire_edit/<?php echo $item->hire_id?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/hire/delete_hire/<?php echo $item->hire_id ?>"><i class="bi-trash"></i></button>
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