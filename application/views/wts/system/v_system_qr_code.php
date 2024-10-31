<style>
    .datatable img {
        width: 40px;
    }
</style>

<!-- Search QR Code Card -->
<!-- <div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                    <i class="bi-search icon-menu"></i><span>ค้นหาข้อมูล</span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="qr_stde_id" class="form-label">แผนกการรักษา</label>
                            <select class="form-select select2" name="search_rdp_stde_id" id="search_rdp_stde_id" data-placeholder="-- กรุณาเลือกแผนกการรักษา --">
                                <option value=""></option>
                                <?php if (isset($stde)) { ?>
                                    <?php foreach ($stde as $dep) : ?>
                                        <option value="<?php echo $dep->stde_id ?>"><?php echo $dep->stde_name_th ?></option> 
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="SpActive" class="form-label">สถานะการใช้งาน</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                    <label class="form-check-label" for="inlineCheckbox1">เปิดใช้งาน</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2" checked>
                                    <label class="form-check-label" for="inlineCheckbox2">ปิดใช้งาน</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- QR Code Table -->
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span>ข้อมูล QR Code</span><span class="badge bg-success"><?php echo count($qr_code); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/wts/System_qr_code/qr_add'"><i class="bi-plus"></i> เพิ่ม QR Code ระบบ </button>
                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">แผนกการรักษา</th>
                                <th class="text-center">รูปภาพ</th>
                                <th class="text-center">วันที่บันทึกข้อมูลล่าสุด</th>
                                <th class="text-center">ผู้บันทึกข้อมูล</th>
                                <th class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($qr_code as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <div class="text-center"><?php echo $key + 1; ?></div>
                                    </td>
                                    <td>
                                        <div><?php echo $item['qr_stde_name'] ?></div>
                                    </td>
                                    <td class="text-center">
                                        <img src="<?php echo $item['qr_link'] ?>" style="width: 100px;" />
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item['qr_update_date'] ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center"><?php echo $item['us_name'] ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href='<?php echo base_url() ?>index.php/wts/System_qr_code/qr_show/<?php echo $item['qr_id'] ?>'"><i class="bi-search"></i></button>
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/wts/System_qr_code/qr_edit/<?php echo $item['qr_id'] ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/wts/System_qr_code/qr_delete_data/<?php echo $item['qr_id'] ?>"><i class="bi-trash"></i></button>
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

