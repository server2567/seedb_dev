<?php if (isset($session_view) && $session_view == 'frontend') { ?>
  <div class="row topbar toggle-sidebar-btn">
    <div class="col-md-12 nav_topbar">
      <a href="<?php echo $this->config->item('ums_webstie'); ?>"><i class="bi bi-globe-asia-australia"></i>&nbsp;<span class="font-14">เว็บไซต์หลัก</span></a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a href="<?php echo site_url(); ?>/ums/frontend/Dashboard_home_patient">
        &nbsp;<i class="bi bi-house-door"></i>&nbsp;
        <span class='font-16'>หน้าหลัก</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a href="<?php echo site_url(); ?>/wts/frontend/User_check_que">
        &nbsp;<i class="bi bi-newspaper"></i>&nbsp;
        <span class='font-16'>หน้าตรวจสอบคิว</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-white"></i>&nbsp;
        &nbsp;<i class="bi bi-sort-numeric-down text-white"></i>&nbsp;
        <span class='font-16 text-white'>หน้าแสดงคิว</span>
    </div>
  </div>
<?php } else { ?>
  <div class="row topbar toggle-sidebar-btn">
    <div class="col-md-12 nav_topbar">
      <a href="<?php echo site_url() . '/personal_dashboard/Personal_dashboard_Controller' ?>">
        <span class='font-16'>หน้า PD</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      <a id="prevPageLink" href="#">
        <span id="prevPageText" class='font-16'>จัดการข้อมูลผู้ลงทะเบียน / ผู้ป่วย</span>
      </a>
      &nbsp;<i class="bi bi-caret-right text-warning"></i>&nbsp;
      &nbsp;<i class="bi bi-person-circle text-white"></i>&nbsp;
      <span class='font-16 text-white'>หน้าข้อมูลส่วนตัวผู้ลงทะเบียน / ผู้ป่วย</span>
    </div>
  </div>
  <script>
    // Function to set the previous page URL and text
    function setPreviousPage() {
      var prevPage = document.referrer;
      var prevPageText = 'จัดการข้อมูลผู้ลงทะเบียน / ผู้ป่วย'; // Default text

      if (prevPage.includes('personal_dashboard/Personal_dashboard_Controller')) {
        prevPageText = 'หน้าหลัก (PD)';
      } else if (prevPage.includes('some_other_page')) {
        prevPageText = 'หน้าอื่นๆ'; // Adjust this condition and text based on your needs
      }

      var prevPageLink = document.getElementById('prevPageLink');
      var prevPageTextElement = document.getElementById('prevPageText');

      if (prevPageLink && prevPageTextElement) {
        prevPageLink.href = prevPage;
        prevPageTextElement.textContent = prevPageText;
      }
    }

    // Set the previous page on page load
    document.addEventListener('DOMContentLoaded', setPreviousPage);
  </script>
<?php } ?>
<style>
.card {
    border: none;
}
.card-header {
  border-bottom: 6px dashed #fff;
  border-radius: 10px 10px 0 0;
  background-color: gold;
  position: relative;
}
</style>
    
