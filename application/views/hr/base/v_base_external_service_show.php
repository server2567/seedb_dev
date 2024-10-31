<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลประเภทบริการหน่วยงาน</span><span class="badge bg-success"><?= isset($exts_info)? count($exts_info) : 0?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/hr/base/External_service/get_external_service_add'"><i class="bi-plus"></i> เพิ่มข้อมูลประเภทบริการหน่วยงาน </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th scope="col"><div class="text-center">#</div></th>
                                <th scope="col" class="text-center">ชื่อประเภทบริการหน่วยงาน (ภาษาไทย)</th>
                                <th scope="col"class="text-center">ชื่อประเภทบริการหน่วยงาน (ภาษาอังกฤษ)</th>
                                <th scope="col"class="text-center">สถานะการใช้งาน</th>
                                <th scope="col"class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($exts_info as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->exts_name_th; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->exts_name_en; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $item->exts_active  == "1" ? 'text-success' : 'text-danger'?>"></i> <?php echo $item->exts_active == '1' ? 'เปิดใช้งาน':'ปิดใช้งาน' ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/External_service/get_external_service_edit/<?php echo $item->exts_id?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/External_service/delete_external_service/<?php echo $item->exts_id ?>"><i class="bi-trash"></i></button>
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