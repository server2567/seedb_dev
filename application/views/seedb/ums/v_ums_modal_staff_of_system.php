 
 <div class="modal fade" id="modalCountStaffSystem" style="width:100%; height:100%;" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">[UMS-2] รายละเอียดจำนวนผู้ใช้งานที่เป็นเจ้าหน้าที่ ที่ถูกกำหนดสิทธิ์เข้าใช้งานของระบบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <ul class="nav nav-pills" id="ums2Tab" role="tablist">
                            <li class="nav-item pr-1 pt-1 pb-1" role="presentation" style="width:50%;">
                                <a class="nav-link active" 
                                    style="margin-right: 10px; margin-top: 10px;" 
                                    id="system-tab"
                                    data-bs-toggle="tab"
                                    href="#system"
                                    role="tab"
                                    value="system"
                                    aria-controls="system" 
                                    aria-selected="true"
                                >
                                    ระบบ
                                </a>
                            </li>
                            <li class="nav-item pr-1 pt-1 pb-1" role="presentation" style="width:50%;">
                                <a class="nav-link" 
                                    style="margin-right: 10px; margin-top: 10px;" 
                                    id="line-tab"
                                    data-bs-toggle="tab"
                                    href="#line"
                                    role="tab"
                                    value="line"
                                    aria-controls="line" 
                                    aria-selected="false"
                                >
                                    สายงาน
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="system" role="tabpanel" aria-labelledby="system-tab">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <ul class="nav nav-pills" id="systemTab" role="tablist">
                                    <?php $indexSysTab = 0;?>
                                    <?php foreach ($system as $id => $label): ?>
                                        <li class="nav-item pr-1 pt-1 pb-1" role="presentation">
                                            <a class="nav-link <?php echo $indexSysTab === 0 ? 'active' : ''; ?>" 
                                            style="margin-right: 10px; margin-top: 10px;" 
                                            id="<?php echo $id; ?>-tab" 
                                            data-bs-toggle="tab" 
                                            href="#<?php echo $id; ?>" 
                                            role="tab" 
                                            value="<?php echo $id; ?>" 
                                            aria-controls="<?php echo $indexSysTab; ?>" 
                                            aria-selected="<?php echo $indexSysTab === 0 ? 'true' : 'false'; ?>" 
                                            tabindex="<?php echo $indexSysTab === 0 ? '' : '-1'; ?>">
                                                <?php echo $label; ?>
                                            </a>
                                        </li>
                                        <?php $indexSysTab ++;?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div id="letterFilter-staff-system" class="row mb-3 mt-3 letterFilter">
                            <div class="col-12 d-flex ">
                                <div class="btn-group" role="group">
                                    <?php
                                    $lettersThai = ['ก', 'ข', 'ค', 'ฆ', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ญ', 'ฎ', 'ฏ', 'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น', 'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร', 'ฤ', 'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ'];
                                    $letters = $lettersThai;
                                    foreach ($letters as $letter) {
                                        echo '<input type="checkbox" class="btn-check" id="staff-system-letter-' . $letter . '" value="' . $letter . '">';
                                        echo '<label class="btn btn-outline-primary" for="staff-system-letter-' . $letter . '">' . $letter . '</label>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#letterFilter-staff-system .btn-check').on('change', function() {
                                    var label = $('label[for="' + $(this).attr('id') + '"]');
                                    if ($(this).is(':checked')) {
                                        label.removeClass('btn-outline-primary').addClass('btn-primary text-white');
                                    } else {
                                        label.removeClass('btn-primary text-white').addClass('btn-outline-primary');
                                    }
                                });
                            });
                        </script>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table  table-bordered table-hover dataTable " width="100%" id="staffSystemDetailTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">เลขบุคลากร</th>
                                            <th class="text-center">เลขบัตรประชาชน</th>
                                            <th class="text-center">ชื่อ-นามสกุล</th> 
                                            <th class="text-center">ประเภทบุคลากร</th> 
                                            <th class="text-center">สายงาน</th> 
                                            <th class="text-center">จำนวนระบบที่รับผิดชอบ</th>
                                            <th class="text-center">จำนวนครั้งที่เข้าสู่ระบบ</th>
                                            <th class="text-center">รายการระบบ</th>
                                            <th class="text-center">ดูรายละเอียด</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="line" role="tabpanel" aria-labelledby="line-tab">
                        <div class="row ">
                            <div class="col-md-12">
                                <ul class="nav nav-pills" id="hireStaffSystemTab" role="tablist">
                                    <?php foreach ($tabs as $id => $label): ?>
                                        <li class="nav-item pr-1 pt-1 pb-1" role="presentation">
                                            <a class="nav-link <?php echo $id === 'all' ? 'active' : ''; ?>" 
                                            style="margin-right: 10px; margin-top: 10px;" 
                                            id="<?php echo $id; ?>-tab" 
                                            data-bs-toggle="tab" 
                                            href="#<?php echo $id; ?>" 
                                            role="tab" 
                                            value="<?php echo $id; ?>" 
                                            aria-controls="<?php echo $id; ?>" 
                                            aria-selected="<?php echo $id === 'all' ? 'true' : 'false'; ?>" 
                                            tabindex="<?php echo $id === 'all' ? '' : '-1'; ?>">
                                                <?php echo $label; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div id="letterFilter-staff-line" class="row mb-3 mt-3 letterFilter">
                            <div class="col-12 d-flex ">
                                <div class="btn-group" role="group">
                                    <?php
                                    $lettersThai = ['ก', 'ข', 'ค', 'ฆ', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ญ', 'ฎ', 'ฏ', 'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น', 'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร', 'ฤ', 'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ'];
                                    $letters = $lettersThai;
                                    foreach ($letters as $letter) {
                                        echo '<input type="checkbox" class="btn-check" id="staff-line-letter-' . $letter . '" value="' . $letter . '">';
                                        echo '<label class="btn btn-outline-primary" for="staff-line-letter-' . $letter . '">' . $letter . '</label>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#letterFilter-staff-line .btn-check').on('change', function() {
                                    var label = $('label[for="' + $(this).attr('id') + '"]');
                                    if ($(this).is(':checked')) {
                                        label.removeClass('btn-outline-primary').addClass('btn-primary text-white');
                                    } else {
                                        label.removeClass('btn-primary text-white').addClass('btn-outline-primary');
                                    }
                                });
                            });
                        </script>
                        <div class="row mb-5 mt-5">
                            <div class="col-md-12 table-responsive">
                                <table class="table  table-bordered table-hover dataTable" width="100%" id="umsStaffLineDetailTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">เลขบุคลากร</th>
                                            <th class="text-center">เลขบัตรประชาชน</th>
                                            <th class="text-center">ชื่อ-นามสกุล</th> 
                                            <th class="text-center">ประเภทบุคลากร</th> 
                                            <th class="text-center">สายงาน</th> 
                                            <th class="text-center">จำนวนระบบ<br>ที่รับผิดชอบ</th>
                                            <th class="text-center">จำนวนครั้ง<br>ที่เข้าสู่ระบบ</th>
                                            <th class="text-center">ดูราย<br>ละเอียด</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
          </div>
        </div>
    </div>
