<div class="modal fade modal-toggle" id="ums-modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ระบบการบริหารจัดการผู้ใช้งานระบบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url().'index.php/gear/set_gear/1'; ?>'"><i class="bi-arrow-right-square"></i> เข้าสู่ระบบ </button>
                </div>
                <div class="card">
                    <ul class="nav nav-tabs d-flex" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="ums-noti-tab" data-bs-toggle="tab" data-bs-target="#ums-noti" type="button" role="tab" aria-controls="ums-noti" aria-selected="true">การแจ้งเตือน</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="ums-his-tab" data-bs-toggle="tab" data-bs-target="#ums-his" type="button" role="tab" aria-controls="ums-his" aria-selected="false">ประวัติการดำเนินการ</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="ums-noti" role="tabpanel" aria-labelledby="ums-noti-tab">
                            <div class="mb-3 text-end" id="btn-option" style="display: none;">
                                <button class="btn btn-success">อนุมัติทั้งหมด </button>
                                <button class="btn btn-danger">ไม่อนุมัติ </button>
                            </div>
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button accordion-button-table" type="button">
                                                <i class="bi-bell icon-menu"></i><span>  รายการแจ้งเตือน</span><span class="badge bg-success">15</span>
                                            </button>
                                        </h2>
                                        <div id="collapseShow" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>			
                                                            <th class="text-center" width="5%"><input class="form-check-input" type="checkbox" id="check-all"></th>
                                                            <th class="text-center" width="5%">#</th>
                                                            <th class="text-center" width="60%">รายละเอียด</th>
                                                            <th class="text-center" width="20%">ดำเนินการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for($i=0; $i<1; $i++){ ?>
                                                        <tr>
                                                            <td class="text-center"><input class="form-check-input" type="checkbox" id="gridCheck<?php echo $i+1; ?>"></td>
                                                            <td class="text-center"><?php echo $i+1; ?></td>
                                                            <td>อนุมัติการเพิ่มสิทธิ์ "ผู้ดูแลระบบ" ให้กับ "กลุ่มผู้ดูแลระบบ" ในระบบการบริหารจัดการผู้ใช้งานระบบ</td>
                                                            <td class="text-center option">
                                                                <button class="btn btn-warning"><i class="bi-pencil-square"></i></button>
                                                                <button class="btn btn-danger"><i class="bi-trash"></i></button>
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
                        </div>
                        <div class="tab-pane fade" id="ums-his" role="tabpanel" aria-labelledby="ums-his-tab">
                            <div class="card">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button accordion-button-table" type="button">
                                                <i class="bi-clock-history icon-menu"></i><span>  รายการประวัติการดำเนินการ</span><span class="badge bg-success">15</span>
                                            </button>
                                        </h2>
                                        <div id="collapseShow" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>			
                                                            <th class="text-center" width="5%">#</th>
                                                            <th class="text-center" width="60%">รายละเอียด</th>
                                                            <th class="text-center" width="20%">ดำเนินการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for($i=0; $i<15; $i++){ ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $i+1; ?></td>
                                                            <td>เพิ่มสิทธิ์ "ผู้ดูแลระบบ" ให้กับ "กลุ่มผู้ดูแลระบบ" ในระบบการบริหารจัดการผู้ใช้งานระบบ</td>
                                                            <td class="text-center">อนุมัติ</td>
                                                        </tr>
                                                        <?php } ?>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
    // var checkboxes = document.getElementsByClassName('form-check-input');
    var checkboxes = document.querySelectorAll('.form-check-input');
    var button = document.getElementById('btn-option'); // Selecting the button

    document.getElementById('check-all').addEventListener('click', function() {
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = true;
        }
    });

    // Function to check if at least one checkbox is checked
    function checkIfAnyChecked() {
        // var isChecked = false;
        var countChecked = 0;
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                // isChecked = true;
                countChecked++;
            }
        });
        return countChecked;
    }

    // Add event listener to each checkbox
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
        if (checkIfAnyChecked() > 0) {
            button.style.display = 'block'; // Show the button
            if (checkIfAnyChecked() == checkboxes.length)
                document.getElementById('check-all').checked = true;
        } else {
            button.style.display = 'none'; // Hide the button
            document.getElementById('check-all').checked = false;
        }
        });
    });
</script>