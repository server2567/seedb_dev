<style>
    .card-tabs ul.nav-tabs {
        border-top-right-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
        border-top-left-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
    }
    .card-tabs li button.nav-link, .card-tabs .nav-item-left {
        padding: 14px 1.25rem;
    }
    .card-tabs .nav-tabs {
        font-weight: bold;
    }
    .card-tabs .card-body {
        padding: 0 1.25rem var(--bs-card-spacer-y) 1.25rem;
    }
    
    .card form button.accordion-button:not(.collapsed) {
        color: var(--bs-primary);
    }
    
</style>
<!-- display: flex !important; -->
<div class="card card-tabs">
    <ul class="nav nav-tabs nav-tabs-bordered bg-primary-light" id="borderedTab" role="tablist">
        <div class="nav-item-left">
            <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($NgID) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลกลุ่มการมองเห็นข่าวสาร</span>
        </div>
        <div class="nav-item-right">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab">แก้ไขข้อมูลผู้ใช้</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#permission" type="button" role="tab">กลุ่มระบบงานของผู้ใช้</button>
            </li>
        </div>
    </ul>
    <div class="card-body">
        <form class="needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/News_newsgroup/update">   <!-- id="validate-form" data-parsley-validate   -->
            <div class="tab-content">
                <div class="tab-pane fade row g-33 show active" id="data" role="tabpanel">
                    <div class="row g-3">
                    <div class="col-md-6">
                            <label for="NgNameT" class="form-label required">ชื่อกลุ่มการมองเห็น(ท)</label>
                            <input type="text" class="form-control" name="NgNameT" id="NgNameT" placeholder="ชื่อกลุ่มการมองเห็นภาษาไทย" value="<?php echo !empty($edit) ? $edit['NgNameT'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="NgNameE" class="form-label required">ชื่อกลุ่มการมองเห็น(E)</label>
                            <input type="text" class="form-control" name="NgNameE" id="NgNameE" placeholder="ชื่อกลุ่มการมองเห็นภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['NgNameE'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="NgDesc" class="form-label">คำอธิบาย</label>
                            <input type="text" class="form-control" name="NgDesc" id="NgDesc" placeholder="คำอธิบายกลุ่มการมองเห็น" value="<?php echo !empty($edit) ? $edit['NgDesc'] : "" ;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="NgActive" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="NgActive" id="NgActive">
                                <label for="NgActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade row g-" id="permission" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="IsAllPeople" id="IsAllPeople">
                                <label class="form-check-label" for="IsAllPeople">ประชาชนทั่วไป</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="IsAllPeople" id="IsAllPeople">
                                <label class="form-check-label" for="IsAllPeople">บุคลากรของโรงพยาบาลทั้งหมด</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                        </div>
                        <div class="col-md-12">
                            <label for="" class="form-label"><b>กลุ่มตำแหน่ง</b></label>
                        </div>
                        <div class="col-md-6 position-group">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-1">
                                    <button class="accordion-button bg-warning-subtle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1">
                                        จักษุแพทย์
                                    </button>
                                    </h2>
                                    <div id="collapse-1" class="accordion-collapse collapse" aria-labelledby="heading-1">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="PositionID-1" id="PositionID-1">
                                                <label class="form-check-label" for="PositionID-1">จักษุแพทย์ เชี่ยวชาญการผ่าตัดต้อกระจก</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="PositionID-5" id="PositionID-5">
                                                <label class="form-check-label" for="PositionID-5">จักษุแพทย์เฉพาะทางด้านโรคกระจกตา</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="PositionID-6" id="PositionID-6">
                                                <label class="form-check-label" for="PositionID-6">จักษุแพทย์เฉพาะทางด้านโรคเส้นประสาทตา</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 position-group">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-2">
                                    <button class="accordion-button bg-warning-subtle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2">
                                        โสต ศอ นาสิกแพทย์
                                    </button>
                                    </h2>
                                    <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="PositionID-2" id="PositionID-2">
                                                <label class="form-check-label" for="PositionID-2">โสต ศอ นาสิกแพทย์</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 position-group">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-3">
                                    <button class="accordion-button bg-warning-subtle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3">
                                        รังสีแพทย์
                                    </button>
                                    </h2>
                                    <div id="collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="PositionID-3" id="PositionID-3">
                                                <label class="form-check-label" for="PositionID-3">รังสีวิทยาทั่วไป (General X-Ray)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 position-group">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-4">
                                    <button class="accordion-button bg-warning-subtle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-4">
                                    ทันตแพทย์
                                    </button>
                                    </h2>
                                    <div id="collapse-4" class="accordion-collapse collapse" aria-labelledby="heading-4">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="PositionID-4" id="PositionID-4">
                                                <label class="form-check-label" for="PositionID-4">ทันตแพทย์</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-3 col-md-12">
                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/News_newsgroup'">ย้อนกลับ</button>
                <button type="submit" class="btn btn-success float-end">บันทึก</button>
            </div>
        </form>
    </div>
</div>