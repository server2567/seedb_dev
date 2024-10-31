<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>  ข้อมูลตำแหน่งปฏิบัติงาน</span><span class="badge bg-success"><?= isset($adline_info)? count($adline_info) : 0?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/hr/base/adline_position/get_adline_position_add'"><i class="bi-plus"></i> เพิ่มตำแหน่งปฏิบัติงาน </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th scope="col"><div class="text-center">#</div></th>
                                <th scope="col" class="text-center">ชื่อตำแหน่งปฏิบัติงาน (ภาษาไทย)</th>
                                <th scope="col" class="text-center">ชื่อตำแหน่งปฏิบัติงาน (ภาษาอังกฤษ)</th>
                                <!-- <th scope="col">ตัวย่อภาษาไทย</th>
                                <th scope="col">ตัวย่อภาษาอังกฤษ</th> -->
                                <th scope="col">สถานะการใช้งาน</th>
                                <th scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($adline_info as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key+1; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo $item->alp_name.(!empty($item->alp_name_abbr)? ' ('.$item->alp_name_abbr.')': '') ?></div>
                                    </td>
                                    <td>
                                        <div class="text-start"><?php echo  $item->alp_name_en.(!empty($item->alp_name_abbr_en)? ' ('.$item->alp_name_abbr_en.')': '')?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><i class="bi-circle-fill <?php echo $item->alp_active == '1' ? 'text-success' : 'text-danger'?>"></i> <?php echo $item->alp_active == '1'? 'เปิดใช้งาน' : 'ปิดใช้งาน'?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/adline_position/get_adline_position_edit/<?php echo $item->alp_id ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/adline_position/delete_adline_position/<?php echo $item->alp_id ?>"><i class="bi-trash"></i></button>
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