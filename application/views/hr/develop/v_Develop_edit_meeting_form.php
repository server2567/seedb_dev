<div class="row">
    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-12 mb-1">
                <label for="">ชื่อ-นามสกุล:</label>
            </div>
            <div class="col-md-12">
                <input type="text" value="<?= $name ?>" class="form-control" disabled>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 mb-1">
                <label for="">วันที่ประชุม:</label>
            </div>
            <div class="col-md-12">
                <input type="date" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 mb-1">
                <label for="">วันที่สิ้นสุดประชุม:</label>
            </div>
            <div class="col-md-12">
                <input type="date" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-2">
    <label for="" require>ประเภทงบประมาณ :</label><br>
        <input class="form-check-input mb-2" type="radio" name="budget">
        <label for="">งบประมาณโรงพยาบาลจักษุสุราษฏร์</label> <br>
        <input type="radio" class="form-check-input" name="budget">
        <label for="">งบประมาณของตนเอง</label>
    </div>
    <div class="col-md-6 mb-2">
        จำนวนงบประมาณ : <br>
        <div class="input-group date input-daterange mt-2">
            <span class="input-group-text">$</span>
            <input type="number" class="form-control" name="budget">
            <span class="input-group-text">.00 บาท</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 mb-1">
                <label for="">จำนวน (ชั่วโมง : นาที)</label>
            </div>
            <div class="col-1"></div>
            <div class="col-md-3">
                <input type="number" class="form-control">
            </div>
            <div class="col-md-1 text-center">
                <h3>:</h3>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 mb-1">
                <label>
                    <input type="checkbox" class="form-check-input" id="myCheckbox" value="11"> คำนวณชั่วโมงอัติโนมัติ
                </label>
            </div>
            <div class="col-md-12 autoDate" hidden>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-md-2">
                        <span for="">1 วันเท่ากับ</span>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <span for="">ชั่วโมง</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#myCheckbox').change(function() {
        // ตรวจสอบว่า checkbox ถูกเลือกหรือไม่
        if ($(this).is(':checked')) {
            // ค้นหา element ที่มีคลาสชื่อ autoDate และลบ attribute hidden
            $('.autoDate').removeAttr('hidden');
        } else {
            $('.autoDate').attr('hidden', true);
        }
    });
</script>