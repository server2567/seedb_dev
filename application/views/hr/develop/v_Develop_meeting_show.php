<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span> จัดการข้อมูลพัฒนาบุคลากร</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <div class="text-center"><img src="https://surateyehospital.com/wp-content/uploads/2023/01/S__64995330-e1674529006351.jpg" width="200px" height="200px"></div>
                            <b>ผู้ดำเนินการ : </b><?= $name ?> <br>
                            <b>ตำแหน่งในการบริหาร </b><?= $position ?><br><b> ตำแหน่งในสายงาน</b> <?= $affiliation ?> <br> <b> ตำแหน่งเฉพาะทาง</b> <?= $special ?><br><br>
                        </div>
                        <div class="col-md-4 ">
                            <b>ระหว่างวันที่ :</b>
                            <div class="input-group date input-daterange">
                                <input type="date" class="form-control" name="StartDate" id="StartDate" placeholder="" value="">
                                <span class="input-group-text">ถึง</span>
                                <input type="date" class="form-control" name="EndDate" id="EndDate" placeholder="" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b>ประเภท :</b>
                            <select type="text" class="form-select select2"> </select>
                        </div>
                        <div class="col-md-4">
                            <b>ด้านการพัฒนา :</b>
                            <select type="text" class="form-select select2"> </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="card p-3">
                                    <div class="row">
                                        <div class="col-12"> <b>งบประมาณพัฒนาที่ใช้ไปทั้งหมด&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></div>
                                        <div class="col-6" style="color:#bb9f39;"><i class="bi bi-currency-dollar" style="font-size: 55px;"></i></div>
                                        <div class="col-6 text-end">
                                            <h1>0.00</h1>บาท
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card p-3">
                                    <div class="row">
                                        <div class="col-12"> <b>งบประมาณพัฒนาตามความต้องการของตนเองที่ได้รับ</b></div>
                                        <div class="col-6" style="color:#a00686;"><i class="bi bi-bar-chart" style="font-size: 55px;"></i></div>
                                        <div class="col-6 text-end">
                                            <h1>0.00</h1>บาท
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card p-3">
                                    <div class="row">
                                        <div class="col-12"> <b>งบประมาณพัฒนาตามความต้องการของตนเองที่ใช้ไป</b></div>
                                        <div class="col-6" style="color:#168214;"><i class="bi bi-cash" style="font-size: 55px;"></i></div>
                                        <div class="col-6 text-end">
                                            <h1>0.00</h1>บาท
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card p-3">
                                    <div class="row">
                                        <div class="col-12"> <b>งบประมาณพัฒนาตามความต้องการของตนเองคงเหลือ</b></div>
                                        <div class="col-6" style="color:#245dc1;"><i class="bi bi-cash" style="font-size: 55px;"></i></div>
                                        <div class="col-6 text-end">
                                            <h1>0.00</h1>บาท
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12 text-end"><button class="btn btn-secondary"><i class="bi bi-x-lg"></i> เคลียข้อมูล</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"><i class="bi bi-search"></i> ค้นหา</button></div>
                        </div>
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
                    <i class="bi-server icon-menu"></i><span> ตารางข้อมูลพัฒนาบุลากร</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/develop/Develop_meeting/get_Develop_meeting_add'"><i class="bi-plus"></i> บันทึกข้อมูลพัฒนาบุคลกร </button>
                        </div>
                    </div>
                    <div class="col-12">

                    </div>
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="text-center" class="text-center">#</div>
                                </th>
                                <th scope="col" width="25%" class="text-center">เรื่องที่ไปร่วมประชุม/อบรม</th>
                                <th scope="col" class="text-center">ประเภทการพัฒนา</th>
                                <!-- <th scope="col">ตัวย่อภาษาไทย</th>
                                <th scope="col">ตัวย่อภาษาอังกฤษ</th> -->
                                <th scope="col" class="text-center">วันที่เข้าร่วม</th>
                                <th scope="col" class="text-center">ประเภท</th>
                                <th scope="col" class="text-center">ด้านการพัฒนา</th>
                                <th scope="col" class="text-center" width="15%">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="text-center">1</div>
                                </td>
                                <td>ไปประชุม <br>
                                    (ผู้ทำเรื่องขอไปราชการ : นพ.บรรยง ชินกุลกิจนิวัฒน์ <br>
                                    ผู้แก้ไขข้อมูลล่าสุด : นพ.บรรยง ชินกุลกิจนิวัฒน์)</td>
                                <td>พัฒนาตามความต้องการของตนเอง </td>
                                <td>-</td>
                                <!-- <td><div class="text-center"></div></td>
                                <td><div class="text-center"></div></td> -->
                                <td>ประชุม/อบรม/สัมมนา</td>
                                <td>ไม่ระบุ</td>
                                <td>
                                    <div class="text-center option">
                                        <a class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/Structure_base_group_position/edit/1'"><i class="bi bi-pencil"></i></a>
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-printer-fill"></i>พิมพ์</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-word-fill"></i>Word</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-printer-fill"></i>แบบรายงาน</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-printer-fill"></i>สรุปผลหลังการประชุม</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-printer-fill"></i>แบบฟอร์มขอเบิกเงินค่าเดินทางไปฝึกอบรม</a></li>
                                        </ul>
                                        <a class="btn btn-danger" href=""><i class="bi bi-trash"></i></a>
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