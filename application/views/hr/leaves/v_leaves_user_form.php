<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <span> ข้อมูลบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-md-7">
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">ชื่อ-นามสกุล</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">นพ.บรรยง ชินกุลกิจนิวัฒน์</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">ประเภทบุคลากร</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">ข้าราชการ</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">ประเภทสายงาน</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">สายสอน</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">อายุงาน</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">35 ปี 3 เดือน 15 วัน</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">ปีงบประมาณ</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">2567</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 p-2" style="background-color: #ffecb3;">
                            <span>
                                <u><b>วีธีกำหนดและตั้งค่าสิทธิ์วันลา</b></u><br>
                                <b>1.</b> กดปุ่ม <b>"บันทึก"</b> เพื่อเพิ่มสิทธิ์การลาที่บุคลากรควรจะได้รับในแต่ละปี และคำนวณวันลาพักผ่อนคงเหลือจากปีก่อนหน้า <br>
                                <b>2.</b> กดปุ่ม <b>"ตั้งค่าสิทธิ์วันลาใหม่"</b> เพื่อคำนวณและประมวลผลจำนวนวันลาที่บุคลากรควรจะได้รับจริง โดยจะคำนวณวันลาพักผ่อนคงเหลือจากปีงบประมาณ
                                ก่อนหน้ามารวมกับจำนวนวันลาที่ได้รับ ในปีงบประมาณปัจจุบัน และคำนวณตามข้อมูลจำนวน "วันลาสะสมสูงสุด"<br>
                                <u><b>หมายเหตุ</b></u> กรุณาทำตามขั้นตอนทุกครั้ง
                            </span>
                        </div>
                        <div class="col-md-12 text-end mt-2">
                            <button class="btn btn-primary">ตั้งค่าสิทธิ์วันลาใหม่</button>
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
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ข้อมูลวันลา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" hidden>#</th>
                                <th class="text-center" scope="col">ประเภทการลา</th>
                                <th class="text-center" scope="col">ชนิดการลา</th>
                                <th class="text-center" scope="col" width="2%">จำนวนครั้งที่ลาไปแล้ว</th>
                                <th class="text-center" scope="col" width="15%">จำนวนครั้งคงเหลือ</th>
                                <th class="text-center" scope="col">จำนวนวันที่ได้รับ (รวมสะสม)</th>
                                <th class="text-center" scope="col">จำนวนวันที่ลาไปแล้ว</th>
                                <th class="text-center" scope="col">จำนวนวันที่ลาไปแล้วนอกระบบ</th>
                                <th class="text-center" scope="col">จำนวนวันคงเหลือ</th>
                                <th class="text-center" scope="col">จำนวนยอดสะสม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <?php if ($i < 4) { ?>
                                    <tr>
                                        <td hidden>
                                            <div class="text-center"><?php echo $i + 1; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start">ลาป่วย</div>
                                        </td>
                                        <td>
                                            <div class="text-start">เหตุปฏิบัติราชการ</div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="ไม่ระบุ" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="99" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0"></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="99" disabled></div>
                                        </td>
                                        <td>
                                         
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <!-- <tr>
                                        <td hidden>
                                            <div class="text-center"><?php echo $i + 1; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start">ลาพักผ่อน</div>
                                        </td>
                                        <td>
                                            <div class="text-start">เหตุปฏิบัติราชการ</div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="ไม่ระบุ" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="99" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0"></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="99" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" ></div>
                                        </td>
                                    </tr> -->
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>