<?php 
    function render_file($files = []) {
        $html = '';

        foreach ($files as $file) {
            $name = htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8');
            $url = htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8');
            $type = htmlspecialchars($file['type'], ENT_QUOTES, 'UTF-8');
            
            if (strpos($type, 'image/') === 0) { // image
                $html .= '<img src="' . $url . '" class="img-fluid" alt="' . $name . '">';
            } else if ($type === 'application/pdf') {
                $html .= '<iframe src="' . $url . '" width="100%" height="600px"></iframe>';
            } else if (strpos($type, 'video/') === 0) {
                $html .= '<video width="100%" height="100%" controls>
                            <source src="' . $url . '" type="' . $type . '">
                            Your browser does not support the video tag or the file format of this video.
                          </video>';
            } else {
                $html .= '<p>' . $name . '</p><a href="' . $url . '" target="_blank">Open File</a>';
            }
            $html .= '<br>';
            $html .= '<a href="' . $url . '" class="btn btn-primary mt-2 mb-2 float-end" target="_blank" title="คลิกปุ่มเพื่อดาวน์โหลดไฟล์"> ดาวน์โหลดไฟล์</a>';
            $html .= '<br><br>';
        }
        
        return $html;
    }
?>

<style>
    #accordionExample {
        padding: 10px;
    }
    .head-exr, .head-exr:not(.collapsed) {
        color: var(--tp-font-color);
        background-color: #f6f9ff;
    }
    .head-exr .font-normal {
        font-weight: normal;
    }
    .head-exr h5 {
        font-weight: bold;
    }
</style>

<div class="accordion" id="accordionExample">
    <?php 
        $i=0;
        foreach ($exam_results as $row) {
    ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button head-exr collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $row['exr_id']; ?>" aria-expanded="false" aria-controls="<?php echo $row['exr_id']; ?>">
            <div class="row">
                <h5><?php echo ($i+1) . ". " . $row['eqs_name'] . " (" . $row['rm_name'] . ")"; ?></h5>
                <div>
                    <i class="bi-calendar-check font-20"></i>
                    <span> วัน-เวลาที่สั่งตรวจ </span>
                    <span class="font-normal"> <?php echo convertToThaiYear($row['exr_inspection_time'], true); ?></span>
                </div>
                <div>
                    <i class="bi-person font-20"></i>
                    <span> เจ้าหน้าที่ดำเนินการ </span>
                    <span class="font-normal"> <?php echo $row['update_ps_full_name']; ?></span>
                </div>
            </div>
        </button>
        </h2>
        <div id="<?php echo $row['exr_id']; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
            <div class="accordion-body">
                <?php 
                    $docs = [];
                    foreach ($exr_docs as $file) {
                        if($file['exr_id'] == $row['exr_id'])
                            $docs[] = $file;
                    } 
                    echo render_file($docs);
                ?>
            </div>
        </div>
    </div>
    <?php $i++; } ?>
</div>