<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-folder2-open icon-menu"></i><span>  ข้อมูลเครื่องมือหัตถการ</span><span class="badge bg-success"><?php echo count($equipments); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body pt-4">
                    <table class="table" width="100%">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center">#</th>
                                <th width="40%">ชื่อเครื่องมือหัตถการ</th>
                                <th width="40%">
                                    ชื่อโฟลเดอร์สำหรับจัดเก็บไฟล์
                                    <!-- <p class="text-primary fw-bold ms-4"> *** กรณีชื่อโฟลเดอร์มีช่องว่าง (Spacebar) ควรเขียนด้วย "_" แทน</p> -->
                                </th>
                                <!-- <th width="10%" class="text-center">ดำเนินการ</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach ($equipments as $row) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td><?php echo $row['eqs_name']; ?></td>
                                <td>
                                    <?php echo $row['eqs_folder']; ?>
                                    <!-- <input type="text" class="form-control" name="eqs_folder[]" id="eqs_folder[<?php //echo $i; ?>]" placeholder="ระบุชื่อโฟลเดอร์" value="<?php //echo $row['eqs_folder']; ?>"> -->
                                </td>
                                <!-- <td class="text-center option">
                                    <button class="btn btn-success" title="บันทึกข้อมูล" onclick=""><i class="bi-floppy2-fill"></i></button>
                                    <button class="btn btn-info" title="เชื่อมโยง" onclick=""><i class="bi-bounding-box"></i></button>
                                </td> -->
                            </tr>
                            <?php 
                                $i++; } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>