<div class="card">
    <div class="card-body">
        <h5 class="card-title">ปฏิทินการทำงาน</h5>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month" type="button" role="tab" aria-controls="month" aria-selected="true">เดือน</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="week-tab" data-bs-toggle="tab" data-bs-target="#week" type="button" role="tab" aria-controls="week" aria-selected="false">สัปดาห์</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="day-tab" data-bs-toggle="tab" data-bs-target="#day" type="button" role="tab" aria-controls="day" aria-selected="false">รายวัน</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabContent">
            <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.
            </div>
            <div class="tab-pane fade show active" id="week" role="tabpanel" aria-labelledby="week-tab">
                <?php $this->load->view($view_dir."v_timework_calendar_week_tab",true); ?>
            </div>
            <div class="tab-pane fade" id="day" role="tabpanel" aria-labelledby="day-tab">
                Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
            </div>
        </div>
    </div>
</div>