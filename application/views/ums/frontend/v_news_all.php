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
      <a href="<?php echo site_url(); ?>/ums/frontend/Dashboard_home_patient/news_all">
        &nbsp;<i class="bi bi-newspaper"></i>&nbsp;
        <span class='font-16'>หน้าข่าวทั้งหมด</span>
      </a>
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
  .truncate {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    /* จำนวนบรรทัดที่ต้องการแสดง */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }
</style>
<section class="py-5 py-lg-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="card-body">
        <div class="col-lg-12 col-xl-12 ps-lg-4 ps-xl-6">
          <div class="row mb-5">
            <div class="col-8 mx-auto">
              <h5>ค้นหาข่าวทั้งหมด</h5>
              <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาข่าว...">
            </div>
          </div>
          <div class="row" id="newsContainer">
            <?php foreach ($get_news as $news) { ?>
              <div class="col-4 mb-4 news-item">
                <div class="card">
                  <img src="<?php echo site_url(); ?>/ums/getIcon?type=News/img&image=<?php echo $news['news_img_name']; ?>" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class=""><?php echo $news['news_name']; ?></h5>
                    <small class="text-muted">วันที่ประกาศ <?php echo formatThaiDateNews($news['news_start_date']); ?></small>
                    <span class="truncate w-100 mt-2"><?php echo $news['news_text']; ?></span>
                    <a class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="loadModalNews(<?php echo $news['news_id']; ?>)">อ่านเพิ่มเติม</a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<!-- ส่วนของ Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" id="modalContent">
      <!-- เนื้อหาจะถูกโหลดที่นี่ -->
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#newsContainer .news-item').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
<script>
  function loadModalNews(news_id) {
    // console.log('loadModalContent called with appointment_id:', appointment_id);  // Debug line
    $.ajax({
      url: "<?php echo site_url('/ums/frontend/Dashboard_modal/modal_News'); ?>/" + news_id,
      method: "GET",
      success: function(data) {
        $('#modalContent').html(data);
        $('#detailModal').modal('show'); // เพิ่มบรรทัดนี้เพื่อเปิด modal
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('AJAX error:', textStatus, errorThrown); // Debug line
      }
    });
  }
</script>