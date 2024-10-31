<style>
    .card-body img {
        width: 60px;
    }
    .card-tabs ul.nav-tabs {
        border-top-right-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
        border-top-left-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
    }
    .card-tabs li button.nav-link, .card-tabs .nav-item-left {
        padding: 14px 1.25rem;
    }
    .card-tabs .nav-tabs {
        font-weight: bold;
    }
    .card form button.accordion-button:not(.collapsed) {
        color: var(--bs-primary);
    }
    .nav-item-left span:first-of-type {
    padding-right: 10px;
    }
</style>

<div class="card card-tabs">
    <ul class="nav nav-tabs nav-tabs-bordered bg-primary-light" id="borderedTab" role="tablist">
        <div class="nav-item-left">
            <i class="bi-window-dock icon-menu"></i><span>ไอคอนรูปภาพ</span><span class="badge bg-success"><?php echo count($icons); ?></span>
        </div>
    </ul>
    <div class="card-body">
        <div class="btn-option mb-3">
            <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Icon/icon_edit'"><i class="bi-plus"></i> เพิ่มไอคอนรูปภาพ </button>
        </div>
        <div class="row">
            <?php 
                $i = 0;
                foreach ($icons as $row) { 
                if($row['ic_type'] == 'system') {
                    $i++;
            ?>
                    <div class="col-md-3">
                    <div class="card info-card me-1">
                        <div class="card-body">
                            <div class="float-start">
                                <?php
                                    if(!empty($row['ic_name'])) { ?>
                                        <img src="<?php echo base_url()."index.php/ums/GetFile?type=system&image=".$row['ic_name'];?>">
                                <?php } ?>
                            </div>
                            <div class="float-end option">
                                <button class="btn btn-warning rounded-circle btn-sm" onclick="window.location.href='<?php echo base_url()?>index.php/ums/Icon/icon_edit/<?php echo $row['ic_id']; ?>'"><i class="bi-pencil-square text-white"></i></button>
                                <button class="btn btn-danger rounded-circle btn-sm swal-delete" data-url="<?php echo base_url()?>index.php/ums/Icon/icon_delete/<?php  echo $row['ic_id']; ?>"><i class="bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    </div>
            <?php } }   
            if($i == 0) { ?>
                    <div class="col-md-12 ">
                        <div class="text-center">
                            <?php echo $this->config->item('text_table_no_data'); ?>
                        </div>
                    </div>
            <?php } ?>
        </div>
    </div>
</div>