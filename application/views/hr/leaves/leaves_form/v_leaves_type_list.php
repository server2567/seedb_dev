<style>
    .leave1{
        color: #4154f1;
        background: #f6f6fe;
    }
    .leave2{
        color: #2eca6a;
        background: #e0f8e9;
    }
    .leave3{
        color: #ff771d;
        background: #ffecdf;
    }
    .leave4{
        color: #fa5278;
        background: #ffe0e7;
    }
    .leave5{
        color: #4154f1;
        background: #f6f6fe;
    }
    .leave6{
        color: #2eca6a;
        background: #e0f8e9;
    }
    .card:hover{
        background-color: #f0f6ff;
    }
    .info-card{
        cursor: pointer;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-card-list icon-menu"></i><span> รายการประเภทการลา</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <section class="section dashboard">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">

                                <?php 
                                        if(count($leave_type_list) == 0){
                                            echo "<div class='text-center mt-5 mb-5'><h4><font color='red'>ยังไม่กำหนดจำนวนวันลา ประจำปีปฏิทิน พ.ศ. ". ((new DateTime())->format("Y") + 543)." กรุณาแจ้งเจ้าหน้าที่ทรัพยากรบุคคล</font></h4></div>";
                                        }
                                        else{
                                            $seq = 0;

                                            foreach($leave_type_list as $key=>$row){ 
                                                $seq++;
    $text_class = "";

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
    if ($row->lsum_remain_day != 0) {
        $text_remain .= $row->lsum_remain_day . " วัน ";
    }
    if ($row->lsum_remain_hour != 0) {
        $text_remain .= $row->lsum_remain_hour . " ชั่วโมง ";
    }
    if ($row->lsum_remain_minute != 0) {
        $text_remain .= $row->lsum_remain_minute . " นาที ";
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

    // JavaScript data attributes for conditional behavior
    $card_data_attributes = $remain_percentage == 0 ? 'data-toggle="modal" data-target="#alertModal"' : '';
    $card_data_attributes .= ($remain_percentage > 0 && $row->lhis_id) ? 'data-lhis-id="' . $row->lhis_id . '"' : '';
?>

    <div class="col-xxl-4 col-md-6">
        <div class="card info-card" <?php echo $card_data_attributes; ?>>
            <div class="card-body">
                <h6 class="card-title"><?php echo $row->leave_name; ?></h6>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center <?php echo "leave".$seq; ?>">
                        <i class="ri ri-number-<?php echo $seq; ?>"></i>
                    </div>
                    <div class="ps-3 mt-3">
                        <h5><span class="text-<?php echo $text_class; ?> fw-bold">คงเหลือ <?php echo $text_remain; ?></span></h5>
                        <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ <?php echo $text_per; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                                

                                <?php
                                            } 
                                            // foreach
                                            echo "<p><font color='red'> * หมายเหตุ : ทั้งนี้หากท่านคิดว่าข้อมูลของท่านไม่ถูกต้อง กรุณาประสานงานเจ้าหน้าที่ทรัพยากรบุคคล</font></p>";
                                        }
                                ?>

                                    
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url().'/'.$controller; ?>'"> ย้อนกลับ</button>
                        </div>
                    </div>
                    <!-- button action form -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alert Modal for 0% remaining -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">การแจ้งเตือน</h5>
            </div>
            <div class="modal-body">
                คุณไม่สามารถเลือกการ์ดนี้ได้ เนื่องจากคงเหลือเป็น 0%
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">เส้นทางอนุมัติการลา</h5>
            </div>
            <div class="modal-body" id="detailModalContent">
                <!-- Content loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle card clicks
    document.querySelectorAll('.info-card[data-lhis-id]').forEach(card => {
        card.addEventListener('click', function() {
            const lhisId = this.getAttribute('data-lhis-id');
            
            // Make AJAX request to fetch details and show in modal
            $.ajax({
                url: '<?php echo site_url()."/".$controller; ?>get_leave_flow_by_lhis_id', // Replace with your actual URL
                type: 'POST',
                data: { lhis_id: lhisId },
                success: function(data) {
                    data = JSON.parse(data);
                    $('#detailModalContent').html(data); // Populate modal content
                    $('#detailModal').modal('show'); // Show modal
                },
                error: function() {
                    alert('ไม่สามารถโหลดข้อมูลได้');
                }
            });
        });
    });
</script>