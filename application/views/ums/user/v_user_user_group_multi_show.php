<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหากลุ่มผู้ใช้งาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="needs-validation row g-3" novalidate id="form_search" method="post" action="javascript:void(0);">
                        <div class="col-md-2 text-end">
                            <label for="bg_ids" class="form-label required">เลือกกลุ่มผู้ใช้</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-select select2-multiple" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="bg_ids" id="bg_ids" multiple required>
                                <option value=""></option>
                                <?php foreach ($base_groups as $row) { ?>
                                <option value="<?php echo $row['bg_id']; ?>"><?php echo $row['bg_name_th']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <label for="st_id" class="form-label required">เลือกระบบ</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="st_id" id="st_id" required>
                                <option value=""></option>
                                <?php foreach ($systems as $row) { ?>
                                <option value="<?php echo $row['st_id']; ?>"><?php echo $row['st_name_th']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <label for="gp_id" class="form-label required">เลือกเลือกสิทธิ์ของระบบ</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกเลือกสิทธิ์ของระบบที่ต้องการกระทำ --" name="gp_id" id="gp_id" disabled required>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-secondary float-start" id="clear">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                        </div>
                    </form>
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
                    <i class="bi-people icon-menu"></i><span>  แสดงผู้ใช้งานที่ต้องการจัดการสิทธิ์ในระบบ</span><span class="badge bg-success" id="badge-users-count">0</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
		            <form class="needs-validation" novalidate id="form_submit" method="post" action="<?php echo base_url()."index.php/ums/User_user_group_multi/User_user_group_multi_update"; ?>">
                        <div class="mb-3 col-md-12 d-flex justify-content-end">
                                <div class="col-md-5 me-3">
                                    <div class="input-group">
                                        <button type="button" class="input-group-text btn btn-primary float-end" id="btn-search-name"><i class="bi bi-search"></i>  ค้นหา</button>
                                        <input type="text" class="form-control" placeholder="ชื่อ-นามสกุล" name="name" id="name" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select select2" data-placeholder="-- เลือกการดำเนินการ --" name="action" id="action" required>
                                        <option value="add">เพิ่มสิทธิ์</option>
                                        <option value="cancel">ยกเลิกสิทธิ์</option>
                                    </select>
                                </div>
                        </div>
                    
                        <div class="mb-3 col-md-12">
                            <button type="button" class="btn btn-primary" id="check-all"> เลือกทั้งหมด </button>
                            <button type="submit" class="btn btn-success float-end"> บันทึก </button>
                        </div>

                        <input type="hidden" class="form-control mb-3" name="message_error">
                        <table class="table">
                            <thead>
                                <tr>			
                                    <th scope="col">#</th>
                                    <th scope="col">กลุ่มผู้ใช้</th>
                                    <th scope="col">ชื่อ-นามสกุล</th>
                                    <th scope="col">ระบบที่จะเพิ่มสิทธิ์ให้</th>
                                    <th scope="col">สิทธิ์ที่จะได้ในระบบ</th>
                                </tr>
                            </thead>
                            <tbody id="users">
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // $('#bg_ids').on('change', function() {
        //     show_groups();
        // });
        $('#st_id').on('change', function() {
            let st_id = $('#st_id').val();

            if (!is_null(st_id)) {
                $('#gp_id').prop('disabled', false);
                var jqxhr = $.post( "User_user_group_multi/User_user_group_multi_get_groups", { 
                    st_id: st_id
                })
                .done(function(data) {
                    $("#gp_id").empty();
                    $("#gp_id").html(data);
                })
                .fail(function() { console.error("ผิดพลาดดดด"); //notics_error();
                })
                .always(function() {//alert( "finished" );
                });
            } else {
                $('#gp_id').val(null);
                $('#gp_id').prop('disabled', true);
            }
        });
        $('#form_search').on('submit', function(event) {
            event.preventDefault();
            $('#name').val('');
            if (this.checkValidity()) {
                get_users();
            }
        });

        // $('#form_submit').on('submit', function(event) {
        //     if (event.key === 'Enter') {
        //         event.preventDefault(); // Prevent the default form submission
        //         // document.getElementById('myForm').submit(); // Manually trigger the form submission
        //     }
        // });

        $('#btn-search-name').on('click', function() {
            get_users();
        });

        $('#clear').on('click', function() {
            $('#bg_ids').val('').trigger('change');
            $('#st_id').val('').trigger('change');
            $('#gp_id').val('').trigger('change');
            $('#name').val('').trigger('change');
            $("#users").empty();
        });
        
        document.getElementById('check-all').addEventListener('click', function() {
            var checkboxes = document.getElementsByClassName('form-check-input');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        });
    });

    function get_users() {
        let bg_ids = $('#bg_ids').val();
        let st_id = $('#st_id').val();
        let gp_id = $('#gp_id').val();
        let name = $('#name').val();

        var jqxhr = $.post( "User_user_group_multi/User_user_group_multi_get_users", { 
            bg_ids: bg_ids,
            st_id: st_id,
            gp_id: gp_id,
            name: name,
        })
        .done(function(data) {
            $("#users").empty();
            $("#users").html(data);
            
            var sync_table = document.getElementById("users");
            var row = sync_table.rows.length;
            document.getElementById("badge-users-count").textContent = row;
        })
        .fail(function() { console.error("ผิดพลาดดดด"); //notics_error();
        })
        .always(function() {//alert( "finished" );
        });
    }
</script>