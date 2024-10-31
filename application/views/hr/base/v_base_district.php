<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหาตำบล</span>
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
                        <div class="col-6 mb-2">
                            <select class="form-select select2" name="RoleID" id="province_id" onchange="updatePvNameEn()" required>
                                <option value="" disabled>-- กรุณาเลือกจังหวัด --</option>
                                <?php foreach ($pv_info as $value) : ?>
                                    <option value="<?= $value->pv_id ?>" <?= $value->pv_id == 1 ? 'selected' : '' ?>><?= $value->pv_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-3"></div>
                        <div class="col-3 text-end">
                            <label for="RoleID" class="form-label required">อำเภอ</label>
                        </div>
                        <div class="col-6 mb-2">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกจังหวัดก่อน --" name="RoleID" id="amphur_id" required>
                                <option value="" selected>กรุณาเลือกจังหวัดก่อน</option>
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
                    <i class="bi-people icon-menu"></i><span>ข้อมูลตำบล</span><span id="count_data" class="badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/district/get_district_add'"><i class="bi-plus"></i> เพิ่มตำบล </button>
                    </div>
                    <table class="table datatable" id="tableList" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อตำบล (ภาษาไทย)</th>
                                <th class="text-center" scope="col">ชื่อตำบล (ภาษาอังกฤษ)</th>
                                <th class="text-center" scope="col">รหัสไปรษณีย์ (Zipcode) </th>
                                <th class="text-center" scope="col">สถานะการใช้งาน</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php foreach ($dt_info as $key => $item) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo $key + 1; ?>
                                    </td>
                                    <td class="text-start">
                                        <div><?php echo $item->dist_name ?></div>
                                    </td>
                                    <td class="text-start">
                                        <div><?php echo $item->dist_name_en ?></div>
                                    </td>
                                    <td class="text-start">
                                        <div><?php echo $item->dist_pos_code ?></div>
                                    </td>
                                    <td class="text-center">
                                        <div><i class="bi-circle-fill <?php echo $item->dist_active == '1' ? 'text-success' : 'text-danger'; ?>"></i> <?php echo $item->dist_active == '1' ? 'เปิดใช้งาน' : 'ปิดใช้งาน'; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/district/get_District_edit/<?php echo $item->dist_id ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/district/district_delete/<?php echo $item->dist_id ?>"><i class="bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div>Loading...</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            filterTable()
            updatePvNameEn()
        });

        function updatePvNameEn() {
            const distSelect = document.getElementById('province_id');
            const selectedOption = distSelect.options[distSelect.selectedIndex];
            $.ajax({
                url: '<?php echo site_url() . '/' . $controller . 'District/get_amphur'; ?>',
                method: 'POST',
                data: {
                    pv_id: distSelect.value
                }
            }).done(function(returnedData) {
                var data = JSON.parse(returnedData)
                var amph_select = document.getElementById('amphur_id');
                amph_select.innerHTML = '<option value="all" selected >ทั้งหมด</option>';
                data.forEach(function(item) {
                    var option = document.createElement('option');
                    option.value = item.amph_id;
                    option.textContent = item.amph_name;
                    amph_select.appendChild(option);
                });
            })
        }

        function filterTable() {
            const provinceId = document.getElementById('province_id').value;
            const amphurId = document.getElementById('amphur_id').value;
            $.ajax({
                url: '<?php echo site_url() . '/' . $controller . 'District/filter_districts'; ?>',
                method: 'POST',
                data: {
                    province_id: provinceId,
                    amphur_id: amphurId
                }
            }).done(function(returnedData) {
                var data = JSON.parse(returnedData);
                $('#count_data').html(data.length);
                var table = $('#tableList').DataTable()
                table.clear().draw();
                data.forEach(function(item, index) {
                    table.row.add([
                        index + 1,
                        '<div class="text-start">'+item.dist_name+'</div>',
                        '<div class="text-start">'+item.dist_name_en+'</div>',
                        '<div class="text-start">'+item.dist_pos_code +'</div>',
                        '<div class="text-center"><i class="bi-circle-fill ' + (item.dist_active == '1' ? 'text-success' : 'text-danger') + '"></i> ' + (item.dist_active == '1' ? 'เปิดใช้งาน' : 'ปิดใช้งาน') + '</div>',
                        '<div class="text-center option">' +
                        '<button class="btn btn-warning m-2" onclick="window.location.href=\'<?php echo base_url() ?>index.php/hr/base/district/get_District_edit/' + item.dist_id + '\'"><i class="bi-pencil-square"></i></button>' +
                        '<button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/district/district_delete/' + item.dist_id + '"><i class="bi-trash"></i></button>' +
                        '</div>'
                    ]).draw();
                });
            });
        }
    </script>