<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูลวันหยุดปฎิทิน</span>
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
                            <label for="RoleID" class="form-label required">ปีปฎิทิน พ.ศ.</label>
                        </div>
                        <div class="col-6">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือก พ.ศ --" name="clnd_year" id="clnd_year" required>
                                <option value="all">ทั้งหมด</option>
                                <?php if (!empty($clnd_year)) : ?>
                                    <?php foreach ($clnd_year as $value) : ?>
                                        <?php if ($value->clnd_year != '0') : ?>
                                            <option value="<?= $value->clnd_year ?>"><?= $value->clnd_year + 543 ?></option>
                                        <?php endif; ?>
                                    <?php endforeach ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <button onclick="filterTable()" class="btn btn-primary float-end">ค้นหา</button>
                            <!-- <button class="btn btn-warning swal-delete">asd</button> -->
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
                    <i class="bi-people icon-menu"></i><span>ข้อมูลวันหยุด</span><span id="count_data" class="badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/calendar/get_calendar_add'"><i class="bi-plus"></i>เพิ่มวันหยุด</button>
                    </div>
                    <table id="tableList" class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" width="25%" scope="col">ชื่อวันหยุด</th>
                                <th class="text-center" scope="col">วัน จ-ศ</th>
                                <th class="text-center" scope="col">วันที่เริ่ม - วันที่สิ้นสุด</th>
                                <th class="text-center" scope="col">ประเภท</th>
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                filterTable()
            });

            function filterTable() {
                const clnd_year = document.getElementById('clnd_year').value;
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'Calendar/filter_year'; ?>',
                    method: 'POST',
                    data: {
                        clnd_year: clnd_year,
                    }
                }).done(function(returnedData) {
                    var data = JSON.parse(returnedData);
                    $('#count_data').html(data.length);
                    var table = $('#tableList').DataTable()
                    table.clear().draw();
                    data.forEach(function(item, index) {
                        table.row.add([
                            index + 1,
                            '<div class="text-start">' + item.clnd_name + '</div>',
                            '<div class="text-start">' + item.dayofweek + '</div>',
                            '<div class="text-start">' + item.date + '</div>',
                            '<div class="text-start">' + item.lct_name + '</div>',
                            '<button class="btn btn-warning m-2" onclick="window.location.href=\'<?php echo base_url() ?>index.php/hr/base/calendar/get_calendar_edit/' + item.clnd_id + '\'"><i class="bi-pencil-square"></i></button>' +
                            '<button class="btn btn-danger swal-delete" data-url="<?php echo base_url() ?>index.php/hr/base/calendar/delete_calendar/' + item.clnd_id + '"><i class="bi-trash"></i></button>' +
                            '</div>'
                        ]).draw();
                    });
                });
            }
            $(document).on('click', '.swal-delete', delete_row);
            function delete_row(){
                const url = $(this).data('url');
                console.log(url);
                Swal.fire({
                    title: text_swal_delete_title,
                    text: text_swal_delete_text,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#198754",
                    cancelButtonColor: "#dc3545",
                    confirmButtonText: text_swal_delete_confirm,
                    cancelButtonText: text_swal_delete_cancel
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            // data: {
                            //   zipcode: 97201
                            // },
                            success: function(data) {
                                if (data.data.status_response == status_response_success) {
                                    dialog_success({
                                        'header': text_toast_delete_success_header,
                                        'body': text_toast_delete_success_body
                                    }, null, true);
                                } else if (data.data.status_response == status_response_error) {
                                    dialog_error({
                                        'header': text_toast_delete_error_header,
                                        'body': text_toast_delete_error_body
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr);
                                dialog_error({
                                    'header': text_toast_delete_error_header,
                                    'body': text_toast_delete_error_body
                                });
                            }
                        });
                    }
                });
            };
        </script>
    </div>
</div>