<div class="modal-header">
  <h5 class="modal-title" id="detailModalLabel"><?php echo $news->news_name; ?></h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mx-auto">
      <div class="card-header border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-2 mb-sm-0">วันที่ประกาศ <?php echo formatThaiDateNews($news->news_start_date); ?></h5>
        <button id="saveImageNews" class="btn btn-info mb-0"><i class="bi bi-image me-2"></i>บันทึกข่าว</button>
      </div>
      <div id="cardToSave">
        <div class="card-body pb-2">
          <div class="row">
            <div class="mt-3 col-md-4">
              <img src="<?php echo site_url(); ?>/ums/getIcon?type=News/img&image=<?php echo $news->news_img_name; ?>" alt="" class="w-100 rounded-3">
            </div>
            <div class="mt-3 col-md-8">
              <?php echo $news->news_text; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
</div>
<script>
  document.getElementById('saveImageNews').addEventListener('click', function() {
    html2canvas(document.getElementById('cardToSave')).then(function(canvas) {
      var link = document.createElement('a');
      link.download = '<?php echo $news->news_name; ?>.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });
  });
</script>