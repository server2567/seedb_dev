<!-- <style>
    .select2-container {
        z-index: 100000;
    }
</style> -->
<div class="card">
    <div class="accordion">
        <h2 class="accordion-header">
            <button class="accordion-button accordion-button-table">จัดการข้อมูลพัฒนาบุคลากร</button>
        </h2>
        <div class="accordion-body">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item ">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลพัฒนาบุคลากร</span>
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <b>ผู้ดำเนินการ</b>
                                            </div>
                                            <div class="col-10 ">
                                                นพ.บรรยง ชินกุลกิจนิวัฒน์ <b>ตำแหน่งในการบริหาร</b> ผู้อำนวยการ <br>
                                                <b>ตำแหน่งในสายงาน</b> จักษุแพทย์ รักษาโรคตาทั่วไป <b>ตำแหน่งเฉพาะทาง</b> เชี่ยวชาญการผ่าตัดต้อกระจก
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">เรื่องที่ไปเข้าร่วม</label>
                                            </div>
                                            <div class="col-8">
                                                <input name="inputField[]" type="text" placeholder="กรอกหัวเรื่อง" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label" style="font-weight: bold;">รายละเอียดการเข้าร่วม</label>
                                            </div>
                                            <div class="col-8">
                                                <textarea name="inputField[]" class="form-control" id=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">วันที่เข้าร่วม</label>
                                            </div>
                                            <div class="col-8">
                                                <div class="input-group date input-daterange">
                                                    <input type="date" class="form-control" name="inputField[]" id="StartDate" placeholder="" value="">
                                                    <span class="input-group-text">ถึง</span>
                                                    <input type="date" class="form-control" name="inputField[]" id="EndDate" placeholder="" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">สถานที่</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control" name="inputField[]" placeholder="กรอกสถานที่">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">ประเทศ</label>
                                            </div>
                                            <div class="col-8">
                                                <select type="text" class="form-control select2" name="inputField[]"> </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">จังหวัด</label>
                                            </div>
                                            <div class="col-8">
                                                <select type="text" class="form-control select2" name="inputField[]"> </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">ผู้จัด/โครงการ</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control" placeholder="กรอกชื่อผู้จัดทำ/โครงการ" name="inputField[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label" style="font-weight: bold;">ประเภทหน่วยงานที่จัด</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="radio" class="form-check-input mb-3" id="inHost" name="dev" value="30">
                                                <label for="age1">ภายในโรงพยาบลจักษุสุราษฏร์</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="outHost" name="dev" value="30">
                                                <label for="age1">ภายนอกโรงพยาบาลจักษุสุราษฏร์</label><br>
                                                <div class="intDetail" hidden>
                                                    <label  for="age1">รายละเอียด: </label><br>
                                                    <textarea class="form-control" name="" id=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label" style="font-weight: bold;">ประเภทการพัฒนา</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="radio" class="form-check-input mb-3" id="type1" name="dev" value="30">
                                                <label for="age1">พัฒนาตามความต้องการของตนเอง</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type2" name="dev" value="60">
                                                <label for="age2">พัฒนาตามนโยบายของวิทยาลัย</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type3" name="dev" value="100">
                                                <label for="age3">พัฒนาตามนโยบายส่วนกลาง</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type3" name="dev" value="100">
                                                <label for="age3">อื่นๆ</label><br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label" style="font-weight: bold;">ประเภท</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="radio" class="form-check-input mb-3" id="type1" name="age" value="30">
                                                <label for="age1">ประชุม/อบรม/สัมมนา</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type2" name="age" value="60">
                                                <label for="age2">เป็นวิทยากร</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type3" name="age" value="100">
                                                <label for="age3">ประชุมราชการ</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type3" name="age" value="100">
                                                <label for="age3">นิเทศงาน</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type3" name="age" value="100">
                                                <label for="age3">การอบรมหลักสูตรระยะสั้น</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type3" name="age" value="100">
                                                <label for="age3">ศึกษาดูงาน</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type3" name="age" value="100">
                                                <label for="age3">บริการวิชาการ</label><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2 mb-3">
                                                <label for="age1" style="font-weight: bold;">อัพโหลดไฟล์ต้นเรื่อง :</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="file" class="form-control">
                                                <label for="age1">
                                                    (อัพโหลดไฟล์ได้สูงสุด 2Mb)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="age1" class="required" style="font-weight: bold;">หมายเหตุ :</label>
                                        ต้องกรอกข้อมูลให้สมบูรณ์
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
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd2" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($StID) ? 'แก้ไข' : 'เพิ่ม' ?>รายชื่อผู้เข้าร่วม</span>
                            </button>
                        </h2>
                        <div id="collapseAdd2" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">

                                <button class="btn btn-primary mb-2" id="addP"><i class="bi bi-plus"></i> เพิ่มผู้เข้าร่วม</button>
                                <table class="table" id="paticipate">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <div class="text-center">#</div>
                                            </th>
                                            <th scope="col" width="20%" class="text-center">ชื่อ-นามสกุล</th>
                                            <th scope="col" class="text-center">วันที่ประชุม</th>
                                            <th scope="col" class="text-center">นับ</th>
                                            <th scope="col" class="text-center">จำนวน (ชั่วโมง : นาที)</th>
                                            <th scope="col" class="text-center">ดำเนินการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr>
                                <td class="text-start">1</td>
                                <td class="text-start" width="20%"><select id="pid" class="form-control select2">
                                        <option value="1" selected>testt</option>
                                        <option value="2">3424</option>
                                    </select></td>
                                <td class="text-center">8 พ.ค. 2567 - 10 พ.ค. 2567</td>
                                <td class="text-center">7 พ.ค. 2567 - 10 พ.ค. 2567</td>
                                <td class="text-center"><input type="checkbox" class="form-check-input"></td>
                                <td class="text-center">8 : 0</td>
                                <td></td>
                                <td class="text-center"><button onclick="editPersonMeeting(1)" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#mainModal"><i class="bi bi-pencil"></i></button> <button class="btn btn-danger"><i class="bi bi-trash"></i></button></td>
                            </tr> -->
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd3" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-window-dock icon-menu"></i><span>รายงานการประชุม/อบรม/สัมมนา</span>
                            </button>
                        </h2>
                        <div id="collapseAdd3" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">เป้าหมาย/วัตถุประสงค์การไปประชุม/อบรม/สัมมนา :</label> <br><br>
                                        <textarea name="inputField[]" id="" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">เนื้อหาการประชุมโดยสรุป :</label> <br><br>
                                        <textarea name="inputField[]" id="" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">ประโยชน์ได้รับ :</label> <br><br>
                                        <textarea name="inputField[]" id="" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd4" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-window-dock icon-menu"></i><span>การนำมาประยุกต์ใช้ในองค์กร</span>
                            </button>
                        </h2>
                        <div id="collapseAdd4" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">การจัดการเรียนการสอน :</label> <br><br>
                                        <textarea name="inputField[]" id="text1" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">วิจัยหรือผลงานวิชาการ :</label> <br><br>
                                        <textarea name="inputField[]" id="text2" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">การบริหาร :</label> <br><br>
                                        <textarea name="inputField[]" id="text3" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">การปฏิบัติงานทั่วไปและอื่น ๆ โปรดระบุ :</label> <br><br>
                                        <textarea name="inputField[]" id="text4" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
            <div class="accordion-footer p-2">
                <div class="row">
                    <div class="col-md-2">
                        <button class="btn btn-secondary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Develop_meeting'">ย้อนกลับ</button>
                        &nbsp;
                        <button class="btn btn-danger" id="cancelButton">ยกเลิก</button>
                    </div>
                    <div class="col-md-10 text-end">
                        <button class="btn btn-dark">บันทึกฉบับร่าง</button>&nbsp;
                        <button class="btn btn-success">ยืนยันการบันทึก</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Modal -->
        <div class="modal modal-lg" id="mainModal" aria-labelledby="mainModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mainModalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="mainModalBody">
                    </div>
                    <div class="modal-footer" id="mainModalFooter">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Modal -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script>
            var name = [];
            let check = 0;
            document.getElementById('addP').addEventListener('click', function() {
                var table = document.getElementById("paticipate");
                var rowCount = table.getElementsByTagName("tr").length;
                var row = table.insertRow(-1); // Insert new row at the end
                var cell1 = row.insertCell(0); // Insert cell for name
                var cell2 = row.insertCell(1); // Insert cell for age
                var cell3 = row.insertCell(2); // Insert cell for age
                var cell4 = row.insertCell(3); // Insert cell for age
                var cell5 = row.insertCell(4); // Insert cell for age
                var cell6 = row.insertCell(5); // Insert cell for cell
                $.ajax({
                    method: "post",
                    url: '../Develop_meeting/get_person_name'
                }).done(function(returnData) {
                    name = returnData.name
                    var person = name.split(',');
                    cell1.innerHTML = rowCount; // Set default value for name
                    var selectElement = document.createElement('select');
                    selectElement.classList.add('form-control', 'select2');

                    // สร้าง option จากอาร์เรย์
                    let index = 0;
                    person.forEach(function(name) {
                        var optionElement = document.createElement('option');
                        optionElement.text = name;
                        optionElement.value = index
                        selectElement.appendChild(optionElement);

                        index++
                    });
                    cell2.appendChild(selectElement);
                    cell3.innerHTML = "-"; // Set default value for name
                    cell3.style.textAlign = "center";
                    cell4.innerHTML =
                        '<input type="checkbox" class="form-check-input">'; // Set default value for name
                    cell4.style.textAlign = "center";
                    cell5.innerHTML = "0 : 0"; // Set default value for age
                    cell5.style.textAlign = "center";
                    cell6.innerHTML = '<button onclick="editPersonMeeting(' + (rowCount) +
                        ')" class="btn btn-warning" ><i class="bi bi-pencil"></i></button> <button onclick="deleteRow(' +
                        (rowCount) +
                        ')" class="btn btn-danger"><i class="bi bi-trash"></i></button>'; // Set default value for age
                    cell6.style.textAlign = "center";
                    $(".select2").select2({
                        theme: "bootstrap-5"
                    });
                });
            });
            $('#inHost').change(function() {
                // ตรวจสอบว่า checkbox ถูกเลือกหรือไม่
                if ($(this).is(':checked')) {
                    // ค้นหา element ที่มีคลาสชื่อ autoDate และลบ attribute hidden
                    $('.intDetail').attr('hidden', true);
                }
            });
            $('#outHost').change(function() {
                // ตรวจสอบว่า checkbox ถูกเลือกหรือไม่
                if ($(this).is(':checked')) {
                    // ค้นหา element ที่มีคลาสชื่อ autoDate และลบ attribute hidden
                    $('.intDetail').removeAttr('hidden');
                }
            });
            $('#carself').change(function() {
                // ตรวจสอบว่า checkbox ถูกเลือกหรือไม่
                if ($(this).is(':checked')) {
                    // ค้นหา element ที่มีคลาสชื่อ autoDate และลบ attribute hidden
                    $('.driver').removeAttr('hidden');
                } else {
                    $('.driver').attr('hidden', true);
                }
            });

            function deleteRow(index) {
                var table = document.getElementById("paticipate");
                table.deleteRow(index);
                for (var i = 1; i < table.rows.length; i++) {
                    var row = table.rows[i];
                    for (var j = 0; j < row.cells.length; j++) {
                        // ดึงข้อมูลจากเซลล์ที่ j
                        var cell = row.cells[j];
                        if (j == 0) {
                            cell.innerHTML = i;
                        } else if (j == 7) {
                            cell.innerHTML = '<button onclick="editPersonMeeting(' + (i) +
                                ')" class="btn btn-warning"><i class="bi bi-pencil"></i></button> <button onclick="deleteRow(' + (
                                    i) + ')" class="btn btn-danger"><i class="bi bi-trash"></i></button>'
                        }
                    }
                }
            }

            function editPersonMeeting(index) {
                var table = document.getElementById("paticipate");
                var row = table.rows[index];
                var cell = row.cells[1];
                var select = cell.querySelector('select');
                if (select) {
                    // ดึงค่าที่ถูกเลือกจาก <select>\
                    if (select.value == 0) {
                        alert('กรุณาเลือกผู้เข้าร่วม');
                        return 0;
                    }
                    var selectedValue = select.value;
                    // แสดงค่าที่ถูกเลือก
                    $.ajax({
                        method: "post",
                        url: '../Develop_meeting/get_Edit_meeting_form',
                        data: {
                            uid: selectedValue
                        }
                    }).done(function(returnData) {
                        $('#mainModalTitle').html(returnData.title);
                        $('#mainModalBody').html(returnData.body);
                        $('#mainModalFooter').html(returnData.footer);
                        var myModal = new bootstrap.Modal(document.getElementById('mainModal'));
                        myModal.show();
                        $('.selectM').select2({
                            dropdownParent: $('.modal'),
                            theme: "bootstrap-5"
                        });
                    });
                }
            }

            $('#cancelButton').on('click', function() {
                check = 0;
                $('[name^="inputField"]').each(function() {
                    if (this.value == 0 || this.value == '' || this.value == 'on') {} else {
                        check = 1;
                    }
                });
                if (check == 1) {
                    let mySwal = Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        html: ` <h5>คุณต้องการที่จะยกเลิกการดำเนินการนี้?</h3>
                        <button id="confirmB" class="btn btn-success text-end">ตกลง</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button id="cancelB" class="btn btn-danger">ยกเลิก</button>
                    `,
                        icon: 'warning',
                        showCancelButton: false,
                        showConfirmButton: false,
                    })
                    document.getElementById('confirmB').addEventListener('click', function() {
                        window.location.href = '<?php echo base_url() ?>index.php/hr/Develop_meeting';
                    });

                    document.getElementById('cancelB').addEventListener('click', function() {
                        mySwal.close();
                    });
                } else {
                    window.location.href = '<?php echo base_url() ?>index.php/hr/Develop_meeting'
                }
            });
        </script>