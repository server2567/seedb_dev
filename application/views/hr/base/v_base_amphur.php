<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหาอำเภอ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <div class="row"> <!-- id="validate-form" data-parsley-validate   -->
                        <!-- <div class="col-2 text-end">
                            <label for="UgID" class="form-label required">เลือกกลุ่มผู้ใช้</label>
                        </div>
                        <div class="col-10">
                            <select class="form-select select2-multiple" data-placeholder="-- กรุณาเลือกระบบ --" name="StID" id="StID" multiple required>
                                <option value=""></option>
                                <option value="1">ระบบการบริหารจัดการผู้ใช้งานระบบ</option>
                            </select>
                        </div> -->
                        <div class="col-3 text-end">
                            <label for="RoleID" class="form-label required">จังหวัด</label>
                        </div>
                        <div class="col-6">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกเลือกจังหวัด --" name="province" id="pv_id" required>
                                <option value="">กรุณาเลือกจังหวัด</option>
                                <?php if (!empty($pv_info)) : ?>
                                    <?php foreach ($pv_info as $value) : ?>
                                        <option value="<?= $value->pv_id ?>" <?= $value->pv_id == 1 ? 'selected' : '' ?>><?= $value->pv_name ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button onclick="filterTable()" class="btn btn-primary float-end">ค้นหา</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> ข้อมูลอำเภอ</span><span class="badge bg-success" id="count_data"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/amphur/get_amphur_add'"><i class="bi-plus"></i> เพิ่มอำเภอ </button>
                    </div>
                    <table class="table datatable" id="tableList" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่ออำเภอ (ภาษาไทย)</th>
                                <th class="text-center" scope="col">ชื่ออำเภอ (ภาษาอังกฤษ)</th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        filterTable()
    });

    function filterTable() {
        const provinceId = document.getElementById('pv_id').value;
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'Amphur/filter_amphurs'; ?>',
            method: 'POST',
            data: {
                province_id: provinceId,
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData);
            console.log(data);
            $('#count_data').html(data.length);
            var table = $('#tableList').DataTable()
            table.clear().draw();
            data.forEach(function(item, index) {
                table.row.add([
                    index + 1,
                    '<div class="text-start">' + item.amph_name + '</div>',
                    '<div class="text-start">' + item.amph_name_en + '</div>',
                    '<div class="text-center"><i class="bi-circle-fill ' + (item.amph_active == '1' ? 'text-success' : 'text-danger') + '"></i> ' + (item.amph_active == '1' ? 'เปิดใช้งาน' : 'ปิดใช้งาน') + '</div>',
                    '<div class="text-center option">' +
                    '<button class="btn btn-warning m-2" onclick="window.location.href=\'<?php echo base_url() ?>index.php/hr/base/amphur/get_amphur_edit/' + item.amph_id + '\'"><i class="bi-pencil-square"></i></button>' +
                    '<button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/amphur/amphur_delete/' + item.amph_id + '"><i class="bi-trash"></i></button>' +
                    '</div>'
                ]).draw();
            });
        });
    }
</script>