<style>
    /* filter */
    .timeline-filter {
        position: relative;
        padding-left: 60px;
        max-width: 900px;
        margin: 0 auto;
    }

    /* ตั้งค่าพื้นฐานของ container */
    .custom-timeline-container {
        width: 100%;
        padding: 20px 0;
        background-color: #fff;
    }

    /* ตั้งค่าพื้นฐานของ content */
    .custom-timeline-content {
        position: relative;
        padding-left: 60px;
        max-width: 900px;
        margin: 0 auto;
    }

    /* เส้นแนวตั้งตรงกลาง timeline */
    .custom-timeline-content:before {
        content: '';
        position: absolute;
        top: 0;
        left: 30px;
        bottom: 0;
        width: 6px;
        background-color: #ddd;
        border-radius: 20px;
    }

    /* ตั้งค่าพื้นฐานของแต่ละกล่อง timeline */
    .custom-timeline-box {
        position: relative;
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* border-left: 5px solid #002554;  */
        transition: all 0.3s ease, transform 0.3s ease;
        /* เพิ่ม transition สำหรับ transform */
        opacity: 0;
        transform: translateY(40px);
        animation: fadeInUp 0.7s forwards;
        /* เพิ่มระยะเวลา animation */
        animation-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
        /* ทำให้ลื่นไหลมากขึ้น */
        border: 1px solid #cdcdcd;
    }

    /* แสดงเงาเมื่อ hover */
    .custom-timeline-box:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        transform: translateY(-5px);
        /* เพิ่ม effect เลื่อนขึ้นเมื่อ hover */
    }

    /* วงกลมของแต่ละกล่อง */
    .custom-timeline-box:before {
        content: '';
        display: block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 4px solid #fff;
        position: absolute;
        top: 20px;
        left: -49px;
    }

    /* สีของวงกลมกล่องแรก */
    .custom-timeline-box:first-child:before {
        background-color: #d9bd23;
        /* สีทองสำหรับกล่องแรก */
    }

    /* สีของวงกลมกล่องอื่นๆ */
    .custom-timeline-box:not(:first-child):before {
        background-color: #002554;
        /* สีน้ำเงินสำหรับกล่องอื่นๆ */
    }

    /* ตั้งค่าพื้นฐานของหัวข้อ */
    .timeline-title {
        font-size: 18px;
        color: #333;
        margin-bottom: 10px;
        padding: 5px 10px;
        border-radius: 5px;
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* ตั้งค่าพื้นฐานของข้อความ */
    .custom-timeline-box p {
        font-size: 15px;
        color: #666;
        margin-bottom: 5px;
    }

    /* ตั้งค่าพื้นฐานของเวลาหรือวันที่ */
    .custom-timeline-box .timeline-time {
        font-size: 16px;
        font-weight: bold;
        color: #000;
        margin-bottom: 10px;
    }

    /* Hover Effect for Button */
    #toggleFilterTimeline:hover {
        color: #fff !important;
        /* White text color on hover */
    }

    /* ทำให้ responsive */
    @media (max-width: 768px) {
        .custom-timeline-content {
            padding-left: 30px;
        }

        .custom-timeline-content:before {
            left: 0px;
        }

        .custom-timeline-box {
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .custom-timeline-content {
            padding-left: 20px;
        }

        .custom-timeline-content:before {
            left: -9px;
        }

        .custom-timeline-box {
            padding: 10px;
        }
    }

    /* Animation Effect */
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<?php if (isset($profile_person['person_work_history_list']) && count($profile_person['person_work_history_list']) > 0) { ?>
    <div class="custom-timeline-container">
        <div class="container">
            <div class="d-flex justify-content-end mb-4 timeline-filter">
                <!-- Filter icon -->
                <button id="toggleFilterTimeline" class="btn btn-outline-primary">
                    <i class="bi bi-sort-down font-20"></i>
                </button>
            </div>
            <div class="custom-timeline-content">
                <?php foreach ($profile_person['person_work_history_list'] as $work) { ?>
                    <div class="custom-timeline-box">
                        <p class="timeline-time"><?php echo $work->wohr_start_date . " - " . $work->wohr_end_date; ?></p>
                        <h1 class="timeline-title"><?php echo ($work->admin_name ? $work->admin_name. ", " : "") . $work->alp_name; ?></h1>
                        <p><?php echo ($work->wohr_place_name ? $work->wohr_place_name : $this->config->item('site_name_th') . " " . $work->stde_name_th); ?></p>
                        <p><?php echo $work->wohr_detail_th . ($work->wohr_detail_en ? " (" . $work->wohr_detail_en . ")" : ""); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="custom-timeline-container">
        <div class="container">
            <div class="d-flex justify-content-end mb-4 timeline-filter">
                <!-- Filter icon -->
                <button id="toggleFilterTimeline" class="btn btn-outline-primary">
                    <i class="bi bi-sort-down font-20"></i>
                </button>
            </div>
            <div class="custom-timeline-content">
                
            </div>
        </div>
    </div>
<?php } ?>
<script>
    // สคริปต์สำหรับสลับลำดับการแสดงผล timeline
    document.getElementById('toggleFilterTimeline').addEventListener('click', function() {
        const container = document.querySelector('.custom-timeline-content');
        const boxes = Array.from(container.children);
        container.innerHTML = '';
        boxes.reverse().forEach(box => container.appendChild(box));
        this.querySelector('i').classList.toggle('bi-sort-down');
        this.querySelector('i').classList.toggle('bi-sort-up');
    });
</script>