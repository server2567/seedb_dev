<!-- Loading Styles -->
<style>
#loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* พื้นหลังโปร่งใส */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050; /* ค่าที่สูงกว่าส่วนอื่นเพื่อให้แสดงอยู่ข้างหน้า */
}

.loading-content {
    text-align: center;
    color: white;
}

.spinner-border {
    width: 5rem;
    height: 5rem;
    margin-bottom: 1rem;
}

p {
    font-size: 1.2rem;
    font-weight: bold;
    color: #ffffff; /* สีขาวเพื่อให้เด่นบนพื้นหลัง */
}
</style>
<div class="card mt-4">
    <div class="accordion" id="excelAccordion">
        <!-- Accordion สำหรับค้นหารายชื่อบุคลากร -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi bi-file-earmark-excel icon-menu font-20"></i><span class="ms-2">นำเข้าข้อมูลด้วย Excel</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#excelAccordion">
                <div class="accordion-body">
                    <!-- Form สำหรับเลือกไฟล์ Excel -->
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="excelFile" class="form-label">เลือกไฟล์ Excel</label>
                                <input class="form-control" type="file" id="excelFile" accept=".xlsx, .xls">
                            </div>
                            <div class="col-md-3 align-self-end">
                                <!-- <button id="clearButton" class="btn btn-warning w-100" onclick="handleClearResults()">ล้างผลลัพธ์</button> -->
                            </div>
                            <div class="col-md-3">
                                <label for="excelFile" class="form-label"></label>
                                <button type="button" id="saveButton" class="btn btn-success" style="display: none;" onclick="handleSaveData()">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </form>

                    <!-- ปุ่มสำหรับเปิด modal ข้อความ error -->
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <button id="errorButton" class="btn btn-danger w-100" style="display: none;" data-bs-toggle="modal" data-bs-target="#errorModal">แสดงข้อผิดพลาด</button>
                        </div>
                    </div>

                    <!-- Tabs สำหรับแสดงข้อมูล sheet ต่างๆ -->
                    <ul class="nav nav-tabs mt-4" id="sheetTabs" role="tablist"></ul>

                    <!-- Tab content สำหรับแสดงข้อมูลจากแต่ละ sheet -->
                    <div class="tab-content mt-3" id="sheetTabContent"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal แสดงข้อผิดพลาด -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="errorModalLabel">ข้อผิดพลาดที่พบ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul id="errorMessagesList"></ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        </div>
        </div>
    </div>
</div>


<!-- ส่วนแสดง Loading -->
<div id="loading">
    <div class="loading-content">
        <div class="spinner-border text-light" role="status">
            <span class="sr-only"></span>
        </div>
        <p>กำลังตรวจสอบข้อมูล...</p>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/xlsx/xlsx.full.min.js"></script>

<script>
// ฟังก์ชันอัปโหลดไฟล์และแสดงปุ่มประมวลผล
document.getElementById('excelFile').addEventListener('change', handleFileUpload, false);

document.addEventListener('DOMContentLoaded', function() {
    $("#loading").hide();
});


let tableCounter = 0; 
let errorMessages = [];
let record_data = [];

function handleFileUpload(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            // เคลียร์เนื้อหาก่อนหน้า
            document.getElementById('sheetTabs').innerHTML = '';
            document.getElementById('sheetTabContent').innerHTML = '';
            record_data = [];

            // Object สำหรับเก็บข้อมูลของแต่ละ sheet
            const sheetData = {};

            // สร้างแท็บสำหรับแต่ละ sheet
            workbook.SheetNames.forEach((sheetName, index) => {
                const isActive = index === 0 ? 'active' : ''; // แผ่นแรกเป็น active

                const tab = document.createElement('li');
                tab.classList.add('nav-item');
                tab.innerHTML = `
                    <a class="nav-link ${isActive}" id="tab-${index}" data-bs-toggle="tab" href="#sheet-${index}" role="tab">
                        Sheet ${index + 1}
                    </a>`;
                document.getElementById('sheetTabs').appendChild(tab);

                // สร้างเนื้อหาของแต่ละแท็บ
                const tabPane = document.createElement('div');
                tabPane.classList.add('tab-pane', 'fade');
                if (isActive === 'active') {
                    tabPane.classList.add('show', 'active');
                }
                tabPane.setAttribute('id', `sheet-${index}`); 
                tabPane.setAttribute('role', 'tabpanel');

                const table = document.createElement('table');
                table.classList.add('table', 'table-bordered', 'mt-3');
                table.id = `table-${index}`; 
                tabPane.appendChild(table);

                document.getElementById('sheetTabContent').appendChild(tabPane);

                // โหลดข้อมูลจาก sheet
                const worksheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

                if (jsonData.length === 0) {
                    table.innerHTML = `<tr><td>ไม่มีข้อมูลใน sheet นี้</td></tr>`;
                } else {
                    
                    populateTable(table, jsonData);
                    sheetData[sheetName] = processSheetData(jsonData); 
                }
            });

            window.uploadedSheetData = sheetData; // บันทึกข้อมูลในตัวแปร global
            record_data = window.uploadedSheetData;
            handleProcessData(); // เริ่มกระบวนการตรวจสอบข้อมูล
        };
        reader.readAsArrayBuffer(file);
    }
}


