<style>
    .profile-header {
        background: url('https://www.arokago.com/_next/image?url=https%3A%2F%2Fbackend.arokago.com%2Fmedia%2Fhospitals%2Ffeatured%2F%25E0%25B8%25A3%25E0%25B8%259B%25E0%25B9%2582%25E0%25B8%25A3%25E0%25B8%2587%25E0%25B8%259E%25E0%25B8%25A2%25E0%25B8%25B2%25E0%25B8%259A%25E0%25B8%25B2%25E0%25B8%25A5%25E0%25B8%2588%25E0%25B8%2581%25E0%25B8%25A9%25E0%25B8%25AA%25E0%25B8%25A3%25E0%25B8%25B2%25E0%25B8%25A9%25E0%25B8%258E%25E0%25B8%25A3.jpg&w=1200&q=75') no-repeat center center;
        background-size: cover;
        width: 100%;
        padding: 10px;
        height: 350px;
        position: -webkit-sticky;
        /* Safari */
        position: sticky;
        top: 0;
        z-index: 500;
        transition: background-size 0.3s ease;
        /* Transition for smooth resizing */
    }

    .PersonalInfo-background-blue {
        background-image: url('https://prium.github.io/falcon/v3.14.0/assets/img/icons/spot-illustrations/corner-2.png');
        background-repeat: no-repeat;
        background-size: contain;
        background-position: right;
        background-size: auto auto;
    }

    .PersonalInfo-background-orange {
        background: url('https://prium.github.io/falcon/v3.14.0/assets/img/icons/spot-illustrations/corner-1.png');
        background-repeat: no-repeat;
        background-size: contain;
        background-position: right;
        background-size: auto auto;
    }

    .PersonalInfo-background-green {
        background: url('https://prium.github.io/falcon/v3.14.0/assets/img/icons/spot-illustrations/corner-3.png');
        background-repeat: no-repeat;
        background-size: contain;
        background-position: right;
        background-size: auto auto;
    }

    .shrunk {
        height: 185px;
        /* Adjust as needed */
    }

    .contrainer {
        display: flex;
        flex: 1;
    }

    .profile-img {
        position: absolute;
        left: 95px;
        bottom: -60px;
        z-index: 5;
    }

    .profile-img img {
        border-radius: 50%;
        height: 210px;
        width: 210px;
        border: 5px solid #fff;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.15);
        background: #fff;
    }


    .profile-side {
        width: 500px;
        position: -webkit-sticky;
        /* Safari */
        position: sticky;
        top: 260px;
        /* ตำแหน่งจากด้านบนของหน้าจอ */
        z-index: 200;
        height: calc(100vh - 50px);
        /* ให้แน่ใจว่าอยู่เหนือเนื้อหาอื่น */
        background: #fff;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 10px;
        margin-top: 40px;
        word-wrap: break-word;
        /* ตัดคำให้พอดีขอบเขต */
        overflow-wrap: break-word;
        /* เพิ่มการรองรับการตัดคำ */
        /* ปรับ margin-top ให้เหมาะสมกับ layout */
        /* ลบ position: relative */
    }

    @media (max-width: 768px) {
        .profile-side {
            position: relative;
            /* หรือ static */
            top: auto;
            /* ลบตำแหน่ง sticky */
            width: 100%;
            /* ปรับให้เต็มความกว้างหน้าจอ */
            margin-top: 20px;
            /* ปรับ margin-top ให้เหมาะสม */
            min-height: 800px;
            /* ปรับความสูงให้เหมาะสม */
        }
    }

    .profile-side-phone {
        position: relative;
        /* หรือ static */
        top: auto;
        /* ลบตำแหน่ง sticky */
        width: 100%;
        /* ปรับให้เต็มความกว้างหน้าจอ */
        margin-top: 20px;
        /* ปรับ margin-top ให้เหมาะสม */
        min-height: 800px;
        /* ปรับความสูงให้เหมาะสม */
    }

    @media (max-width: 1268px) {
        .profile-side {
            position: relative;
            /* หรือ static */
            top: auto;
            /* ลบตำแหน่ง sticky */
            width: 100%;
            /* ปรับให้เต็มความกว้างหน้าจอ */
            margin-top: 20px;
            /* ปรับ margin-top ให้เหมาะสม */
            min-height: 600px;
            /* ปรับความสูงให้เหมาะสม */
        }
    }

    .profile-nav-info {
        margin-left: 0;
        padding-top: 10px;
        text-align: center;
        color: #333;
    }

    .profile-nav-info h3 {
        font-size: 1.8rem;
        font-weight: bold;
        color: var(--color-primary);
    }

    .profile-nav-info .address {
        font-weight: 500;
        color: #777;
    }

    .main-bd {
        display: flex;
        margin-top: 50px;
        gap: 20px;
    }

    .profile-side p {
        margin-bottom: 10px;
        color: #333;
        font-size: 14px;
    }

    .profile-side p i {
        color: var(--color-primary);
        margin-right: 10px;
    }

    button.chatbtn,
    button.createbtn {
        border: 0;
        padding: 10px;
        width: 100%;
        border-radius: 3px;
        background: var(--color-primary);
        color: #fff;
        font-size: 1rem;
        cursor: pointer;
        box-shadow: 0px 5px 7px 0px rgba(0, 0, 0, 0.15);
        transition: background 0.3s ease-in-out;
    }

    button.chatbtn:hover,
    button.createbtn:hover {
        background: rgba(0, 123, 255, 0.9);
    }

    .profile-nav-topic {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
        padding: 10px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        position: absolute;
        /* left: 60%; */
        top: 77%;
        /* transform: translateX(70%); */
        margin-left: 370px;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .profile-nav-topic ul {
        list-style-type: none;
        display: flex;
        gap: 15px;
        margin: 0;
        padding: 0;
    }

    .profile-nav-topic li {
        padding: 10px 20px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        background-color: #fff;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .profile-nav-topic li i {
        font-size: 1.2rem;
    }

    .profile-nav-topic li:hover {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0px 4px 10px rgba(0, 123, 255, 0.3);
        transform: translateY(-5px);
    }

    .profile-nav-topic li.active {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0px 4px 10px rgba(0, 123, 255, 0.3);
    }

    .profile-nav-topic li.active i {
        color: #fff;
    }

    .profile-body {
        width: 100%;
    }

    .tab {
        display: none;
    }

    .tab.active {
        display: block;
    }

    .tab h1 {
        font-family: "Nunito", sans-serif;
        font-size: 1.5rem;
        font-weight: bold;
        margin: 20px 0;
    }

    .tab p {
        font-size: 1rem;
        line-height: 1.6;
        color: #333;
    }

    .tab-content {
        /* background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.1); */
    }

    button.edit {
        position: absolute;
        top: 10px;
        margin-right: 5px;
        right: 0;
    }

    @media (max-width: 800px) {
        .main-bd {
            flex-direction: column;
            align-items: center;
            margin-top: 135px;
        }

        .profile-side {
            width: 100%;
            text-align: center;
            margin-top: 90px;
        }

        .profile-img {
            left: 37%;
            transform: translateX(-2%);
        }

        .profile-header {
            height: 250px;
            text-align: center;
        }

        .profile-nav-topic {
            margin-top: 136px;
            margin-left: 0px;
            transform: translateX(-1%);
        }

        .profile-img img {
            height: 180px;
            width: 180px;
        }
    }

    @media (min-width: 800px) and (max-width: 899px) {
        .main-bd {
            flex-direction: column;
            align-items: center;
            margin-top: 135px;
        }

        .profile-side {
            width: 100%;
            text-align: center;
            margin-top: 70px;
        }

        .profile-img {
            left: 37%;
            transform: translateX(-2%);
        }

        .profile-header {
            height: 250px;
            text-align: center;
        }

        .profile-nav-topic {
            margin-top: 136px;
            margin-left: 0px;
            transform: translateX(-1%);
        }

        .profile-img img {
            height: 180px;
            width: 180px;
        }
    }

    @media (min-width: 900px) and (max-width: 999px) {

        .main-bd {
            flex-direction: column;
            align-items: center;
            margin-top: 100px;
        }

        .profile-side {
            width: 100%;
            text-align: center;
            margin-top: 90px;
        }

        .profile-img {
            left: 36%;
            transform: translateX(-2%);
        }

        .profile-header {
            height: 250px;
            text-align: center;
        }

        .profile-nav-topic {
            margin-top: 136px;
            margin-left: 0px;
            transform: translateX(-1%);
        }
    }

    @media (min-width: 1000px) and (max-width: 1100px) {
        .main-bd {
            flex-direction: column;
            align-items: center;
            margin-top: 100px;
        }

        .profile-side {
            width: 100%;
            text-align: center;
            margin-top: 80px;
        }

        .profile-img {
            left: 40%;
            transform: translateX(-2%);
        }

        .profile-header {
            height: 250px;
            text-align: center;
        }

        .profile-nav-topic {
            margin-top: 136px;
            margin-left: 0px;
            transform: translateX(11%);
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1101px) and (max-width: 1219px) {
        .profile-nav-topic {
            transform: translateX(-3%);
            top: 70%;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1220px) and (max-width: 1399px) {
        .profile-nav-topic {
            transform: translateX(22%);
            left: -20%
        }
    }

    /* Extra extra large devices (larger desktops, 1400px and up) */
    @media (min-width: 1400px) {
        .profile-nav-topic {
            transform: translateX(23%);
        }
    }

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

    .fixed-plugin {
        position: fixed;
        top: 30%;
        right: 0;
        transform: translateY(-50%);
        z-index: 1030;
        background-color: #cfe2ff;
        padding: 10px;
        border-radius: 8px 0 0 8px;
    }

    .fixed-plugin .dropdown-menu {
        max-height: 450px;
        overflow-y: auto;
    }

    .fixed-plugin .header-title {
        color: #000;
        padding: 10px;
        text-align: center;
        font-size: 18px;
        border-bottom: 1px solid #000;
    }

    .fixed-plugin .dropdown-item {
        color: #cfe2ff;
    }

    .fixed-plugin .dropdown-item:hover {
        background-color: #cfe2ff;
    }

    .fixed-plugin .dropdown-toggle {
        color: #000;
    }

    .partial-name {
        display: inline-block;
        position: relative;
    }

    .partial-name:after {
        content: "";
        height: 4px;
        width: 230%;
        /* ปรับขนาดความกว้างของเส้น */
        background: #0d6efd;
        display: block;
        position: absolute;
        top: 50%;
        left: 100%;
        right: 0;
        /* เริ่มจากด้านขวา */
        margin-left: 10px;
        transform: translateY(-50%);
    }

    .tab h1 {
        font-family: "Nunito", sans-serif;
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0px 0;
    }

    .card-IMG {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .center-icon {
        display: flex;
        align-items: center;
        margin: 0px;
        /* จัดกลางในแนวตั้ง */
        justify-content: center;
        /* จัดกลางในแนวนอน */
        background-color: #FCFBFC;
        height: 105px;
        width: 50%;
    }
</style>
<div class="container mt-4">
    <div class="profile-header">
        <div class="profile-img">
            <img id="profile_picture" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($row_profile->psd_picture != '' ? $row_profile->psd_picture : "default.png")); ?>">
        </div>
        <div class="profile-nav-topic">
            <ul>
                <li onclick="tabs(0)" class="user-post active">
                    <i class="bi bi-person-circle"></i> ข้อมูลส่วนตัว (HR)
                </li>
                <li onclick="tabs(1)">
                    <i class="bi bi-people-fill"></i> ข้อมูลการทำงาน (HRM)
                </li>
                <li onclick="tabs(2)">
                    <i class="bi bi-people-fill"></i> ข้อมูลการพัฒนาตนเอง (HRD)
                </li>
                <!-- <li onclick="tabs(2)">
            <i class="bi bi-cash-stack"></i> ข้อมูลประวัติเงินเดือน (Payroll)
        </li> -->
            </ul>
        </div>

    </div>
    <div class="fixed-plugin">
        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-html="true" title="เครื่องมือในการนำทาง">
            <i class="bi bi-cassette"></i>
        </a>

        <!-- Dropdown Menu -->
        <ul class="dropdown-menu" id="dropdown-menu">
            <!-- Menu items will be added here by JavaScript -->
        </ul>
    </div>
    <div class="main-bd">
        <div class="profile-side PersonalInfo-background-blue">
            <div class="profile-nav-info">
                <!-- <h3 class="user-name font-26"><?= $row_profile->pf_name_abbr ?></h3> -->
                <h3 class="user-name font-26"><?= $row_profile->pf_name_abbr . ' ' . $row_profile->ps_fname . ' ' . $row_profile->ps_lname ?></h3>
                <h5 class="user-name-eng font-18"><?= $row_profile->pf_name_abbr_en . ' ' . $row_profile->ps_fname_en . ' ' . $row_profile->ps_lname_en ?></h5>
                <hr>
                <div class="address text-start">
                    <div class="row pb-3">
                        <div class="col-md-3 text-end">
                            <i class="bi bi-upc" style="font-size:30px"></i>
                        </div>
                        <div class="col-md-8 font-16">
                            รหัสบุคลากร <br>
                            <span style="color: #012970; font-16"><?= $row_profile->pos_ps_code ?> </span>
                        </div>
                    </div>
                    <div class="row  pb-3">
                        <div class="col-md-3 text-end">
                            <i class="bi bi-kanban" style="font-size:30px"></i>
                        </div>
                        <div class="col-md-8 font-16">
                            ตำแหน่งการบริหาร<br>
                            <span style="color: #012970; font-16">
                                <?php foreach ($person_department_detail[1]->admin_po as $key => $value) : ?>
                                    <?= $value->admin_name . '<br>' ?>
                                <?php endforeach ?>
                            </span>
                        </div>
                    </div>
                    <div class="row  pb-3">
                        <div class="col-md-3 text-end">
                            <i class="bi bi-person-workspace" style="font-size:30px"></i>
                        </div>
                        <div class="col-md-8 font-16">
                            ตำแหน่งปฏิบัติงาน<br>
                            <span style="color: #012970; font-16">
                                <?= $person_department_detail[1]->alp_name . '<br>' ?>
                            </span>
                        </div>
                    </div>
                    <div class="row  pb-3">
                        <div class="col-md-3 text-end">
                            <i class="bi bi-phone" style="font-size:30px"></i>
                        </div>
                        <div class="col-md-8 font-16">
                            เบอร์โทรศัพท์<br>
                            <span style="color: #012970; font-16">
                                <?= $row_profile->psd_cellphone == NULL || $row_profile->psd_cellphone == '' ? '+66801234567' : $row_profile->psd_cellphone ?>
                            </span>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-md-3 text-end">
                            <i class="bi bi-envelope" style="font-size:30px"></i>
                        </div>
                        <div class="col-md-8 font-16">
                            อีเมล<br>
                            <span style="color: #012970; font-16">
                                <?= $row_profile->psd_email ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-bio">
                <?php if ($row_profile->psd_desc != null || $row_profile->psd_desc != '') : ?>
                    <h3>Bio</h3>
                    <p class="bio">
                        <?= $row_profile->psd_desc ?>
                    </p>
                <?php endif ?>
            </div>
        </div>



        <div class="profile-body">
            <div class="tab-content">
                <div class="tab profile-posts active">
                    <div class="card PersonalInfo-background-blue" id="PersonalInfo-HR-Section-1">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 card-IMG">
                                <img src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_summary_icon&image=Personal.png") ?>" class="img-fluid rounded" width="100px" alt="ชื่อสื่อการเรียนรู้ 1">
                            </div>
                            <div class="col-md-9 p-3 pt-2">
                                <h5 class="card-title partial-name font-22" style="margin-bottom: 0px;">ข้อมูลทั่วไป</h5>
                                <button class="btn btn-outline-secondary edit btn-sm " onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/Profile_user/get_profile_user/<?php echo $row_profile->ps_id ?>/<?= 1 ?>'"><i class="bi bi-pencil"></i></button>
                                <!-- New row for additional details -->
                                <div class="row font-18" style="padding-left: 25px;">
                                    <div class="col-12 col-sm-6 col-md-4" style="color:#777;padding-bottom:10px">
                                        ชื่อ - นามสกุล (TH)
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-7  text-start">
                                        <?= $row_profile->pf_name_abbr . " " . $row_profile->ps_fname . " " . $row_profile->ps_lname ?>
                                    </div>
                                    <div class="col-12 col-md-4" style="color:#777;padding-bottom:10px">
                                        ชื่อ - นามสกุล (EN)
                                    </div>
                                    <div class="col-12 col-md-7 text-start">
                                        <?= $row_profile->pf_name_abbr_en . " " . $row_profile->ps_fname_en . " " . $row_profile->ps_lname_en ?>
                                    </div>
                                    <div class="col-md-2 col-lg-4 " style="color:#777;padding-bottom:10px">
                                        เลขบัตรประชาชน
                                    </div>
                                    <div class="col-md-8 text-start" style="padding-bottom:10px">
                                        <?= $row_profile->psd_id_card_no ?>
                                    </div>
                                    <div class="col-2 col-md-2 col-lg-2" style="color:#777;padding-bottom:10px;padding-right:0px">
                                        วันเกิด
                                    </div>
                                    <div class="col-4 col-md-3 col-lg-3 text-start" style="padding-left:0px">
                                        <?= $row_profile->psd_birthdate != null ? abbreDate2($row_profile->psd_birthdate) : '21 ส.ค 2507' ?>
                                    </div>
                                    <div class="col-2 col-md-2" style="color:#777;padding-left:0px;padding-right:0px">
                                        อายุ
                                    </div>
                                    <div class="col-2 col-md-5  text-start" style="padding-left:0px;">
                                        <?= $row_profile->psd_birthdate != null ? abbreDate2($row_profile->psd_birthdate) : '60 ปี' ?>
                                    </div>
                                    <div class="col-4 col-md-2 col-lg-2" style="color:#777">
                                        กรุ๊ปเลือด
                                    </div>
                                    <div class="col-2 col-md-1 col-lg-3 text-start" style="padding-left:0px;">
                                        <?= $row_profile->psd_blood_id != null ? $row_profile->blood_name : 'B' ?>
                                    </div>
                                    <div class="col-3 col-md-2 col-lg-2" style="color:#777;padding-bottom:10px;padding-left:0px;padding-right:0px">
                                        สัญชาติ
                                    </div>
                                    <div class="col-2 col-md-2 col-lg-4  text-start" style="padding-left:0px;">
                                        <?= $row_profile->psd_nation_id != null ? $row_profile->country_name : 'ไทย' ?>
                                    </div>
                                    <div class="col-3 col-md-2 col-lg-2" style="color:#777;padding-right:0px;">
                                        เชื้อชาติ
                                    </div>
                                    <div class="col-2 col-md-3  text-start" style="padding-left:0px;">
                                        <?= $row_profile->psd_race_id != null ? $row_profile->race_name : 'ไทย' ?>
                                    </div>
                                    <div class="col-3 col-md-2 col-lg-2" style="color:#777;padding-bottom:10px;padding-left:0px;padding-right:0px">
                                        ศาสนา
                                    </div>
                                    <div class="col-2 col-md-2  text-start" style="padding-left:0px;">
                                        <?= $row_profile->psd_reli_id != null ? $row_profile->reli_name : 'พุทธ' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card PersonalInfo-background-blue" id="PersonalInfo-HR-Section-2">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 card-IMG">
                                <img src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_summary_icon&image=home-address.png") ?>" class="img-fluid rounded" width="100px" alt="ชื่อสื่อการเรียนรู้ 1">
                            </div>
                            <div class="col-9 p-3 pt-2">
                                <h5 class="card-title partial-name font-22" style="margin-bottom: 0px;">ข้อมูลที่อยู่</h5>
                                <button class="btn btn-outline-secondary edit btn-sm" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/Profile_user/get_profile_user/<?php echo $row_profile->ps_id ?>/<?= 2 ?>'"><i class="bi bi-pencil"></i></button>
                                <!-- New row for additional details -->
                                <div class="row font-18">
                                    <div class="col-md-12" style="padding-left: 30px;">
                                        <div>
                                            <span style="color:#777"> <i class="bi bi-house font-30"></i> ที่อยู่ปัจจุบัน</span><br>
                                            <span style="padding-left:32px"></span>
                                            <?= $row_profile->psd_addcur_no != null ? '44/1 ถนนศรีวิชัย' : '44/1 ถนนศรีวิชัย' ?>
                                            ต.<?= $row_profile->psd_addcur_dist_id != null ? $row_profile->dist_name == '' ? '-' : '44/1 ถนนศรีวิชัย' : '44/1 ถนนศรีวิชัย' ?>
                                            อ.<?= $row_profile->psd_addcur_amph_id != null ? 'มะขามเตี้ย' : 'มะขามเตี้ย' ?>
                                            จ.<?= $row_profile->psd_addcur_pv_id != null ? 'ราษฎร์ธานี' : 'ราษฎร์ธานี' ?>
                                            <?= $row_profile->psd_addcur_zipcode != null ? '84000' : '84000' ?>
                                        </div>
                                        <div>
                                            <span style="color:#777"> <i class="bi bi-house font-30"></i> ที่อยู่ตามสำเนาทะเบียนบ้าน</span>
                                            <br>
                                            <span style="padding-left:32px"></span>
                                            <?= $row_profile->psd_addhome_no != null ?  '44/1 ถนนศรีวิชัย' : '44/1 ถนนศรีวิชัย' ?>
                                            ต.<?= $row_profile->psd_addhome_dist_id != null ? $row_profile->dist_name == '' ? '-' : '44/1 ถนนศรีวิชัย' : '44/1 ถนนศรีวิชัย' ?>
                                            อ.<?= $row_profile->psd_addhome_amph_id != null ? 'มะขามเตี้ย' : 'มะขามเตี้ย' ?>
                                            จ.<?= $row_profile->psd_addhome_pv_id != null ? 'ราษฎร์ธานี' : 'ราษฎร์ธานี' ?>
                                            <?= $row_profile->psd_addcur_zipcode != null ? '84000' : '84000' ?>
                                        </div>
                                        <div>
                                            <span style="color:#777"><i class="bi bi-phone font-30"></i> เบอร์โทรศัพท์ที่สามารถติดต่อได้</span> <br>
                                            <span style="padding-left:32px"></span>
                                            <?= $row_profile->psd_cellphone == NULL || $row_profile->psd_cellphone == '077 276 999' ? '077 276 999' : $row_profile->psd_cellphone ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card PersonalInfo-background-blue">
                        <div class="card-body m-0" id="PersonalInfo-HR-Section-3">
                            <div class="row">
                                <div class="col-sm-12 col-md-3 card-IMG">
                                    <img src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_summary_icon&image=Educate.png") ?>" class="img-fluid rounded" width="100px" alt="ชื่อสื่อการเรียนรู้ 1">
                                </div>
                                <div class="col-9 p-3 pt-2">
                                    <h5 class="card-title partial-name font-22" style="margin-bottom: 0px;">ข้อมูลการศึกษา</h5>
                                    <button class="btn btn-outline-secondary edit btn-sm" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/Profile_user/get_profile_user/<?php echo $row_profile->ps_id ?>/<?= 3 ?>'"><i class="bi bi-pencil"></i></button>
                                    <div class="row font-18">
                                        <div class="col-md-12">
                                            <?php foreach ($person_education_info as $key => $education) : ?>
                                                <div class="mt-2 mb-3"> <i class="bi-bookmark-star-fill profile-badge text-primary font-30"></i> <span style="color:#777;"><?= $education->edulv_name ?></span></div>
                                                <div style="padding-left: 40px;">
                                                    <i class="bi-mortarboard-fill pe-2 font-30"></i>
                                                    พ.ศ. <?= $education->edu_start_year + 543 ?>-<?= $education->edu_end_year + 543 ?><br><span style="margin-right: 60px;">&nbsp;</span><?= $education->edudg_name ?> <?= $education->edumj_name ?> <br><span style="margin-right: 60px;">&nbsp;</span><?= $education->place_name ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card PersonalInfo-background-blue">
                        <div class="card-body" id="PersonalInfo-HR-Section-4">
                            <h5 class="card-title partial-name font-22" style="margin-bottom: 0px;">ข้อมูลประสบการณ์ทำงาน</h5>
                            <button class="btn btn-outline-secondary edit btn-sm" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/Profile_user/get_profile_user/<?php echo $row_profile->ps_id ?>/<?= 5 ?>'"><i class="bi bi-pencil"></i></button>
                            <div class="custom-timeline-container">
                                <div class="container">
                                    <div class="d-flex justify-content-end mb-4 timeline-filter">
                                        <!-- Filter icon -->
                                        <button id="toggleFilterTimeline" class="btn btn-outline-primary">
                                            <i class="bi bi-sort-down font-20"></i>
                                        </button>
                                    </div>
                                    <div class="custom-timeline-content">
                                        <?php foreach ($person_work_history_list as $work) { ?>
                                            <div class="custom-timeline-box">
                                                <p class="timeline-time"><?php echo $work->wohr_start_date . " - " . $work->wohr_end_date; ?></p>
                                                <h1 class="timeline-title"><?php echo ($work->admin_name ? $work->admin_name . ", " : "") . $work->alp_name; ?></h1>
                                                <p><?php echo ($work->wohr_place_name ? $work->wohr_place_name : $this->config->item('site_name_th') . " " . $work->stde_name_th); ?></p>
                                                <!-- <p><?php echo $work->wohr_detail_th . ($work->wohr_detail_en ? " (" . $work->wohr_detail_en . ")" : ""); ?></p> -->
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card PersonalInfo-background-blue" id="PersonalInfo-HR-Section-5">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 card-IMG">
                                <img src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_summary_icon&image=trophy.png") ?>" class="img-fluid rounded" width="100px" alt="ชื่อสื่อการเรียนรู้ 1">
                            </div>
                            <div class="col-9 p-3 pt-2">
                                <h5 class="card-title partial-name font-22" style="margin-bottom: 0px;">ข้อมูลรางวัล</h5>
                                <button class="btn btn-outline-secondary edit btn-sm" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/Profile_user/get_profile_user/<?php echo $row_profile->ps_id ?>/<?= 3 ?>'"><i class="bi bi-pencil"></i></button>
                                <div class="row font-18" style="padding-left: 30px;">
                                    <div class="col-md-12">
                                        <?php foreach ($person_reward_list as $year) { ?>
                                            <div class="mt-2 mb-3"> <i class="bi-bookmark-star-fill profile-badge text-primary font-30"></i> <span style="color:#777;">พ.ศ. <?= $year->rewd_year; ?></span></div>
                                            <?php
                                            foreach ($year->reward_detail as $rewd) {
                                            ?>
                                                <div style="padding-left: 40px;">
                                                    <i class="bi bi-award-fill pe-2 font-30"></i>
                                                    <?= $rewd->rewd_name_th ?>
                                                    <br>
                                                    <span style="margin-right: 59px;">&nbsp;</span> <?= $rewd->rewd_org_th ?>
                                                    <br>
                                                    <span style="margin-right: 60px;">&nbsp;</span>
                                                </div>
                                        <?php
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-12 col-md-3 card-IMG">
                                <img src="https://cdn-icons-png.flaticon.com/128/10205/10205841.png" class="img-fluid rounded" width="100px" alt="ชื่อสื่อการเรียนรู้ 1">
                            </div>
                            <div class="col-9 p-3 pt-2">
                                <div class="card-body" id="PersonalInfo-HR-Section-5">
                                    <h5 class="card-title">ข้อมูลรางวัล</h5>
                                    <button class="btn btn-outline-secondary edit btn-sm" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/profile/Profile_user/get_profile_user/<?php echo $row_profile->ps_id ?>/<?= 7 ?>'"><i class="bi bi-pencil"></i></button>
                                    <?php
                                    foreach ($person_reward_list as $year) {
                                    ?>
                                        <div class="profile-item d-flex">
                                            <div class="profile-icon">
                                                <i class="bx bx-award icon-menu text-warning profile-badge"></i>
                                            </div>
                                            <div class="profile-content">
                                                <div class="mt-2"><b>พ.ศ. <?php echo $year->rewd_year; ?></b></div>
                                                <?php
                                                foreach ($year->reward_detail as $rewd) {
                                                ?>
                                                    <div>
                                                        <?= $rewd->rewd_date ?>
                                                    </div>
                                                    <div class="mt-3">
                                                        <i class='bi-megaphone-fill pe-2'></i><?php echo $rewd->rwt_name; ?>
                                                    </div>
                                                    <div>
                                                        <i class='ri-medal-fill pe-2'></i><?php echo $rewd->rwlv_name; ?>
                                                    </div>
                                                    <div>
                                                        <i class='bi-collection-fill pe-2'></i><?php echo $rewd->rewd_name_th . " (" . $rewd->rewd_name_en . ")"; ?>
                                                    </div>
                                                    <div>
                                                        <i class='bi-people-fill pe-2'></i><?php echo $rewd->rewd_org_th . " (" . $rewd->rewd_org_en . ")"; ?>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="tab profile-reviews">
                    <div class="card PersonalInfo-background-green" id="WorkInfo-HRM-Section-1">
                        <div class="card-body m-0">
                            <div class="float-end">
                                <ul class="nav nav-pills mb-0 mt-0" id="hr-tab" role="tablist">
                                    <?php foreach ($person_department_topic as $key => $value) : ?>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link <?php echo $key == 0 ? 'active' : ''; ?>"
                                                id="hr-develop-tab-<?= $value->dp_id ?>"
                                                data-bs-toggle="pill"
                                                data-bs-target="#hr-develop-<?= $value->dp_id ?>"
                                                type="button"
                                                role="tab"
                                                aria-controls="hr-develop-<?= $value->dp_id ?>"
                                                aria-selected="<?= $key == 0 ? 'true' : 'false'; ?>"
                                                style="margin-left: 13px;">
                                                <?= $value->dp_name_th ?>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <h5 class="card-title font-22 partial-name ">ข้อมูลการทำงาน</h5>
                        </div>
                    </div>
                    <div class="tab-content" id="hr-tabContent">
                        <?php foreach ($person_department_topic as $key => $row) : ?>
                            <div class="tab-pane fade <?php echo $key == 0 ? 'show active' : ''; ?>"
                                id="hr-develop-<?= $row->dp_id ?>"
                                role="tabpanel"
                                aria-labelledby="hr-develop-tab-<?= $row->dp_id; ?>">
                                <!-- <div class="d-flex justify-content-end mb-4 timeline-filter"> -->
                                <!-- Filter icon -->
                                <!-- <button id="toggleFilterTimeline" class="btn btn-outline-primary">
                                        <i class="bi bi-sort-down font-20"></i>
                                    </button>
                                </div> -->
                                <?php if (isset($person_position_info[$row->dp_id])) : ?>
                                    <?php if (count($person_position_info[$row->dp_id]) > 0) : ?>
                                        <div class="custom-timeline-content">
                                            <?php foreach ($person_position_info[$row->dp_id] as $key2 => $timeline) : ?>
                                                <div class="custom-timeline-box PersonalInfo-background-green">
                                                    <div class="card <?= $timeline['hipos_pos_status'] == 1 ? 'PersonalInfo-background-green' : 'PersonalInfo-background-orange' ?>">
                                                        <div class="card-body">
                                                            <div class="tab-content" id="hr-tabContent">
                                                                <div class="row font-18">
                                                                    <!-- <div class="col-md-12 row">
                                                                <div class="col-md-4">
                                                                    <p>รหัสประจำตัวบุคลากร</p>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <?= $person_position_info[$row->dp_id]->pos_ps_code != null ? $person_position_info[$row->dp_id]->pos_ps_code : '-' ?>
                                                                </div>
                                                            </div> -->
                                                                    <?php if ($timeline['hipos_pos_status'] != 2) : ?>
                                                                        <div class="col-md-12 row">
                                                                            <div class="col-md-4">
                                                                                <p>วันที่เริ่มปฏิบัติงาน</p>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <?= $timeline['hipos_start_date'] != null ? fullDateTH3($timeline['hipos_start_date']).' ถึง '.($timeline['hipos_end_date'] == '9999-12-31'? 'ปัจจุบัน': fullDateTH3($timeline['hipos_end_date'])) : '-' ?>

                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <?php if ($timeline['admin_po'] != null) : ?>
                                                                        <div class="col-md-12 row">
                                                                            <div class="col-md-4">
                                                                                <p>ตำแหน่งในการบริหาร</p>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <?php foreach ($timeline['admin_po'] as $key => $admin) : ?>
                                                                                    <?= $admin->admin_name . "<br>" ?>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <div class="col-md-12 row">
                                                                        <div class="col-md-4">
                                                                            <p>ตำแหน่งปฏิบัติงาน</p>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <?= $timeline['alp_name'] != null ? $timeline['alp_name'] : '-' ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php if ($timeline['spcl_po'] != null) : ?>
                                                                        <div class="col-md-12 row">
                                                                            <div class="col-md-4">
                                                                                <p>ตำแหน่งงานเฉพาะทาง</p>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <?php foreach ($timeline['spcl_po'] as $key => $spcl) : ?>
                                                                                    <?= $spcl->spcl_name . "<br>" ?>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <!-- <div class="col-md-12 row mb-3">
                                                                <div class="col-md-4">
                                                                    <p>รายละเอียดความชำนาญเฉพาะทาง</p>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <?= $person_position_info[$row->dp_id]->pos_desc != null ? preg_replace('/([A-Za-z])/', '<br>$1', $person_position_info[$row->dp_id]->pos_desc, 1) : '-' ?>
                                                                </div>
                                                            </div> -->
                                                                    <?php if ($timeline['hire_name'] != null) : ?>
                                                                        <div class="col-md-12 row">
                                                                            <div class="col-md-4">
                                                                                <p>ประเภทบุคลากร</p>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <?= $timeline['hire_name'] ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <div class="col-md-12 row">
                                                                        <div class="col-md-4">
                                                                            <p>สถานะการปฏิบัติงาน</p>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <?= $timeline['hipos_pos_status'] != null ? $timeline['retire_name'] : '-' ?>
                                                                            <?php if ($timeline['hipos_pos_status'] == 2) : ?>
                                                                                <br>
                                                                                สิ้นสุดการปฏิบัติงาน ณ วันที่ <?= fullDateTH3($timeline['hipos_end_date']) ?> <button class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="custom-timeline-content">
                                            <div class="custom-timeline-box ">
                                                <div class="card ">
                                                    <div class="card-body">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="tab profile-settings">
                    <div class="card PersonalInfo-background-orange" id="SelfDevelopment-HRD-Section-1">
                        <div class="card-body">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button accordion-button-table" type="button">
                                            <i class="bi bi-table icon-menu"></i><span> ข้อมูลการพัฒนาตนเอง</span></span>
                                        </button>
                                    </h2>
                                    <div id="collapse-hr-develop-in-tab" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <div clas="row">
                                                <div class="col-md-12">
                                                    <div class="d-grid col-4 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="select_year_develop" class="form-label">ปีปฏิทิน</label>
                                                            </div>
                                                            <?php $todayYear = date('Y') + 543; ?>
                                                            <div class="col-md-9">
                                                                <select class="form-select select2 ms-2 w-15" style="display: inline;" data-ps-id="<?= $row_profile->ps_id ?>" data-placeholder="-- กรุณาเลือกปี --" name="select_year_develop" id="select_year_develop">
                                                                    <?php for ($i = 0; $i <= 3; $i++) { ?>
                                                                        <option value="<?= $todayYear - $i ?>"><?= $todayYear - $i ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-6">
                                                            <div class="card info-card sales-card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">จำนวนชั่วโมงการไปพัฒนาบุคลากร</h5>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                                            <i class="bi bi-briefcase-fill"></i>
                                                                        </div>
                                                                        <div class="ps-3">
                                                                            <h6 id='dev_sum_hour'><?= $dev_sum_hour ?> ชั่วโมง</h6>
                                                                            <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $org_one = array_filter($devlop_list_person, function ($item) {
                                                            return $item->dev_organized_type == 1;
                                                        });

                                                        $org_two = array_filter($devlop_list_person, function ($item) {
                                                            return $item->dev_organized_type == 2;
                                                        }); ?>
                                                        <!-- Pills Tabs -->
                                                        <ul class="nav nav-pills mb-3 mt-3" id="hr-tab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link active" id="hr-develop-in-tab" data-bs-toggle="pill" data-bs-target="#hr-develop-in" type="button" role="tab" aria-controls="hr-develop-in" aria-selected="true" style="margin-left: 13px;">หน่วยงานภายใน <span class="badge bg-success" id="summary-develop-in"><?= count($org_one) ?></span></button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link" id="hr-develop-out-tab" data-bs-toggle="pill" data-bs-target="#hr-develop-out" type="button" role="tab" aria-controls="hr-develop-out" aria-selected="false">หน่วยงานภายนอก <span class="badge bg-success" id="summary-develop-out"><?= count($org_two) ?></span></button>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content pt-2" id="table-hr-develop-in-tab">
                                                            <div class="tab-pane fade show active" id="hr-develop-in" role="tabpanel" aria-labelledby="home-tab">
                                                                <div class="card">
                                                                    <div class="accordion">
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header">
                                                                                <button class="accordion-button accordion-button-table" type="button">
                                                                                    <i class="bi bi-table icon-menu"></i><span> ตารางรายการข้อมูลพัฒนาบุคลากรหน่วยงานภายใน</span></span>
                                                                                </button>
                                                                            </h2>
                                                                            <div id="collapse-hr-develop-in-tab" class="accordion-collapse collapse show">
                                                                                <div class="accordion-body">
                                                                                    <table class="table datatable table-hover" width="100%" id="table-develop-in">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th scope="col" class="text-center">#</th>
                                                                                                <th scope="col">ชื่อเรื่อง</th>
                                                                                                <th scope="col">วันที่</th>
                                                                                                <th scope="col">ประเภทการพัฒนาบุคลากร</th>
                                                                                                <th scope="col">ผู้จัดโครงการ/หน่วยงาน</th>
                                                                                                <th scope="col">จำนวนชั่วโมง</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php foreach ($devlop_list_person as $key => $develop_one) : ?>
                                                                                                <?php if ($develop_one->dev_organized_type == 1) : ?>
                                                                                                    <tr>
                                                                                                        <td class="text-center"><?= $key + 1 ?></td>
                                                                                                        <td><?= $develop_one->dev_topic ?></td>
                                                                                                        <td class="text-center"><?= fullDateTH3($develop_one->dev_start_date) ?></td>
                                                                                                        <td><?= $develop_one->dev_server_type_name ?></td>
                                                                                                        <td><?= $develop_one->dev_project ?></td>
                                                                                                        <td class="text-center"><?= $develop_one->dev_hour ?></td>
                                                                                                    </tr>
                                                                                                <?php endif; ?>
                                                                                            <?php endforeach; ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="hr-develop-out" role="tabpanel" aria-labelledby="profile-tab">
                                                                <div class="tab-pane fade show active" id="hr-develop-out" role="tabpanel" aria-labelledby="home-tab">
                                                                    <div class="card">
                                                                        <div class="accordion">
                                                                            <div class="accordion-item">
                                                                                <h2 class="accordion-header">
                                                                                    <button class="accordion-button accordion-button-table" type="button">
                                                                                        <i class="bi bi-table icon-menu"></i><span> ตารางรายการข้อมูลบริการหน่วยงายภายนอก</span></span>
                                                                                    </button>
                                                                                </h2>
                                                                                <div id="collapse-hr-develop-in-tab" class="accordion-collapse collapse show">
                                                                                    <div class="accordion-body">
                                                                                        <table class="table datatable table-hover" width="100%" id="table-develop-out">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th scope="col" class="text-center">#</th>
                                                                                                    <th scope="col">ชื่อเรื่อง</th>
                                                                                                    <th scope="col">วันที่</th>
                                                                                                    <th scope="col">ประเภทการพัฒนาบุคลากร</th>
                                                                                                    <th scope="col">ผู้จัดโครงการ/หน่วยงาน</th>
                                                                                                    <th scope="col">จำนวนชั่วโมง</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php foreach ($devlop_list_person as $key => $develop_one) : ?>
                                                                                                    <?php if ($develop_one->dev_organized_type == 2) : ?>
                                                                                                        <tr>
                                                                                                            <td class="text-center"><?= $key + 1 ?></td>
                                                                                                            <td><?= $develop_one->dev_topic ?></td>
                                                                                                            <td class="text-center"><?= fullDateTH3($develop_one->dev_start_date) ?></td>
                                                                                                            <td><?= $develop_one->dev_server_type_name ?></td>
                                                                                                            <td><?= $develop_one->dev_project ?></td>
                                                                                                            <td class="text-center"><?= $develop_one->dev_hour ?></td>
                                                                                                        </tr>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Pills Tabs -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var tab = 0
    document.addEventListener('DOMContentLoaded', function() {
        // เลือก .profile-side, .profile-nav-info และ .user-bio
        var sideBody = document.querySelector('.profile-side');
        var profileNavInfo = document.querySelector('.profile-nav-info');
        var userBio = document.querySelector('.user-bio');

        // ตรวจสอบและปรับความสูงของ .profile-side
        if (sideBody && profileNavInfo && userBio) {
            // คำนวณความสูงรวมของเนื้อหาภายใน .profile-nav-info และ .user-bio
            var totalHeight = profileNavInfo.offsetHeight + userBio.offsetHeight;
            // กำหนดความสูงของ .profile-side ให้ตรงกับความสูงรวม
            sideBody.style.height = (totalHeight + 50) + 'px';
        }
    });
    $(document).ready(function() {
        // Handle change event
        $('#select_year_develop').on('change', function() {
            let selectedValue = $(this).val(); // Get the selected value

            $('#selected_value').text(selectedValue); // Display the value
            if (selectedValue == null) return 0;
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>filter_develops_person_by_year',
                type: 'POST',
                data: {
                    filter_ps_id: $(this).data('ps-id'),
                    filter_year: selectedValue
                },
                success: function(dataReturn) {
                   var dataJSON = JSON.parse(dataReturn)
                   var data = dataJSON.data
                   
                    var sum_hour = dataJSON.sum_hour
                    $('#dev_sum_hour').html(sum_hour);
                    var table_in = $('#table-develop-in').DataTable()
                    var table_out = $('#table-develop-out').DataTable()
                    table_out.clear().draw();
                    table_in.clear().draw();
                    data.forEach(function(item, index) {
                        if (item.dev_organized_type == 1) {
                            table_in.row.add([
                                index + 1,
                                '<div class="text-start">' + item.dev_topic + '</div>',
                                '<div class="text-start">' + item.dev_start_date + '</div>',
                                '<div class="text-start">' + item.dev_server_type_name + '</div>',
                                '<div class="text-start">' + item.dev_project + '</div>',
                                '<div class="text-start">' + item.dev_hour + '</div>'
                            ]).draw();
                        } else {
                            table_out.row.add([
                                index + 1,
                                '<div class="text-start">' + item.dev_topic + '</div>',
                                '<div class="text-start">' + item.dev_start_date + '</div>',
                                '<div class="text-start">' + item.dev_server_type_name + '</div>',
                                '<div class="text-start">' + item.dev_project + '</div>',
                                '<div class="text-start">' + item.dev_hour + '</div>'
                            ]).draw();
                        }
                    });

                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            });
        });
    });
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.profile-header');
        var profileNavInfo = document.querySelector('.profile-nav-info');
        var userBody = document.querySelector('.profile-body');
        var sideBody = document.querySelector('.profile-side');
        var totalHeight = profileNavInfo.offsetHeight + userBody.offsetHeight;
        if (window.innerWidth < 1100) {
            sideBody.style.position = 'static';
            sideBody.style.top = '260px';
            sideBody.style.width = '100%';
            sideBody.style.height = 'auto';
            sideBody.style.marginTop = '40px';
        } else {
            sideBody.style.width = '500px';
            sideBody.style.position = '-webkit-sticky'; // สำหรับ Safari
            sideBody.style.position = 'sticky';
            sideBody.style.top = '260px';
            sideBody.style.zIndex = '200';
            sideBody.style.background = '#fff';
            sideBody.style.boxShadow = '0px 3px 5px rgba(0, 0, 0, 0.1)';
            sideBody.style.padding = '20px';
            sideBody.style.borderRadius = '10px';
            sideBody.style.marginTop = '40px';
            var userBio = document.querySelector('.user-bio');
            // ตรวจสอบและปรับความสูงของ .profile-side
            if (sideBody && profileNavInfo && userBio) {
                // คำนวณความสูงรวมของเนื้อหาภายใน .profile-nav-info และ .user-bio
                var totalHeightBio = profileNavInfo.offsetHeight + userBio.offsetHeight;
                // กำหนดความสูงของ .profile-side ให้ตรงกับความสูงรวม
                sideBody.style.height = (totalHeightBio + 50) + 'px';
            }
        }
        var check = ''
        const header_nav = document.querySelector('.profile-nav-topic')

        if (window.scrollY > 70) {
            header.classList.add('shrunk');
            header_nav.style.top = '105px';
        } else {
            if (window.scrollY > 60) {
                header.classList.remove('shrunk');
                header_nav.style.top = '270px';
            }
        }

        // if (tab == 0) {
        //     if (totalHeight > 2000) {
        //         if (window.scrollY > 50) { // ปรับค่า scroll ตามต้องการ
        //             header.classList.add('shrunk');
        //         } else {
        //             header.classList.remove('shrunk');
        //         }
        //     }
        // } else if (tab == 1) {
        //     if (totalHeight > 1400 && totalHeight < 2700) {
        //         if (window.scrollY > 50) {
        //             header.classList.add('shrunk');
        //         } else {
        //             header.classList.remove('shrunk');
        //         }
        //     }
        // } else if (tab == 2) {
        //     if (totalHeight > 2700 && totalHeight < 3000) {
        //         if (window.scrollY > 50) {
        //             header.classList.add('shrunk');
        //         } else {
        //             header.classList.remove('shrunk');
        //         }
        //     }
        // }
    });
    const sections = [
        [{
                'id': 'PersonalInfo-HR-Section-1',
                'name': 'ข้อมูลทั่วไป'
            }, {
                'id': 'PersonalInfo-HR-Section-2',
                'name': 'ข้อมูลที่อยู่'
            }, {
                'id': 'PersonalInfo-HR-Section-3',
                'name': 'ข้อมูลการศึกษา'
            },
            {
                'id': 'PersonalInfo-HR-Section-4',
                'name': 'ข้อมูลประสบการณ์ทำงาน'
            },
            {
                'id': 'PersonalInfo-HR-Section-5',
                'name': 'ข้อมูลรางวัล'
            }
        ],
        [{
            'id': 'WorkInfo-HRM-Section-1',
            'name': 'ข้อมูลการทำงาน'
        }],
        [{
                'id': 'SelfDevelopment-HRD-Section-1',
                'name': 'ข้อมูลการพัฒนาตนเอง'
            },
            {
                'id': 'SelfDevelopment-HRD-Section-2',
                'name': 'ข้อมูลบริการหน่วยงานภายนอก'
            }
        ]
    ];

    function updateDropdown(index) {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.innerHTML = ''; // Clear existing items
        sections[index].forEach(sectionId => {
            // const sectionName = document.getElementById(sectionId).innerText; // Get the name from the section
            const listItem = document.createElement('li');
            listItem.classList.add('dropdown-item');
            listItem.innerHTML = `<a href="javascript:void(0);" onclick="scrollToSection('${sectionId['id']}')">${sectionId['name']}</a>`;
            dropdownMenu.appendChild(listItem);
        });
    }

    function tabs(index) {
        // Update active class
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.profile-nav-topic ul li').forEach(item => item.classList.remove('active'));
        document.querySelectorAll('.profile-nav-topic ul li')[index].classList.add('active');
        document.querySelectorAll('.tab')[index].classList.add('active');
        tab = index
        // Update dropdown menu
        updateDropdown(index);
    }

    function scrollToSection(sectionId) {
        const element = document.getElementById(sectionId);
        if (element) {
            const rect = element.getBoundingClientRect();
            const offset = 520; // ระยะทางที่ต้องการเพิ่ม (ปรับค่าตามต้องการ)
            window.scrollTo({
                top: rect.top + window.pageYOffset - offset,
                behavior: 'smooth'
            });
        }
    }
    document.querySelectorAll(".profile-nav-topic ul li").forEach((li, index) => {
        li.addEventListener("click", () => tabs(index));
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize with the first tab
    tabs(0);
</script>