<style>
    .input-with-unit {
        display: flex;
        align-items: center;
        border-bottom: 2px solid #cfe2ff;
        /* เส้นขีดด้านล่างของ input */
        padding-bottom: 5px;
        max-width: 300px;
    }

    .input-with-unit input {
        border: none;
        outline: none;
        padding: 10px;
        width: 100%;
        font-size: 16px;
        margin-right: 10px;
        text-align: right;
        /* ระยะห่างระหว่าง input กับกล่องหน่วย */
    }

    .input-with-unit .unit-box {
        background-color: #f1f1f1;
        /* สีพื้นหลังของกล่องหน่วย */
        border: 2px solid #cfe2ff;
        /* ขอบกล่องหน่วย */
        border-radius: 5px;
        /* ขอบกล่องหน่วยที่โค้งมน */
        padding: 5px 10px;
        font-size: 16px;
        color: #333;
    }

    .hr_line {
        border-top: 3px solid #4154f0;
        border-radius: 5px;
        width: 100%;
        /* This ensures the hr takes the full width of its parent */
        max-width: 300px;
        /* Same width as input-with-unit to keep consistency */
    }

    .input-with-unit input:focus {
        border-bottom-color: #4CAF50;
        /* เปลี่ยนสีเส้นขีดเมื่อ input ถูกเลือก */
    }

    #dropZone {
        width: 100%;
        max-width: 400px;
        height: 250px;
        border: 2px dashed #ccc;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin: 15px 15px;
        padding: 20px;
        color: #999;
    }

    .input-group .select2-container--bootstrap-5 .select2-selection {
        height: 70%;
    }

    #dropZone.dragover {
        border-color: #000;
        color: #000;
    }

    .input-group .select2-container--bootstrap-5 .select2-selection .input-group .form-control,
    .input-group .input-group-text {
        height: auto;
        /* Ensures both elements have the same height */
        display: flex;
        align-items: center;
    }
