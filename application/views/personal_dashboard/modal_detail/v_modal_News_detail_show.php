<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <!-- <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShow1">
                    <span>หัวข้อข่าวสาร:</span><span> <?= $news->news_name ?></span>
                </button>
            </h2> -->
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShow1" aria-expanded="false" aria-controls="collapseOne">
                    <i class="bi bi-postcard icon-menu font-20"></i>
                    <span>หัวข้อข่าวสาร:</span><span> <?= $news->news_name ?></span>
                </button>
            </h2>
            <div id="collapseShow1" class="accordion-collapse collapse show mb-5">
                <div class="accordion-body">
                    <div class="text-center">
                        <img id="profile_picture2" src="<?php echo site_url($this->config->item('ums_dir') . 'getIcon?type=' . $this->config->item('ums_news_dir') . 'img&image=' . ($news->news_img_name != '' ? $news->news_img_name : 'default.png')); ?>">
                    </div>
                    <div>
                        <div><?= $news->news_text ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($news->news_file_name)&&$news->news_file_name!=null) : ?>
            <div class="accordion-item">
                <!-- <h2 class="accordion-header mt-2">
                <button class="accordion-button accordion-button-table" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShow2">
                    <span>เอกสารประกอบ</span>
                </button>
            </h2> -->
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShow2" aria-expanded="false" aria-controls="collapseOne">
                        <i class="bi bi-file-earmark-post-fill font-20"></i>
                        <span>เอกสารประกอบ</span>
                    </button>
                </h2>
                <div id="collapseShow2" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div>
                            <div>ชื่อเอกสาร : <?= $news->news_file_name ?></div>
                            <br>
                            <div>
                                <?php
                                $previewPath = site_url($this->config->item('ums_dir') . 'Getpreview?path=' . $this->config->item('ums_uploads_news_file') . '&doc=' . $news->news_file_name);
                                ?>
                                <!-- <div>Generated URL: <?php echo $previewPath; ?></div> -->
                                <div class="document-preview">
                                    <iframe id="documentIframe" style="width: 100%; height: 500px;" src="<?php echo $previewPath; ?>"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var previewPath = "<?php echo $previewPath; ?>";
        console.log("Preview Path:", previewPath);
        var iframe = document.getElementById('documentIframe');
        iframe.src = previewPath;
    });
</script>