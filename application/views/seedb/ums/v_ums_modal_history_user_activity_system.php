 <div class="modal fade" id="modalUsersActivitySystem" style="width:100%; height:100%;" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">[UMS-3] รายละเอียดการเข้าใช้งานระบบ จำแนกตามระบบ แสดง 14 วันล่าสุด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <ul class="nav nav-pills" id="UsersActiveSystemTab" role="tablist">
                            <?php $indexSysTab = 0;?>
                            <?php foreach ($system as $id => $label): ?>
                                <?php if ($id != 'all'){ ?>
                                    <li class="nav-item pr-1 pt-1 pb-1" role="presentation">
                                        <a class="nav-link <?php echo $indexSysTab === 1 ? 'active' : ''; ?>" 
                                        style="margin-right: 10px; margin-top: 10px;" 
                                        id="<?php echo $id; ?>-tab" 
                                        data-bs-toggle="tab" 
                                        href="#<?php echo $id; ?>" 
                                        role="tab" 
                                        value="<?php echo $id; ?>" 
                                        aria-controls="<?php echo $indexSysTab; ?>" 
                                        aria-selected="<?php echo $indexSysTab === 1 ? 'true' : 'false'; ?>" 
                                        tabindex="<?php echo $indexSysTab === 1 ? '' : '-1'; ?>">
                                            <?php echo $label; ?>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php $indexSysTab ++;?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div id="letterFilter-usersActiveSystem" class="row mb-3 mt-3 letterFilter">
                    <div class="col-12 d-flex ">
                        <div class="btn-group" role="group">
                            <?php
                            $lettersThai = ['ก', 'ข', 'ค', 'ฆ', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ญ', 'ฎ', 'ฏ', 'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น', 'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร', 'ฤ', 'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ'];
                            $letters = $lettersThai;
                            foreach ($letters as $letter) {
                                echo '<input type="checkbox" class="btn-check" id="usersActiveSystem-letter-' . $letter . '" value="' . $letter . '">';
                                echo '<label class="btn btn-outline-primary" for="usersActiveSystem-letter-' . $letter . '">' . $letter . '</label>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#letterFilter-usersActiveSystem .btn-check').on('change', function() {
                            var label = $('label[for="' + $(this).attr('id') + '"]');
                            if ($(this).is(':checked')) {
                                label.removeClass('btn-outline-primary').addClass('btn-primary text-white');
                            } else {
                                label.removeClass('btn-primary text-white').addClass('btn-outline-primary');
                            }
                        });
                    });
                </script>
                <div class="row mb-5 mt-3">
                    <div class="col-md-12 table-responsive">
                        <table class="table  table-bordered table-hover dataTable" width="100%" id="usersActiveSystemTable">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">เลขบุคลากร</th>
                                    <th class="text-center">เลขบัตรประชาชน</th>
                                    <th class="text-center" style="width: 150px;">ชื่อ-นามสกุล</th> 
                                    <th class="text-center">ประเภทบุคลากร</th> 
                                    <th class="text-center">จำนวนระบบที่รับผิดชอบ</th>
                                    <th class="text-center" style="width: 100px;">วัน-เวลาที่เข้าใช้งานระบบ</th>
                                    <th class="text-center">ดูรายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
    function getDetailUsersActivitySystem(e){
        toggleLoaderSearchBtn(e);
        $('#letterFilter-usersActiveSystem input[type="checkbox"]').prop('checked', false)


        const department  = document.getElementById('select_department').value;
        const startDate   = document.getElementById('select_date_start').value;
        const endDate     = document.getElementById('select_date_end').value;
        const year        = document.getElementById('select_year').value;


        //From axios generate chart ums-3
        const sDate  = sessionStorage.getItem('sDate');
        const sMonth = sessionStorage.getItem('sMonth');
        const sYear  = sessionStorage.getItem('sYear');


        let formData = new FormData()
        formData.append('department', department)
        formData.append('startDate', startDate)
        formData.append('endDate', endDate)
        formData.append('year', year)

        let usersActiveSystemDataTable = $.fn.DataTable.isDataTable('#usersActiveSystemTable');
        if (usersActiveSystemDataTable) {
            $('#usersActiveSystemTable').DataTable().destroy(); // ทำลาย DataTable เดิม
        }


        var activeTab = document.querySelector('#UsersActiveSystemTab .nav-link.active');
        var tabVal = activeTab ? activeTab.getAttribute('value') : 'all';
        var selectedLetters = []

        document.querySelectorAll('#UsersActiveSystemTab .nav-link').forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                let clickedTab = event.target; 
                tabVal = clickedTab.getAttribute('value'); 

                $('#letterFilter-usersActiveSystem input[type="checkbox"]').prop('checked', false)
                $('#letterFilter-usersActiveSystem .btn-check').each(function() {
                    var label = $('label[for="' + $(this).attr('id') + '"]');
                    label.removeClass('btn-primary text-white').addClass('btn-outline-primary');
                });
                selectedLetters = []
                usersActiveSystemDataTable.ajax.reload();
            });
        });

        $('#letterFilter-usersActiveSystem input[type="checkbox"]').on('change', function () {
            selectedLetters = []
            $('#letterFilter-usersActiveSystem input[type="checkbox"]:checked').each(function () {
                if (!selectedLetters.includes($(this).val())) {
                    selectedLetters.push($(this).val());
                }
            });
            usersActiveSystemDataTable.ajax.reload();
        });



        usersActiveSystemDataTable  = $('#usersActiveSystemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo site_url('/seedb/ums/Ums_dashboard/getUsersActivitySystemHistory'); ?>",
                type: 'POST',
                data: function (d) {
                    d.department    = department;
                    d.startDate     = startDate;
                    d.endDate       = endDate;
                    d.year          = year;
                    d.selectedLetters = JSON.stringify(selectedLetters);
                    d.stId      = tabVal;
                    d.sDate     = sDate;
                    d.sMonth    = sMonth;
                    d.sYear     = sYear;

                }
            },
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
                [15, 25, 50, 100, 250, 500],
                [15, 25, 50, 100, 250, 500]
            ],
            columnDefs: [
                {
                    targets: 6,  
                    width: '100px'  
                },
                {
                    targets: 3,  
                    width: '150px'  
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
            columns: [
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1+ meta.settings._iDisplayStart;
                    }
                },
                { data: 'pos_ps_code' },
                { data: 'psd_id_card_no_format' },
                { data: 'ps_fname', render: function (data, type, row) {
                    return row.pf_name + '' + row.ps_fname + ' ' + row.ps_lname;
                }},
                { data: 'hire_name' },
                { data: 'count_system',  className: 'text-center' },
                { data: 'ml_date', render: function (data, type, row) {
                    let dateForConvert = row.ml_date;
                    if (dateForConvert == "" || dateForConvert == null) return '-';
                    const thaiMonths = [
                        "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", 
                        "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                    ];

                    const date = new Date(dateForConvert);
                    const day = date.getDate();
                    const month = thaiMonths[date.getMonth()];
                    const year = date.getFullYear() + 543;  // เพิ่ม 543 ปีสำหรับปีพุทธศักราช
                    const hours = date.getHours().toString().padStart(2, '0');
                    const minutes = date.getMinutes().toString().padStart(2, '0');

                    return `${day} ${month} ${year} เวลา ${hours}.${minutes} น.`;

                }},
                { data: 'token',  orderable: false, className: 'text-center', render: function (data) {
                    let url = "<?php echo site_url('/hr/profile/Profile_summary/get_profile_summary')?>" + `/${data}`;
                    return `<a class="bi-search btn btn-primary p-1 ps-2 pe-2 font-12" href="${ url }" target="_blank"></a>`;
                }}
               
            ],
            order: [],  // ปิดการเรียงลำดับเริ่มต้น
            paging: true,
            searching: true
        })





        var modal = document.getElementById('modalUsersActivitySystem');
        var bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
        toggleLoaderSearchBtn(e);
    }

    
 </script>