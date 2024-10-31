<div class="modal fade" id="modalCountPatient" style="width:100%; height:100%;" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">[UMS-C1] รายละเอียดประชาชนที่ลงทะเบียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="letterFilter" class="row mb-3 letterFilter">
                    <div class="col-12 d-flex ">
                        <div class="btn-group" role="group">
                            <?php

                            $lettersThai = ['ก', 'ข', 'ค', 'ฆ', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ญ', 'ฎ', 'ฏ', 'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น', 'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร', 'ฤ', 'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ'];
                            $lettersEnglish = range('A', 'Z'); 
                            $letters = array_merge($lettersThai, $lettersEnglish);

                            foreach ($letters as $letter) {
                                echo '<input type="checkbox" class="btn-check" id="letter-' . $letter . '" value="' . $letter . '">';
                                echo '<label class="btn btn-outline-primary" for="letter-' . $letter . '">' . $letter . '</label>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#letterFilter .btn-check').on('change', function() {
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
                        <table class="table  table-bordered table-hover dataTable " width="100%" id="patientDetailTable">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">เลข HN </th>
                                    <th class="text-center">เลขบัตรประชาชน</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th> 
                                    <th class="text-center">เบอร์โทรศัพท์</th>
                                    <th class="text-center">สถานะการยืนยันนโยบายฯ</th>
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
    
    function get_detail_patient(e){
        $('#letterFilter input[type="checkbox"]').prop('checked', false)
        
        toggleLoaderSearchBtn(e)

        const department  = document.getElementById('select_department').value;
        const startDate   = document.getElementById('select_date_start').value;
        const endDate     = document.getElementById('select_date_end').value;
        const year        = document.getElementById('select_year').value;

        let formData = new FormData()
        formData.append('department', department)
        formData.append('startDate', startDate)
        formData.append('endDate', endDate)
        formData.append('year', year)
        
        let patientDataTable = $.fn.DataTable.isDataTable('#patientDetailTable');
        
        if (patientDataTable) {
            $('#patientDetailTable').DataTable().destroy(); // ทำลาย DataTable เดิม
        }


        var selectedLetters = []
        $('#letterFilter input[type="checkbox"]').on('change', function () {
            selectedLetters = []
            $('#letterFilter input[type="checkbox"]:checked').each(function () {
                if (!selectedLetters.includes($(this).val())) {
                    selectedLetters.push($(this).val());
                }
            });
            patientDataTable.ajax.reload();
        });
        


        patientDataTable = $('#patientDetailTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo site_url('/seedb/ums/Ums_dashboard/getUmsPatientDetail'); ?>",
                type: 'POST',
                data: function (d) {
                    d.department = department;
                    d.startDate = startDate;
                    d.endDate = endDate;
                    d.year = year;
                    d.selectedLetters = JSON.stringify(selectedLetters); 
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
                { data: 'pt_identification' , render : function (data, type, row){
                    return row.pt_identification_format
                }},
                { data: 'pt_fname', render: function (data, type, row) {
                    return row.pt_prefix + '' + row.pt_fname + ' ' + row.pt_lname;
                }},
                { data: 'pt_tel' , render : function (data, type, row){
     
                    return row.pt_tel_format 
                }},
                { data: 'pt_privacy',  className: 'text-center' , render : function (data) {
                    return (data == 'Y') ? "ยืนยัน" : "ไม่ยืนยัน";
                } },
                { data: 'pt_id',  orderable: false, className: 'text-center', render: function (data) {
                    return '<a class="bi-search btn btn-primary p-1 ps-2 pe-2 font-12 "onclick="showProfile(' + data + ')"></a>';
                }}
            ],
            order: [],  // ปิดการเรียงลำดับเริ่มต้น
            paging: true,
            searching: true
        });



        var modal = document.getElementById('modalCountPatient');
        var bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
        toggleLoaderSearchBtn(e);
    }

    function showProfile(id) {
        const f = document.createElement("form");
        f.setAttribute('method', "post");
        f.setAttribute('target', "_blank");
        f.setAttribute('action', "<?php echo site_url('/ums/frontend/Dashboard_home_patient'); ?>");

        const i = document.createElement("input");
        i.setAttribute('type', "hidden");
        i.setAttribute('name', "pt_id");
        i.setAttribute('value', id);

        f.appendChild(i);

        document.body.appendChild(f);

        f.submit();

        document.body.removeChild(f);
    }


</script>