// ฟังก์ชันสำหรับแสดงข้อมูลในตาราง
function populateTable(table, data) {
    table.innerHTML = '';
    const thead = document.createElement('thead');
    const tbody = document.createElement('tbody');

    if (data.length > 0) {
        const headers = data[0];
        const headerRow = document.createElement('tr');
        headers.forEach((header, headerIndex) => {
            const th = document.createElement('th');
            th.textContent = header;
            th.id = `header-${tableCounter}-${headerIndex}`; 
            headerRow.appendChild(th);
        });

        const statusTh = document.createElement('th');
        statusTh.textContent = "สถานะ";
        headerRow.appendChild(statusTh);
        thead.appendChild(headerRow);
    }

    for (let rowIndex = 1; rowIndex < data.length; rowIndex++) {
        const row = data[rowIndex];
        const tr = document.createElement('tr');
        tr.id = `row-${tableCounter}-${rowIndex}`; 

        row.forEach((cell, colIndex) => {
            const td = document.createElement('td');
            td.textContent = cell || '';
            td.id = `row-${tableCounter}-${rowIndex}-col-${colIndex}`; 
            tr.appendChild(td);
        });

        const statusTd = document.createElement('td');
        statusTd.id = `row-${tableCounter}-${rowIndex}-status`; 
        tr.appendChild(statusTd);

        tbody.appendChild(tr);
    }

    table.appendChild(thead);
    table.appendChild(tbody);
    tableCounter++; 
}

// ฟังก์ชันประมวลผลข้อมูลของแต่ละ sheet
function processSheetData(data) {
    const result = [];
    for (let i = 1; i < data.length; i++) {
        const row = data[i];
        const machineCode = row[0];
        const employeeCode = row[1];
        const fullName = row[2];
        const department = row[3];
        const date = row[4];
        const timeColumns = row.slice(5);
        const times = timeColumns.filter(scan => scan);

        const rowData = { machineCode, employeeCode, fullName, department, date, times };
        result.push(rowData);
    }
    return result;
}

// ฟังก์ชันตรวจสอบข้อมูลในแต่ละ sheet
function validateSheetData(sheetData) {
    let isValid = true;
    let tableCounter = 0;
    let promises = [];

    for (const sheetName in sheetData) {
        const rows = sheetData[sheetName];

        rows.forEach((row, rowIndex) => {
            let rowHasError = false;
            const statusCell = document.querySelector(`#row-${tableCounter}-${rowIndex + 1}-status`);

            if (!row.fullName || !row.date) {
                rowHasError = true;
                errorMessages.push(`แถวที่ ${rowIndex + 1} ในตารางที่ ${tableCounter}: ข้อมูลไม่ครบถ้วน`);
                highlightCell(tableCounter, rowIndex, [2, 4]); 
            }

            // ตรวจสอบเวลาถ้ามีข้อมูล
            if (row.times && Array.isArray(row.times)) {
                row.times.forEach((time, timeIndex) => {
                    const colIndex = 5 + timeIndex;
                    if (!isValidTimeFormat(time) && time) {
                        rowHasError = true;
                        errorMessages.push(`แถวที่ ${rowIndex + 1} ในตารางที่ ${tableCounter}: รูปแบบเวลาผิดพลาด (${time})`);
                        highlightCell(tableCounter, rowIndex, [colIndex]);
                    }
                });
                if(statusCell){
                    if (rowHasError) {
                        statusCell.innerHTML = '<div class="text-center"><i class="bi bi-x-circle-fill text-danger"></i></div>';
                    } else {
                        statusCell.innerHTML = '<div class="text-center"><i class="bi bi-check-circle-fill text-success"></i></div>';
                    } 
                }
               
            }
           
            
            const checkPromise = checkDataWithAjax(row.machineCode, row.employeeCode, rowIndex, tableCounter)
                .then(function(HasError) {
                    rowHasError = HasError; 
                    if(HasError){
                        errorMessages.push(`แถวที่ ${rowIndex + 1} ในตารางที่ ${tableCounter}: รหัสที่เครื่อง (${row.machineCode})`);
                    }
                })
                .catch(function(error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'เกิดข้อผิดพลาดของการตรวจสอบข้อมูล'
                    });
                });
            promises.push(checkPromise); 
        });

        tableCounter++; 
    }

    return Promise.all(promises).then(() => {
        if (errorMessages.length > 0) {
            isValid = false;
        }
        return isValid;
    });
}