</style>
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
                                <form class="row g-3" method="#">
                                    <!-- <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <b>ผู้ดำเนินการ</b>
                                            </div>
                                            <div class="col-10 ">
                                                นพ.บรรยง ชินกุลกิจนิวัฒน์ <b>ตำแหน่งในการบริหาร</b> ผู้อำนวยการ <br>
                                                <b>ตำแหน่งในสายงาน</b> จักษุแพทย์ รักษาโรคตาทั่วไป <b>ตำแหน่งเฉพาะทาง</b> เชี่ยวชาญการผ่าตัดต้อกระจก
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">รูปแบบการไปพัฒนาบุคลากร</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="radio" class="form-check-input mb-3" id="dev_organized_type_1" <?= !isset($develop_info) ? 'checked' : '' ?> <?= isset($develop_info) && $develop_info->dev_organized_type == 1 ? 'checked' : '' ?> name="dev_organized" value="1">
                                                <label for="age1">ภายในโรงพยาบาลจักษุสุราษฏร์</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="dev_organized_type_2" <?= isset($develop_info) && $develop_info->dev_organized_type == 2 ? 'checked' : '' ?> name="dev_organized" value="2">
                                                <label for="age1">ภายนอกโรงพยาบาลจักษุสุราษฏร์</label><br>
                                                <div class="intDetail" hidden>
                                                    <label for="age1">รายละเอียด: </label><br>
                                                    <textarea class="form-control" name="" id=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">เรื่องที่ไปเข้าร่วม</label>
                                            </div>
                                            <div class="col-8">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="doc_temp">IN-091067</span>
                                                    <select name="inputField[]" id="dev_topic" class="form-control select2" placeholder="กรอกหัวเรื่อง">
                                                        <?php foreach ($develop_heading as $key => $value) : ?>
                                                            <optgroup label="<?= $value->devh_group_name ?>">
                                                                <?php foreach ($value->devh_list as $key => $devh_list) : ?>
                                                                    <option value="<?= $devh_list['devh_id'] ?>" <?= isset($develop_info) && $develop_info->dev_topic == $devh_list['devh_id'] ? 'selected' : '' ?>><?= $devh_list['devh_name_th'] ?></option>
                                                                <?php endforeach; ?>
                                                            </optgroup>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-3" id="additional_rounds_container"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label" style="font-weight: bold;">รายละเอียดการเข้าร่วม</label>
                                            </div>
                                            <div class="col-8">
                                            <textarea name="inputField[]" id="dev_desc" class="form-control"><?= isset($develop_info) ? htmlspecialchars($develop_info->dev_desc) : '' ?></textarea>

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
                                                    <input type="text" class="form-control" name="inputField[]" id="dev_start_date" placeholder="" value="<?= isset($develop_info) ? $develop_info->dev_start_date : '' ?>">
                                                    <span class="input-group-text">ถึง</span>
                                                    <input type="text" class="form-control" name="inputField[]" id="dev_end_date" placeholder="" value="<?= isset($develop_info) ? $develop_info->dev_end_date : '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">เวลาสิ้นสุดโครงการ</label>
                                            </div>
                                            <div class="col-2">
                                                <div class="input-group date input-daterange">
                                                    <input type="time" class="form-control" name="inputField[]" id="dev_end_time" placeholder="" value="<?= isset($develop_info) ? $develop_info->dev_end_time : '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="input-group date input-daterange">
                                                    <label for="StNameT" class="form-label " style="font-weight: bold; padding-right:10px">รวม</label>
                                                    <input type="number" class="form-control" name="inputField[]" id="dev_hour" placeholder="" value="<?= isset($develop_info) ? $develop_info->dev_hour : '' ?>">
                                                    <label for="StNameT" class="form-label " style="font-weight: bold; padding-left:10px">ชั่วโมง</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label" style="font-weight: bold;">&nbsp;</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="checkbox" class="form-check-input" name="inputField[]" id="dev_see_place">
                                                <label for="">ที่อยู่ตามรพ.จักษุสุราษฎร์</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">สถานที่</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control" name="inputField[]" id="dev_place" value="<?= isset($develop_info) ? $develop_info->dev_place : '' ?>" placeholder="กรอกสถานที่">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">ประเทศ</label>
                                            </div>
                                            <div class="col-8">
                                                <select type="text" class="form-control select2" id="dev_country_id" value="<?= isset($develop_info) ? $develop_info->dev_country_id : '' ?>" name="inputField[]">
                                                    <option value="none" selected disabled>-- เลือกประเทศ --</option>
                                                    <?php foreach ($base_country_list as $key => $country) : ?>
                                                        <option value="<?= $country->country_id ?>" <?= isset($develop_info) && $develop_info->dev_country_id == $country->country_id ? 'selected' : '' ?>><?= $country->country_name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">จังหวัด</label>
                                            </div>
                                            <div class="col-8">
                                                <select type="text" class="form-control select2" name="inputField[]" id="dev_pv_id" value="<?= isset($develop_info) ? $develop_info->dev_pv_id : '' ?>">
                                                    <option value="none" selected disabled>-- เลือกจังหวัด --</option>
                                                    <?php foreach ($base_province_list as $key => $province) : ?>
                                                        <option value="<?= $province->pv_id ?>" <?= isset($develop_info) && $develop_info->dev_pv_id == $province->pv_id ? 'selected' : '' ?>><?= $province->pv_name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">ผู้จัด/โครงการ</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control" placeholder="กรอกชื่อผู้จัดทำ/โครงการ" id="dev_project" value="<?= isset($develop_info) ? $develop_info->dev_project : '' ?>" name="inputField[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">ประกาศนียบัตร</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="radio" class="form-check-input mb-3" id="dev_certi_1" <?= !isset($develop_info) ? 'checked' : '' ?> <?= isset($develop_info) && $develop_info->dev_certificate == 1 ? 'checked' : '' ?> name="dev_certi" value="1">
                                                <label for="age1">มี</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="dev_certi_2" <?= isset($develop_info) && $develop_info->dev_certificate == 0 ? 'checked' : '' ?> name="dev_certi" value="0">
                                                <label for="age1">ไม่มี</label><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">ประเภทการพัฒนา</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="radio" class="form-check-input mb-3" id="type1" <?= !isset($develop_info) ? 'checked' : '' ?> <?= isset($develop_info) && $develop_info->dev_type == 1 ? 'checked' : '' ?> name="dev_type" value="1">
                                                <label for="age1">พัฒนาตามความต้องการของตนเอง</label><br>
                                                <input type="radio" class="form-check-input mb-3" id="type3" <?= isset($develop_info) && $develop_info->dev_type == 2 ? 'checked' : '' ?> name="dev_type" value="2">
                                                <label for="age3">พัฒนาตามนโยบายของโรงพยาบาลจักษุสุราษฏร์</label><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="StNameT" class="form-label required" style="font-weight: bold;">ประเภท</label>
                                            </div>
                                            <div class="col-10">
                                                <?php foreach ($base_develop_type_list as $key => $value) { ?>
                                                    <input type="radio" class="form-check-input mb-3" id="service_type<?= $key ?>" <?= $key == 0 && !isset($develop_info) ? 'checked' : '' ?> <?= isset($develop_info) && $develop_info->dev_go_service_type == $value->devb_id ? 'checked' : '' ?> name="service_type" value="<?= $value->devb_id ?>">
                                                    <label for="age1"><?= $value->devb_name ?></label><br>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2 mb-3">
                                                <label for="age1" style="font-weight: bold;">อัพโหลดไฟล์ต้นเรื่อง :</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="file" id="fileInput" multiple style="display:none;" accept="application/pdf,image/jpeg,image/png">
                                                <div id="dropZone">สามารถลากไฟล์ และวางได้ที่นี้ หรือ &nbsp;<button type="button" class="btn btn-info btn-sm" id="browseBtn">Browse</button></div>
                                                <label for="age1">
                                                    (อัพโหลดไฟล์ได้สูงสุด 2Mb หรือ 2000KB)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="fileList"></div> <!-- ส่วนนี้จะแสดงรายการไฟล์ที่เลือก -->
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

                                <button class="btn btn-primary mb-2" id="addP" data-bs-toggle="modal" data-bs-target="#addPersonModal"><i class="bi bi-plus"></i> เพิ่มผู้เข้าร่วม</button>
                                <table class="table" id="paticipate">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <div class="text-center">ลำดับ</div>
                                            </th>
                                            <th class="text-center">รหัสบุคลากร</th>
                                            <th scope="col" width="20%" class="text-center">ชื่อ-นามสกุล</th>
                                            <!-- <th class="text-center">ตำแหน่ง</th>
                                            <th scope="col" class="text-center">แผนก</th>
                                            <th scope="col" class="text-center">ฝ่าย</th> -->
                                            <th scope="col" class="text-center">สาย</th>
                                            <th scope="col" class="text-center">ดำเนินการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($develop_info)) : ?>
                                            <?php foreach ($develop_info->dev_person as $key => $person_list) : ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?= $key + 1 ?>
                                                    </td>
                                                    <td class="text-start">
                                                        <?= $person_list['pos_ps_code'] ?>
                                                    </td>
                                                    <td class="text-start">
                                                        <?= $person_list['ps_name'] ?>
                                                    </td>
                                                    <!-- <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td> -->
                                                    <td class="text-start">
                                                        <?= $person_list['hire_name'] ?>
                                                    </td>
                                                    <td width="10%" class="text-center">
                                                        <button class="btn btn-sm btn-danger delPerson" data-id="<?= $person_list['ps_id'] ?>"><i class="bi bi-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
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
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd5" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-window-dock icon-menu"></i><span>ค่าใช้จ่าย</span>
                            </button>
                        </h2>
                        <div id="collapseAdd5" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <div class="row p-4 font-16">
                                    <div class="col-md-4">
                                        <span>1. ค่าฝึกอบรม ต่อคน / ต่อครั้ง</span>
                                    </div>
                                    <div class="col-md-4 font-end">
                                        <label for="amount">จำนวนเงิน :</label>
                                        <div class="input-with-unit">
                                            <input type="text" name="inputField[]" id="dev_budget" placeholder="0.00" value="<?= isset($develop_info) ? $develop_info->dev_budget : '' ?>" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 font-end mb-4">
                                        <label for="amount">รวม VAT :</label>
                                        <div class="input-with-unit">
                                            <input type="text" name="inputField[]" id="dev_budget_vat" placeholder="0.00" value="<?= isset($develop_info) ? $develop_info->dev_budget_vat : '' ?>" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span>2. เบี้ยเลี้ยง ต่อคน / ต่อครั้ง</span>
                                    </div>
                                    <div class="col-md-4 font-end">
                                        <label for="amount">จำนวนเงิน :</label>
                                        <div class="input-with-unit">
                                            <input type="text" name="inputField[]" id="dev_allowance" placeholder="0.00" value="<?= isset($develop_info) ? $develop_info->dev_allowance : '' ?>" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 font-end mb-4">
                                        <label for="amount">รวม VAT :</label>
                                        <div class="input-with-unit">
                                            <input type="text" name="inputField[]" id="dev_allowance_vat" placeholder="0.00" value="<?= isset($develop_info) ? $develop_info->dev_allowance_vat : '' ?>" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span>3. ค่าที่พักและอาหาร ต่อคน / ต่อครั้ง</span>
                                    </div>
                                    <div class="col-md-4 font-end">
                                        <label for="amount">จำนวนเงิน :</label>
                                        <div class="input-with-unit">
                                            <input type="text" name="inputField[]" id="dev_accommodation" placeholder="0.00" value="<?= isset($develop_info) ? $develop_info->dev_accommodation : '' ?>" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 font-end mb-4">
                                        <label for="amount">รวม VAT :</label>
                                        <div class="input-with-unit">
                                            <input type="text" name="inputField[]" id="dev_accommodation_vat" placeholder="0.00" value="<?= isset($develop_info) ? $develop_info->dev_accommodation_vat : '' ?>" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span>4. อื่น ๆ</span>
                                    </div>
                                    <div class="col-md-4 font-end">
                                        <label for="amount">จำนวนเงิน :</label>
                                        <div class="input-with-unit">
                                            <input type="text" name="inputField[]" id="dev_budget_type_other" placeholder="0.00" value="<?= isset($develop_info) ? $develop_info->dev_budget_type_other : '' ?>" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 font-end mb-4">
                                        <label for="amount">รวม VAT :</label>
                                        <div class="input-with-unit">
                                            <input type="text" name="inputField[]" id="dev_budget_type_other_vat" placeholder="0.00" value="<?= isset($develop_info) ? $develop_info->dev_budget_type_other_vat : '' ?>" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;รวมค่าใช้จ่ายทั้งสิ้น</span>
                                    </div>
                                    <div class="col-md-4 font-end">
                                        <label for="amount">จำนวนเงิน :</label>
                                        <div class="input-with-unit">
                                            <input type="text" id="sum-cost" placeholder="0.00" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <hr class="hr_line">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 font-end">
                                        <label for="amount">รวม VAT :</label>
                                        <div class="input-with-unit">
                                            <input type="text" id="sum-cost-vat" placeholder="0.00" class="currency-input" />
                                            <div class="unit-box">บาท</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <hr class="hr_line">
                                            </div>
                                        </div>
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
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd3" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-window-dock icon-menu"></i><span>รายงานการประชุม/อบรม/สัมมนา</span>
                            </button>
                        </h2>
                        <div id="collapseAdd3" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">เป้าหมาย/วัตถุประสงค์การไปประชุม/อบรม/สัมมนา :</label> <br><br>
                                        <textarea name="inputField[]" id="dev_objecttive" class="form-control"><?= isset($develop_info) ? htmlspecialchars($develop_info->dev_objecttive, ENT_QUOTES, 'UTF-8') : '' ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">เนื้อหาการประชุมโดยสรุป :</label> <br><br>
                                        <textarea name="inputField[]" id="dev_short_content" class="form-control"><?= isset($develop_info) ? htmlspecialchars($develop_info->dev_short_content, ENT_QUOTES, 'UTF-8') : '' ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label style="font-weight: bold;" for="">ประโยชน์ได้รับ :</label> <br><br>
                                        <textarea name="inputField[]" id="dev_benefits" class="form-control"><?= isset($develop_info) ? htmlspecialchars($develop_info->dev_benefits, ENT_QUOTES, 'UTF-8') : '' ?></textarea>
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
                        <button class="btn btn-secondary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/develop/Develop_meeting'">ย้อนกลับ</button>
                    </div>
                    <div class="col-md-10 text-end">
                        <!-- <button class="btn btn-dark">บันทึกฉบับร่าง</button>&nbsp; -->
                        <button class="btn btn-success" id="submit-develop">ยืนยันการบันทึก</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Modal -->
        <div class="modal fade" id="addPersonModal" aria-labelledby="addPersonModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPersonModalLabel">เพิ่มรายชื่อผู้เข้าร่วม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addPersonForm">
                            <div class="mb-3">
                                <label for="personName" class="form-label">ชื่อผู้เข้าร่วม :</label>
                                <select class="form-control select2" id="personName" onchange="getpersonInfo(value)" name="personName" style="width: 100%;">
                                    <option value="none" selected disabled>-- เลือกผู้เข้าร่วม --</option>
                                    <?php foreach ($person_option as $key => $value) : ?>
                                        <option value="<?= $value->ps_id ?>"><?= $value->pf_name . ' ' . $value->ps_fname . ' ' . $value->ps_lname ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="person_info">
                                </div>
                            </div>
                            <!-- Add more fields as needed -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" id="savePerson" class="btn btn-success">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var name = [];
    var valid = false;
    var dev_id = '<?php echo isset($develop_info) ? $develop_info->dev_id : 'new' ?>'
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const browseBtn = document.getElementById('browseBtn');
    const fileListElement = document.getElementById('fileList');
    var fileArray = []
    <?php if (isset($develop_info)) { ?>
        // ใช้ json_encode เพื่อแปลง array PHP เป็น JSON
        var person_list = <?php echo json_encode($develop_info->dev_person); ?>;
        var start_default_date = <?php echo json_encode($develop_info->dev_start_date) ?>;
        start_default_date = new Date(start_default_date)
        var end_default_date = <?php echo json_encode($develop_info->dev_end_date) ?>;
        end_default_date = new Date(end_default_date)
    <?php } else { ?>
        var person_list = []
        var start_default_date = new Date();
        var end_default_date = new Date();
    <?php  } ?>
    let check = 0;
    flatpickr("#dev_start_date", {
        mode: 'range',
        dateFormat: 'd/m/Y',
        locale: 'th', // Thai locale for Buddhist calendar
        defaultDate: [start_default_date, end_default_date], // Default to today's date
        onReady: function(selectedDates, dateStr, instance) {
            convertYearsToThai()
            if (selectedDates[0]) {
                // Update start date field
                document.getElementById('dev_start_date').value = formatDateToThai(selectedDates[0]);
            }
            if (selectedDates[1]) {
                // Update end date field
                document.getElementById('dev_end_date').value = formatDateToThai(selectedDates[1]);
            }
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            // Convert years to Thai year
            convertYearsToThai();
            if (selectedDates[0]) {
                // Update start date field
                document.getElementById('dev_start_date').value = formatDateToThai(selectedDates[0]);

            }
            if (selectedDates[1]) {
                // Update end date field
                document.getElementById('dev_end_date').value = formatDateToThai(selectedDates[1]);

            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });
    flatpickr("#dev_end_date", {
        mode: 'range',
        dateFormat: 'd/m/Y',
        locale: 'th', // Thai locale for Buddhist calendar
        defaultDate: [start_default_date, end_default_date], // Default to today's date
        onReady: function(selectedDates, dateStr, instance) {
            convertYearsToThai()
            if (selectedDates[0]) {
                // Update start date field
                document.getElementById('dev_start_date').value = formatDateToThai(selectedDates[0]);
            }
            if (selectedDates[1]) {
                // Update end date field
                document.getElementById('dev_end_date').value = formatDateToThai(selectedDates[1]);
            }
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            console.log(selectedDates);

            // Convert years to Thai year
            convertYearsToThai();
            if (selectedDates[0]) {
                // Update start date field
                document.getElementById('dev_start_date').value = formatDateToThai(selectedDates[0]);

            }
            if (selectedDates[1]) {
                // Update end date field
                document.getElementById('dev_end_date').value = formatDateToThai(selectedDates[1]);

            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });
    // Function to format date to Thai (Buddhist) calendar
    browseBtn.addEventListener('click', function() {
        fileInput.click();
    });

    // เมื่อเลือกไฟล์ผ่านปุ่ม Browse
    fileInput.addEventListener('change', function() {
        const files = fileInput.files;
        addFilesToList(files); // จัดการไฟล์ที่ถูกเลือก
        fileInput.value = ''; // ล้างค่า fileInput เพื่อให้สามารถเลือกไฟล์เดิมได้อีกครั้ง
    });

    // ฟังก์ชันสำหรับป้องกันการทำงานปกติของ browser เมื่อมีการ drag เข้า
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // เพิ่มการตอบสนองเมื่อมีการลากไฟล์เข้ามาในกล่อง dropZone
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, function(e) {
            preventDefaults(e);
            dropZone.classList.add('dragover');
        });
    });

    // ยกเลิกการตอบสนองเมื่อไฟล์ถูกลากออกไปจากกล่อง dropZone
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, function(e) {
            preventDefaults(e);
            dropZone.classList.remove('dragover');
        });
    });

    // เมื่อไฟล์ถูกลากมาวางใน dropZone
    dropZone.addEventListener('drop', function(e) {
        preventDefaults(e);
        const files = e.dataTransfer.files;
        addFilesToList(files); // จัดการไฟล์ที่ถูกลากมาวาง
    });

    // ฟังก์ชันที่ใช้จัดการไฟล์และเพิ่มลงในรายการไฟล์
    function addFilesToList(files) {
        var allowedExtensions = ['application/pdf', 'image/jpeg', 'image/png'];
        for (let i = 0; i < files.length; i++) {
            var validFiles = true;
            if (!allowedExtensions.includes(files[i].type)) {
                alert('เฉพาะไฟล์ PDF, JPG, และ PNG เท่านั้น');
                validFiles = false;
            }
            files[i].old = false;
            if (!validFiles) return false;
            fileArray.push(files[i]); // เพิ่มไฟล์เข้าไปใน array
        }


        updateFileList(); // อัพเดตรายการไฟล์ที่แสดง
    }

    // ฟังก์ชันที่ใช้แสดงรายการไฟล์ที่ถูกเลือกทั้งหมด
    function updateFileList() {
        fileListElement.innerHTML = ''; // ล้างรายการไฟล์ก่อนหน้า
        if (fileArray.length === 0) {
            return; // ออกจากฟังก์ชันโดยไม่สร้างตาราง
        }
        const table = document.createElement('table');
        const div_table = document.createElement('div');
        div_table.classList.add('p-5', 'pt-0');
        table.classList.add('table');
        const thead = document.createElement('thead');
        const tbody = document.createElement('tbody');

        // สร้างหัวตาราง
        const headerRow = document.createElement('tr');
        const headers = ['ชื่อไฟล์', 'ขนาดไฟล์ (KB)', 'ดำเนินการ'];
        headers.forEach(headerText => {
            const th = document.createElement('th');
            th.textContent = headerText;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);

        // เพิ่มรายการไฟล์ในตาราง
        for (let i = 0; i < fileArray.length; i++) {
            const tr = document.createElement('tr');

            // ชื่อไฟล์
            const fileNameCell = document.createElement('td');
            if (fileArray[i].old == true) {
                const fileName = fileArray[i].name; // ใช้ชื่อไฟล์จาก fileArray
                const href = "<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=/var/www/uploads/hr/develop_file/dev_'); ?>" + dev_id + "<?php echo '/&doc='; ?>" + fileName;
                const previewPath = "<?php echo site_url($this->config->item('hr_dir') . 'Getpreview?path=/var/www/uploads/hr/develop_file/dev_'); ?>" + dev_id + "<?php echo '/&doc='; ?>" + fileName;
                const downloadPath = "<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=/var/www/uploads/hr/develop_file/dev_'); ?>" + dev_id + "<?php echo '/&doc='; ?>" + fileName;

                const anchor = document.createElement('a');
                anchor.classList.add('btn', 'btn-link');
                anchor.setAttribute('data-file-name', fileName);
                anchor.setAttribute('href', href);
                anchor.setAttribute('data-preview-path', previewPath);
                anchor.setAttribute('data-download-path', downloadPath);
                anchor.setAttribute('data-bs-toggle', 'modal');
                anchor.setAttribute('id', 'btn_preview_file');
                anchor.setAttribute('data-bs-target', '#preview_file_modal');
                anchor.setAttribute('title', 'คลิกเพื่อดูไฟล์เอกสารหลักฐาน');
                anchor.textContent = fileName;
                fileNameCell.appendChild(anchor); // เพิ่ม anchor ลงใน fileNameCell
            } else {
                fileNameCell.textContent = fileArray[i].name
            }
            tr.appendChild(fileNameCell);

            // ขนาดไฟล์
            const fileSizeCell = document.createElement('td');
            fileSizeCell.textContent = Math.round(fileArray[i].size / 1024); // ขนาดไฟล์ใน KB
            tr.appendChild(fileSizeCell);

            // ปุ่มลบไฟล์
            const actionCell = document.createElement('td');
            const removeButton = document.createElement('button');
            removeButton.classList.add('btn', 'btn-danger', 'btn-sm');
            removeButton.setAttribute('type', 'button');
            const icon = document.createElement('i');
            icon.classList.add('bi', 'bi-trash');

            removeButton.appendChild(icon);
            removeButton.addEventListener('click', function() {
                removeFile(i); // เรียกฟังก์ชันลบไฟล์
            });
            actionCell.appendChild(removeButton);
            tr.appendChild(actionCell);

            tbody.appendChild(tr);
        }
        table.appendChild(thead);
        table.appendChild(tbody);
        div_table.appendChild(table);
        fileListElement.appendChild(div_table); // แสดงตารางรายการไฟล์ที่เลือก
    }



    // ฟังก์ชันลบไฟล์ออกจาก array และอัพเดตรายการไฟล์
    function removeFile(index) {
        if (fileArray[index].old == true) {
            var file_name = fileArray[index].name
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการลบไฟล์เอกสารนี้ ใช่หรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "post",
                        url: '<?php echo site_url() . "/" . $controller_dir; ?>delete_devlop_file',
                        data: {
                            dev_id: dev_id,
                            file_name: file_name
                        }
                    }).done(function(data) {
                        dialog_success({
                            'header': text_toast_default_success_header,
                            'body': 'ลบไฟล์สำเร็จ'
                        });
                        fileArray.splice(index, 1); // ลบไฟล์จาก array
                        updateFileList(); // อัพเดตรายการไฟล์ที่แสดงใหม่
                    });
                }
            });
        } else {
            fileArray.splice(index, 1); // ลบไฟล์จาก array
            updateFileList(); // อัพเดตรายการไฟล์ที่แสดงใหม่
        }
    }


    function getpersonInfo(ps_id) {
        var person_div = document.getElementById('person_info');
        $.ajax({
            method: "post",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_info',
            data: {
                ps_id: ps_id
            }
        }).done(function(data) {
            data = JSON.parse(data);
            const div_person = document.getElementById('person_info')
            div_person.innerHTML = ``
            // Update your person_div with the returned data if necessary
        });
    }

    function calculateTotals() {
        // Array of IDs for the amount fields
        const amountIds = [
            'dev_budget',
            'dev_budget_vat',
            'dev_allowance',
            'dev_allowance_vat',
            'dev_accommodation',
            'dev_accommodation_vat',
            'dev_budget_type_other',
            'dev_budget_type_other_vat'
        ];

        // Initialize total and VAT variables
        let totalAmount = 0;
        let totalVAT = 0;

        // Iterate through each amount field to calculate the total
        amountIds.forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                // Remove commas from the value before parsing it
                let value = input.value.replace(/,/g, '');
                value = parseFloat(value) || 0; // Get value or default to 0

                if (id.endsWith('_vat')) {
                    totalVAT += value;
                } else {
                    totalAmount += value;
                }
            }
        });

        // Update total amount and VAT fields with commas and two decimal places
        document.getElementById('sum-cost').value = totalAmount.toLocaleString('en', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('sum-cost-vat').value = totalVAT.toLocaleString('en', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    // Calculate totals on document load
    document.addEventListener('DOMContentLoaded', calculateTotals);
    document.addEventListener("DOMContentLoaded", function() {
        // ตรวจสอบว่า input มีค่า value หรือไม่
        var dateInput = document.getElementById('dev_start_date');
        if (!dateInput.value) {
            // ถ้าไม่มีค่า ให้ตั้งค่าเป็นวันที่ปัจจุบัน
            var today = new Date().toISOString().split('T')[0]; // ได้วันที่ในรูปแบบ YYYY-MM-DD
            dateInput.value = today;
        }
    });

    // Recalculate totals when input fields change
    document.addEventListener('input', calculateTotals);
    document.getElementById('addP').addEventListener('click', function() {
        const div_person = document.getElementById('person_info')
        div_person.innerHTML = ''
        $('#personName').select2({
            placeholder: "เลือกชื่อคน",
            allowClear: true,
            theme: "bootstrap-5", // ใช้ธีม Bootstrap 5
            dropdownParent: $('#addPersonModal')
        });
    })
    document.getElementById('savePerson').addEventListener('click', function() {
        var ps_id = $('#personName').val()
        let found = false;
        if (dev_id != 'new') {
            $.ajax({
                method: "post",
                url: '<?php echo site_url() . "/" . $controller_dir; ?>check_person',
                data: {
                    ps_id: ps_id,
                    dev_id: dev_id,
                }
            }).done(function(data) {
                data = JSON.parse(data)
                if (data.data.status_response == 2) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'เลือกผู้เข้าร่วมซ้ำในโครงการ'
                    });
                    return 0;
                } else {
                    $.ajax({
                        method: "post",
                        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_info',
                        data: {
                            ps_id: ps_id
                        }
                    }).done(function(data) {
                        data = JSON.parse(data)
                        person_list.forEach(function(person) {
                            if (person.ps_id == parseInt(data.person.ps_id)) {
                                found = true;
                            }
                        });
                        if (found) {
                            dialog_error({
                                'header': text_toast_default_error_header,
                                'body': 'เลือกผู้เข้าร่วมซ้ำในโครงการ'
                            });
                            return 0;
                        }
                        var table = document.getElementById("paticipate");
                        var rowCount = table.getElementsByTagName("tr").length;
                        var row = table.insertRow(-1); // Insert new row at the end
                        var cell1 = row.insertCell(0); // Insert cell for name
                        var cell2 = row.insertCell(1); // Insert cell for age
                        var cell3 = row.insertCell(2); // Insert cell for age
                        // var cell4 = row.insertCell(3); // Insert cell for age
                        // var cell5 = row.insertCell(4); // Insert cell for age
                        // var cell6 = row.insertCell(5); // Insert cell for cell
                        var cell7 = row.insertCell(3);
                        var cell8 = row.insertCell(4);
                        cell1.innerHTML = rowCount;
                        cell1.style.textAlign = "center";
                        cell2.innerHTML = data.person.detail.pos_ps_code;
                        cell3.innerHTML = data.person.pf_name_abbr + ' ' + data.person.ps_fname + ' ' + data.person.ps_lname
                        // cell4.innerHTML = ''
                        // cell5.innerHTML = ''
                        // cell6.innerHTML = ''
                        cell7.innerHTML = ''
                        cell8.innerHTML = `<button class="btn btn-sm btn-danger delPerson" data-id="${data.person.ps_id}"><i class="bi bi-trash"> </i> </button>`
                        cell8.style.textAlign = "center";

                        var newPerson = {
                            'ps_id': parseInt(data.person.ps_id),
                            'devps_status': 1,
                            'check': 'new',
                            "pos_ps_code": "TEST",
                            "ps_name": data.person.ps_fname + ' ' + data.person.ps_lname,
                            "hire_name": "ศัลยแพทย์"
                        };
                        person_list.push(newPerson);
                        dialog_success({
                            'header': text_toast_default_success_header,
                            'body': 'เพิ่มผู้เข้าร่วมสำเร็จ'
                        });
                        $('#addPersonModal').modal('hide');

                    })
                }
            })
        } else {
            $.ajax({
                method: "post",
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_info',
                data: {
                    ps_id: ps_id
                }
            }).done(function(data) {
                data = JSON.parse(data)
                person_list.forEach(function(person) {
                    if (person.ps_id == parseInt(data.person.ps_id)) {
                        found = true;
                    }
                });
                if (found) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'เลือกผู้เข้าร่วมซ้ำในโครงการ'
                    });
                    return 0;
                }

                var table = document.getElementById("paticipate");
        

                var rowCount = table.getElementsByTagName("tr").length;
                var row = table.insertRow(-1); // Insert new row at the end
                var cell1 = row.insertCell(0); // Insert cell for name
                var cell2 = row.insertCell(1); // Insert cell for age
                var cell3 = row.insertCell(2); // Insert cell for age
                // var cell4 = row.insertCell(3); // Insert cell for age
                // var cell5 = row.insertCell(4); // Insert cell for age
                // var cell6 = row.insertCell(5); // Insert cell for cell
                var cell7 = row.insertCell(3);
                var cell8 = row.insertCell(4);
                cell1.innerHTML = rowCount;
                cell1.style.textAlign = "center";
                cell2.innerHTML = data.person.pos_ps_code;
                cell3.innerHTML = data.person.pf_name_abbr + ' ' + data.person.ps_fname + ' ' + data.person.ps_lname
                // cell4.innerHTML = ''
                // cell5.innerHTML = ''
                // cell6.innerHTML = ''
                cell7.innerHTML = ''
                cell8.innerHTML = `<button class="btn btn-sm btn-danger delPerson" data-id="${data.person.ps_id}"><i class="bi bi-trash"> </i> </button>`
                cell8.style.textAlign = "center";
                var newPerson = {
                    'ps_id': parseInt(data.person.ps_id),
                    'devps_status': 1,
                    'check': 'new',
                    "pos_ps_code": "TEST",
                    "ps_name": data.person.ps_fname + ' ' + data.person.ps_lname,
                    "hire_name": "ศัลยแพทย์"
                };
                person_list.push(newPerson);
                dialog_success({
                    'header': text_toast_default_success_header,
                    'body': 'เพิ่มผู้เข้าร่วมสำเร็จ'
                });
                $('#addPersonModal').modal('hide');

            })
        }
    })

    function convertThaiDateToISO(thaiDate) {
        // แยกส่วนวัน, เดือน, และปีจากวันที่ไทย
        const parts = thaiDate.split('/');
        const day = parts[0];
        const month = parts[1];
        const year = parseInt(parts[2], 10) - 543; // ลบด้วย 543 เพื่อเปลี่ยนเป็นปีสากล

        // รวมกลับเป็นวันที่ในรูปแบบ ISO
        const isoDate = `${year}-${month}-${day}`;
        return isoDate;
    }
    document.getElementById('submit-develop').addEventListener('click', function() {
        const develop_info = {}
        $('[name^="inputField"]').each(function() {
            develop_info[this.id] = this.value;
        });


        if (develop_info['dev_start_date'] == '' || develop_info['dev_end_date'] == '' || develop_info['dev_topic'] == '' ||
            develop_info['dev_pv_id'] == 'none' || develop_info['dev_country_id'] == 'none' || develop_info['dev_project'] == '' ||
            develop_info['dev_end_time'] == '' || develop_info['dev_hour'] == 0 || develop_info['dev_hour'] == ''
        ) {

            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return 0;
        }
        develop_info['dev_start_date'] = convertThaiDateToISO(develop_info['dev_start_date'])
        develop_info['dev_end_date'] = convertThaiDateToISO(develop_info['dev_end_date'])
        develop_info['dev_accommodation'] = develop_info['dev_accommodation'].replace(/,/g, '')
        develop_info['dev_accommodation_vat'] = develop_info['dev_accommodation_vat'].replace(/,/g, '')
        develop_info['dev_allowance'] = develop_info['dev_allowance'].replace(/,/g, '')
        develop_info['dev_allowance_vat'] = develop_info['dev_allowance_vat'].replace(/,/g, '')
        develop_info['dev_budget'] = develop_info['dev_budget'].replace(/,/g, '')
        develop_info['dev_budget_vat'] = develop_info['dev_budget_vat'].replace(/,/g, '')
        develop_info['dev_budget_type_other'] = develop_info['dev_budget_type_other'].replace(/,/g, '')
        develop_info['dev_budget_type_other_vat'] = develop_info['dev_budget_type_other_vat'].replace(/,/g, '')
        develop_info['dev_id'] = dev_id
        develop_info['service_type'] = getSelectedRadioValue('service_type');
        develop_info['dev_type'] = getSelectedRadioValue('dev_type');
        develop_info['dev_certi'] = getSelectedRadioValue('dev_certi');
        develop_info['dev_organized'] = getSelectedRadioValue('dev_organized');
        develop_info['dev_person_list'] = person_list
        if (valid == true) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            method: "post",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>submit_develop_form',
            data: develop_info
        }).done(function(data) {
            var formData = new FormData();
            var data = JSON.parse(data)

            formData.append('dev_id', data.data.dev_id);
            // Append files from fileArray to the FormData
            fileArray.forEach(function(file, index) {
                formData.append('files[]', file); // Correctly append each file
            });
            // for (var pair of formData.entries()) {
            //     console.log(pair[0] + ': ' + pair[1]);
            // }

            $.ajax({
                method: "post",
                url: '<?php echo site_url() . "/" . $controller_dir; ?>upload_file',
                data: formData,
                processData: false, // ปิดการประมวลผลข้อมูล
                contentType: false, // ปิดการตั้งค่า content type เพื่อให้เบราว์เซอร์จัดการเอง
            }).done(function(data) {
                dialog_success({
                    'header': text_toast_default_success_header,
                    'body': 'บันทึกข้อมูลสำเร็จ'
                });
                // setInterval(function() {
                //     location.reload(); // Reloads the current page
                // }, 1000);
                return 0;
            })
        })
        // ลูปผ่านฟิลด์และดึงค่า
    })
    document.getElementById('paticipate').addEventListener('click', function(event) {
        if (event.target.closest('.delPerson')) {
            // ลบแถวที่ปุ่มลบอยู่
            var button = event.target.closest('.delPerson');
            var dataId = button.getAttribute('data-id');
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการลบผู้เข้าร่วมคนนี้ ใช่หรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    var index = person_list.findIndex(item => item.ps_id == dataId);

                    if (index !== -1) {
                        if (person_list[index].check === 'new') {
                            person_list.splice(index, 1);
                        } else {
                            person_list[index].devps_status = 0;
                        }
                    }

 

                    // ลบแถวที่ปุ่มลบอยู่
                    var row = button.closest('tr');
                    row.remove();
                }
            });
        }
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

    function getSelectedRadioValue(name) {
        var selectedRadio = $(`input[name="${name}"]:checked`);
        if (selectedRadio.val() == '' || selectedRadio.val() == null) {
            valid = true;
        }
        return selectedRadio.length ? selectedRadio.val() : null;
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

    //อัพเดท Doc code template
    function updateDocTemp() {
        var trainingType = document.querySelector('input[name="dev_organized"]:checked').value;
        var trainingDate = document.getElementById('dev_start_date').value;
        if (trainingDate) {
            // แยกวันที่ออกเป็นปี, เดือน, และวัน
            var dateParts = trainingDate.split('/');
            var year = parseInt(dateParts[2]); // เปลี่ยนเป็น พ.ศ.
            var shortYear = year.toString().slice(-2); // เอาแค่ 2 หลักท้าย
            var month = dateParts[1];
            var day = dateParts[0];

            // รวมวันและเดือนเป็น ddmm
            var formattedDate = day + month;

            if (trainingType === "1") {
                // ภายในโรงพยาบาล
                document.getElementById('doc_temp').innerText = "IN-" + formattedDate + shortYear;
            } else if (trainingType === "2") {
                // ภายนอกโรงพยาบาล
                document.getElementById('doc_temp').innerText = "PU-" + formattedDate + shortYear;
            }
        }
    }
    // ฟังเหตุการณ์เมื่อรูปแบบการฝึกอบรมหรือวันที่ถูกเลือก
    document.querySelectorAll('input[name="dev_organized"]').forEach(function(radio) {
        radio.addEventListener('change', updateDocTemp);
    });

    document.getElementById('dev_start_date').addEventListener('change', updateDocTemp);

    // เรียกใช้ฟังก์ชันเพื่อกำหนดค่าเริ่มต้นของ doc_temp
    document.addEventListener("DOMContentLoaded", function() {
        updateDocTemp();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const currencyInputs = document.querySelectorAll('.currency-input');

        function formatCurrencyInput(input) {
            let value = input.value.replace(/,/g, ''); // ลบจุลภาคทั้งหมดก่อน
            if (!isNaN(value) && value !== '') {
                // แปลงตัวเลขให้มีทศนิยม 2 ตำแหน่งพร้อมจุลภาค
                input.value = parseFloat(value).toLocaleString('en', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        }

        function restrictToNumbers(input) {
            let value = input.value.replace(/[^0-9.]/g, ''); // ลบตัวอักษรที่ไม่ใช่ตัวเลขและจุดทศนิยม
            input.value = value;
        }
        // เรียกฟังก์ชันฟอร์แมตทันทีเมื่อหน้าเว็บโหลดสำหรับทุก input ที่มีค่าเริ่มต้น
        currencyInputs.forEach(input => {
            if (input.value) {
                formatCurrencyInput(input);
            }

            // ฟอร์แมต input เมื่อออกจากช่อง (blur)
            input.addEventListener('blur', function() {
                formatCurrencyInput(input);
            });

            // ลบจุลภาคเมื่อโฟกัสที่ input
            input.addEventListener('focus', function() {
                input.value = input.value.replace(/,/g, '');
            });

            // ตรวจสอบและห้ามไม่ให้กรอกตัวอักษร (text)
            input.addEventListener('input', function() {
                restrictToNumbers(input);
            });
        });
    });

    function getFileList() {
        $.ajax({
            method: "post",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_file_list_by_dev_id',
            data: {
                dev_id: dev_id
            }
        }).done(function(returnData) {
            data = JSON.parse(returnData);
            data.data.dev_file.forEach(element => {
                element.old = true
                fileArray.push(element);
            });
            updateFileList()

        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('dev_see_place');
        const placeInput = document.getElementById('dev_place');
        const countrySelect = $('#dev_country_id');
        const provinceSelect = $('#dev_pv_id');

        function updateFields() {
            if (checkbox.checked) {
                // Set the values and disable the fields
                placeInput.value = 'โรงพยาบาลจักษุสุราษฎร์';
                placeInput.disabled = true;

                // Set and disable Select2 fields for country and province
                countrySelect.val('7').trigger('change'); // Assuming 'TH' is the country code for Thailand
                countrySelect.prop('disabled', true);

                provinceSelect.val('67').trigger('change'); // Assuming 'SUR' is the province code for Surat Thani
                provinceSelect.prop('disabled', true);
            } else {
                // Enable the fields and allow users to change them
                placeInput.disabled = false;
                countrySelect.prop('disabled', false);
                provinceSelect.prop('disabled', false);
            }
        }
        // Initialize the fields based on the current checkbox status
        updateFields();
        getFileList()
        // Listen for checkbox change
        checkbox.addEventListener('change', updateFields);
    });
</script>