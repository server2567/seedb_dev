<?php 
function getCharTypeValue($string) {
    $hasNumber = preg_match('/[0-9]/', $string);
    $hasLowercase = preg_match('/[a-z]/', $string);
    $hasUppercase = preg_match('/[A-Z]/', $string);
    $hasThai = preg_match('/[\x{0E00}-\x{0E7F}]/u', $string);

    if ($hasNumber) {
        return 'number';
    } elseif ($hasLowercase) {
        return 'lowercase';
    } elseif ($hasUppercase) {
        return 'uppercase';
    } elseif ($hasThai) {
        return 'thai';
    } else {
        return 'unknown';
    }
}
 ?>
<div class="card">

    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span>จัดการรูปแบบเลขนัดหมาย</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/que/Tracking_manage/update_format/<?php echo $info[0]->ct_id; ?>">
                        <div class="row justify-content-center mt-2">
                            <div class="col-md-4">
                                <label for="numPositions" class="form-label required">จำนวนตำแหน่ง</label>
                                <select name="ct_value_count" class="form-control" id="numPositions" onchange="updatePositions()" required>
                                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                                        <option value="<?= $i ?>"<?php if (isset($info) && isset($info[0]->ct_value) && count($info[0]->ct_value) == $i) { echo "selected"; } ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div id="positionsContainer">
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <div class="row justify-content-center mt-2 position-row" id="positionRow<?= $i ?>" style="display: none;">
                                    <div class="col-md-4">
                                        <label for="length_pos<?= $i ?>" class="form-label required">เลือกจำนวนตัวอักษร <?= $i ?></label>
                                        <select type="text" class="form-control" name="length_pos<?= $i ?>" id="length_pos<?= $i ?>" placeholder="ระบุชื่อชนิดเลขนัดหมาย" onchange="updateExample(<?= $i ?>)" required>
                                            <option disabled selected value=" " <?php if (is_null($info[0]->ct_value)) echo "selected"; ?> selected>-- เลือกจำนวนตัวอักษร <?= $i ?> --</option>
                                            <?php for ($f = 1; $f <= 10; $f++) : ?>
                                                <option <?php if (!is_null($info[0]->ct_value) && isset($info[0]->ct_value[$i - 1]) && $info[0]->ct_value[$i - 1]->char_length == $f) echo 'selected'; ?> value="<?php echo $f ?>"> <?php echo $f; ?> </option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pos<?= $i ?>" class="form-label required">เลขนัดหมายตำแหน่งที่ <?= $i ?></label>
                                        <select type="text" class="form-control" name="pos<?= $i ?>" id="pos<?= $i ?>" placeholder="ระบุชื่อชนิดเลขนัดหมาย" onchange="updateExample(<?= $i ?>)" required>
                                            <option data-type-value="now" value=" " disabled <?php if (is_null($info[0]->ct_value)) echo "selected"; ?> selected>- เลือกตำแหน่งที่ <?= $i ?> ---</option>
                                            
                                            <?php if (isset($type)) {
                                                foreach ($type as $item) : ?>
                                                    <option data-type-value="<?php if (is_object($item->type_value) && isset($item->type_value->value)) {
                                                                                     if (!is_null($info[0]->ct_value) && isset($info[0]->ct_value[$i - 1]) && $item->type_code=='rn' && getCharTypeValue($item->type_value->value)==getCharTypeValue($info[0]->ct_value[$i - 1]->char_type_value)) { 
                                                                                        echo $info[0]->ct_value[$i - 1]->char_type_value; 
                                                                                    } else { 
                                                                                        echo $item->type_value->value;  
                                                                                    } 
                                                                                        
                                                                                    
                                                                                } else if (is_string($item->type_value)) {
                                                                                    if ($item->type_value == "ปีปฏิทิน") {
                                                                                        $date = date('Y') + 543;
                                                                                        echo $date;
                                                                                    } else if ($item->type_value == "ปีงบประมาณ") {
                                                                                        $date = date('Y') + 543;
                                                                                        if (date('m') > 9) {
                                                                                            $date++;
                                                                                        }
                                                                                        echo $date;
                                                                                    }
                                                                                } else if (is_array($item->type_value)) {
                                                                                    $number = "0123456789";
                                                                                    $lowercase = "abcdefghijklmnopqrstuvwxyz";
                                                                                    $uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                                                                    $characters = $number . $lowercase . $uppercase;
                                                                                    $charactersLength = mb_strlen($characters, 'utf-8');
                                                                                    $randomString = '';
                                                                                    for ($j = 0; $j < 15; $j++) {
                                                                                        $randomString .= mb_substr($characters, rand(0, $charactersLength - 1), 1, 'utf-8');
                                                                                    }
                                                                                    echo $randomString;
                                                                                } else if (is_null($item->type_value)) {
                                                                                    if (!is_null($info[0]->ct_value) && isset($info[0]->ct_value[$i - 1]) && $info[0]->ct_value[$i-1]->char_type == 'fx') { 
                                                                                        echo $info[0]->ct_value[$i - 1]->char_type_value; 
                                                                                    } else { 
                                                                                        echo NULL; 
                                                                                    } 
                                                                                } ?>"data-type-code="<?php echo $item->type_code ?>" value="<?php echo $item->type_id ?>" <?php if (!is_null($info[0]->ct_value) && isset($info[0]->ct_value[$i - 1]) && $info[0]->ct_value[$i - 1]->char_id == $item->type_id) echo 'selected'; ?>><?php echo $item->type_name ?></option>
                                            <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" id="lb<?= $i ?>">ตัวอย่าง</label>
                                        <input class="form-control" name="ex<?= $i ?>" id="ex<?= $i ?>" value=" " placeholder="ระบุเลขนัดหมาย" readonly required>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-3 d-flex align-items-center justify-content-center mt-4">
                                <button type="button" class="btn btn-info" onclick="updateCtValue()">ตรวจสอบรูปแบบเลขนัดหมาย</button>
                            </div>
                            <div class="col-md-4">
                                <label for="StNameT" class="form-label required"> ตัวอย่างรูปแบบเลขนัดหมาย </label>
                                <input type="text" class="form-control" name="ct_value" id="ct_value" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="type_code" class="form-label ">เลขที่ใช้ปัจจุบัน</label>
                                <input disabled readonly class="form-control" name="current_track" value="<?= isset($current_code) ? $current_code[0]['cl_code'] : '' ?>" id="curent_track">
                            </div>
                            
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/que/Tracking_manage'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updateExample(pos) {
        var select = document.getElementById('pos' + pos);
        var exampleInput = document.getElementById('ex' + pos);
        var exampleLabel = document.getElementById('lb' + pos);
        var lengthSelect = document.getElementById('length_pos' + pos)
        var selectedOption = select.options[select.selectedIndex];
        var typeValue = selectedOption.getAttribute('data-type-value');
        var typeCode = selectedOption.getAttribute('data-type-code');
        var selectedLength = lengthSelect.options[lengthSelect.selectedIndex].value;

        if (typeValue === "now") {
            exampleInput.value = " ";
            exampleInput.placeholder = "โปรดเลือกประเภทเลขนัดหมาย";
            exampleLabel.innerHTML = "‎ ";
            exampleInput.disabled = true;
            exampleInput.readOnly = true;

        } else if (typeValue && typeValue.length === 15) {
            var randomString = '';
            var characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var charactersLength = characters.length;
            for (var i = 0; i < selectedLength; i++) {
                randomString += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            exampleInput.value = randomString;
            exampleInput.readOnly = true;
            exampleInput.disabled = false;
            exampleInput.maxLength = selectedLength;
        } else if (typeCode && typeCode == 'rn' ) {
            if (typeValue.length < selectedLength) {
            typeValue = typeValue.padStart(selectedLength, '0');
        }
            exampleInput.value = typeValue;
            exampleInput.readOnly = true;
            exampleInput.disabled = false;
            exampleInput.maxLength = selectedLength;
        }else if (typeValue) {
            exampleInput.value = typeValue;
            exampleInput.readOnly = false;
            exampleInput.disabled = false;
            exampleInput.maxLength = selectedLength;
        } else {
            exampleInput.value = '';
            exampleInput.maxLength = selectedLength;
            exampleLabel.innerHTML = "‎ ";
            exampleInput.readOnly = false;
            exampleInput.placeholder = "ระบุหมายเลขนัดหมาย";
            exampleInput.disabled = false;
        }
    }

    window.onload = function() {
        initializeForm();
    }
    function initializeForm() {
        
        for (var i = 1; i <= 10; i++) {
            var row = document.getElementById('positionRow' + i);
            if (row) {
                row.style.display = 'flex';
            }
            updateExample(i); // Initialize the example for each row
        }

        updatePositions();
    }

    function updatePositions() {
        var numPositions = document.getElementById('numPositions').value;
        let isCtValueAvailable
        <?php
        // PHP logic here to determine the condition
        $isCtValueAvailable = [];
        for ($i = 0; $i < 10; $i++) {
            if (isset($info[0]->ct_value[$i])) {
                $isCtValueAvailable[] = $info[0]->ct_value[$i];
            }
        };
        ?>
        isCtValueAvailable = <?= json_encode($isCtValueAvailable) ?>;
        for (var i = 1; i <= 10; i++) {
            var row = document.getElementById('positionRow' + i);
            var select = document.getElementById('length_pos' + i);
            var type = document.getElementById('pos' + i);
            if (i <= numPositions) {
                row.style.display = '';
                type.className = 'form-select';
                select.className = 'form-select';
            } else {
                if (isCtValueAvailable) {
                    row.style.display = 'none';
                    type.className = 'form-control';
                    select.className = 'form-control';
                } else {
                    row.style.display = 'none';
                    type.value = " ";
                    select.value = " ";
                    type.className = 'form-control';
                    select.className = 'form-control';
                }
            }
        }
        console.log(isCtValueAvailable);
        updateCtValue();

    }
    document.addEventListener('DOMContentLoaded', function() {
        updatePositions();
        for (let i = 1; i <= 10; i++) {
            document.getElementById('pos' + i).addEventListener('change', function() {
                updateExample(i);

            });
        }
    });

    function updateCtValue() {
        let ctValueInput = document.getElementById('ct_value');
        let ctValue = '';
        for (let i = 1; i <= 10; i++) {
            let exValue = document.getElementById('ex' + i).value;
            if (document.getElementById('positionRow' + i).style.display !== 'none') {
                ctValue += exValue;
            }
        }
        ctValueInput.value = ctValue;
    }
</script>