<div class="card" style="margin-top: 50px;">
        <div class="card-header">
            <?php
            $pt_full_name = $pt_que[0]['pt_prefix'] . '' . $pt_que[0]['pt_fname'] . ' ' . $pt_que[0]['pt_lname'];
            $ps_full_name = $pt_que[0]['pf_name'] . '' . $pt_que[0]['ps_fname'] . ' ' . $pt_que[0]['ps_lname'];
            ?>
            <!-- <div class="mb-3 mt-4 text-center" style="font-size: 16pt;">
                ข้อมูลผู้ป่วย
            </div> -->
            <div class="d-flex flex-column align-items-center">
                <!-- <h5 class="text-muted text-center">ชื่อ-นามสกุล</h5> -->
                <!-- <div class="text-muted text-center" style="font-size: 14pt;">ชื่อ-นามสกุล</div> -->
                <!-- <h4 id="full_name"><?php //echo $pt_full_name; ?></h4> -->
            </div>
            <div class="d-flex flex-column align-items-center mt-4">
            <!-- <h5 class="text-dark pb-4 text-center">แผนก</h5> -->
            <h4 id="stde"><?php echo $pt_que[0]['stde_name_th'] ?></h4>
            <div class="d-flex flex-column align-items-center" style="margin-top: 10px;">
                <h6 class="text-dark pt-4 text-center font-20">หมายเลขคิวปัจจุบัน</h6>
                <h1 class="text-center" id="apm-cl-code"><?php echo $pre_que[0]['apm_ql_code'] ?></h1>
            </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body mb-3">
              
                <div>
                  <?php if($pre_que[0]['apm_ql_code'] == $pt_que[0]['apm_ql_code']) { ?>
                    <h2 class="text-success text-center" id="waiting-time">ถึงคิวของท่านแล้ว</h2>
                  <?php } else { ?>
                    <h4 class="text-primary text-center" id="waiting-time" style="margin-top: -50px;"></h4>
                  <?php } ?>
                    <h6 class="text-dark pt-4 text-center font-20" style="margin-top: 10px;">หมายเลขคิวของท่าน</h6>
                    <h1 class="text-center" id="pt-que-code"><?php echo $pt_que[0]['apm_ql_code'] ?></h1>
                    <h6 class="text-dark text-center pt-4 font-20" style="margin-top: 10px;">แพทย์ที่ทำการรักษา</h6>
                    <h4 class="text-center" id="ps"><?php echo $ps_full_name; ?></h4>

                    <!-- <h6 class="text-dark text-center">ระยะเวลารอคอย</h6> -->
                    <!-- <h6 class="text-muted text-center">เวลาประมาณที่จะได้รับบริการ</h6>
                    <h2 class="text-center" id="que_time"><?php echo ($pre_que[0]['apm_ql_code'] == $pt_que[0]['apm_ql_code']) ? date('H:i') . ' น.' : $pt_que[0]['que_time'] . ' น.' ?></h2> -->
                </div>
            </div>
        </div>
</div>

<!-- $pt_que[0]['sum_time'] . ' นาที' -->

<!-- <script>
    // Function to update the timer display
    function update_timer() {
        // Get the current time
        const now = new Date();

        // Calculate days, months, years, hours, minutes, and seconds
        const day = now.toLocaleString('th-TH', {
            weekday: 'long'
        });
        const date = now.getDate();
        const months = now.toLocaleString('th-TH', {
            month: 'long'
        }); //now.getMonth() + 1; // January is 0
        const years = now.getUTCFullYear() + 543; //now.getFullYear();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();

        // Display the time in the format dd/mm/yyyy hh:mm:ss
        document.getElementById("timer").innerText = day.toString() + "ที่ " +
            date.toString() + " " +
            months.toString() + " พ.ศ. " +
            years.toString() + " เวลา " +
            hours.toString().padStart(2, '0') + ":" +
            minutes.toString().padStart(2, '0') + ":" +
            seconds.toString().padStart(2, '0') + " น.";
    }

    // Start time (current time when the script begins)
    var startTime = new Date();

    // Update the timer display every second
    setInterval(update_timer, 1);
</script> -->

<script>
    var previousData = <?php echo json_encode($pre_que[0]['apm_ql_code']); ?>;
    
    function checkDataChange() {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/wts/frontend/User_check_que/que_show/' + <?php echo json_encode($pt_que[0]['apm_ql_code']); ?>, 
            method: 'GET',
            success: function(response) {
                console.log('Response from server:', response); // Log the response for debugging
                if (previousData !== null && previousData !== response.data) {
                    window.location.reload(); // Refresh the page if data has changed
                }
                previousData = response.data;
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', status, error);
            }
        });
    }

    setInterval(checkDataChange, 5000); // Check for data changes every 5 seconds


</script>

<!-- <script>
        function reloadQueue() {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/wts/frontend/User_check_que/que_show/' + <?php echo json_encode($pt_que[0]['apm_ql_code']); ?>, // เปลี่ยนเป็น URL ของคุณที่ดึงข้อมูลคิวใหม่
                method: 'GET',
                success: function(data) {
                    // สมมุติว่า data เป็น object ที่มีข้อมูลคิวใหม่
                    $('#full_name').text(data.full_name);
                    $('#apm-cl-code').text(data.current_queue_code);
                    $('#pt-que-code').text(data.your_queue_code);
                    $('#waiting-time').text(data.waiting_time);
                    $('#timer').text(data.timer);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching queue data:', error);
                }
            });
        }

        // รีโหลดคิวปัจจุบันทุก 30 วินาที
        setInterval(reloadQueue, 5000);

        // โหลดข้อมูลคิวครั้งแรกเมื่อเริ่มต้น
        $(document).ready(function() {
            reloadQueue();
        });
    </script> -->