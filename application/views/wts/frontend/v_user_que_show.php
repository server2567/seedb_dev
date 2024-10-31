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
    
<div class="queue-show" style="margin-top: 50px;"></div>

<script>
function reloadQueue() {

    fetch('<?php echo site_url('wts/frontend/User_check_que/get_patient_queue/' . $stde . '/' . $pt_que[0]['apm_ql_code']); ?>')
        .then(response => response.json())
        .then(data => {
            let queueShow = document.querySelector('.queue-show');
            queueShow.innerHTML = ''; // Clear the previous content

            // Check if the queue data exists
            if (!data.que || !data.pre_que) {
                let emptyCard = document.createElement('div');
                emptyCard.className = 'col-md-12';
                emptyCard.innerHTML = `
                    <div class="card mb-0 text-center fw-bold">
                        <h3>ไม่พบหมายเลขคิว</h3>
                    </div>
                `;
                queueShow.appendChild(emptyCard);
                return;
            }

            // Display the queue information
            let card = document.createElement('div');
            card.className = 'card';
            card.style.marginTop = '50px';
            card.innerHTML = `
                <div class="card-header">
                    <div class="d-flex flex-column align-items-center mt-4">
                        <h4 id="stde">${data.pt_que[0].stde_name_th}</h4>
                        <div class="d-flex flex-column align-items-center" style="margin-top: 10px;">
                            <h6 class="text-dark pt-4 text-center font-20">หมายเลขคิวปัจจุบัน</h6>
                            <h1 class="text-center" id="apm-cl-code">${data.pre_que[0].apm_ql_code}</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body mb-3">
                        <div>
                            ${data.pre_que[0].apm_ql_code == data.pt_que[0].apm_ql_code
                                ? `<h2 class="text-success text-center" id="waiting-time">ถึงคิวของท่านแล้ว</h2>`
                                : `<h2 class="text-success text-center" id="waiting-time">เหลือ ${data.queue_list.length-1} คิว</h2>`
                            }
                            <h6 class="text-dark pt-4 text-center font-20" style="margin-top: 10px;">หมายเลขคิวของท่าน</h6>
                            <h1 class="text-center" id="pt-que-code">${data.pt_que[0].apm_ql_code}</h1>
                            <h6 class="text-dark text-center pt-4 font-20" style="margin-top: 10px;">แพทย์ที่ทำการรักษา</h6>
                            <h4 class="text-center" id="ps">${data.pt_que[0].pf_name_abbr} ${data.pt_que[0].ps_fname} ${data.pt_que[0].ps_lname}</h4>
                        </div>
                    </div>
                </div>
            `;
            queueShow.appendChild(card);
        })
        .catch(error => {
            console.error('Error fetching queue data:', error);
            let queueShow = document.querySelector('.queue-show');
            queueShow.innerHTML = `
                <div class="card mb-0 text-center fw-bold">
                    <h3>เกิดข้อผิดพลาดในการดึงข้อมูลคิว</h3>
                </div>
            `;
        });
}

// Uncomment to auto-refresh every 30 seconds
setInterval(reloadQueue, 5000);

// Load the queue when the page is first loaded
document.addEventListener('DOMContentLoaded', function() {
    reloadQueue();
});
</script>
