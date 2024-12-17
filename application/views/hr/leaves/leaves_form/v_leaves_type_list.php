<style>
    .leave1 {
        color: #4154f1;
        background: #f6f6fe;
    }

    .leave2 {
        color: #2eca6a;
        background: #e0f8e9;
    }

    .leave3 {
        color: #ff771d;
        background: #ffecdf;
    }

    .leave4 {
        color: #fa5278;
        background: #ffe0e7;
    }

    .leave5 {
        color: #4154f1;
        background: #f6f6fe;
    }

    .leave6 {
        color: #2eca6a;
        background: #e0f8e9;
    }

    .card:hover {
        background-color: #f0f6ff;
    }

    .info-card {
        cursor: pointer;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-card-list icon-menu"></i><span> รายการประเภทการลา ประจำปีปฏิทิน พ.ศ. <?= date('Y')+543 ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <section class="section dashboard">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">

                                    <?php
                                    if (count($leave_type_list) == 0) {
                                        echo "<div class='text-center mt-5 mb-5'><h4><font color='red'>ยังไม่กำหนดจำนวนวันลา ประจำปีปฏิทิน พ.ศ. " . ((new DateTime())->format("Y") + 543) . " กรุณาแจ้งเจ้าหน้าที่ทรัพยากรบุคคล</font></h4></div>";
                                    } else {
                                        $seq = 0;

                                        foreach ($leave_type_list as $key => $row) {
                                            $seq++;
                                            $text_class = "";

                                            if ($row->lsum_per_day == "-99" || $row->lsum_per_day == "-99" || $row->lsum_per_day == "-99") {
                                                $remain_percentage = 100;
                                                $text_per = "ลาได้ไม่จำกัดสิทธิ์";
                                                $text_class = "success";
                                                $text_remain = '<i class="bi bi-infinity"></i>';
                                            } else {
                                                // Calculate total remaining time in minutes, considering 1 day = 8 hours
                                                $total_remain_minutes = ($row->lsum_remain_day * 8 * 60) + ($row->lsum_remain_hour * 60) + $row->lsum_remain_minute;
                                                $total_per_minutes = ($row->lsum_per_day * 8 * 60) + ($row->lsum_per_hour * 60) + $row->lsum_per_minute;

                                                // Calculate the remaining percentage
                                                $remain_percentage = $total_per_minutes > 0 ? ($total_remain_minutes / $total_per_minutes) * 100 : 0;

                                                // Determine the color class based on the percentage
                                                if ($remain_percentage > 50) {
                                                    $text_class = "success";
                                                } else if ($remain_percentage >= 21 && $remain_percentage <= 49) {
                                                    $text_class = "warning";
                                                } else {
                                                    $text_class = "danger";
                                                }

                                                $text_remain = "";
                                                if ($row->lsum_remain_day == 0) {
                                                    $text_remain .= "คงเหลือ ";
                                                } else {
                                                    $text_remain .= "คงเหลือ " . $row->lsum_remain_day . " วัน ";
                                                }
                                                if ($row->lsum_remain_hour != 0) {
                                                    $text_remain .= $row->lsum_remain_hour . " ชั่วโมง ";
                                                }
                                                if ($row->lsum_remain_minute != 0) {
                                                    $text_remain .= $row->lsum_remain_minute . " นาที ";
                                                }

                                                if ($row->lsum_remain_day == 0 && $row->lsum_remain_hour == 0 && $row->lsum_remain_minute == 0) {
                                                    $text_remain = "หมดสิทธิ์การลา";
                                                }

                                                $text_per = "";
                                                if ($row->lsum_per_day != 0) {
                                                    $text_per .= $row->lsum_per_day . " วัน ";
                                                }
                                                if ($row->lsum_per_hour != 0) {
                                                    $text_per .= $row->lsum_per_hour . " ชั่วโมง ";
                                                }
                                                if ($row->lsum_per_minute != 0) {
                                                    $text_per .= $row->lsum_per_minute . " นาที ";
                                                }

                                                $text_per .= "จำนวนสิทธิ์การลาที่ได้รับ " . $text_per;
                                            }




                                    ?>

                                            <div class="col-xxl-4 col-md-6">
                                                <div class="card info-card"
                                                    <?php if ($remain_percentage == 0): ?>
                                                    onclick="showNoRemainingLeaveModal()"
                                                    <?php elseif ($remain_percentage > 0): ?>
                                                    <?php if (!empty($row->lhis_id)): ?>
                                                    onclick="show_modal_approve_flow('<?php echo encrypt_id($row->lhis_id); ?>')"
                                                    <?php else: ?>
                                                    onclick="window.location.href='<?php echo site_url() . '/' . $controller . 'leaves_input/' . $row->lsum_leave_id . '/' . encrypt_id($row->lsum_ps_id) . '/' . encrypt_id($row->lsum_year); ?>'"
                                                    <?php endif; ?>
                                                    <?php endif; ?>>
                                                    <div class="card-body">
                                                        <h6 class="card-title"><?php echo $row->leave_name; ?></h6>
                                                        <div class="d-flex align-items-center">
                                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center <?php echo "leave" . $seq; ?>">
                                                                <i class="ri ri-number-<?php echo $seq; ?>"></i>
                                                            </div>
                                                            <div class="ps-3 mt-3">
                                                                <h5><span class="text-<?php echo $text_class; ?> fw-bold"><?php echo $text_remain; ?></span></h5>
                                                                <span class="text-dark small"><?php echo $text_per; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                    <?php
                                        }
                                        // foreach
                                        echo '<p><font color="red"> * หมายเหตุ : ทั้งนี้หากท่านคิดว่าข้อมูลของท่านไม่ถูกต้อง กรุณาประสานงานเจ้าหน้าที่ทรัพยากรบุคคล</font><br><font color="red"><i class="bi bi-exclamation-circle"></i> 60 นาที มีค่าเท่ากับ 1 ชั่วโมง</font><br><font color="red"><i class="bi bi-exclamation-circle"></i> 8 ชั่วโมง มีค่าเท่ากับ 1 วัน</font></p>';
                                    }
                                    ?>


                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url() . '/' . $controller; ?>'"> ย้อนกลับ</button>
                        </div>
                    </div>
                    <!-- button action form -->
                </div>
            </div>
        </div>
        <?php if (isset($leave_type_list_nextYear)) : ?>
            <div class="accordion-item mt-2">
                <h2 class="accordion-header">
                    <button class="accordion-button accordion-button-table" type="button">
                        <i class="bi-card-list icon-menu"></i><span> รายการประเภทการลา ประจำปีปฏิทิน พ.ศ. <?= date('Y')+544 ?></span>
                    </button>
                </h2>
                <div id="collapseShow" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <section class="section dashboard">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">

                                        <?php
                                        if (count($leave_type_list_nextYear) == 0) {
                                            echo "<div class='text-center mt-5 mb-5'><h4><font color='red'>ยังไม่กำหนดจำนวนวันลา ประจำปีปฏิทิน พ.ศ. " . ((new DateTime())->format("Y") + 544) . " กรุณาแจ้งเจ้าหน้าที่ทรัพยากรบุคคล</font></h4></div>";
                                        } else {
                                            $seq = 0;

                                            foreach ($leave_type_list_nextYear as $key => $row) {
                                                $seq++;
                                                $text_class = "";

                                                if ($row->lsum_per_day == "-99" || $row->lsum_per_day == "-99" || $row->lsum_per_day == "-99") {
                                                    $remain_percentage = 100;
                                                    $text_per = "ลาได้ไม่จำกัดสิทธิ์";
                                                    $text_class = "success";
                                                    $text_remain = '<i class="bi bi-infinity"></i>';
                                                } else {
                                                    // Calculate total remaining time in minutes, considering 1 day = 8 hours
                                                    $total_remain_minutes = ($row->lsum_remain_day * 8 * 60) + ($row->lsum_remain_hour * 60) + $row->lsum_remain_minute;
                                                    $total_per_minutes = ($row->lsum_per_day * 8 * 60) + ($row->lsum_per_hour * 60) + $row->lsum_per_minute;

                                                    // Calculate the remaining percentage
                                                    $remain_percentage = $total_per_minutes > 0 ? ($total_remain_minutes / $total_per_minutes) * 100 : 0;

                                                    // Determine the color class based on the percentage
                                                    if ($remain_percentage > 50) {
                                                        $text_class = "success";
                                                    } else if ($remain_percentage >= 21 && $remain_percentage <= 49) {
                                                        $text_class = "warning";
                                                    } else {
                                                        $text_class = "danger";
                                                    }

                                                    $text_remain = "";
                                                    if ($row->lsum_remain_day == 0) {
                                                        $text_remain .= "คงเหลือ ";
                                                    } else {
                                                        $text_remain .= "คงเหลือ " . $row->lsum_remain_day . " วัน ";
                                                    }
                                                    if ($row->lsum_remain_hour != 0) {
                                                        $text_remain .= $row->lsum_remain_hour . " ชั่วโมง ";
                                                    }
                                                    if ($row->lsum_remain_minute != 0) {
                                                        $text_remain .= $row->lsum_remain_minute . " นาที ";
                                                    }

                                                    if ($row->lsum_remain_day == 0 && $row->lsum_remain_hour == 0 && $row->lsum_remain_minute == 0) {
                                                        $text_remain = "หมดสิทธิ์การลา";
                                                    }

                                                    $text_per = "";
                                                    if ($row->lsum_per_day != 0) {
                                                        $text_per .= $row->lsum_per_day . " วัน ";
                                                    }
                                                    if ($row->lsum_per_hour != 0) {
                                                        $text_per .= $row->lsum_per_hour . " ชั่วโมง ";
                                                    }
                                                    if ($row->lsum_per_minute != 0) {
                                                        $text_per .= $row->lsum_per_minute . " นาที ";
                                                    }

                                                    $text_per .= "จำนวนสิทธิ์การลาที่ได้รับ " . $text_per;
                                                }




                                        ?>

                                                <div class="col-xxl-4 col-md-6">
                                                    <div class="card info-card"
                                                        <?php if ($remain_percentage == 0): ?>
                                                        onclick="showNoRemainingLeaveModal()"
                                                        <?php elseif ($remain_percentage > 0): ?>
                                                        <?php if (!empty($row->lhis_id)): ?>
                                                        onclick="show_modal_approve_flow('<?php echo encrypt_id($row->lhis_id); ?>')"
                                                        <?php else: ?>
                                                            onclick="window.location.href='<?php echo site_url() . '/' . $controller . 'leaves_input/' . $row->lsum_leave_id . '/' . encrypt_id($row->lsum_ps_id) . '/' . encrypt_id($row->lsum_year); ?>'"
                                                        <?php endif; ?>
                                                        <?php endif; ?>>
                                                        <div class="card-body">
                                                            <h6 class="card-title"><?php echo $row->leave_name; ?></h6>
                                                            <div class="d-flex align-items-center">
                                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center <?php echo "leave" . $seq; ?>">
                                                                    <i class="ri ri-number-<?php echo $seq; ?>"></i>
                                                                </div>
                                                                <div class="ps-3 mt-3">
                                                                    <h5><span class="text-<?php echo $text_class; ?> fw-bold"><?php echo $text_remain; ?></span></h5>
                                                                    <span class="text-dark small"><?php echo $text_per; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                        <?php
                                            }
                                            // foreach
                                            echo '<p><font color="red"> * หมายเหตุ : ทั้งนี้หากท่านคิดว่าข้อมูลของท่านไม่ถูกต้อง กรุณาประสานงานเจ้าหน้าที่ทรัพยากรบุคคล</font><br><font color="red"><i class="bi bi-exclamation-circle"></i> 60 นาที มีค่าเท่ากับ 1 ชั่วโมง</font><br><font color="red"><i class="bi bi-exclamation-circle"></i> 8 ชั่วโมง มีค่าเท่ากับ 1 วัน</font></p>';
                                        }
                                        ?>


                                    </div>
                                </div>

                            </div>
                        </section>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url() . '/' . $controller; ?>'"> ย้อนกลับ</button>
                            </div>
                        </div>
                        <!-- button action form -->
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal for no remaining leave -->
<div class="modal fade" id="noRemainingLeaveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แจ้งเตือน</h5>
            </div>
            <div class="modal-body">
                <p>คุณไม่มีสิทธิ์การลาคงเหลือ</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for leave details -->
<div class="modal fade" id="leaveDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เส้นทางอนุมัติการลา</h5>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded via AJAX -->
                <p>โหลดข้อมูล...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showNoRemainingLeaveModal() {
        // Trigger modal when there's 0% remaining leave
        $('#noRemainingLeaveModal').modal('show');
    }

    function show_modal_approve_flow(lhis_id) {
        // Trigger the modal to display leave details
        $('#leaveDetailsModal').modal('show');

        // Perform AJAX request to fetch data based on lhis_id
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller; ?>leaves_approve_flow/' + lhis_id, // Replace with your actual URL
            method: 'POST',
            success: function(response) {
                // data = JSON.parse(response);
                // Assuming `response` contains the HTML content for the modal
                $('#leaveDetailsModal .modal-body').html(response);
            },
            error: function() {
                $('#leaveDetailsModal .modal-body').html('<p>Error loading details.</p>');
            }
        });
    }
</script>