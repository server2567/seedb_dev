<div class="row">
    <div class="col-md-6">
        <label for=""><?= isset($type) && $type == '1' ? 'รายการรายจ่าย' : 'รายการรายจ่าย' ?></label>
        <select class="form-select select2" name="" id="expenseId">
            <option selected disabled value="-1">-- เลือกรายจ่าย --</option>
            <option value="1">test</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="">จำนวนเงิน</label>
        <input type="number" class="form-control" id="expenseCost">
    </div>
    <div class="col-md-12">
        <label for="">คำอธิบาย</label>
        <textarea class="form-control" id="expenseDetail"> </textarea>
    </div>
</div>