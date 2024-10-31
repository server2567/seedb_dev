<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อแผนก</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-md-2">
                            <label for="SearchFirstName" class="form-label">ชื่อแผนก
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกแผนก --" name="UsTitle" id="UsTitle" required>
                                <option value=""></option>
                                <option value="1">รายบุคคล</option>
                                <option value="1">รายกลุ่ม</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
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
                    <i class="bi-server icon-menu"></i><span> ข้อมูลแผนก และห้องปฏิบัติงาน</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row mb-2">
                        <div class="col-2">
                            <button id="addDepartment" class="btn btn-primary addDepart"><i class="bi-plus"></i>เพิ่มรายการแผนก</button>
                        </div>
                        <!-- <div class="col-2">
                            <select class="form-select" name="" id=""></select>
                        </div> -->
                    </div>
                    <table id="table" class="table" width="100%">
                        <thead>
                            <tr>
                                <th data-dt-order="disable" scope="col">
                                    <div class="text-center">ชื่อแผนก</div>
                                </th>
                                <th data-dt-order="disable" scope="col">
                                    <div class="text-center">ลำดับห้อง</div>
                                </th>
                                <th data-dt-order="disable" scope="col" class="text-center">ห้องปฏิบัติงาน</th>
                                <th data-dt-order="disable" scope="col" class="text-center">ปรับปรุงล่าสุด</th>
                                <th data-dt-order="disable" scope="col" class="text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="group">
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td colspan="5" style="background: #e0e0e0">
                                    <div class="row">
                                        <div class="col-6 text-start ">
                                            <b>แผนกผู้ป่วยใน</b>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-success addRoom" data-value="1"><i class="bi bi-building-add"></i></button>
                                            <button class="btn btn-warning editDepart" data-value="1"><i class="bi-pencil-square" style="color:white"></i></button>
                                            <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td hidden></td>
                                <td hidden></td>
                                <!-- <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_matching_code/edit/1'"><i class="bi-pencil-square"></i></button>
                                    </div>
                                </td> -->
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">1</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 101</div>
                                </td>
                                <td>
                                    <div class="text-center">4/23/2566 10:14</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">2</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 102</div>
                                </td>
                                <td>
                                    <div class="text-center">9/11/2566 08:45</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">3</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 103</div>
                                </td>
                                <td>
                                    <div class="text-center">5/7/2566 14:20</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group">
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td colspan="5" style="background: #e0e0e0">
                                    <div class="row">
                                        <div class="col-6 text-start ">
                                            <b>แผนกผู้ป่วยนอก</b>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-success addRoom" data-value="1"><i class="bi bi-building-add"></i></button>
                                            <button class="btn btn-warning editDepart" data-value="1"><i class="bi-pencil-square" style="color:white"></i></button>
                                            <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td hidden></td>
                                <td hidden></td>
                                <!-- <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_matching_code/edit/1'"><i class="bi-pencil-square"></i></button>
                                    </div>
                                </td> -->
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">1</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 121</div>
                                </td>
                                <td>
                                    <div class="text-center">12/30/2566 18:03</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">2</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 122</div>
                                </td>
                                <td>
                                    <div class="text-center">6/2/2566 21:57</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">3</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 123</div>
                                </td>
                                <td>
                                    <div class="text-center">10/19/2566 12:08</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group">
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td colspan="5" style="background: #e0e0e0">
                                    <div class="row">
                                        <div class="col-6 text-start ">
                                            <b>แผนกจิตเวช</b>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-success addRoom" data-value="1"><i class="bi bi-building-add"></i></button>
                                            <button class="btn btn-warning editDepart" data-value="1"><i class="bi-pencil-square" style="color:white"></i></button>
                                            <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td hidden></td>
                                <td hidden></td>
                                <!-- <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_matching_code/edit/1'"><i class="bi-pencil-square"></i></button>
                                    </div>
                                </td> -->
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">1</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 131</div>
                                </td>
                                <td>
                                    <div class="text-center">2/8/2566 05:26</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">2</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 132</div>
                                </td>
                                <td>
                                    <div class="text-center">7/25/2566 17:39</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">3</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 133</div>
                                </td>
                                <td>
                                    <div class="text-center">11/1/2566 23:11</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group">
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td colspan="5" style="background: #e0e0e0">
                                    <div class="row">
                                        <div class="col-6 text-start ">
                                            <b>แผนกฉุกเฉินและอุบัติเหตุ</b>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-success addRoom" data-value="1"><i class="bi bi-building-add"></i></button>
                                            <button class="btn btn-warning editDepart" data-value="1"><i class="bi-pencil-square" style="color:white"></i></button>
                                            <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td hidden></td>
                                <td hidden></td>
                                <!-- <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_matching_code/edit/1'"><i class="bi-pencil-square"></i></button>
                                    </div>
                                </td> -->
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">1</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 201</div>
                                </td>
                                <td>
                                    <div class="text-center">1/5/2566 13:25</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">2</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 202</div>
                                </td>
                                <td>
                                    <div class="text-center">6/29/2566 10:40</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">3</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 203</div>
                                </td>
                                <td>
                                    <div class="text-center">9/3/2566 19:18</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="1"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group">
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td hidden>
                                    <div class="text-center"></div>
                                </td>
                                <td colspan="5" style="background: #e0e0e0">
                                    <div class="row">
                                        <div class="col-6 text-start ">
                                            <b>แผนกบัญชี</b>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-success addRoom" data-value="2"><i class="bi bi-building-add"></i></button>
                                            <button class="btn btn-warning editDepart" data-value="2"><i style="color:white" class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td hidden></td>
                                <td hidden></td>
                                <!-- <td>
                                    <div class="text-center option">
                                        <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Time_matching_code/edit/1'"><i class="bi-pencil-square"></i></button>
                                    </div>
                                </td> -->
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">1</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 221</div>
                                </td>
                                <td>
                                    <div class="text-center">12/10/2566 07:51</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">2</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 222</div>
                                </td>
                                <td>
                                    <div class="text-center">8/22/2566 06:37</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">3</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 223</div>
                                </td>
                                <td>
                                    <div class="text-center">10/8/2566 11:17</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">4</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 301</div>
                                </td>
                                <td>
                                    <div class="text-center">11/25/2566 16:45</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">5</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 302</div>
                                </td>
                                <td>
                                    <div class="text-center">4/23/2566 10:14</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">6</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 303</div>
                                </td>
                                <td>
                                    <div class="text-center">4/23/2566 10:14</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">7</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 401</div>
                                </td>
                                <td>
                                    <div class="text-center">4/23/2566 10:14</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">8</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 402</div>
                                </td>
                                <td>
                                    <div class="text-center">4/23/2566 10:14</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2"><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="room">
                                <td>
                                    <div class="text-center"></div>
                                </td>
                                <td>
                                    <div class="text-center">9</div>
                                </td>
                                <td>
                                    <div class="text-center">ห้อง 501</div>
                                </td>
                                <td>
                                    <div class="text-center">4/23/2566 10:14</div>
                                </td>
                                <td>
                                    <div class="text-end option">
                                        <button class="btn btn-warning editRoom" data-value="2" s><i class="bi-pencil-square"></i></button>
                                        <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">เพิ่มรายการแผนก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <label for="depart" class="form-label">ชื่อแผนก</label>
                    <input type="text" class="form-control" name="idPatient" id="depart" placeholder="" value="<?php echo !empty($edit) ? $edit['idPatient'] : ""; ?>">
                </div>
                <div class="col-md-12">
                    <label for="name" class="form-label">ห้องปฏิบัติงาน</label>
                    <div id="table-container">
                        <table id="rtable" class="table">
                            <thead>
                                <tr>
                                    <th>ลำดับห้อง</th>
                                    <th>หมายเลขห้อง</th>
                                    <th>ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ใส่แถวของข้อมูลที่ได้จาก JavaScript ที่นี่ -->
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-info" id="add-rtable">เพิ่มห้อง</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">บันทึก</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-lg" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog " style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle2">เพิ่มห้องปฏิบัติงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">บันทึก</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    var index = 1;
    var titleModal = 'เพิ่มรายการแผนก'
    var Data = [
        ['101', '102'],
        ['201', '202', '203', '204', '205']
    ];
    var Data = [{
        depart: 'แผนกเลขนุการ',
        room: ['101', '102']
    }, {
        depart: 'แผนกบัญชี',
        room: ['201', '202', '203', '204', '205']
    }];
    document.getElementById('add-rtable').addEventListener('click', function() {
        var table = document.getElementById('rtable').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);

        cell1.innerHTML = index;
        cell2.innerHTML = '<input class="form-control" type="text" placeholder="เลขห้อง">';
        cell3.innerHTML = '<button class="btn btn-danger" onclick="deleteRow(this)">ลบ</button>';
        index++
    });

    // ฟังก์ชันสำหรับลบแถว
    function deleteRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        index--
    }
    $(document).ready(function() {
        var count = $('#table tbody tr.room').length;
        var table = $('#table').DataTable({
            // responsive: true,
            language: {
                decimal: "",
                emptyTable: "ไม่มีรายการในระบบ",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "_MENU_",
                loadingRecords: "Loading...",
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
                info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด " + count + " รายการ",
            },
        });
    });
    // `Button ${event.target.id} clicked!`
    document.querySelectorAll('.editRoom, .addRoom').forEach(button => {
        button.addEventListener('click', event => {
            let title = 'เพิ่มห้องปฏิบัติงาน';
            if (event.target.classList.contains('editRoom') || event.target.parentNode.classList.contains('editRoom')) {
                title = 'แก้ไขห้องปฏิบัติงาน';
            }
            let buttonValue = event.currentTarget.getAttribute('data-value');
            console.log(buttonValue);
            let data = Data[buttonValue - 1]
            Swal.fire({
                title: title,
                html: '<input id="swal-input1" placeholder="ชื่อแผนก" value="' + data.depart + '" class="swal2-input" disabled>' +
                    '<input id="swal-input2"placeholder="เลขห้อง" class="swal2-input">',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                preConfirm: () => {
                    return [
                        document.getElementById('swal-input1').value,
                        document.getElementById('swal-input2').value
                    ];
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: `Hello, ${result.value.name}!`,
                        html: 'Your request has been successfully submitted.'
                    })
                }
            })
        });
    });
    document.querySelectorAll('.addDepart,.editDepart').forEach(button => {
        button.addEventListener('click', event => {
            let buttonValue = event.currentTarget.getAttribute('data-value');
            if (event.target.classList.contains('editDepart') || event.target.parentNode.classList.contains('editDepart')) {
                document.getElementById('modalTitle').innerHTML = 'แก้ไขรายการแผนก';
                var table = document.getElementById('rtable').getElementsByTagName('tbody')[0];
                table.innerHTML = '';
                index = 1;
                if (Data) {
                    data = Data[buttonValue - 1];
                    $('#depart').val(data.depart);
                    data.room.forEach(function(rowData) {
                        // Create a new row
                        var newRow = table.insertRow();
                        var cell1 = newRow.insertCell(0);
                        var cell2 = newRow.insertCell(1);
                        var cell3 = newRow.insertCell(2);

                        cell1.innerHTML = index;
                        cell2.innerHTML = '<input class="form-control" type="text" placeholder="เลขห้อง" value="' + rowData + '">';
                        cell3.innerHTML = '<button class="btn btn-danger" onclick="deleteRow(this)">ลบ</button>';
                        index++;
                    });
                }
            } else {
                $('#depart').val('');
                var table = document.getElementById('rtable').getElementsByTagName('tbody')[0];
                table.innerHTML = '';
                index = 1;
                document.getElementById('modalTitle').innerHTML = 'เพิ่มรายการแผนก'
            }
            var modal = document.getElementById('exampleModal');
            var modalObj = new bootstrap.Modal(modal);
            modalObj.show();
        });
    });
</script>