// ฟังก์ชันสำหรับตรวจสอบข้อมูล machine_code และ pos_ps_code ผ่าน AJAX โดยใช้ Promise
function checkDataWithAjax(machine_code, pos_ps_code, rowIndex, tableCounter) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>check_validate_data',
            type: 'POST',
            data: { machine_code: machine_code, pos_ps_code: pos_ps_code },
            success: function(data) {
                data = JSON.parse(data);
                let hasError = false;

                const statusCell = document.querySelector(`#row-${tableCounter}-${rowIndex + 1}-status`);
                if (data == 0) {
                    highlightCell(tableCounter, rowIndex, [0]); 
                    hasError = true;
                    statusCell.innerHTML = '<div class="text-center"><i class="bi bi-x-circle-fill text-danger"></i></div>';
                } else {
                    statusCell.innerHTML = '<div class="text-center"><i class="bi bi-check-circle-fill text-success"></i></div>';
                } 
                resolve(hasError); 
            },
            error: function(xhr, status, error) {
                reject(error);
            }
        });
    });
}

// ฟังก์ชันตรวจสอบรูปแบบเวลา (เฉพาะรูปแบบ 12-hour AM/PM)
function isValidTimeFormat(timeStr) {
    const timeFormat12 = /^([0]?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/i;
    return timeFormat12.test(timeStr);
}

// ฟังก์ชันสำหรับไฮไลต์เซลล์ที่มีปัญหา
function highlightCell(tableCounter, rowIndex, columnIndexes) {
    const table = document.querySelector(`#table-${tableCounter}`);

    if (!table) {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': `ไม่พบตารางที่ ${tableCounter}`
        });
        return;
    }

    const row = table.querySelector(`#row-${tableCounter}-${rowIndex + 1}`);

    if (!row) {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': `ไม่พบแถวที่ ${rowIndex + 1} ในตารางที่ ${tableCounter}`
        });
        return;
    }

    columnIndexes.forEach(colIndex => {
        const cell = row.querySelector(`#row-${tableCounter}-${rowIndex + 1}-col-${colIndex}`);

        if (cell) {
            cell.classList.add('highlight-error');
        } else {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': `ไม่พบเซลล์ที่ row-${tableCounter}-${rowIndex + 1}-col-${colIndex} ในตารางที่ ${tableCounter}`
            });
        }
    });
}

// ฟังก์ชันประมวลผลและตรวจสอบข้อมูล
function handleProcessData() {
    if (!window.uploadedSheetData) {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': 'กรุณาอัปโหลดไฟล์ก่อน'
        });
        return;
    }
    $("#loading").show();
    // document.getElementById('loading').style.display = 'block';

    validateSheetData(window.uploadedSheetData)
        .then(function(isValid) {
            $("#loading").hide();

            // document.getElementById('loading').style.display = 'none';

            if (isValid) {
                dialog_success({'header': text_toast_default_success_header, 'body': "การตรวจสอบเสร็จสิ้น: ข้อมูลถูกต้อง"});
                document.getElementById('saveButton').style.display = 'inline-block';
            } else {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'พบข้อผิดพลาดในการตรวจสอบข้อมูล'
                });
                document.getElementById('errorButton').style.display = 'inline-block'; // แสดงปุ่ม error
                displayErrors(); // แสดง error ใน modal
            }
        })
        .catch(function(error) {
            // document.getElementById('loading').style.display = 'none';
            $("#loading").hide();
                dialog_error({
                'header': text_toast_default_error_header,
                'body': 'เกิดข้อผิดพลาดในการตรวจสอบข้อมูล'
            });
        });
}

// ฟังก์ชันแสดง errorMessages ใน modal
function displayErrors() {
    const errorList = document.getElementById('errorMessagesList');
    errorList.innerHTML = ''; // เคลียร์รายการเก่า

    errorMessages.forEach(message => {
        const li = document.createElement('li');
        li.textContent = message;
        errorList.appendChild(li);
    });

    document.getElementById('errorButton').click(); // เปิด modal ข้อความ error
}

// ฟังก์ชันสำหรับยืนยันการบันทึกข้อมูล (ส่งไปยัง PHP)
function handleSaveData() {
    if (!window.uploadedSheetData) {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': 'กรุณาอัปโหลดไฟล์และประมวลผลก่อน'
        });
        return;
    }
    
    // const postData = {
    //     sheetData: window.uploadedSheetData
    // };

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>timework_record_import_excel_save',
        type: 'POST',
        data: {
            record_data : record_data
        },
        success: function(data) {
            data = JSON.parse(data);
            dialog_success({'header': text_toast_default_success_header, 'body': data.message_dialog});
            setTimeout(function() {
                window.location.href = '<?php echo site_url() . "/" . $controller_dir; ?>'
            }, 1500);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
            });
        }
    });
}

// ฟังก์ชันล้างผลลัพธ์
function handleClearResults() {
    document.getElementById('sheetTabs').innerHTML = '';
    document.getElementById('sheetTabContent').innerHTML = '';
    document.getElementById('excelFile').value = '';
    document.getElementById('saveButton').style.display = 'none';
}
</script>
