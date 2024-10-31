<div class="modal fade" id="modalAllState" style="width:100%; height:100%;" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">[WTS-G2] สถานะของผู้ที่เข้ารับบริการ</h5> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"> 
                <div class="row mt-1">
                    <div class="col-md-10">
                        <ul class="nav nav-pills" id="allStateTab" role="tablist">
                            <li class="nav-item pr-1 pt-1 pb-1" role="presentation" style="">
                                <a class="nav-link active" 
                                    style="margin-right: 10px; margin-top: 10px;" 
                                    id="all-waiting-tab"
                                    data-bs-toggle="tab"
                                    href="#all-waiting"
                                    role="tab"
                                    value="W"
                                    aria-controls="waiting" 
                                    aria-selected="true"
                                >
                                    รอคิว
                                </a>
                            </li>
                            <li class="nav-item pr-1 pt-1 pb-1" role="presentation" style="">
                                <a class="nav-link" 
                                    style="margin-right: 10px; margin-top: 10px;" 
                                    id="all-inprogress-tab"
                                    data-bs-toggle="tab"
                                    href="#all-inProgress"
                                    role="tab"
                                    value="P"
                                    aria-controls="line" 
                                    aria-selected="false"
                                >
                                    เข้ารับการรักษา
                                </a>
                            </li>
                            <li class="nav-item pr-1 pt-1 pb-1" role="presentation" style="">
                                <a class="nav-link" 
                                    style="margin-right: 10px; margin-top: 10px;" 
                                    id="all-done-tab"
                                    data-bs-toggle="tab"
                                    href="#all-done"
                                    role="tab"
                                    value="D"
                                    aria-controls="line" 
                                    aria-selected="false"
                                >
                                    เสร็จสิ้น
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2" style="    border-left: 1px solid #ccc !important;">
                        <label class="w-100">
                            ประเภทผู้ป่วย
                            <select name="allStateType" id="allStateType" class="form-control">
                                <option value="">ทั้งหมด</option>
                                <option value="new">ผู้ป่วยใหม่</option>
                                <option value="old">ผู้ป่วยเก่า</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div id="letterFilter-all-state" class="row mb-3 letterFilter">
                    <div class="col-12 d-flex ">
                        <div class="btn-group" role="group">
                            <?php
                            $lettersThai = ['ก', 'ข', 'ค', 'ฆ', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ญ', 'ฎ', 'ฏ', 'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น', 'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร', 'ฤ', 'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ'];
                            $lettersEnglish = range('A', 'Z'); 
                            $letters = array_merge($lettersThai, $lettersEnglish);

                            foreach ($letters as $letter) {
                                echo '<input type="checkbox" class="btn-check" id="letter-all-state-' . $letter . '" value="' . $letter . '">';
                                echo '<label class="btn btn-outline-primary" for="letter-all-state-' . $letter . '">' . $letter . '</label>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#letterFilter-all-state .btn-check').on('change', function() {
                            var label = $('label[for="' + $(this).attr('id') + '"]');
                            if ($(this).is(':checked')) {
                                label.removeClass('btn-outline-primary').addClass('btn-primary text-white');
                            } else {
                                label.removeClass('btn-primary text-white').addClass('btn-outline-primary');
                            }
                        });
                    });
                </script>
                <div class="row mt-1">
                    <div class="col-md-12 table-responsive">
                        <table class="table  table-bordered table-hover dataTable" width="100%" id="wtsallStateTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px; text-align: center;">ลำดับ</th>
                                    <th style="width: 100px; text-align: center;">เลข HN</th>
                                    <th style="width: 120px; text-align: center;">หมายเลขนัดหมาย</th>
                                    <th style="width: 100px; text-align: center;">หมายเลขคิว</th>
                                    <th style="width: 150px; text-align: center;">ประเภทการ<br>เข้ารับบริการ</th>
                                    <th style="width: 150px; text-align: center;">เลขบัตรประชาชน</th>
                                    <th style="width: 200px; text-align: center;">ชื่อ-นามสกุล</th>
                                    <th style="width: 150px; text-align: center;">ประเภทผู้ป่วย</th>
                                    <th style="width: 120px; text-align: center;" id="all-th-text">วันที่นัดพบแพทย์</th>
                                    <th style="width: 80px; text-align: center;">เวลา</th>
                                    <th style="width: 100px; text-align: center;">แผนก</th>
                                    <th style="width: 150px; text-align: center;">แพทย์ที่นัดพบ</th>
                                    <th style="width: 100px; text-align: center;">ดูรายละเอียด</th>
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
    function getTotalAllStateDetail(e) {
        toggleLoaderSearchBtn(e)
        $('#letterFilter-all-state input[type="checkbox"]').prop('checked', false)

        const department  = document.getElementById('select_department').value;
        const startDate   = document.getElementById('select_date_start').value;
        const endDate     = document.getElementById('select_date_end').value;
        const year        = document.getElementById('select_year').value;

        let formData = new FormData()
        formData.append('department', department)
        formData.append('startDate', startDate)
        formData.append('endDate', endDate)
        formData.append('year', year)

        let wtsallStateTable = $.fn.DataTable.isDataTable('#wtsallStateTable');
        if (wtsallStateTable) {
            $('#wtsallStateTable').DataTable().destroy(); // ทำลาย DataTable เดิม
        }


        var activeTab = document.querySelector('#allStateTab .nav-link.active');
        var tabVal = activeTab ? activeTab.getAttribute('value') : '';
        var selectedLetters = []


        document.querySelectorAll('#allStateTab .nav-link').forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                let clickedTab = event.target; 
                tabVal = clickedTab.getAttribute('value'); 
                if (tabVal == 'W'){
                    $('#all-th-text').text('วันที่นัดพบแพทย์')
                }else if (tabVal == 'D'){
                    $('#all-th-text').text('วันที่เสร็จสิ้น')
                }else {
                    $('#all-th-text').text('วันที่ดำเนินการ')
                }

                $('#letterFilter-all-state input[type="checkbox"]').prop('checked', false)
                $('#letterFilter-all-state .btn-check').each(function() {
                    var label = $('label[for="' + $(this).attr('id') + '"]');
                    label.removeClass('btn-primary text-white').addClass('btn-outline-primary');
                });
                selectedLetters = []
                wtsallStateTable.ajax.reload();
            });
        });


        $('#letterFilter-all-state input[type="checkbox"]').on('change', function () {
            selectedLetters = []
            $('#letterFilter-all-state input[type="checkbox"]:checked').each(function () {
                if (!selectedLetters.includes($(this).val())) {
                    selectedLetters.push($(this).val());
                }
            });
            wtsallStateTable.ajax.reload();
        });

        const mySelect  = document.getElementById('allStateType');
        mySelect.addEventListener('change', function() {
            wtsallStateTable.ajax.reload();
        });


        wtsallStateTable = $('#wtsallStateTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo site_url('/seedb/wts/Wts_dashboard/getTotalAllStateDetail'); ?>",
                type: 'POST',
                data: function (d) {
                    d.department = department;
                    d.startDate = startDate;
                    d.endDate = endDate;
                    d.year = year;
                    d.selectedLetters = JSON.stringify(selectedLetters);
                    d.type = mySelect.value;
                    d.state = tabVal;
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
                [10, 25, 50, 100, 250, 500],
                [10, 25, 50, 100, 250, 500]
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
                columnDefs: [
                { 
                    targets: 0, 
                    className: 'text-center',
                    width: '50px' 
                },
                { 
                    targets: 1, 
                    width: '100px' 
                },
                { 
                    targets: 2, 
                    width: '120px',
                    visible: false 
                },
                { 
                    targets: 3, 
                    width: '100px' 
                },
                { 
                    targets: 4, 
                    width: '150px',
                    visible: true 
                },
                { 
                    targets: 5, 
                    width: '150px' 
                },
                { 
                    targets: 6, 
                    width: '200px' 
                },
                { 
                    targets: 7, 
                    width: '150px'
                },
                { 
                    targets: 8, 
                    width: '120px' 
                },
                { 
                    targets: 9, 
                    width: '80px' 
                },
                { 
                    targets: 10, 
                    width: '100px' 
                },
                { 
                    targets: 11, 
                    width: '150px' 
                },
                { 
                    targets: 12, 
                    width: '100px',
                    className: 'text-center',
                    orderable: false
                }
            ],
            columns: [
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1+ meta.settings._iDisplayStart;
                    }
                },
                { data: 'pt_member' },
                { data: 'apm_visit', visible : false },
                { data: 'apm_ql_code'},
                {
                    data: 'apm_app_walk',
                    visible : true,
                    render : function (data, type, row){
                        return row.type_walk
                    }
                },
                { data: 'pt_identification' , render : function (data, type, row){
                    return row.pt_identification_format
                }},
                { data: 'pt_fname', render: function (data, type, row) {
                    
                    return row.pt_prefix + '' + row.pt_fname + ' ' + row.pt_lname;
                }},
                { data: 'apm_patient_type', render : function (data, type, row){
                    return row.type_name
                }},
                {
                    data:  (tabVal == 'W' )?'apm_date': (tabVal == 'P' ) ? 'ntdp_date_start' : 'ntdp_date_finish', 
                    render: function (data, type, row) {
                                
                        if (tabVal == 'W'){
                            let dateForConvert = row.apm_date;
                            if (dateForConvert == "" || dateForConvert == null) return '-';
        
                            const date = new Date(dateForConvert);
                            const day = date.getDate().toString().padStart(2, '0'); // แปลงวันเป็นเลขสองหลัก
                            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // เดือนในรูปแบบตัวเลขสองหลัก
                            const year = (date.getFullYear() + 543).toString(); // เพิ่ม 543 ปีสำหรับปีพุทธศักราช
        
                            return `${day}/${month}/${year}`;
                        }else if (tabVal == 'P'){

                            let dateForConvert = row.ntdp_date_start;
                            if (dateForConvert == "" || dateForConvert == null) return '-';
        
                            const date = new Date(dateForConvert);
                            const day = date.getDate().toString().padStart(2, '0'); // แปลงวันเป็นเลขสองหลัก
                            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // เดือนในรูปแบบตัวเลขสองหลัก
                            const year = (date.getFullYear() + 543).toString(); // เพิ่ม 543 ปีสำหรับปีพุทธศักราช
        
                            return `${day}/${month}/${year}`;

                        }else {

                            let dateForConvert = row.ntdp_date_finish;
                            if (dateForConvert == "" || dateForConvert == null) return '-';
        
                            const date = new Date(dateForConvert);
                            const day = date.getDate().toString().padStart(2, '0'); // แปลงวันเป็นเลขสองหลัก
                            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // เดือนในรูปแบบตัวเลขสองหลัก
                            const year = (date.getFullYear() + 543).toString(); // เพิ่ม 543 ปีสำหรับปีพุทธศักราช
        
                            return `${day}/${month}/${year}`;
                        }
                    }
                },
                {
                    data: (tabVal == 'W' )?'apm_time': (tabVal == 'P' ) ? 'ntdp_time_start' : 'ntdp_time_finish' ,
                    render : function (data, type, row) {
                        if (tabVal == 'W'){
                            if (row.apm_time == null || row.apm_time == ''){
                                return '';
                            }else {
                                const time = row.apm_time;
                                const [hours, minutes] = time.split(':');
                                return `${hours}:${minutes} น.`;
                            }
                        }else if (tabVal == 'P') {
                            if (row.ntdp_time_start == null || row.ntdp_time_start == ''){
                                return '';
                            }else {
                                const time = row.ntdp_time_start;
                                const [hours, minutes] = time.split(':');
                                return `${hours}:${minutes} น.`;
                            }
                        }else {
                            if (row.ntdp_time_finish == null || row.ntdp_time_finish == ''){
                                return '';
                            }else {
                                const time = row.ntdp_time_finish;
                                const [hours, minutes] = time.split(':');
                                return `${hours}:${minutes} น.`;
                            }
                        }
                    }
                },
                {
                    data: 'stde_id', render : function (data, type, row){
                        if (row.stde_abbr){
                            return row.stde_abbr
                        }else {
                            return row.stde_name_th
                        }
                    }
                },
                { data: 'ps_fname', render: function (data, type, row) {
                    if(row.ps_id == null){
                        return  '';
                    }else {
                        return row.pf_name + '' + row.ps_fname + ' ' + row.ps_lname;
                    }
                }},
                { data: 'pt_id',  orderable: false, className: 'text-center', render: function (data) {
                    return '<a class="bi-search btn btn-primary p-1 ps-2 pe-2 font-12 "onclick="showProfile(' + data + ')"></a>';
                }}
            ],
            order: [],  // ปิดการเรียงลำดับเริ่มต้น
            paging: true,
            searching: true
        })


        
        var modal = document.getElementById('modalAllState');
        var bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
        toggleLoaderSearchBtn(e);
    }
</script>