</div>


 <script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('#systemTab .nav-link').forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                $('#letterFilter-staff-system input[type="checkbox"]').prop('checked', false)
                $('#letterFilter-staff-system .btn-check').each(function() {
                    var label = $('label[for="' + $(this).attr('id') + '"]');
                    label.removeClass('btn-primary text-white').addClass('btn-outline-primary');
                });
                getStaffOfSystem()
            });
        });

        $('#letterFilter-staff-system input[type="checkbox"]').on('change', function () {
            getStaffOfSystem()
        });


        document.querySelectorAll('#hireStaffSystemTab .nav-link').forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                $('#letterFilter-staff-line input[type="checkbox"]').prop('checked', false)
                $('#letterFilter-staff-line .btn-check').each(function() {
                    var label = $('label[for="' + $(this).attr('id') + '"]');
                    label.removeClass('btn-primary text-white').addClass('btn-outline-primary');
                });
                getStaffOfLine()
            });
        });

        $('#letterFilter-staff-line input[type="checkbox"]').on('change', function () {
            getStaffOfLine()
        });
    })

    async function getDetailStaffOfSystem(e) {
        toggleLoaderSearchBtn(e)

        try {
            
            await getStaffOfSystem()
            await getStaffOfLine()
                        
            var modal = document.getElementById('modalCountStaffSystem');
            var bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        
        } catch (error) {
            console.error("Can't fetching data");
        }

        toggleLoaderSearchBtn(e);
    }

    async function getStaffOfSystem(){
        
        var activeTab = document.querySelector('#systemTab .nav-link.active');
        var tabVal = activeTab ? activeTab.getAttribute('value') : 'all';

        const department  = document.getElementById('select_department').value;
        const startDate   = document.getElementById('select_date_start').value;
        const endDate     = document.getElementById('select_date_end').value;
        const year        = document.getElementById('select_year').value;

        let selectedLetters = []
        $('#letterFilter-staff-system input[type="checkbox"]:checked').each(function () {
            if (!selectedLetters.includes($(this).val())) {
                selectedLetters.push($(this).val());
            }
        });

        let formData = new FormData()
        formData.append('department', department)
        formData.append('startDate', startDate)
        formData.append('endDate', endDate)
        formData.append('year', year)
        formData.append('stId', tabVal)
        formData.append('selectedLetters', JSON.stringify(selectedLetters))

        try {
            if ($.fn.DataTable.isDataTable('#staffSystemDetailTable')) {
                $('#staffSystemDetailTable').DataTable().clear().destroy();
            }

            let table = $('#staffSystemDetailTable').DataTable({
                "dom": 'lBfrtip',
                "buttons": [{
                    extend: 'print',
                    text: '<i class="bi-file-earmark-fill"></i> Print',
                    titleAttr: 'Print',
                    title: 'รายการข้อมูล'
                    },
                    {
                    extend: 'excel',
                    text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'รายการข้อมูล'
                    },
                    {
                    extend: 'pdf',
                    text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
                    titleAttr: 'PDF',
                    title: 'รายการข้อมูล',
                    customize: function(doc) {
                        doc.defaultStyle = {
                        font: 'THSarabun'
                        };
                    }
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 250, 500],
                    [10, 25, 50, 100, 250, 500]
                ],
                columnDefs: [
                    {
                        targets: 8,  
                        visible: tabVal === 'all' // 
                    },
                    {
                        targets: 6,  
                        width: '80px'  
                    },
                    {
                        targets: 7,  
                        width: '80px'  
                    },
                    {
                        targets: 9,  
                        width: '80px'  
                    },
                    {
                        targets: 3,  
                        width: '250px'  
                    }
                ],
                "language": {
                    decimal: "",
                    emptyTable: "ไม่มีรายการในระบบ",
                    info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                    infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    lengthMenu: "_MENU_",
                    loadingRecords: "ไม่พบรายการ",
                    processing: "",
                    search: "",
                    searchPlaceholder: 'ค้นหา...',
                    zeroRecords: "ไม่พบรายการ",
                    paginate: {
                    first: "«",
                    last: "»",
                    next: "›",
                    previous: "‹"
                    },
                    aria: {
                    orderable: "Order by this column",
                    orderableReverse: "Reverse order this column"
                    },
                },
            });
            table.clear().draw();

   

            const response = await api.post('/getStaffOfSystem', formData);
            const res = response.data.staff ?? [];
            res.forEach((row, index) => {

                let url = "<?php echo site_url('/hr/profile/Profile_summary/get_profile_summary')?>" + `/${row.token}`;
                let btn = `<a class="bi-search btn btn-primary p-1 ps-2 pe-2 font-12" href="${ url }" target="_blank"></a>`;

                let mySystem = "";
                row.mySystem.forEach((sys) => {
                    mySystem += ` <span class="badge badge-primary">${sys.st_name_abbr_en}</span>`
                })

                table.row.add([
                    `<center> ${index + 1} </center>`,
                    row.pos_ps_code,
                    row.psd_id_card_no_format + `<br><small class="d-none"> ${row.psd_id_card_no} </small>`,
                    row.pf_name + '' + row.ps_fname + ' ' + row.ps_lname,
                    row.hire_name,
                    row.hire_is_medical_name,
                    `<center> ${ row.count_system } </center>`,
                    `<center> ${row.count_login} </center>`,
                    mySystem,
                    `<center> ${btn} </center>`
                ])

                table.draw();
            })
            
        } catch (error) {
            console.error("Can't fetching data of system list");
        }

    }
    
    async function getStaffOfLine() {
        
        var activeTab = document.querySelector('#hireStaffSystemTab .nav-link.active');
        var tabVal = activeTab ? activeTab.getAttribute('value') : 'all';

        const department  = document.getElementById('select_department').value;
        const startDate   = document.getElementById('select_date_start').value;
        const endDate     = document.getElementById('select_date_end').value;
        const year        = document.getElementById('select_year').value;

        let selectedLetters = []
        $('#letterFilter-staff-line input[type="checkbox"]:checked').each(function () {
            if (!selectedLetters.includes($(this).val())) {
                selectedLetters.push($(this).val());
            }
        });

        let formData = new FormData()
        formData.append('department', department)
        formData.append('startDate', startDate)
        formData.append('endDate', endDate)
        formData.append('year', year)
        formData.append('hireType', tabVal)
        formData.append('selectedLetters', JSON.stringify(selectedLetters))

        try {

            if ($.fn.DataTable.isDataTable('#umsStaffLineDetailTable')) {
                $('#umsStaffLineDetailTable').DataTable().clear().destroy();
            }

            let table = $('#umsStaffLineDetailTable').DataTable({
                "dom": 'lBfrtip',
                "buttons": [{
                    extend: 'print',
                    text: '<i class="bi-file-earmark-fill"></i> Print',
                    titleAttr: 'Print',
                    title: 'รายการข้อมูล'
                    },
                    {
                    extend: 'excel',
                    text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'รายการข้อมูล'
                    },
                    {
                    extend: 'pdf',
                    text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
                    titleAttr: 'PDF',
                    title: 'รายการข้อมูล',
                    customize: function(doc) {
                        doc.defaultStyle = {
                        font: 'THSarabun'
                        };
                    }
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 250, 500],
                    [10, 25, 50, 100, 250, 500]
                ],
                columnDefs: [
                    {
                        targets: 5,  
                        visible: tabVal === 'all' // 
                    }
                ],
                "language": {
                    decimal: "",
                    emptyTable: "ไม่มีรายการในระบบ",
                    info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                    infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    lengthMenu: "_MENU_",
                    loadingRecords: "ไม่พบรายการ",
                    processing: "",
                    search: "",
                    searchPlaceholder: 'ค้นหา...',
                    zeroRecords: "ไม่พบรายการ",
                    paginate: {
                    first: "«",
                    last: "»",
                    next: "›",
                    previous: "‹"
                    },
                    aria: {
                    orderable: "Order by this column",
                    orderableReverse: "Reverse order this column"
                    },
                },
            });
            table.clear().draw();

            const response = await api.post('/getStaffOfLine', formData);
            const res = response.data.staff ?? [];

            res.forEach((row, index) => {

                let url = "<?php echo site_url('/hr/profile/Profile_summary/get_profile_summary')?>" + `/${row.token}`;
                let btn = `<a class="bi-search btn btn-primary p-1 ps-2 pe-2 font-12" href="${ url }" target="_blank"></a>`;

                let mySystem = "";
                row.mySystem.forEach((sys) => {
                    mySystem += ` <span class="badge badge-primary">${sys.st_name_abbr_en}</span>`
                })

                table.row.add([
                    `<center> ${index + 1} </center>`,
                    row.pos_ps_code,
                    row.psd_id_card_no_format + `<br><small class="d-none"> ${row.psd_id_card_no} </small>`,
                    row.pf_name + '' + row.ps_fname + ' ' + row.ps_lname,
                    row.hire_name,
                    row.hire_is_medical_name,
                    `<center> ${ row.count_system } </center>`,
                    `<center> ${row.count_login} </center>`,
                    `<center> ${btn} </center>`
                ])

                table.draw();
            })

        } catch (error) {
            console.error("Can't fetching data staff detail");
        }

    }
 </script>