<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span> ประมวลผล</span><span class="badge bg-success">2</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body p-5">
                    <div class="row">
                        <span class="col-2 text-end">เลือกวันที่ต้องการ : </span>
                        <div class="col-6">
                            <div class="input-daterange input-group" id="datepicker-range2" data-date-format="dd/mm/yyyyy" data-date-language="th-th">
                                <input type="date" class="input-small form-control" name="choose_start_year" id="start_year" value="01/04/2567" autocomplete="off">
                                <span class="btn btn-primary mb-3" disabled>ถึง</span>
                                <input type="date" class="input-small form-control" name="choose_end_year" id="end_year" value="18/04/2567" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-4 mb-5">
                        </div>
                        <span class="col-2 text-end">โครงสร้างบริหาร (แผนก/ฝ่าย) : </span>
                        <div class="col-6  mb-3">
                            <select class="form-control text-center" name="" id="">
                                <option value="">
                                    ------ เลือก ------
                                </option>
                            </select>
                        </div>
                        <div class="col-4 mb-5">
                        </div>
                        <span class="col-2 text-end">ประเภทบุคลากร : </span>
                        <div class="col-6  mb-3">
                            <select class="form-control text-center" name="" id="">
                                <option value="">
                                    ------ เลือก ------
                                </option>
                            </select>
                        </div>
                        <div class="col-4 mb-5">
                        </div>
                        <span class="col-2 text-end">ตำแหน่งงาน (แผนก/ฝ่าย) : </span>
                        <div class="col-6">
                            <select class="form-control text-center" name="" id="">
                                <option value="">
                                    ------ เลือก ------
                                </option>
                            </select>
                        </div>
                        <div class="col-8 mt-4"></div>
                        <div class="col-4 text-end  mt-4"><button class="btn btn-primary" style="margin-right: 15px;">ค้นหา</button> <button class="btn btn-primary">ประมวลผล</button></div>
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
                    <i class="bi-server icon-menu"></i><span> ข้อมูลตำแหน่งงาน</span><span class="badge bg-success">2</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table id="example" class="table datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2" width="15%">ลำดับ</th>
                                <th class="text-center" rowspan="2" width="15%">ชื่อ-นามสกุล</th>
                                <th class="text-center" colspan="2">สถานะการปฎิบัติงาน</th>
                            </tr>
                            <tr>
                                <th class="text-center" colspan="1" data-dt-order="disable">ปกติ</th>
                                <th class="text-center" colspan="1" data-dt-order="disable">Direct</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td><a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">ดร.ขวัญตา บุญวาศ</a></td>
                                <td class="text-center">1</td>
                                <td class="text-center">16</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td><a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">นางสาวนัฎพิสชา กลิ่นหอม</a></td>
                                <td class="text-center">-</td>
                                <td class="text-center">17</td>
                            </tr>
                        </tbody>
                        <!-- <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>E-mail</th>
            </tr>
        </tfoot> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " style="width: 100%; max-width:1800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addpermodal">ข้อมูลประมวลผล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-window-dock icon-menu"></i><span>ข้อมูลบุคลากร</span>
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body m-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <span>ชื่อ-นามสกุล:</span>
                                            </div>
                                            <div class="col-6">
                                                <span>นางสาวเจียมใจ ศรีชัยรัตนกูล</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <span>ตำแหน่ง :</span>
                                            </div>
                                            <div class="col-6">
                                                <span>อาจารย์</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <span>หน่วยงาน :</span>
                                            </div>
                                            <div class="col-6">
                                                <span>งานทะเบียน วัดและประเมินผลการศึกษา</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <span>ประเภทบุคลากร :</span>
                                            </div>
                                            <div class="col-6">
                                                <span>ข้าราชการ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <span>ประเภทสายงาน :</span>
                                            </div>
                                            <div class="col-6">
                                                <span>สายสอน</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <span>วันที่เลือก :</span>
                                            </div>
                                            <div class="col-6">
                                                <span>1 เม.ย. 2567 ถึง 18 เม.ย. 2567</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion mt-2">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd2" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-window-dock icon-menu"></i><span>ตารางแสดงข้อมูลการประมวลผล</span>
                            </button>
                        </h2>
                        <div id="collapseAdd2" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body m-3">
                                <h4>เม.ย.-2567</h4>
                                <table id="example2" class="table datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2" width="15%">วันที่</th>
                                            <th class="text-center" rowspan="2" width="15%">เวลาเข้า</th>
                                            <th class="text-center" rowspan="2" width="15%">เวลาออก</th>
                                            <th class="text-center" colspan="4">สถานะ</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" colspan="1" data-dt-order="disable">ปกติ</th>
                                            <th class="text-center" colspan="1">ลาป่วย</th>
                                            <th class="text-center" colspan="1">วันหยุดประจำสัปดาห์
                                            </th>
                                            <th class="text-center" colspan="1">ไม่ระบุ
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1 เม.ย. 2567</td>
                                            <td class="text-center">ไม่มีเวลาเข้า</td>
                                            <td class="text-center">ไม่มีเวลาออก</td>
                                            <td class="text-center"><i class="ri ri-check-fill"></i></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2 เม.ย. 2567</td>
                                            <td class="text-center">ไม่มีเวลาเข้า</td>
                                            <td class="text-center">ไม่มีเวลาออก</td>
                                            <td class="text-center"><i class="ri ri-check-fill"></i></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                        </tr>
                                    </tbody>
                                    <!-- <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>E-mail</th>
            </tr>
        </tfoot> -->
                                </table>
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.4/js/dataTables.bootstrap5.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
<script>
    // new DataTable('#example', {
    //     layout: {
    //         topStart: {
    //             buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    //         }
    //     }
    // });
    // new DataTable('#example2', {
    //     layout: {
    //         topStart: {
    //             buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    //         }
    //     }
    // });
    // let tableData = [{
    //         id: 1,
    //         firstName: 'ดร.ขวัญตา บุญวาศ',
    //         lastName: '1',
    //         email: '16'
    //     },
    //     {
    //         id: 2,
    //         firstName: 'นางสาวนัฎพิสชา กลิ่นหอม',
    //         lastName: '-',
    //         email: '17'
    //     },
    //     {
    //         id: 2,
    //         firstName: 'นางสาวพรรณี จันทรังษี',
    //         lastName: '-',
    //         email: '17'
    //     },
    //     {
    //         id: 2,
    //         firstName: 'นางวรางคณา อุดมทรัพย์',
    //         lastName: '-',
    //         email: '17'
    //     },
    //     {
    //         id: 2,
    //         firstName: 'นางสาวพนารัตน์ วิศวเทพนิมิตร',
    //         lastName: '-',
    //         email: '17'
    //     },
    //     {
    //         id: 2,
    //         firstName: 'นางวรัญญา แสงพิทักษ์',
    //         lastName: '-',
    //         email: '17'
    //     },
    //     // Add more data as needed
    // ];

    // let perPage = 5;
    // let currentPage = 1;

    // function renderTableData() {
    //     let startIndex = (currentPage - 1) * perPage;
    //     let endIndex = startIndex + perPage;
    //     let filteredData = tableData.filter(data =>
    //         data.firstName.toLowerCase().includes(searchInput.value.toLowerCase()) ||
    //         data.lastName.toLowerCase().includes(searchInput.value.toLowerCase()) ||
    //         data.email.toLowerCase().includes(searchInput.value.toLowerCase())
    //     );
    //     if (filteredData.length === 0) {
    //         let tbody = document.querySelector('#dataTable tbody');
    //         tbody.innerHTML = '<tr><td class="text-center" colspan="4">ไม่พบข้อมูล</td></tr>';
    //         return;
    //     }
    //     let paginatedData = filteredData.slice(startIndex, endIndex);

    //     let tbody = document.querySelector('#dataTable tbody');
    //     tbody.innerHTML = '';
    //     paginatedData.forEach((data, index) => {
    //         let row = `<tr>
    //             <td>${startIndex + index + 1}</td>
    //             <td>${data.firstName}</td>
    //             <td>${data.lastName}</td>
    //             <td>${data.email}</td>
    //         </tr>`;
    //         tbody.insertAdjacentHTML('beforeend', row);
    //     });
    // }

    // function renderPagination() {
    //     let totalPages = Math.ceil(tableData.length / perPage);
    //     let pagination = document.querySelector('#pagination');
    //     pagination.innerHTML = '';
    //     for (let i = 1; i <= totalPages; i++) {
    //         let li = `<li class="page-item ${i === currentPage ? 'active' : ''}">
    //             <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
    //         </li>`;
    //         pagination.insertAdjacentHTML('beforeend', li);
    //     }
    // }

    // function changePage(page) {
    //     currentPage = page;
    //     renderTableData();
    //     renderPagination();
    // }

    // document.getElementById('searchInput').addEventListener('input', function() {
    //     renderTableData();
    //     renderPagination();
    // });

    // renderTableData();
    // renderPagination();
</script>